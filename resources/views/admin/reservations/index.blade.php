@extends('layouts.admin')

@section('title', 'Front Desk Reservations')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Front Desk Reservations</h3>
        <p class="text-secondary small mb-0">Manage guest bookings, room key assignments, check-ins, and check-outs.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('admin.reservations.create') }}" class="btn btn-warning btn-sm px-3 fw-bold shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> New Walk-In Booking
        </a>
    </div>
</div>

<!-- Filters & Search Bar -->
<div class="card border rounded-4 shadow-sm mb-4 bg-white p-3">
    <form action="{{ route('admin.reservations.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by reference, guest name, email..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed (Upcoming)</option>
                <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In (In-House)</option>
                <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out (Departed)</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}" title="Filter by active date">
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100 fw-semibold">Filter</button>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Reservations Table -->
<div class="card border rounded-4 shadow-sm bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Booking Ref</th>
                        <th>Guest Details</th>
                        <th>Suite & Room</th>
                        <th>Stay Dates</th>
                        <th>Folio Balance</th>
                        <th>Booking Status</th>
                        <th>Payment</th>
                        <th class="text-end">Front Desk Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $r)
                        <tr>
                            <td>
                                <a href="{{ route('admin.reservations.show', $r->id) }}" class="fw-bold font-monospace text-dark text-decoration-none">
                                    {{ $r->booking_reference }}
                                </a>
                                @if($r->assigned_key_card)
                                    <small class="d-block text-muted font-monospace">{{ $r->assigned_key_card }}</small>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $r->guest->full_name }}</div>
                                <small class="text-muted">{{ $r->guest->phone }} &bull; {{ $r->guest->email }}</small>
                                @if($r->guest->vip_status)
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">VIP</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $r->roomType->name }}</div>
                                @if($r->room)
                                    <span class="badge bg-dark text-warning">Room {{ $r->room->room_number }} (Floor {{ $r->room->floor }})</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                {{ $r->check_in_date->format('M d') }} &rarr; {{ $r->check_out_date->format('M d, Y') }}
                                <small class="d-block text-muted">{{ $r->nights }} Night{{ $r->nights > 1 ? 's' : '' }} &bull; {{ $r->adults }} Adults</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">${{ number_format($r->total_amount, 2) }}</div>
                                @if($r->balance_due > 0)
                                    <span class="badge bg-danger-subtle text-danger">Due: ${{ number_format($r->balance_due, 2) }}</span>
                                @else
                                    <span class="badge bg-success-subtle text-success">Settled</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $r->status_badge }} text-uppercase">
                                    {{ str_replace('_', ' ', $r->booking_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $r->payment_status === 'paid' ? 'success' : 'warning' }} text-uppercase">
                                    {{ $r->payment_status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    @if($r->booking_status === 'confirmed')
                                        <form action="{{ route('admin.reservations.check-in', $r->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" title="Check-In Guest">
                                                <i class="bi bi-box-arrow-in-right"></i> Check In
                                            </button>
                                        </form>
                                    @elseif($r->booking_status === 'checked_in')
                                        <form action="{{ route('admin.reservations.check-out', $r->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" title="Check-Out Guest">
                                                <i class="bi bi-box-arrow-right"></i> Check Out
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.reservations.show', $r->id) }}" class="btn btn-outline-dark" title="View Folio">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('booking.receipt', $r->booking_reference) }}" target="_blank" class="btn btn-outline-secondary" title="Print Receipt">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                No reservations match the current query.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($reservations->hasPages())
        <div class="card-footer bg-white border-top p-3">
            {{ $reservations->links() }}
        </div>
    @endif
</div>

@endsection
