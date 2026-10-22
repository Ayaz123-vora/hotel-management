@extends('layouts.app')

@section('title', 'Luxury Facilities & Wellness - Grand Horizon Hotel')

@section('content')

<!-- Header -->
<div class="bg-dark text-white py-5 mb-5" style="background: linear-gradient(rgba(11,19,43,0.85), rgba(11,19,43,0.95)), url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1920&q=80') center/cover;">
    <div class="container text-center py-4">
        <span class="text-warning text-uppercase letter-spacing-2 fw-bold small">Recreation & Wellness Sanctuary</span>
        <h1 class="display-4 font-serif fw-bold mt-1 text-white">Hotel Facilities & Operations</h1>
        <p class="lead text-white-50 max-w-700 mx-auto">
            Indulge in our rooftop infinity pool, thermal baths, private cabanas, and executive conference spaces.
        </p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        @foreach($facilities as $facility)
            <div class="col-lg-6">
                <div class="card card-luxury h-100 border rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="feature-icon-box mb-0">
                                <i class="bi {{ $facility->icon ?? 'bi-gem' }}"></i>
                            </div>
                            <span class="badge bg-{{ $facility->status_badge }} text-uppercase px-3 py-2">
                                {{ str_replace('_', ' ', $facility->status) }}
                            </span>
                        </div>

                        <h3 class="font-serif fw-bold text-dark mb-2">{{ $facility->facility_name }}</h3>
                        <p class="text-secondary mb-4 flex-grow-1">
                            {{ $facility->daily_maintenance_notes ?? 'World-class facility available exclusively to hotel guests and private club reservation holders.' }}
                        </p>

                        <div class="row g-2 py-3 border-top border-bottom small text-secondary mb-4">
                            <div class="col-6">
                                <i class="bi bi-clock-history text-warning me-1"></i> {{ $facility->operating_hours }}
                            </div>
                            <div class="col-6">
                                <i class="bi bi-geo-alt text-warning me-1"></i> {{ $facility->location }}
                            </div>
                            <div class="col-12 mt-2">
                                <i class="bi bi-person-badge text-warning me-1"></i> Facility Manager: {{ $facility->manager_in_charge ?? 'Concierge Desk' }}
                            </div>
                        </div>

                        <button type="button" class="btn btn-gold py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#facilityModal{{ $facility->id }}">
                            <i class="bi bi-calendar-plus me-1"></i> Reserve Experience / Cabana
                        </button>
                    </div>
                </div>
            </div>

            <!-- Booking Modal for this Facility -->
            <div class="modal fade" id="facilityModal{{ $facility->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header bg-dark text-white p-4">
                            <div>
                                <small class="text-warning text-uppercase fw-bold">Experience Reservation</small>
                                <h5 class="modal-title font-serif fw-bold text-white">{{ $facility->facility_name }}</h5>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('facilities.book') }}" method="POST">
                            @csrf
                            <input type="hidden" name="facility_id" value="{{ $facility->id }}">
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Full Name</label>
                                    <input type="text" name="guest_name" class="form-control" placeholder="e.g. Marcus Aurelius" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Email</label>
                                    <input type="email" name="guest_email" class="form-control" placeholder="e.g. marcus@example.com" required>
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
                                        <input type="number" name="guest_count" class="form-control" value="2" min="1" max="50" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Hotel Booking Ref (Optional)</label>
                                        <input type="text" name="booking_reference" class="form-control text-uppercase" placeholder="GH-26-XXXX">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Special Notes or Equipment Requests</label>
                                    <textarea name="special_notes" class="form-control" rows="2" placeholder="e.g. Aromatherapy oils, extra towels, poolside champagne..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer p-3 bg-light border-top">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-gold px-4 fw-bold">Confirm Experience Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
