@extends('layouts.app')

@section('title', 'Secure Payment - Grand Horizon Hotel')

@section('content')

<!-- Header -->
<div class="bg-dark text-white py-4 mb-5 border-bottom border-secondary">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <span class="text-warning text-uppercase letter-spacing-1 small fw-bold">Step 2 of 2: Payment Gateway</span>
            <h2 class="font-serif fw-bold text-white mb-0">Secure Transaction Checkout</h2>
        </div>
        <div class="mt-3 mt-md-0 d-flex align-items-center gap-3">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill small">
                <i class="bi bi-shield-lock-fill me-1"></i> 256-Bit SSL Encrypted
            </span>
            <span class="text-white-50 small">Booking Ref: <strong class="text-warning">{{ $reservation->booking_reference }}</strong></span>
        </div>
    </div>
</div>

<div class="container mb-5">
    <form action="{{ route('booking.process-payment', $reservation->booking_reference) }}" method="POST" id="paymentProcessForm">
        @csrf
        <div class="row g-5">
            <!-- Left: Payment Options Tabs -->
            <div class="col-lg-8">
                <div class="card p-4 border rounded-4 shadow-sm bg-white mb-4">
                    <h5 class="font-serif fw-bold mb-4">Select Payment Method</h5>

                    <!-- Method Selector Radio Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="card p-3 border rounded-3 h-100 cursor-pointer payment-method-card active" for="method_card">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="method_card" value="card" checked onchange="togglePaymentPane('card')">
                                    <label class="form-check-label fw-bold text-dark" for="method_card">
                                        <i class="bi bi-credit-card-2-front text-warning fs-5 me-1"></i> Credit / Debit Card
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Visa, Mastercard, Amex</small>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="card p-3 border rounded-3 h-100 cursor-pointer payment-method-card" for="method_upi">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="method_upi" value="upi" onchange="togglePaymentPane('upi')">
                                    <label class="form-check-label fw-bold text-dark" for="method_upi">
                                        <i class="bi bi-qr-code-scan text-warning fs-5 me-1"></i> UPI / QR Code
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Google Pay, PhonePe, Paytm</small>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="card p-3 border rounded-3 h-100 cursor-pointer payment-method-card" for="method_cash">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="method_cash" value="cash" onchange="togglePaymentPane('cash')">
                                    <label class="form-check-label fw-bold text-dark" for="method_cash">
                                        <i class="bi bi-cash-coin text-warning fs-5 me-1"></i> Pay at Counter
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Front Desk Check-In</small>
                            </label>
                        </div>
                    </div>

                    <!-- PANE 1: CREDIT / DEBIT CARD -->
                    <div id="pane_card" class="payment-pane">
                        <div class="p-3 bg-light rounded-3 mb-4 border d-flex justify-content-between align-items-center">
                            <span class="small text-secondary fw-semibold">Accepted Cards</span>
                            <div class="d-flex gap-2 fs-4 text-secondary">
                                <i class="bi bi-credit-card text-primary" title="Visa"></i>
                                <i class="bi bi-credit-card-2-back text-danger" title="Mastercard"></i>
                                <i class="bi bi-wallet2 text-success" title="Amex"></i>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Cardholder Full Name</label>
                                <input type="text" name="card_name" class="form-control form-control-lg" placeholder="Name as it appears on card" value="{{ $reservation->guest->full_name }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Card Number</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white"><i class="bi bi-credit-card text-warning"></i></span>
                                    <input type="text" name="card_number" id="card_number" class="form-control" placeholder="4242 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 4242" maxlength="19" value="4242 4242 4242 4242">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Expiration Date</label>
                                <input type="text" name="card_expiry" class="form-control form-control-lg" placeholder="MM / YY" maxlength="5" value="12/28">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary text-uppercase">CVV / Security Code</label>
                                <div class="input-group input-group-lg">
                                    <input type="password" name="card_cvv" class="form-control" placeholder="123" maxlength="4" value="888">
                                    <span class="input-group-text bg-white" title="3-digit code on back of card"><i class="bi bi-info-circle text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PANE 2: UPI / QR CODE -->
                    <div id="pane_upi" class="payment-pane d-none">
                        <div class="text-center p-4 bg-light rounded-4 border">
                            <h6 class="fw-bold mb-3">Scan Dynamic Payment QR Code</h6>
                            <!-- Simulated High-tech QR Code with Amount -->
                            <div class="d-inline-block p-3 bg-white rounded-3 shadow-sm border mb-3">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=upi://pay?pa=grandhorizon@luxuryhotel&pn=GrandHorizonHotel&am={{ $reservation->total_amount }}&cu=USD" alt="Payment QR Code" width="180" height="180" class="img-fluid">
                            </div>
                            <p class="text-secondary small mb-2">Scan with Google Pay, PhonePe, Paytm, or any UPI App</p>
                            <span class="badge bg-dark text-warning fs-6 px-3 py-2 mb-3">Payable: ${{ number_format($reservation->total_amount, 2) }}</span>
                            
                            <div class="max-w-400 mx-auto mt-2">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Or Enter Virtual Payment Address (VPA)</label>
                                <div class="input-group">
                                    <input type="text" name="upi_id" class="form-control" placeholder="yourname@upi" value="guest@okaxis">
                                    <button class="btn btn-outline-dark" type="button">Verify</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PANE 3: CASH AT COUNTER -->
                    <div id="pane_cash" class="payment-pane d-none">
                        <div class="p-4 bg-light rounded-3 border text-center">
                            <i class="bi bi-building-check fs-1 text-warning mb-2 d-block"></i>
                            <h5 class="fw-bold font-serif">Pay Upon Arrival at Hotel Front Desk</h5>
                            <p class="text-secondary small max-w-500 mx-auto mb-3">
                                Your suite is reserved immediately. You can settle your folio balance via physical credit/debit card, foreign currency, or cash at our 24/7 reception desk when checking in.
                            </p>
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">No Advance Deposit Required</span>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="d-flex flex-wrap justify-content-between align-items-center p-3 border rounded-3 bg-white text-muted small">
                    <span class="d-flex align-items-center"><i class="bi bi-shield-check text-success fs-5 me-2"></i> PCI-DSS Level 1 Compliant</span>
                    <span class="d-flex align-items-center"><i class="bi bi-lock-fill text-warning fs-5 me-2"></i> End-to-End Encryption</span>
                    <span class="d-flex align-items-center"><i class="bi bi-award text-primary fs-5 me-2"></i> Instant Digital Receipt</span>
                </div>
            </div>

            <!-- Right: Itemized Summary & Pay Button -->
            <div class="col-lg-4">
                <div class="card card-luxury sticky-top p-4 border rounded-4 shadow-sm" style="top: 100px;">
                    <h5 class="font-serif fw-bold mb-3 pb-2 border-bottom">Booking Summary</h5>

                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-bold">Guest Name</small>
                        <h6 class="fw-bold text-dark mb-0">{{ $reservation->guest->full_name }}</h6>
                        <small class="text-secondary">{{ $reservation->guest->email }}</small>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-bold">Selected Residence</small>
                        <h6 class="fw-bold text-dark mb-0">{{ $reservation->roomType->name }}</h6>
                        <small class="text-secondary">
                            {{ $reservation->check_in_date->format('M d, Y') }} &rarr; {{ $reservation->check_out_date->format('M d, Y') }} ({{ $reservation->nights }} Nights)
                        </small>
                    </div>

                    <div class="d-flex flex-column gap-2 py-3 border-top border-bottom small">
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary">Room Charges ({{ $reservation->nights }} nights)</span>
                            <span class="fw-semibold">${{ number_format($reservation->total_room_charges, 2) }}</span>
                        </div>
                        @if($reservation->services_charges > 0)
                            <div class="d-flex justify-content-between">
                                <span class="text-secondary">Add-On Experiences</span>
                                <span class="fw-semibold">${{ number_format($reservation->services_charges, 2) }}</span>
                            </div>
                        @endif
                        @if($reservation->discount_amount > 0)
                            <div class="d-flex justify-content-between text-success">
                                <span>Promo Discount</span>
                                <span class="fw-semibold">-${{ number_format($reservation->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary">Taxes & Hospitality VAT (12%)</span>
                            <span class="fw-semibold">${{ number_format($reservation->tax_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 mb-4">
                        <span class="fs-6 fw-bold text-dark">Total Payable Now</span>
                        <span class="fs-3 fw-bold text-success">${{ number_format($reservation->total_amount, 2) }}</span>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm" id="paySubmitBtn">
                        <i class="bi bi-lock-fill me-1"></i> Authorize & Confirm (${{ number_format($reservation->total_amount, 2) }})
                    </button>

                    <div class="text-center mt-3 text-muted small">
                        By confirming, you agree to the Grand Horizon Terms & Cancellation Policy.
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    function togglePaymentPane(type) {
        document.querySelectorAll('.payment-pane').forEach(p => p.classList.add('d-none'));
        document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('active'));

        document.getElementById(`pane_${type}`).classList.remove('d-none');
        document.querySelector(`label[for="method_${type}"]`).classList.add('active');

        const btn = document.getElementById('paySubmitBtn');
        if (type === 'cash') {
            btn.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> Confirm Reservation (Pay at Hotel)`;
        } else {
            btn.innerHTML = `<i class="bi bi-lock-fill me-1"></i> Authorize & Confirm (${'${{ number_format($reservation->total_amount, 2) }}'})`;
        }
    }

    // Auto format card number with spaces
    document.getElementById('card_number')?.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        let formatted = value.match(/.{1,4}/g)?.join(' ') || '';
        e.target.value = formatted.substring(0, 19);
    });
</script>
@endsection
