<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Receipt & Folio #<?php echo e($reservation->booking_reference); ?> - Grand Horizon</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .receipt-card {
            max-width: 840px;
            margin: 2rem auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .receipt-header {
            background-color: #0b132b;
            color: #ffffff;
            padding: 2.5rem 3rem;
            border-bottom: 4px solid #c5a880;
        }

        .hotel-brand-title {
            font-family: 'Playfair Display', serif;
            letter-spacing: 2px;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .receipt-body {
            padding: 3rem;
        }

        .table-receipt th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: 700;
        }

        .barcode-strip {
            font-family: monospace;
            letter-spacing: 6px;
            background: #000;
            color: #fff;
            padding: 4px 14px;
            display: inline-block;
            font-size: 1.1rem;
            border-radius: 4px;
        }

        @media print {
            body {
                background: #ffffff;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .receipt-card {
                box-shadow: none;
                border: none;
                max-width: 100%;
                margin: 0;
            }
            .receipt-header {
                background-color: #0b132b !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Top Action Bar (hidden when printing) -->
    <div class="no-print bg-dark py-3 border-bottom text-center">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Return to Hotel Website
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm">
                    <i class="bi bi-printer-fill me-1"></i> Print / Save as PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Printable Receipt Voucher -->
    <div class="receipt-card">
        <!-- Header -->
        <div class="receipt-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h1 class="hotel-brand-title mb-1">GRAND HORIZON</h1>
                <p class="text-warning small text-uppercase letter-spacing-2 mb-2">5-Star Luxury Resort & Residences</p>
                <div class="small text-white-50">
                    500 Oceanview Boulevard, Waterfront District<br>
                    Concierge: +1 (800) 472-6346 &bull; reservations@grandhorizonhotel.com<br>
                    Tax Registration / GSTIN: GH-US-89201948-B
                </div>
            </div>
            <div class="text-md-end mt-3 mt-md-0">
                <span class="badge bg-warning text-dark text-uppercase px-3 py-2 fs-6 fw-bold mb-2 d-inline-block">
                    Official Tax Receipt & Folio
                </span>
                <div class="text-white-50 small">
                    Receipt #: <strong class="text-white"><?php echo e($payment->receipt_number ?? 'RCPT-' . date('Y') . '-' . $reservation->id); ?></strong><br>
                    Issue Date: <strong class="text-white"><?php echo e(date('F d, Y')); ?></strong><br>
                    Status: <span class="badge bg-success">PAID IN FULL</span>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="receipt-body">
            <!-- Reservation & Guest Details Grid -->
            <div class="row g-4 mb-4 pb-4 border-bottom">
                <div class="col-6 col-md-4">
                    <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem;">Billed To (Guest)</small>
                    <h6 class="fw-bold text-dark mb-1"><?php echo e($reservation->guest->full_name); ?></h6>
                    <div class="small text-secondary">
                        <?php echo e($reservation->guest->email); ?><br>
                        <?php echo e($reservation->guest->phone); ?><br>
                        <?php if($reservation->guest->id_number): ?>
                            ID: <?php echo e($reservation->guest->id_type); ?> (<?php echo e($reservation->guest->id_number); ?>)
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem;">Stay Details</small>
                    <div class="small text-secondary">
                        <strong>Check-In:</strong> <?php echo e($reservation->check_in_date->format('M d, Y')); ?> (from 3 PM)<br>
                        <strong>Check-Out:</strong> <?php echo e($reservation->check_out_date->format('M d, Y')); ?> (by 11 AM)<br>
                        <strong>Duration:</strong> <?php echo e($reservation->nights); ?> Night<?php echo e($reservation->nights > 1 ? 's' : ''); ?><br>
                        <strong>Occupants:</strong> <?php echo e($reservation->adults); ?> Adult<?php echo e($reservation->adults > 1 ? 's' : ''); ?><?php echo e($reservation->children > 0 ? ', ' . $reservation->children . ' Children' : ''); ?>

                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem;">Booking Reference</small>
                    <h5 class="fw-bold text-dark font-monospace mb-1"><?php echo e($reservation->booking_reference); ?></h5>
                    <div class="small text-secondary mb-2">
                        <strong>Suite:</strong> <?php echo e($reservation->roomType->name); ?><br>
                        <?php if($reservation->room): ?>
                            <strong>Room Number:</strong> <span class="badge bg-dark text-warning">Room <?php echo e($reservation->room->room_number); ?></span> (Floor <?php echo e($reservation->room->floor); ?>)<br>
                            <?php if($reservation->assigned_key_card): ?>
                                <strong>Keycard Code:</strong> <span class="font-monospace"><?php echo e($reservation->assigned_key_card); ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <strong>Room:</strong> Allocated upon arrival
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Itemized Charges Table -->
            <div class="table-responsive mb-4">
                <table class="table table-receipt table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-center" style="width: 100px;">Qty / Nights</th>
                            <th class="text-end" style="width: 130px;">Unit Price</th>
                            <th class="text-end" style="width: 140px;">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong class="text-dark"><?php echo e($reservation->roomType->name); ?></strong>
                                <small class="text-muted d-block">Room rate per night &bull; <?php echo e($reservation->roomType->bed_type); ?></small>
                            </td>
                            <td class="text-center"><?php echo e($reservation->nights); ?></td>
                            <td class="text-end">$<?php echo e(number_format($reservation->room_rate_per_night, 2)); ?></td>
                            <td class="text-end fw-semibold">$<?php echo e(number_format($reservation->total_room_charges, 2)); ?></td>
                        </tr>

                        <!-- Add-On Services -->
                        <?php if($reservation->services && $reservation->services->count() > 0): ?>
                            <?php $__currentLoopData = $reservation->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $srv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="text-dark"><?php echo e($srv->service_name); ?></span>
                                        <small class="text-muted d-block">Selected add-on hotel experience</small>
                                    </td>
                                    <td class="text-center"><?php echo e($srv->quantity); ?></td>
                                    <td class="text-end">$<?php echo e(number_format($srv->unit_price, 2)); ?></td>
                                    <td class="text-end fw-semibold">$<?php echo e(number_format($srv->total_price, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="border-top">
                        <tr>
                            <td colspan="3" class="text-end text-secondary">Subtotal:</td>
                            <td class="text-end fw-semibold">$<?php echo e(number_format($reservation->total_room_charges + $reservation->services_charges, 2)); ?></td>
                        </tr>
                        <?php if($reservation->discount_amount > 0): ?>
                            <tr>
                                <td colspan="3" class="text-end text-success">Promotional Discount:</td>
                                <td class="text-end text-success fw-semibold">-$<?php echo e(number_format($reservation->discount_amount, 2)); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" class="text-end text-secondary">Hospitality VAT & Tax (12%):</td>
                            <td class="text-end fw-semibold">$<?php echo e(number_format($reservation->tax_amount, 2)); ?></td>
                        </tr>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fs-6 fw-bold text-dark">Grand Total:</td>
                            <td class="text-end fs-5 fw-bold text-dark">$<?php echo e(number_format($reservation->total_amount, 2)); ?></td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="3" class="text-end fw-bold text-success">Amount Paid:</td>
                            <td class="text-end fw-bold text-success">-$<?php echo e(number_format($reservation->paid_amount, 2)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold text-dark">Balance Due:</td>
                            <td class="text-end fw-bold text-dark">$0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Transaction Audit & Payment Details -->
            <div class="row g-4 align-items-center p-3 bg-light rounded-3 border mb-4">
                <div class="col-md-7">
                    <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size: 0.75rem;">Payment Audit Information</small>
                    <div class="small text-secondary">
                        <strong>Transaction ID:</strong> <span class="font-monospace text-dark"><?php echo e($payment->transaction_id ?? 'TXN-ONLINE-VERIFIED'); ?></span><br>
                        <strong>Payment Method:</strong> <?php echo e(ucfirst($payment->payment_method ?? 'card')); ?>

                        <?php if($payment && $payment->card_last_four): ?>
                            (Ending in &bull;&bull;&bull;&bull; <?php echo e($payment->card_last_four); ?>)
                        <?php endif; ?>
                        <br>
                        <strong>Paid At:</strong> <?php echo e($payment ? $payment->paid_at->format('M d, Y h:i A') : date('M d, Y h:i A')); ?><br>
                        <strong>Gateway Reference:</strong> <?php echo e($payment->gateway_reference ?? 'PAYMENT_AUTHORIZED_OK'); ?>

                    </div>
                </div>
                <div class="col-md-5 text-md-end">
                    <!-- Simulated Digital QR Code -->
                    <div class="d-inline-block text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=95x95&data=https://grandhorizonhotel.com/verify/<?php echo e($reservation->booking_reference); ?>" alt="Verification QR" width="85" height="85" class="border rounded p-1 bg-white shadow-sm mb-1">
                        <small class="d-block text-muted" style="font-size: 0.7rem;">Scan to Verify Folio</small>
                    </div>
                </div>
            </div>

            <!-- Policies & Signatures -->
            <div class="pt-3 border-top small text-secondary">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="fw-bold text-dark mb-1">Hotel Notice & Policies</h6>
                        <ul class="ps-3 mb-0" style="font-size: 0.78rem;">
                            <li>Check-in begins at 3:00 PM. Early check-in is subject to room readiness.</li>
                            <li>A valid government-issued photo ID is required upon check-in.</li>
                            <li>The Grand Horizon Hotel maintains a strictly smoke-free indoor environment.</li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-center mt-3 mt-md-0">
                        <div class="border-bottom pb-4 mb-1" style="height: 40px;">
                            <span class="font-serif fst-italic text-muted">A. Vance (General Manager)</span>
                        </div>
                        <small class="text-muted d-block">Authorized Front Desk Signature</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\xampp\htdocs\hotel-management\resources\views/booking/receipt.blade.php ENDPATH**/ ?>