<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show the online reservation checkout form.
     */
    public function create(Request $request)
    {
        $roomTypeId = $request->get('room_type_id');
        $roomType = $roomTypeId ? RoomType::findOrFail($roomTypeId) : RoomType::where('is_active', true)->firstOrFail();
        $allRoomTypes = RoomType::where('is_active', true)->get();

        $checkIn = $request->get('check_in', Carbon::now()->addDay()->format('Y-m-d'));
        $checkOut = $request->get('check_out', Carbon::now()->addDays(3)->format('Y-m-d'));
        $adults = (int)$request->get('adults', 2);
        $children = (int)$request->get('children', 0);

        $startDate = Carbon::parse($checkIn);
        $endDate = Carbon::parse($checkOut);
        $nights = max(1, $startDate->diffInDays($endDate));

        $addOnCatalog = [
            [
                'id' => 'breakfast',
                'name' => 'Royal Champagne Breakfast Buffet',
                'description' => 'Unlimited artisan bakery, caviar & eggs benedict station, cold press juices',
                'price' => 25.00,
                'per_night' => true,
            ],
            [
                'id' => 'limousine',
                'name' => 'Airport Executive Limousine Chauffeur',
                'description' => 'Mercedes S-Class private transfer with refreshments & luggage handling',
                'price' => 95.00,
                'per_night' => false,
            ],
            [
                'id' => 'spa',
                'name' => 'Signature Wellness Spa & Thermal Pass',
                'description' => '60-minute therapeutic massage plus complimentary sauna & eucalyptus steam access',
                'price' => 120.00,
                'per_night' => false,
            ],
            [
                'id' => 'late_checkout',
                'name' => 'Guaranteed Late Check-Out (Until 3:00 PM)',
                'description' => 'Relax and enjoy hotel facilities without rush on your departure day',
                'price' => 45.00,
                'per_night' => false,
            ],
        ];

        return view('booking.create', compact(
            'roomType',
            'allRoomTypes',
            'checkIn',
            'checkOut',
            'adults',
            'children',
            'nights',
            'addOnCatalog'
        ));
    }

    /**
     * Process reservation creation and redirect to secure payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1|max:10',
            'children' => 'nullable|integer|min:0|max:10',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'id_type' => 'required|string',
            'id_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'special_requests' => 'nullable|string|max:500',
        ]);

        return DB::transaction(function () use ($request) {
            $roomType = RoomType::findOrFail($request->room_type_id);
            $checkIn = Carbon::parse($request->check_in_date);
            $checkOut = Carbon::parse($request->check_out_date);
            $nights = max(1, $checkIn->diffInDays($checkOut));

            // 1. Create or update guest record
            $guest = Guest::updateOrCreate(
                ['email' => $request->email],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'id_type' => $request->id_type,
                    'id_number' => $request->id_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'country' => $request->country,
                ]
            );

            // 2. Financial calculation
            $roomRate = $roomType->base_price;
            $totalRoomCharges = $roomRate * $nights;
            
            // Add-ons calculation
            $servicesCharges = 0;
            $selectedServices = [];

            if ($request->has('services') && is_array($request->services)) {
                $servicePrices = [
                    'Royal Champagne Breakfast Buffet' => 25.00 * ($request->adults) * $nights,
                    'Airport Executive Limousine Chauffeur' => 95.00,
                    'Signature Wellness Spa & Thermal Pass' => 120.00,
                    'Guaranteed Late Check-Out (Until 3:00 PM)' => 45.00,
                ];

                foreach ($request->services as $serviceName) {
                    if (isset($servicePrices[$serviceName])) {
                        $cost = $servicePrices[$serviceName];
                        $servicesCharges += $cost;
                        $selectedServices[] = [
                            'service_name' => $serviceName,
                            'unit_price' => $cost,
                            'quantity' => 1,
                            'total_price' => $cost,
                        ];
                    }
                }
            }

            // Promo code discount (e.g. "WELCOME10" gives 10% off room rate)
            $discount = 0;
            if (strtoupper($request->promo_code ?? '') === 'WELCOME10') {
                $discount = round($totalRoomCharges * 0.10, 2);
            }

            $subtotal = ($totalRoomCharges + $servicesCharges) - $discount;
            $taxAmount = round($subtotal * 0.12, 2); // 12% standard hotel tax
            $totalAmount = round($subtotal + $taxAmount, 2);

            // 3. Create Reservation
            $reservation = Reservation::create([
                'booking_reference' => Reservation::generateBookingReference(),
                'guest_id' => $guest->id,
                'room_type_id' => $roomType->id,
                'check_in_date' => $checkIn->format('Y-m-d'),
                'check_out_date' => $checkOut->format('Y-m-d'),
                'adults' => $request->adults,
                'children' => $request->children ?? 0,
                'nights' => $nights,
                'room_rate_per_night' => $roomRate,
                'total_room_charges' => $totalRoomCharges,
                'services_charges' => $servicesCharges,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discount,
                'total_amount' => $totalAmount,
                'paid_amount' => 0.00,
                'booking_status' => 'pending',
                'payment_status' => 'pending',
                'special_requests' => $request->special_requests,
            ]);

            // Save services
            foreach ($selectedServices as $service) {
                $reservation->services()->create($service);
            }

            return redirect()->route('booking.payment', $reservation->booking_reference)
                ->with('info', 'Your room has been temporarily reserved. Please complete payment to confirm your booking.');
        });
    }

    /**
     * Display secure payment transaction checkout.
     */
    public function payment($reference)
    {
        $reservation = Reservation::where('booking_reference', $reference)
            ->with(['guest', 'roomType', 'services'])
            ->firstOrFail();

        if ($reservation->booking_status === 'confirmed' && $reservation->payment_status === 'paid') {
            return redirect()->route('booking.confirmation', $reservation->booking_reference);
        }

        return view('booking.payment', compact('reservation'));
    }

    /**
     * Process payment transaction, generate digital receipt, assign room.
     */
    public function processPayment(Request $request, $reference)
    {
        $reservation = Reservation::where('booking_reference', $reference)
            ->with(['guest', 'roomType'])
            ->firstOrFail();

        $request->validate([
            'payment_method' => 'required|in:card,upi,netbanking,cash',
            'card_name' => 'required_if:payment_method,card|nullable|string|max:100',
            'card_number' => 'required_if:payment_method,card|nullable|string',
            'card_expiry' => 'required_if:payment_method,card|nullable|string',
            'card_cvv' => 'required_if:payment_method,card|nullable|string',
            'upi_id' => 'required_if:payment_method,upi|nullable|string',
        ]);

        return DB::transaction(function () use ($request, $reservation) {
            $paymentMethod = $request->payment_method;
            $cardLastFour = null;
            $cardBrand = null;

            if ($paymentMethod === 'card') {
                $cleanNumber = preg_replace('/\D/', '', $request->card_number ?? '4242');
                $cardLastFour = substr($cleanNumber, -4) ?: '4242';
                $cardBrand = str_starts_with($cleanNumber, '5') ? 'Mastercard' : (str_starts_with($cleanNumber, '3') ? 'Amex' : 'Visa');
            }

            // Create Payment record
            $payment = Payment::create([
                'reservation_id' => $reservation->id,
                'transaction_id' => Payment::generateTransactionId(),
                'receipt_number' => Payment::generateReceiptNumber(),
                'payment_method' => $paymentMethod,
                'amount' => $reservation->total_amount,
                'currency' => 'USD',
                'payment_status' => 'successful',
                'card_last_four' => $cardLastFour,
                'card_brand' => $cardBrand,
                'gateway_reference' => 'GATEWAY_' . strtoupper(Str::random(10)),
                'paid_at' => Carbon::now(),
                'notes' => 'Automated online checkout payment confirmed.',
            ]);

            // Automatically find and assign available physical room
            $availableRoom = Room::where('room_type_id', $reservation->room_type_id)
                ->where('status', 'available')
                ->where('housekeeping_status', 'clean')
                ->first();

            if (!$availableRoom) {
                // Fallback: any available room of this type
                $availableRoom = Room::where('room_type_id', $reservation->room_type_id)
                    ->whereIn('status', ['available', 'cleaning'])
                    ->first();
            }

            $assignedRoomId = $availableRoom ? $availableRoom->id : null;

            // Update Reservation
            $reservation->update([
                'room_id' => $assignedRoomId,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
                'paid_amount' => $reservation->total_amount,
                'assigned_key_card' => $availableRoom ? 'KEY-' . $availableRoom->room_number . '-ONLINE' : null,
            ]);

            // Update room status
            if ($availableRoom) {
                $isToday = $reservation->check_in_date->isToday();
                $availableRoom->update([
                    'status' => $isToday ? 'occupied' : 'reserved',
                ]);
            }

            return redirect()->route('booking.confirmation', $reservation->booking_reference)
                ->with('success', 'Payment successful! Your reservation has been confirmed and your digital receipt is ready.');
        });
    }

    /**
     * Confirmation celebration page.
     */
    public function confirmation($reference)
    {
        $reservation = Reservation::where('booking_reference', $reference)
            ->with(['guest', 'roomType', 'room', 'services', 'payments'])
            ->firstOrFail();

        $latestPayment = $reservation->payments()->latest()->first();

        return view('booking.confirmation', compact('reservation', 'latestPayment'));
    }

    /**
     * Digital Printable Receipt & Voucher with Barcode & QR.
     */
    public function receipt($reference)
    {
        $reservation = Reservation::where('booking_reference', $reference)
            ->with(['guest', 'roomType', 'room', 'services', 'payments'])
            ->firstOrFail();

        $payment = $reservation->payments()->latest()->first();

        return view('booking.receipt', compact('reservation', 'payment'));
    }

    /**
     * Guest Booking Lookup / Find My Reservation.
     */
    public function lookup(Request $request)
    {
        $reservation = null;
        $error = null;

        if ($request->filled('booking_reference') && $request->filled('email')) {
            $reservation = Reservation::where('booking_reference', trim($request->booking_reference))
                ->whereHas('guest', function ($q) use ($request) {
                    $q->where('email', trim($request->email));
                })
                ->with(['guest', 'roomType', 'room', 'services', 'payments'])
                ->first();

            if (!$reservation) {
                $error = 'No reservation found with that reference code and email combination. Please check your details and try again.';
            }
        }

        return view('booking.lookup', compact('reservation', 'error'));
    }
}
