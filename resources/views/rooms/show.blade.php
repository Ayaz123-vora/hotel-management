@extends('layouts.app')

@section('title', $roomType->name . ' - Grand Horizon Hotel')

@section('content')

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-secondary">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-decoration-none text-secondary">Suites</a></li>
            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $roomType->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Left: Gallery & Descriptions -->
        <div class="col-lg-8">
            <div class="mb-4">
                <span class="badge bg-gold text-dark mb-2 px-3 py-1 text-uppercase letter-spacing-1">Signature Collection</span>
                <h1 class="display-5 font-serif fw-bold text-dark mb-2">{{ $roomType->name }}</h1>
                <p class="lead text-secondary">{{ $roomType->tagline }}</p>
            </div>

            <!-- Main Featured Image -->
            <div class="rounded-4 overflow-hidden shadow-sm mb-4 position-relative" style="max-height: 480px;">
                <img src="{{ $roomType->featured_image }}" id="mainGalleryImage" class="w-100 h-100 object-fit-cover" alt="{{ $roomType->name }}">
                <span class="badge bg-dark text-warning position-absolute top-0 end-0 m-3 px-3 py-2 fs-5 shadow">
                    ${{ number_format($roomType->base_price, 2) }} <small class="text-white-50 fs-6">/ night</small>
                </span>
            </div>

            <!-- Gallery Thumbnails -->
            @if(is_array($roomType->gallery) && count($roomType->gallery) > 1)
                <div class="d-flex gap-3 mb-5 overflow-auto pb-2">
                    @foreach($roomType->gallery as $img)
                        <img src="{{ $img }}" class="rounded-3 object-fit-cover border shadow-sm cursor-pointer gallery-thumb" width="110" height="75" onclick="document.getElementById('mainGalleryImage').src = this.src;">
                    @endforeach
                </div>
            @endif

            <!-- Room Key Specifications -->
            <div class="p-4 bg-light rounded-4 mb-5 border">
                <h5 class="font-serif fw-bold mb-3">Suite Specifications</h5>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-door-closed fs-3 text-warning"></i>
                            <div>
                                <small class="text-muted d-block">Bed Configuration</small>
                                <span class="fw-bold small">{{ $roomType->bed_type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-arrows-fullscreen fs-3 text-warning"></i>
                            <div>
                                <small class="text-muted d-block">Suite Area</small>
                                <span class="fw-bold small">{{ $roomType->room_size_sqft }} Sq Ft</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-people fs-3 text-warning"></i>
                            <div>
                                <small class="text-muted d-block">Adult Capacity</small>
                                <span class="fw-bold small">{{ $roomType->capacity_adults }} Adults</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person fs-3 text-warning"></i>
                            <div>
                                <small class="text-muted d-block">Child Capacity</small>
                                <span class="fw-bold small">{{ $roomType->capacity_children }} Children</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-5">
                <h4 class="font-serif fw-bold mb-3">About The Residence</h4>
                <p class="text-secondary lh-lg mb-4">
                    {{ $roomType->description }}
                </p>
            </div>

            <!-- Full Amenities List -->
            <div class="mb-5">
                <h4 class="font-serif fw-bold mb-3">Signature Amenities & Inclusions</h4>
                <div class="row g-3">
                    @if(is_array($roomType->amenities))
                        @foreach($roomType->amenities as $amenity)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded-3 bg-white">
                                    <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                                    <span class="small fw-semibold text-dark">{{ $amenity }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Real-Time Availability & Booking Box -->
        <div class="col-lg-4">
            <div class="card card-luxury sticky-top p-4 border rounded-4 shadow-sm" style="top: 100px;">
                <div class="d-flex justify-content-between align-items-baseline mb-3 pb-3 border-bottom">
                    <div>
                        <span class="fs-3 fw-bold text-dark font-serif">${{ number_format($roomType->base_price, 0) }}</span>
                        <span class="text-secondary small">/ night</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">
                        <i class="bi bi-shield-check me-1"></i> Best Rate Guarantee
                    </span>
                </div>

                <form action="{{ route('booking.create') }}" method="GET" id="availabilityForm">
                    <input type="hidden" name="room_type_id" id="room_type_id" value="{{ $roomType->id }}">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary">Check-In</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" value="{{ $defaultCheckIn }}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary">Check-Out</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" value="{{ $defaultCheckOut }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Adults</label>
                            <select name="adults" class="form-select">
                                @for($i = 1; $i <= $roomType->capacity_adults; $i++)
                                    <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Children</label>
                            <select name="children" class="form-select">
                                @for($i = 0; $i <= $roomType->capacity_children; $i++)
                                    <option value="{{ $i }}">{{ $i }} Child{{ $i > 1 ? 'ren' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Live Dynamic Price Breakdown Box -->
                    <div id="priceCalculationBox" class="p-3 bg-light rounded-3 mb-4 border small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary" id="nightsLabel">2 Nights ($ {{ number_format($roomType->base_price, 0) }} / night)</span>
                            <span class="fw-semibold" id="subtotalDisplay">${{ number_format($roomType->base_price * 2, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Hospitality Tax & VAT (12%)</span>
                            <span class="fw-semibold" id="taxDisplay">${{ number_format($roomType->base_price * 2 * 0.12, 2) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between fs-6 fw-bold text-dark">
                            <span>Estimated Total</span>
                            <span class="text-success" id="totalDisplay">${{ number_format($roomType->base_price * 2 * 1.12, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                        <i class="bi bi-credit-card me-2"></i> Proceed To Reservation
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center text-secondary small">
                    <i class="bi bi-lock-fill text-warning me-1"></i> Secure 256-bit SSL encrypted checkout
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const roomTypeId = document.getElementById('room_type_id').value;
    const basePrice = {{ $roomType->base_price }};

    function recalculate() {
        const inDate = new Date(checkInInput.value);
        const outDate = new Date(checkOutInput.value);

        if (inDate && outDate && outDate > inDate) {
            const diffTime = Math.abs(outDate - inDate);
            const nights = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
            const subtotal = basePrice * nights;
            const tax = subtotal * 0.12;
            const total = subtotal + tax;

            document.getElementById('nightsLabel').textContent = `${nights} Night${nights > 1 ? 's' : ''} ($${basePrice} / night)`;
            document.getElementById('subtotalDisplay').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('taxDisplay').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('totalDisplay').textContent = `$${total.toFixed(2)}`;
        }
    }

    checkInInput.addEventListener('change', recalculate);
    checkOutInput.addEventListener('change', recalculate);
</script>
@endsection
