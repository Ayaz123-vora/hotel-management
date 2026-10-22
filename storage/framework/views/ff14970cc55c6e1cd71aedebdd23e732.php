<?php $__env->startSection('title', 'Complete Your Reservation - Grand Horizon Hotel'); ?>

<?php $__env->startSection('content'); ?>

<!-- Header -->
<div class="bg-dark text-white py-4 mb-5 border-bottom border-secondary">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div>
            <span class="text-warning text-uppercase letter-spacing-1 small fw-bold">Step 1 of 2: Guest Details & Preferences</span>
            <h2 class="font-serif fw-bold text-white mb-0">Secure Room Reservation</h2>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-2">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-shield-lock-fill me-1"></i> Guaranteed Best Rate</span>
        </div>
    </div>
</div>

<div class="container mb-5">
    <form action="<?php echo e(route('booking.store')); ?>" method="POST" id="bookingCheckoutForm">
        <?php echo csrf_field(); ?>
        <div class="row g-5">
            <!-- Left: Form Fields -->
            <div class="col-lg-8">
                <!-- 1. Selected Suite & Stay Dates -->
                <div class="card p-4 border rounded-4 shadow-sm mb-4 bg-white">
                    <h5 class="font-serif fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-dark text-warning rounded-circle me-2 p-2" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">1</span>
                        Accommodation & Dates
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Selected Suite</label>
                            <select name="room_type_id" id="room_type_id" class="form-select form-select-lg" required>
                                <?php $__currentLoopData = $allRoomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($rt->id); ?>" data-price="<?php echo e($rt->base_price); ?>" <?php echo e($rt->id == $roomType->id ? 'selected' : ''); ?>>
                                        <?php echo e($rt->name); ?> &bull; $<?php echo e(number_format($rt->base_price, 0)); ?>/night (<?php echo e($rt->bed_type); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Check-In Date</label>
                            <input type="date" name="check_in_date" id="check_in_date" class="form-control" value="<?php echo e($checkIn); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Check-Out Date</label>
                            <input type="date" name="check_out_date" id="check_out_date" class="form-control" value="<?php echo e($checkOut); ?>" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Adult Guests</label>
                            <select name="adults" id="adults" class="form-select">
                                <option value="1" <?php echo e($adults == 1 ? 'selected' : ''); ?>>1 Adult</option>
                                <option value="2" <?php echo e($adults == 2 ? 'selected' : ''); ?>>2 Adults</option>
                                <option value="3" <?php echo e($adults == 3 ? 'selected' : ''); ?>>3 Adults</option>
                                <option value="4" <?php echo e($adults == 4 ? 'selected' : ''); ?>>4 Adults</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Children (Ages 0-12)</label>
                            <select name="children" id="children" class="form-select">
                                <option value="0" <?php echo e($children == 0 ? 'selected' : ''); ?>>None</option>
                                <option value="1" <?php echo e($children == 1 ? 'selected' : ''); ?>>1 Child</option>
                                <option value="2" <?php echo e($children == 2 ? 'selected' : ''); ?>>2 Children</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. Guest Information -->
                <div class="card p-4 border rounded-4 shadow-sm mb-4 bg-white">
                    <h5 class="font-serif fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-dark text-warning rounded-circle me-2 p-2" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">2</span>
                        Guest Information & Contact
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="e.g. Eleanor" value="<?php echo e(old('first_name')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="e.g. Vance" value="<?php echo e(old('last_name')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Email Address (For Confirmation & Receipt)</label>
                            <input type="email" name="email" class="form-control" placeholder="e.g. eleanor.vance@example.com" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Phone / Mobile Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="e.g. +1 (555) 234-5678" value="<?php echo e(old('phone')); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Identification Type</label>
                            <select name="id_type" class="form-select" required>
                                <option value="Passport" selected>Passport</option>
                                <option value="National ID">National ID Card</option>
                                <option value="Driver License">Driver's License</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">ID / Passport Number</label>
                            <input type="text" name="id_number" class="form-control" placeholder="e.g. P9028471" value="<?php echo e(old('id_number')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">City & State</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. New York, NY" value="<?php echo e(old('city')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Country</label>
                            <input type="text" name="country" class="form-control" placeholder="e.g. United States" value="<?php echo e(old('country')); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Special Requests & Dietary Preferences</label>
                            <textarea name="special_requests" class="form-control" rows="2" placeholder="e.g. Quiet room on high floor, feather-free pillows, celebration champagne setup..."><?php echo e(old('special_requests')); ?></textarea>
                            <small class="text-muted">Special requests are subject to availability upon check-in.</small>
                        </div>
                    </div>
                </div>

                <!-- 3. Add-On Luxury Services -->
                <div class="card p-4 border rounded-4 shadow-sm mb-4 bg-white">
                    <h5 class="font-serif fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-dark text-warning rounded-circle me-2 p-2" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">3</span>
                        Enhance Your Experience (Optional Add-Ons)
                    </h5>

                    <div class="d-flex flex-column gap-3">
                        <?php $__currentLoopData = $addOnCatalog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between hover-bg-light">
                                <div class="form-check d-flex align-items-start gap-3 mb-0">
                                    <input class="form-check-input addon-checkbox mt-1" type="checkbox" name="services[]" value="<?php echo e($addon['name']); ?>" data-price="<?php echo e($addon['price']); ?>" data-pernight="<?php echo e($addon['per_night'] ? 'true' : 'false'); ?>" id="addon_<?php echo e($addon['id']); ?>">
                                    <label class="form-check-label" for="addon_<?php echo e($addon['id']); ?>">
                                        <span class="fw-bold text-dark d-block"><?php echo e($addon['name']); ?></span>
                                        <small class="text-secondary"><?php echo e($addon['description']); ?></small>
                                    </label>
                                </div>
                                <div class="text-end ps-3">
                                    <span class="fw-bold text-dark fs-6">+$<?php echo e(number_format($addon['price'], 2)); ?></span>
                                    <?php if($addon['per_night']): ?>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">/ guest / night</small>
                                    <?php else: ?>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">one-time</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Right: Sticky Order Summary & Price Breakdown -->
            <div class="col-lg-4">
                <div class="card card-luxury sticky-top p-4 border rounded-4 shadow-sm" style="top: 100px;">
                    <h5 class="font-serif fw-bold mb-3 pb-2 border-bottom">Reservation Folio</h5>

                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-bold">Accommodation</small>
                        <h6 class="fw-bold text-dark mb-1" id="summarySuiteName"><?php echo e($roomType->name); ?></h6>
                        <small class="text-secondary" id="summaryDates"><?php echo e(date('M d, Y', strtotime($checkIn))); ?> &rarr; <?php echo e(date('M d, Y', strtotime($checkOut))); ?> (<span id="summaryNights"><?php echo e($nights); ?></span> Nights)</small>
                    </div>

                    <!-- Promo Code input -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Promo Code</label>
                        <div class="input-group">
                            <input type="text" name="promo_code" id="promo_code" class="form-control form-control-sm text-uppercase" placeholder="Try WELCOME10">
                            <button class="btn btn-outline-dark btn-sm" type="button" id="applyPromoBtn">Apply</button>
                        </div>
                        <small class="text-success small d-none" id="promoSuccessMsg"><i class="bi bi-check-circle-fill"></i> 10% Discount Applied!</small>
                    </div>

                    <!-- Itemized Breakdown -->
                    <div class="d-flex flex-column gap-2 py-3 border-top border-bottom small">
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary">Room Charges (<span id="calcNightsLabel"><?php echo e($nights); ?></span> nights)</span>
                            <span class="fw-semibold" id="calcRoomCharges">$<?php echo e(number_format($roomType->base_price * $nights, 2)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary">Add-On Services</span>
                            <span class="fw-semibold" id="calcServicesCharges">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between text-success d-none" id="discountRow">
                            <span>Promotional Discount</span>
                            <span class="fw-semibold" id="calcDiscount">-$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary">Hospitality VAT & Tax (12%)</span>
                            <span class="fw-semibold" id="calcTaxes">$<?php echo e(number_format(($roomType->base_price * $nights) * 0.12, 2)); ?></span>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="d-flex justify-content-between align-items-center pt-3 mb-4">
                        <span class="fs-6 fw-bold text-dark">Total Amount Due</span>
                        <span class="fs-4 fw-bold text-success" id="calcTotal">$<?php echo e(number_format(($roomType->base_price * $nights) * 1.12, 2)); ?></span>
                    </div>

                    <button type="submit" class="btn btn-gold btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm">
                        Continue to Secure Payment <i class="bi bi-arrow-right ms-1"></i>
                    </button>

                    <div class="mt-4 pt-3 border-top text-center text-muted small">
                        <i class="bi bi-shield-check text-success me-1"></i> Instant Confirmation & Digital Receipt
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const checkInInput = document.getElementById('check_in_date');
    const checkOutInput = document.getElementById('check_out_date');
    const roomTypeSelect = document.getElementById('room_type_id');
    const promoInput = document.getElementById('promo_code');
    const promoBtn = document.getElementById('applyPromoBtn');
    const promoSuccessMsg = document.getElementById('promoSuccessMsg');
    const discountRow = document.getElementById('discountRow');
    const addonCheckboxes = document.querySelectorAll('.addon-checkbox');

    let isPromoApplied = false;

    function calculateFolio() {
        const inDate = new Date(checkInInput.value);
        const outDate = new Date(checkOutInput.value);

        let nights = 1;
        if (inDate && outDate && outDate > inDate) {
            const diffTime = Math.abs(outDate - inDate);
            nights = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
        }

        const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
        const baseRate = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const suiteName = selectedOption.text.split('•')[0].trim();

        // Room subtotal
        const roomTotal = baseRate * nights;

        // Add-ons subtotal
        let servicesTotal = 0;
        const adults = parseInt(document.getElementById('adults').value) || 1;

        addonCheckboxes.forEach(cb => {
            if (cb.checked) {
                const price = parseFloat(cb.getAttribute('data-price')) || 0;
                const isPerNight = cb.getAttribute('data-pernight') === 'true';
                if (isPerNight) {
                    servicesTotal += price * adults * nights;
                } else {
                    servicesTotal += price;
                }
            }
        });

        // Discount
        let discount = 0;
        if (isPromoApplied) {
            discount = roomTotal * 0.10;
            discountRow.classList.remove('d-none');
            document.getElementById('calcDiscount').textContent = `-$${discount.toFixed(2)}`;
        } else {
            discountRow.classList.add('d-none');
        }

        const taxable = Math.max(0, (roomTotal + servicesTotal) - discount);
        const tax = taxable * 0.12;
        const grandTotal = taxable + tax;

        // Update UI
        document.getElementById('summarySuiteName').textContent = suiteName;
        document.getElementById('summaryNights').textContent = nights;
        document.getElementById('calcNightsLabel').textContent = nights;
        document.getElementById('calcRoomCharges').textContent = `$${roomTotal.toFixed(2)}`;
        document.getElementById('calcServicesCharges').textContent = `$${servicesTotal.toFixed(2)}`;
        document.getElementById('calcTaxes').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('calcTotal').textContent = `$${grandTotal.toFixed(2)}`;
    }

    promoBtn.addEventListener('click', function() {
        if (promoInput.value.trim().toUpperCase() === 'WELCOME10') {
            isPromoApplied = true;
            promoSuccessMsg.classList.remove('d-none');
        } else {
            isPromoApplied = false;
            promoSuccessMsg.classList.add('d-none');
            alert('Invalid promo code. Try WELCOME10 for 10% off room rate!');
        }
        calculateFolio();
    });

    checkInInput.addEventListener('change', calculateFolio);
    checkOutInput.addEventListener('change', calculateFolio);
    roomTypeSelect.addEventListener('change', calculateFolio);
    document.getElementById('adults').addEventListener('change', calculateFolio);
    addonCheckboxes.forEach(cb => cb.addEventListener('change', calculateFolio));

    calculateFolio();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/booking/create.blade.php ENDPATH**/ ?>