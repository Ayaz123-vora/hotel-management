<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousekeepingTask;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HousekeepingController extends Controller
{
    public function index()
    {
        $pendingTasks = HousekeepingTask::where('status', 'pending')->with('room.roomType')->latest()->get();
        $inProgressTasks = HousekeepingTask::where('status', 'in_progress')->with('room.roomType')->latest()->get();
        $completedTasks = HousekeepingTask::whereIn('status', ['completed', 'verified'])->with('room.roomType')->latest()->take(10)->get();

        $roomsNeedingCleaning = Room::whereIn('status', ['cleaning', 'maintenance'])
            ->orWhere('housekeeping_status', 'dirty')
            ->with('roomType')
            ->get();

        $allRooms = Room::orderBy('room_number')->get();

        return view('admin.housekeeping.index', compact(
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'roomsNeedingCleaning',
            'allRooms'
        ));
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'task_type' => 'required|in:routine_cleaning,deep_cleaning,turn_down,linen_change,checkout_sanitization',
            'priority' => 'required|in:normal,high,urgent',
            'assigned_staff_name' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:300',
        ]);

        HousekeepingTask::create([
            'room_id' => $request->room_id,
            'task_type' => $request->task_type,
            'priority' => $request->priority,
            'assigned_staff_name' => $request->assigned_staff_name ?? 'Housekeeping Team',
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        Room::where('id', $request->room_id)->update(['housekeeping_status' => 'dirty']);

        return redirect()->back()->with('success', 'Housekeeping task scheduled successfully!');
    }

    public function updateTaskStatus(Request $request, HousekeepingTask $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,verified',
        ]);

        $data = ['status' => $request->status];
        if (in_array($request->status, ['completed', 'verified'])) {
            $data['completed_at'] = Carbon::now();

            // Automatically update room housekeeping status
            if ($task->room && $task->room->status === 'cleaning') {
                $task->room->update([
                    'status' => 'available',
                    'housekeeping_status' => 'clean',
                ]);
            } else if ($task->room) {
                $task->room->update([
                    'housekeeping_status' => 'clean',
                ]);
            }
        }

        $task->update($data);

        return redirect()->back()->with('success', "Task status updated to " . ucfirst(str_replace('_', ' ', $request->status)) . "!");
    }

    public function markClean(Room $room)
    {
        $room->update([
            'status' => 'available',
            'housekeeping_status' => 'clean',
        ]);

        // Complete any pending tasks for this room
        HousekeepingTask::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->update([
                'status' => 'completed',
                'completed_at' => Carbon::now(),
            ]);

        return redirect()->back()->with('success', "Room {$room->room_number} is now marked as Clean & Inspected (Available for check-in)!");
    }
}
