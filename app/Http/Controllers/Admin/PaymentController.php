<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['reservation.guest', 'reservation.roomType']);

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('receipt_number', 'like', "%{$search}%")
                  ->orWhereHas('reservation', function ($r) use ($search) {
                      $r->where('booking_reference', 'like', "%{$search}%")
                        ->orWhereHas('guest', function ($g) use ($search) {
                            $g->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%");
                        });
                  });
            });
        }

        $payments = $query->latest('paid_at')->paginate(20);

        $totalRevenue = Payment::where('payment_status', 'successful')->sum('amount');
        $cardRevenue = Payment::where('payment_status', 'successful')->where('payment_method', 'card')->sum('amount');
        $upiRevenue = Payment::where('payment_status', 'successful')->where('payment_method', 'upi')->sum('amount');
        $cashRevenue = Payment::where('payment_status', 'successful')->where('payment_method', 'cash')->sum('amount');

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'cardRevenue', 'upiRevenue', 'cashRevenue'));
    }
}
