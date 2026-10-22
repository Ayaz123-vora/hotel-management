@extends('layouts.admin')

@section('title', 'Room Matrix & Inventory')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Room Matrix & Status Board</h3>
        <p class="text-secondary small mb-0">Visual status tracker for all physical room units across floors.</p>
    </div>
    <div class="d-flex gap-2 mt-3 mt-md-0">
        <a href="{{ route('admin.rooms.types') }}" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-door-open me-1"></i> Manage Room Types & Pricing
        </a>
        <button class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoomModal">
            <i class="bi bi-plus-circle-fill me-1"></i> Add Physical Room
        </button>
    </div>
</div>

<!-- Filters -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white p-3">
    <form action="{{ route('admin.rooms.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-3">
            <select name="floor" class="form-select form-select-sm">
                <option value="">All Floors</option>
                @foreach($floors as $fl)
                    <option value="{{ $fl }}" {{ request('floor') == $fl ? 'selected' : '' }}>Floor {{ $fl }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="cleaning" {{ request('status') == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="room_type_id" class="form-select form-select-sm">
                <option value="">All Room Categories</option>
                @foreach($roomTypes as $rt)
                    <option value="{{ $rt->id }}" {{ request('room_type_id') == $rt->id ? 'selected' : '' }}>{{ $rt->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark btn-sm w-100 fw-semibold">Apply</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Visual Room Grid -->
<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold mb-0 text-dark">Live Floor Units</h6>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-success-subtle text-success">Available</span>
            <span class="badge bg-danger-subtle text-danger">Occupied</span>
            <span class="badge bg-warning-subtle text-warning-emphasis">Reserved</span>
            <span class="badge bg-info-subtle text-info-emphasis">Cleaning</span>
            <span class="badge bg-secondary-subtle text-secondary">Maintenance</span>
        </div>
    </div>

    <div class="row g-3">
        @forelse($rooms as $room)
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <div class="room-chip bg-{{ $room->status_badge }}-subtle text-{{ $room->status_badge }}-emphasis border border-{{ $room->status_badge }}-subtle p-3" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $room->id }}">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted fw-bold">Fl. {{ $room->floor }}</small>
                        <i class="bi bi-{{ $room->housekeeping_status === 'clean' ? 'stars text-success' : 'brush text-warning' }}" title="Housekeeping: {{ $room->housekeeping_status }}"></i>
                    </div>
                    <div class="fw-bold fs-4">#{{ $room->room_number }}</div>
                    <small class="d-block text-truncate" style="font-size: 0.72rem;">{{ $room->roomType->name }}</small>
                    <span class="badge bg-{{ $room->status_badge }} text-uppercase mt-2 w-100" style="font-size: 0.65rem;">
                        {{ $room->status }}
                    </span>
                </div>

                <!-- Modal for updating status -->
                <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <div class="modal-header bg-dark text-white p-3">
                                <div>
                                    <h6 class="modal-title font-serif mb-0">Room {{ $room->room_number }}</h6>
                                    <small class="text-warning">{{ $room->roomType->name }} &bull; Floor {{ $room->floor }}</small>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.rooms.status', $room->id) }}" method="POST">
                                @csrf
                                <div class="modal-body p-3">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Room Status</label>
                                    <select name="status" class="form-select mb-3">
                                        <option value="available" {{ $room->status === 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="occupied" {{ $room->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="reserved" {{ $room->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                                        <option value="cleaning" {{ $room->status === 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                        <option value="maintenance" {{ $room->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Housekeeping</label>
                                    <select name="housekeeping_status" class="form-select">
                                        <option value="clean" {{ $room->housekeeping_status === 'clean' ? 'selected' : '' }}>Clean & Inspected</option>
                                        <option value="inspecting" {{ $room->housekeeping_status === 'inspecting' ? 'selected' : '' }}>Inspecting</option>
                                        <option value="dirty" {{ $room->housekeeping_status === 'dirty' ? 'selected' : '' }}>Dirty / Turnover Required</option>
                                    </select>
                                </div>
                                <div class="modal-footer p-2 bg-light">
                                    <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">No rooms match filter.</div>
        @endforelse
    </div>
</div>

<!-- Modal: Add New Room -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title font-serif">Add Physical Room Unit</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Room Number</label>
                        <input type="text" name="room_number" class="form-control" placeholder="e.g. 505, PH-02" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Floor Level</label>
                        <input type="number" name="floor" class="form-control" value="1" min="1" max="50" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Room Category</label>
                        <select name="room_type_id" class="form-select" required>
                            @foreach($roomTypes as $rt)
                                <option value="{{ $rt->id }}">{{ $rt->name }} &bull; ${{ number_format($rt->base_price, 0) }}/night</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Initial Status</label>
                        <select name="status" class="form-select" required>
                            <option value="available" selected>Available (Ready for Guests)</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Internal Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Corner room with sunset view"></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold px-4">Create Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
