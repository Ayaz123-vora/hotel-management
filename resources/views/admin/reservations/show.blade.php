@extends('layouts.admin')

@section('title', 'Folio #' . $reservation->booking_reference)

@section('content')

<!-- Header & Quick Actions -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
            <h3 class="fw-bold mb-0">Reservation Folio</h3>
            <span class="badge bg-{{ $reservation->status_badge }} fs-6 text-uppercase">{{ str_replace('_', ' ', $reservation->booking_status) }}</span>
        </div>
        <p class="text-secondary small mb-0 font-monospace">Ref: {{ $reservation->booking_reference }} &bull; Created {{ $reservation->created_at->format('M d, Y h:i A') }}</p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0">
        @if($reservation->booking_status === 'confirmed')
            <form action="{{ route('admin.reservations.check-in', $reservation->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Check In Guest
                </button>
            </form>
        @elseif($reservation->booking_status === 'checked_in')
            <form action="{{ route('admin.reservations.check-out', $reservation->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger fw-bold">
                    <i class="bi bi-box-arrow-right me-1"></i> Check Out Guest
                </button>
            </form>
        @endif

        @if($reservation->booking_status !== 'cancelled' && $reservation->booking_status !== 'checked_out')
            <form action="{{ route('admin.reservations.cancel', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Cancel Booking</button>
            </form>
        @endif

        <a href="{{ route('booking.receipt', $reservation->booking_reference) }}" target="_blank" class="btn btn-dark fw-bold">
            <i class="bi bi-printer me-1"></i> Print Digital Receipt
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Left Column: Guest & Stay Details -->
    <div class="col-lg-8">
        <!-- Guest Details Card -->
        <div class="card border rounded-4 shadow-sm bg-white p-4 mb-4">
            <h5 class="font-serif fw-bold mb-3 d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-fill text-warning me-2"></i> Guest Profile</span>
                @if($reservation->guest->vip_status)
                    <span class="badge bg-warning text-dark px-3 py-1">VIP Guest</span>
                @endif
            </h5>
            <div class="row g-3 small">
                <div class="col-md-6">
                    <span class="text-muted text-uppercase fw-bold d-block">Full Name</span>
                    <span class="fw-bold fs-6 text-dark">{{ $reservation->guest->full_name }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase fw-bold d-block">Contact</span>
                    <span class="text-dark">{{ $reservation->guest->phone }} &bull; {{ $reservation->guest->email }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase fw-bold d-block">Identification</span>
                    <span class="text-dark">{{ $reservation->guest->id_type }}: {{ $reservation->guest->id_number ?? 'Not Provided' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase fw-bold d-block">Location</span>
                    <span class="text-dark">{{ $reservation->guest->city ?? 'N/A' }}, {{ $reservation->guest->country ?? 'N/A' }}</span>
                </div>
                @if($reservation->special_requests)
                    <div class="col-12 mt-3 pt-3 border-top">
                        <span class="text-muted text-uppercase fw-bold d-block">Special Requests / Notes:</span>
                        <div class="p-2 bg-light rounded text-dark mt-1 fst-italic">"{{ $reservation->special_requests }}"</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Room & Stay Details Card -->
        <div class="card border rounded-4 shadow-sm bg-white p-4 mb-4">
            <h5 class="font-serif fw-bold mb-3"><i class="bi bi-door-closed-fill text-warning me-2"></i> Accommodation & Allocation</h5>
            <div class="row g-3 small mb-4">
                <div class="col-md-4">
                    <span class="text-muted text-uppercase fw-bold d-block">Room Category</span>
                    <span class="fw-bold text-dark fs-6">{{ $reservation->roomType->name }}</span>
                    <small class="text-muted d-block">{{ $reservation->roomType->bed_type }}</small>
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-uppercase fw-bold d-block">Physical Room Number</span>
                    @if($reservation->room)
                        <span class="badge bg-dark text-warning fs-6">Room {{ $reservation->room->room_number }} (Floor {{ $reservation->room->floor }})</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger fs-6">Not Yet Assigned</span>
                    @endif
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-uppercase fw-bold d-block">Assigned Keycard</span>
                    <span class="font-monospace text-dark fw-bold">{{ $reservation->assigned_key_card ?? 'Pending Keycard' }}</span>
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-uppercase fw-bold d-block">Check-In</span>
                    <span class="text-dark fw-bold">{{ $reservation->check_in_date->format('M d, Y') }}</span>
                    <small class="text-muted d-block">{{ $reservation->checked_in_at ? 'Checked in: ' . $reservation->checked_in_at->format('h:i A') : 'Standard: 3:00 PM' }}</small>
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-uppercase fw-bold d-block">Check-Out</span>
                    <span class="text-dark fw-bold">{{ $reservation->check_out_date->format('M d, Y') }}</span>
                    <small class="text-muted d-block">{{ $reservation->checked_out_at ? 'Checked out: ' . $reservation->checked_out_at->format('h:i A') : 'Standard: 11:00 AM' }}</small>
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-uppercase fw-bold d-block">Guests / Duration</span>
                    <span class="text-dark fw-bold">{{ $reservation->nights }} Nights &bull; {{ $reservation->adults }} Adults</span>
                    @if($reservation->children > 0)
                        <small class="text-muted d-block">{{ $reservation->children }} Children</small>
                    @endif
                </div>
            </div>

            <!-- Room Reassignment Form -->
            <div class="p-3 bg-light rounded-3 border">
                <span class="fw-bold small text-dark d-block mb-2">Change / Assign Physical Room:</span>
                <form action="{{ route('admin.reservations.assign-room', $reservation->id) }}" method="POST" class="row g-2 align-items-center">
                    @csrf
                    <div class="col-md-8">
                        <select name="room_id" class="form-select form-select-sm" required>
                            <option value="">Select Physical Room Unit...</option>
                            @foreach($availableRooms as $avail)
                                <option value="{{ $avail->id }}" {{ $reservation->room_id == $avail->id ? 'selected' : '' }}>
                                    Room {{ $avail->room_number }} (Floor {{ $avail->floor }}) &bull; Status: {{ ucfirst($avail->status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-dark btn-sm w-100 fw-bold">Update Room Assignment</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payments Ledger for this Reservation -->
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h5 class="font-serif fw-bold mb-3"><i class="bi bi-credit-card-2-front-fill text-warning me-2"></i> Payment Transactions</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Transaction ID</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                            <th>Gateway Ref</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservation->payments as $p)
                            <tr>
                                <td class="font-monospace fw-bold">{{ $p->transaction_id }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ ucfirst($p->payment_method) }}</span>
                                    @if($p->card_last_four)
                                        <small class="text-muted">(&bull;&bull;&bull;&bull; {{ $p->card_last_four }})</small>
                                    @endif
                                </td>
                                <td class="fw-bold text-success">${{ number_format($p->amount, 2) }}</td>
                                <td><span class="badge bg-success">Successful</span></td>
                                <td>{{ $p->paid_at->format('M d, Y h:i A') }}</td>
                                <td class="font-monospace small text-muted">{{ $p->gateway_reference ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">No transactions recorded for this reservation.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Financial Itemized Bill -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white p-4 sticky-top" style="top: 90px;">
            <h5 class="font-serif fw-bold mb-3 pb-2 border-bottom">Folio Financial Summary</h5>

            <div class="d-flex flex-column gap-2 py-2 small">
                <div class="d-flex justify-content-between">
                    <span class="text-secondary">Room Rate ({{ $reservation->nights }} nights @ ${{ number_format($reservation->room_rate_per_night, 2) }})</span>
                    <span class="fw-semibold text-dark">${{ number_format($reservation->total_room_charges, 2) }}</span>
                </div>

                @if($reservation->services && $reservation->services->count() > 0)
                    <div class="pt-2 border-top">
                        <span class="text-muted fw-bold d-block mb-1">Add-On Services:</span>
                        @foreach($reservation->services as $srv)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-secondary">&bull; {{ $srv->service_name }} (x{{ $srv->quantity }})</span>
                                <span class="fw-semibold text-dark">${{ number_format($srv->total_price, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($reservation->discount_amount > 0)
                    <div class="d-flex justify-content-between text-success">
                        <span>Discount Applied</span>
                        <span class="fw-semibold">-${{ number_format($reservation->discount_amount, 2) }}</span>
                    </div>
                @endif

                <div class="d-flex justify-content-between pt-2 border-top">
                    <span class="text-secondary">Hospitality VAT & Tax (12%)</span>
                    <span class="fw-semibold text-dark">${{ number_format($reservation->tax_amount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between pt-2 border-top fs-6 fw-bold text-dark">
                    <span>Total Folio Amount</span>
                    <span class="text-dark">${{ number_format($reservation->total_amount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between text-success fw-bold">
                    <span>Total Paid</span>
                    <span>-${{ number_format($reservation->paid_amount, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between pt-2 border-top fs-5 fw-bold {{ $reservation->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                    <span>Balance Due</span>
                    <span>${{ number_format($reservation->balance_due, 2) }}</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top">
                <span class="badge bg-{{ $reservation->payment_status === 'paid' ? 'success' : 'warning' }} w-100 py-2 fs-6 text-uppercase mb-3">
                    Payment Status: {{ $reservation->payment_status }}
                </span>
                <a href="{{ route('booking.receipt', $reservation->booking_reference) }}" target="_blank" class="btn btn-outline-dark w-100 py-2">
                    <i class="bi bi-receipt me-1"></i> View Official Receipt
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
