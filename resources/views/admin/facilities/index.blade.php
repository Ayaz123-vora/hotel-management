@extends('layouts.admin')

@section('title', 'Daily Facility Operations')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Facility Operations & Daily Maintenance</h3>
        <p class="text-secondary small mb-0">Monitor operational status, environmental logs, and reserve cabanas, spas, and boardrooms.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <button class="btn btn-warning btn-sm px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#newFacilityBookingModal">
            <i class="bi bi-calendar-plus-fill me-1"></i> New Facility Reservation
        </button>
    </div>
</div>

<!-- Facilities Grid -->
<div class="row g-4 mb-5">
    @foreach($facilities as $fac)
        <div class="col-lg-4 col-md-6">
            <div class="card border rounded-4 shadow-sm bg-white h-100 p-4 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi {{ $fac->icon ?? 'bi-gem' }}"></i>
                    </div>
                    <span class="badge bg-{{ $fac->status_badge }} text-uppercase px-3 py-1">
                        {{ str_replace('_', ' ', $fac->status) }}
                    </span>
                </div>

                <h5 class="fw-bold text-dark font-serif mb-1">{{ $fac->facility_name }}</h5>
                <small class="text-muted d-block mb-3">
                    <i class="bi bi-geo-alt text-warning me-1"></i> {{ $fac->location }} &bull; {{ $fac->operating_hours }}
                </small>

                <div class="p-3 bg-light rounded-3 small text-secondary mb-3 flex-grow-1 border">
                    <strong class="text-dark d-block mb-1">Daily Log:</strong>
                    {{ $fac->daily_maintenance_notes ?? 'Operating normally with routine water quality & climate controls verified.' }}
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top small text-muted">
                    <span><i class="bi bi-person-badge me-1"></i> In Charge: <strong>{{ $fac->manager_in_charge ?? 'Staff' }}</strong></span>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editFacilityModal{{ $fac->id }}">
                        <i class="bi bi-gear-fill me-1"></i> Status
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Status Modal -->
        <div class="modal fade" id="editFacilityModal{{ $fac->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header bg-dark text-white p-4">
                        <h5 class="modal-title font-serif">Facility Operational Settings</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.facilities.status', $fac->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <h6 class="fw-bold text-dark mb-3">{{ $fac->facility_name }}</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Operational Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="operational" {{ $fac->status === 'operational' ? 'selected' : '' }}>Operational (Open for Guests)</option>
                                    <option value="maintenance" {{ $fac->status === 'maintenance' ? 'selected' : '' }}>Under Scheduled Maintenance</option>
                                    <option value="private_booking" {{ $fac->status === 'private_booking' ? 'selected' : '' }}>Private Exclusive Booking</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Manager / Supervisor in Charge</label>
                                <input type="text" name="manager_in_charge" class="form-control" value="{{ $fac->manager_in_charge }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Daily Maintenance Notes & Inspection Log</label>
                                <textarea name="daily_maintenance_notes" class="form-control" rows="3">{{ $fac->daily_maintenance_notes }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer p-3 bg-light border-top">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning fw-bold px-4">Update Facility Log</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Scheduled Facility Bookings -->
<div class="card border rounded-4 shadow-sm bg-white overflow-hidden mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-event-fill text-warning me-2"></i> Upcoming Facility Experience Bookings</h6>
        <span class="badge bg-dark">{{ $upcomingBookings->count() }} Scheduled</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th>Facility</th>
                        <th>Guest Name</th>
                        <th>Date & Time Slot</th>
                        <th>Guests</th>
                        <th>Special Notes</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingBookings as $b)
                        <tr>
                            <td>
                                <strong class="text-dark">{{ $b->facility->facility_name }}</strong>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $b->guest_name }}</div>
                                <small class="text-muted">{{ $b->guest_email }}</small>
                            </td>
                            <td>
                                <div><i class="bi bi-calendar me-1 text-warning"></i> {{ $b->booking_date->format('M d, Y') }}</div>
                                <small class="text-muted"><i class="bi bi-clock me-1 text-warning"></i> {{ $b->time_slot }}</small>
                            </td>
                            <td>{{ $b->guest_count }} Person{{ $b->guest_count > 1 ? 's' : '' }}</td>
                            <td>{{ $b->special_notes ?? 'None' }}</td>
                            <td><span class="badge bg-success text-uppercase">{{ $b->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No scheduled facility bookings.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: New Facility Booking -->
<div class="modal fade" id="newFacilityBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white p-4">
                <h5 class="modal-title font-serif">Reserve Facility Experience</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.facilities.booking') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Facility</label>
                        <select name="facility_id" class="form-select" required>
                            @foreach($facilities as $f)
                                <option value="{{ $f->id }}">{{ $f->facility_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Link to In-House Guest (Optional)</label>
                        <select name="reservation_id" class="form-select">
                            <option value="">External / Non-Resident</option>
                            @foreach($activeReservations as $act)
                                <option value="{{ $act->id }}">{{ $act->guest->full_name }} &bull; {{ $act->booking_reference }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Guest Full Name</label>
                            <input type="text" name="guest_name" class="form-control" placeholder="e.g. Marcus Aurelius" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Email</label>
                            <input type="email" name="guest_email" class="form-control" placeholder="e.g. marcus@example.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Date</label>
                            <input type="date" name="booking_date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Time Slot</label>
                            <select name="time_slot" class="form-select" required>
                                <option value="09:00 AM - 11:00 AM">09:00 AM - 11:00 AM</option>
                                <option value="11:00 AM - 01:00 PM">11:00 AM - 01:00 PM</option>
                                <option value="02:00 PM - 04:00 PM" selected>02:00 PM - 04:00 PM</option>
                                <option value="04:00 PM - 06:00 PM">04:00 PM - 06:00 PM</option>
                                <option value="06:00 PM - 08:00 PM">06:00 PM - 08:00 PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Guest Count</label>
                            <input type="number" name="guest_count" class="form-control" value="2" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Charge Amount ($)</label>
                            <input type="number" step="0.01" name="total_price" class="form-control" value="0.00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Special Requests & Notes</label>
                        <textarea name="special_notes" class="form-control" rows="2" placeholder="e.g. Private cabana with mineral water..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3 bg-light border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold px-4">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
