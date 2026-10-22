<?php

namespace Database\Seeders;

use App\Models\FacilityBooking;
use App\Models\FacilityOperation;
use App\Models\Guest;
use App\Models\HousekeepingTask;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Staff & Admin Accounts
        User::create([
            'name' => 'Alexander Vance',
            'email' => 'admin@hotel.com',
            'role' => 'admin',
            'phone' => '+1 (555) 019-2834',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Elena Rostova',
            'email' => 'reception@hotel.com',
            'role' => 'receptionist',
            'phone' => '+1 (555) 018-7721',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Carlos Mendez',
            'email' => 'housekeeping@hotel.com',
            'role' => 'housekeeper',
            'phone' => '+1 (555) 017-4490',
            'password' => Hash::make('password123'),
        ]);

        // 2. Room Types
        $roomTypes = [
            [
                'name' => 'Presidential Penthouse Suite',
                'slug' => 'presidential-penthouse-suite',
                'tagline' => 'Unrivaled 360° skyline vistas with private jacuzzi terrace & butler service',
                'description' => 'Experience the pinnacle of hospitality. Spanning 1,200 square feet on the top floor, this penthouse features custom Italian furnishings, an expansive marble bathroom with a freestanding hydrotherapy jacuzzi, a private dining room, and around-the-clock bespoke butler assistance.',
                'base_price' => 650.00,
                'capacity_adults' => 3,
                'capacity_children' => 2,
                'bed_type' => '1 California King Bed',
                'room_size_sqft' => 1200,
                'featured_image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80'
                ],
                'amenities' => [
                    'Private Terrace Jacuzzi',
                    '24/7 Dedicated Butler',
                    'Complimentary Moët & Chandon',
                    'Nespresso Vertuo Bar',
                    '75" 4K Bang & Olufsen Sound System',
                    'Executive Airport Limousine Transfer',
                    'Molton Brown Toiletries',
                    'High-speed Wi-Fi 6'
                ],
            ],
            [
                'name' => 'Executive Ocean View Suite',
                'slug' => 'executive-ocean-view-suite',
                'tagline' => 'Breathtaking coastal horizons, deep soaking tub & walk-out sun deck',
                'description' => 'A serene sanctuary suspended between the ocean and sky. Wake up to gentle sunrise waves, unwind on your private teak balcony, and sink into an oversized king bed draped in 600-thread-count Egyptian cotton linens.',
                'base_price' => 380.00,
                'capacity_adults' => 2,
                'capacity_children' => 1,
                'bed_type' => '1 Ultra-Plush King Bed',
                'room_size_sqft' => 750,
                'featured_image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80'
                ],
                'amenities' => [
                    'Panoramic Ocean View Balcony',
                    'Marble Bathroom with Deep Tub',
                    'Artisan Minibar Selection',
                    'Complimentary Gourmet Breakfast',
                    '65" 4K Smart TV with Netflix',
                    'Ergonomic Workstation',
                    'Ultra-Fast Fiber Internet',
                    'Plush Bathrobes & Slippers'
                ],
            ],
            [
                'name' => 'Royal Deluxe King',
                'slug' => 'royal-deluxe-king',
                'tagline' => 'Contemporary urban luxury with bespoke craftsmanship & soundproof peace',
                'description' => 'Elegantly curated for both discerning corporate travelers and weekend romantic getaways. Offers floor-to-ceiling double-glazed windows, atmospheric circadian lighting, and an expansive walk-in rain shower.',
                'base_price' => 240.00,
                'capacity_adults' => 2,
                'capacity_children' => 1,
                'bed_type' => '1 King Bed',
                'room_size_sqft' => 520,
                'featured_image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80'
                ],
                'amenities' => [
                    'City Skyline Vista',
                    'Walk-in Rainforest Shower',
                    'Acoustic Soundproofing',
                    'Specialty Coffee Machine',
                    '55" 4K Smart TV',
                    'In-Room Digital Safe',
                    'Turndown Pillow Menu',
                    'High-Speed Wi-Fi'
                ],
            ],
            [
                'name' => 'Signature Family Penthouse',
                'slug' => 'signature-family-penthouse',
                'tagline' => 'Spacious dual-bedroom layout with open kitchenette & kids chill lounge',
                'description' => 'The ultimate luxury home away from home. Designed for multi-generational families or group travelers, featuring two secluded bedrooms, two full bathrooms, a fully equipped kitchenette, and dining table.',
                'base_price' => 450.00,
                'capacity_adults' => 4,
                'capacity_children' => 2,
                'bed_type' => '2 Queen Beds + 1 Sofa Bed',
                'room_size_sqft' => 980,
                'featured_image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80'
                ],
                'amenities' => [
                    '2 Private Bedrooms & 2 Baths',
                    'Gourmet Kitchenette & Fridge',
                    'Kids Entertainment Console',
                    'Spacious Family Dining Area',
                    '2x 55" Smart TVs',
                    'Washer & Dryer in Unit',
                    'Crib & Highchair upon request',
                    'Complimentary Breakfast Buffet'
                ],
            ],
            [
                'name' => 'Grand Classic Double',
                'slug' => 'grand-classic-double',
                'tagline' => 'Timeless comfort with serene garden courtyard views & cozy ambiance',
                'description' => 'An immaculate retreat designed for friends or colleagues sharing a room. Equipped with two queen size pillow-top mattresses, blackout curtains, and warm oak accents throughout.',
                'base_price' => 175.00,
                'capacity_adults' => 2,
                'capacity_children' => 1,
                'bed_type' => '2 Double Beds',
                'room_size_sqft' => 420,
                'featured_image' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80'
                ],
                'amenities' => [
                    'Quiet Courtyard Garden View',
                    'Dual Double Beds',
                    'En-suite Bathroom with Tub',
                    'Electric Kettle & Tea Chest',
                    '50" Smart TV',
                    'Climate Control Thermostat',
                    'Daily Housekeeping',
                    'High-Speed Wi-Fi'
                ],
            ],
        ];

        $createdRoomTypes = [];
        foreach ($roomTypes as $data) {
            $createdRoomTypes[] = RoomType::create($data);
        }

        // 3. Physical Rooms (20 Rooms across Floors 1 to 5)
        $roomConfigs = [
            // Floor 1 (Classic Double & Deluxe King)
            ['101', 1, $createdRoomTypes[4]->id, 'available', 'clean'],
            ['102', 1, $createdRoomTypes[4]->id, 'occupied', 'clean'],
            ['103', 1, $createdRoomTypes[2]->id, 'available', 'clean'],
            ['104', 1, $createdRoomTypes[2]->id, 'cleaning', 'dirty'],
            // Floor 2 (Deluxe King & Ocean View)
            ['201', 2, $createdRoomTypes[2]->id, 'available', 'clean'],
            ['202', 2, $createdRoomTypes[2]->id, 'occupied', 'clean'],
            ['203', 2, $createdRoomTypes[1]->id, 'available', 'clean'],
            ['204', 2, $createdRoomTypes[1]->id, 'reserved', 'clean'],
            // Floor 3 (Ocean View & Family Penthouse)
            ['301', 3, $createdRoomTypes[1]->id, 'available', 'clean'],
            ['302', 3, $createdRoomTypes[1]->id, 'occupied', 'clean'],
            ['303', 3, $createdRoomTypes[3]->id, 'available', 'clean'],
            ['304', 3, $createdRoomTypes[3]->id, 'maintenance', 'inspecting'],
            // Floor 4 (Family Penthouse & Ocean View)
            ['401', 4, $createdRoomTypes[3]->id, 'available', 'clean'],
            ['402', 4, $createdRoomTypes[1]->id, 'available', 'clean'],
            ['403', 4, $createdRoomTypes[2]->id, 'available', 'clean'],
            ['404', 4, $createdRoomTypes[4]->id, 'available', 'clean'],
            // Floor 5 (Penthouse Suite & Executive)
            ['501', 5, $createdRoomTypes[0]->id, 'available', 'clean'],
            ['502', 5, $createdRoomTypes[0]->id, 'occupied', 'clean'],
            ['503', 5, $createdRoomTypes[1]->id, 'available', 'clean'],
            ['504', 5, $createdRoomTypes[0]->id, 'reserved', 'clean'],
        ];

        $createdRooms = [];
        foreach ($roomConfigs as $cfg) {
            $createdRooms[] = Room::create([
                'room_number' => $cfg[0],
                'floor' => $cfg[1],
                'room_type_id' => $cfg[2],
                'status' => $cfg[3],
                'housekeeping_status' => $cfg[4],
                'notes' => 'Inspected standard luxury unit.',
            ]);
        }

        // 4. Guests
        $guestsData = [
            [
                'first_name' => 'Sophia',
                'last_name' => 'Montgomery',
                'email' => 'sophia.montgomery@example.com',
                'phone' => '+1 (415) 890-1122',
                'id_type' => 'Passport',
                'id_number' => 'US-88491029',
                'address' => '742 Evergreen Terrace',
                'city' => 'San Francisco',
                'country' => 'United States',
                'vip_status' => true,
                'notes' => 'Prefers hypoallergenic feather-free pillows and sparkling water.',
            ],
            [
                'first_name' => 'Marcus',
                'last_name' => 'Aurelius',
                'email' => 'marcus.aurelius@example.com',
                'phone' => '+44 20 7946 0912',
                'id_type' => 'Passport',
                'id_number' => 'GB-49281720',
                'address' => '10 Downing Mews',
                'city' => 'London',
                'country' => 'United Kingdom',
                'vip_status' => true,
                'notes' => 'Frequent corporate visitor; request late checkout when possible.',
            ],
            [
                'first_name' => 'Amara',
                'last_name' => 'Patel',
                'email' => 'amara.patel@example.com',
                'phone' => '+91 98201 54321',
                'id_type' => 'National ID',
                'id_number' => 'IN-90817264',
                'address' => '45 Marine Drive, Nariman Point',
                'city' => 'Mumbai',
                'country' => 'India',
                'vip_status' => false,
                'notes' => 'Traveling for anniversary celebration.',
            ],
            [
                'first_name' => 'Liam',
                'last_name' => 'Chen',
                'email' => 'liam.chen@example.com',
                'phone' => '+65 6789 0123',
                'id_type' => 'Passport',
                'id_number' => 'SG-59281903',
                'address' => '12 Marina Boulevard',
                'city' => 'Singapore',
                'country' => 'Singapore',
                'vip_status' => false,
                'notes' => 'Requested high floor with quiet corner.',
            ],
        ];

        $createdGuests = [];
        foreach ($guestsData as $g) {
            $createdGuests[] = Guest::create($g);
        }

        // 5. Active & Past Reservations
        // Reservation 1: Sophia Montgomery (Currently Checked In - Room 502 Penthouse)
        $res1 = Reservation::create([
            'booking_reference' => 'GH-26-PENT01',
            'guest_id' => $createdGuests[0]->id,
            'room_type_id' => $createdRoomTypes[0]->id,
            'room_id' => $createdRooms[17]->id, // 502
            'check_in_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            'check_out_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'nights' => 3,
            'room_rate_per_night' => 650.00,
            'total_room_charges' => 1950.00,
            'services_charges' => 220.00,
            'tax_amount' => 260.40,
            'discount_amount' => 0.00,
            'total_amount' => 2430.40,
            'paid_amount' => 2430.40,
            'booking_status' => 'checked_in',
            'payment_status' => 'paid',
            'special_requests' => 'Chilled Dom Pérignon ready on arrival; late check-out at 1:00 PM.',
            'assigned_key_card' => 'KEY-PH-502-A',
            'checked_in_at' => Carbon::now()->subDays(1)->setTime(14, 30),
        ]);

        ReservationService::create([
            'reservation_id' => $res1->id,
            'service_name' => 'Airport Limousine Pickup',
            'unit_price' => 120.00,
            'quantity' => 1,
            'total_price' => 120.00,
        ]);
        ReservationService::create([
            'reservation_id' => $res1->id,
            'service_name' => 'Signature Champagne Welcome Package',
            'unit_price' => 100.00,
            'quantity' => 1,
            'total_price' => 100.00,
        ]);

        Payment::create([
            'reservation_id' => $res1->id,
            'transaction_id' => 'TXN-20261021-994812',
            'receipt_number' => 'RCPT-2026-00101',
            'payment_method' => 'card',
            'amount' => 2430.40,
            'currency' => 'USD',
            'payment_status' => 'successful',
            'card_last_four' => '4242',
            'card_brand' => 'Visa',
            'gateway_reference' => 'STRIPE_CH_90192834',
            'paid_at' => Carbon::now()->subDays(1)->setTime(14, 20),
            'notes' => 'Paid in full via online checkout.',
        ]);

        // Reservation 2: Marcus Aurelius (Currently Checked In - Room 202)
        $res2 = Reservation::create([
            'booking_reference' => 'GH-26-EXEC02',
            'guest_id' => $createdGuests[1]->id,
            'room_type_id' => $createdRoomTypes[2]->id,
            'room_id' => $createdRooms[5]->id, // 202
            'check_in_date' => Carbon::now()->format('Y-m-d'),
            'check_out_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'adults' => 1,
            'children' => 0,
            'nights' => 3,
            'room_rate_per_night' => 240.00,
            'total_room_charges' => 720.00,
            'services_charges' => 75.00,
            'tax_amount' => 95.40,
            'discount_amount' => 50.00,
            'total_amount' => 840.40,
            'paid_amount' => 840.40,
            'booking_status' => 'checked_in',
            'payment_status' => 'paid',
            'special_requests' => 'High floor, quiet side of building. HDMI cable for workspace monitor.',
            'assigned_key_card' => 'KEY-202-B',
            'checked_in_at' => Carbon::now()->setTime(11, 15),
        ]);

        ReservationService::create([
            'reservation_id' => $res2->id,
            'service_name' => 'Gourmet Buffet Breakfast (3 Days)',
            'unit_price' => 25.00,
            'quantity' => 3,
            'total_price' => 75.00,
        ]);

        Payment::create([
            'reservation_id' => $res2->id,
            'transaction_id' => 'TXN-20261021-881234',
            'receipt_number' => 'RCPT-2026-00102',
            'payment_method' => 'card',
            'amount' => 840.40,
            'currency' => 'USD',
            'payment_status' => 'successful',
            'card_last_four' => '1199',
            'card_brand' => 'Mastercard',
            'gateway_reference' => 'STRIPE_CH_77281920',
            'paid_at' => Carbon::now()->setTime(11, 10),
            'notes' => 'Corporate travel card payment.',
        ]);

        // Reservation 3: Amara Patel (Upcoming Confirmed Reservation - Room 204)
        $res3 = Reservation::create([
            'booking_reference' => 'GH-26-OCN003',
            'guest_id' => $createdGuests[2]->id,
            'room_type_id' => $createdRoomTypes[1]->id,
            'room_id' => $createdRooms[7]->id, // 204
            'check_in_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'check_out_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'nights' => 3,
            'room_rate_per_night' => 380.00,
            'total_room_charges' => 1140.00,
            'services_charges' => 150.00,
            'tax_amount' => 154.80,
            'discount_amount' => 0.00,
            'total_amount' => 1444.80,
            'paid_amount' => 1444.80,
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
            'special_requests' => 'Anniversary cake and flower arrangement in room before check-in.',
        ]);

        ReservationService::create([
            'reservation_id' => $res3->id,
            'service_name' => 'Couples Thermal Spa & Aroma Therapy',
            'unit_price' => 150.00,
            'quantity' => 1,
            'total_price' => 150.00,
        ]);

        Payment::create([
            'reservation_id' => $res3->id,
            'transaction_id' => 'TXN-20261021-339182',
            'receipt_number' => 'RCPT-2026-00103',
            'payment_method' => 'upi',
            'amount' => 1444.80,
            'currency' => 'USD',
            'payment_status' => 'successful',
            'gateway_reference' => 'UPI-REF-902847120',
            'paid_at' => Carbon::now()->subHours(5),
            'notes' => 'Confirmed via online instant booking portal.',
        ]);

        // 6. Housekeeping Tasks
        HousekeepingTask::create([
            'room_id' => $createdRooms[3]->id, // 104
            'assigned_staff_name' => 'Carlos Mendez',
            'task_type' => 'checkout_sanitization',
            'priority' => 'high',
            'status' => 'in_progress',
            'notes' => 'Guest checked out this morning. Complete sanitization, restock linens & amenities.',
        ]);

        HousekeepingTask::create([
            'room_id' => $createdRooms[11]->id, // 304
            'assigned_staff_name' => 'Maria Santos',
            'task_type' => 'deep_cleaning',
            'priority' => 'normal',
            'status' => 'pending',
            'notes' => 'Quarterly upholstery steaming and carpet wash.',
        ]);

        HousekeepingTask::create([
            'room_id' => $createdRooms[19]->id, // 504
            'assigned_staff_name' => 'Carlos Mendez',
            'task_type' => 'turn_down',
            'priority' => 'normal',
            'status' => 'completed',
            'notes' => 'Prepared room for VIP arrival tomorrow.',
            'completed_at' => Carbon::now()->subHours(2),
        ]);

        // 7. Facility Operations
        $facilities = [
            [
                'facility_name' => 'Azure Infinity Sky Pool & Cabanas',
                'icon' => 'bi-water',
                'operating_hours' => '06:00 AM - 10:00 PM',
                'location' => 'Rooftop Terrace (Level 5)',
                'status' => 'operational',
                'manager_in_charge' => 'Julian Drake',
                'daily_maintenance_notes' => 'Water pH balanced at 7.4. All private cabanas wiped and stocked with fresh Egyptian cotton towels.',
            ],
            [
                'facility_name' => 'Serenity Luxury Spa & Thermal Bath',
                'icon' => 'bi-flower1',
                'operating_hours' => '08:00 AM - 09:00 PM',
                'location' => 'Level 2 Wellness Wing',
                'status' => 'operational',
                'manager_in_charge' => 'Chloe Bennett',
                'daily_maintenance_notes' => 'Eucalyptus steam room running at optimal 42°C. Aromatherapy oils replenished.',
            ],
            [
                'facility_name' => 'Grand Horizon Ballroom & Banquets',
                'icon' => 'bi-building',
                'operating_hours' => 'Events by Reservation',
                'location' => 'Ground Floor East Pavilion',
                'status' => 'operational',
                'manager_in_charge' => 'David Sterling',
                'daily_maintenance_notes' => 'Acoustic testing and crystal chandelier lighting checks completed for evening gala.',
            ],
            [
                'facility_name' => 'Olympus Elite Fitness & Gym',
                'icon' => 'bi-activity',
                'operating_hours' => '24 Hours (Keycard Access)',
                'location' => 'Level 2 Mezzanine',
                'status' => 'operational',
                'manager_in_charge' => 'Tanya Gomez',
                'daily_maintenance_notes' => 'Technogym treadmills and Peloton bikes calibrated. Cold towels and detox citrus water refilled.',
            ],
            [
                'facility_name' => 'The Zenith Executive Boardroom',
                'icon' => 'bi-briefcase',
                'operating_hours' => '07:00 AM - 08:00 PM',
                'location' => 'Level 4 Executive Wing',
                'status' => 'private_booking',
                'manager_in_charge' => 'David Sterling',
                'daily_maintenance_notes' => 'Reserved for Private Tech Summit conference 2:00 PM - 6:00 PM.',
            ],
        ];

        $createdFacilities = [];
        foreach ($facilities as $f) {
            $createdFacilities[] = FacilityOperation::create($f);
        }

        // 8. Facility Bookings
        FacilityBooking::create([
            'facility_id' => $createdFacilities[1]->id, // Spa
            'reservation_id' => $res1->id,
            'guest_name' => 'Sophia Montgomery',
            'guest_email' => 'sophia.montgomery@example.com',
            'booking_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'time_slot' => '04:00 PM - 05:30 PM',
            'guest_count' => 2,
            'status' => 'confirmed',
            'total_price' => 150.00,
            'special_notes' => 'Aromatherapy lavender relaxation massage.',
        ]);

        FacilityBooking::create([
            'facility_id' => $createdFacilities[4]->id, // Boardroom
            'reservation_id' => $res2->id,
            'guest_name' => 'Marcus Aurelius',
            'guest_email' => 'marcus.aurelius@example.com',
            'booking_date' => Carbon::now()->format('Y-m-d'),
            'time_slot' => '02:00 PM - 06:00 PM',
            'guest_count' => 8,
            'status' => 'confirmed',
            'total_price' => 350.00,
            'special_notes' => 'Projector setup and sparkling coffee service required.',
        ]);
    }
}
