<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Room Types
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description');
            $table->decimal('base_price', 10, 2);
            $table->integer('capacity_adults')->default(2);
            $table->integer('capacity_children')->default(1);
            $table->string('bed_type')->default('1 King Bed');
            $table->integer('room_size_sqft')->default(450);
            $table->string('featured_image');
            $table->json('gallery')->nullable();
            $table->json('amenities');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Rooms (Physical units)
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->integer('floor')->default(1);
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->enum('status', ['available', 'occupied', 'reserved', 'cleaning', 'maintenance'])->default('available');
            $table->enum('housekeeping_status', ['clean', 'inspecting', 'dirty'])->default('clean');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Guests
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->index();
            $table->string('phone');
            $table->string('id_type')->default('Passport');
            $table->string('id_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('vip_status')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Reservations
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('nights')->default(1);
            $table->decimal('room_rate_per_night', 10, 2);
            $table->decimal('total_room_charges', 10, 2);
            $table->decimal('services_charges', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('booking_status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'refunded'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->string('assigned_key_card')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamps();
        });

        // 5. Reservation Add-on Services
        Schema::create('reservation_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->string('service_name');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });

        // 6. Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->string('transaction_id')->unique();
            $table->string('receipt_number')->unique();
            $table->string('payment_method');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('payment_status', ['successful', 'pending', 'failed', 'refunded'])->default('successful');
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_brand')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->timestamp('paid_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 7. Housekeeping Tasks
        Schema::create('housekeeping_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('assigned_staff_name')->nullable();
            $table->enum('task_type', ['routine_cleaning', 'deep_cleaning', 'turn_down', 'linen_change', 'checkout_sanitization'])->default('routine_cleaning');
            $table->enum('priority', ['normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'verified'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 8. Facility Operations
        Schema::create('facility_operations', function (Blueprint $table) {
            $table->id();
            $table->string('facility_name');
            $table->string('icon')->default('bi-gem');
            $table->string('operating_hours');
            $table->string('location');
            $table->enum('status', ['operational', 'maintenance', 'private_booking'])->default('operational');
            $table->string('manager_in_charge')->nullable();
            $table->text('daily_maintenance_notes')->nullable();
            $table->timestamps();
        });

        // 9. Facility Bookings
        Schema::create('facility_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->constrained('facility_operations')->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();
            $table->string('guest_name');
            $table->string('guest_email')->nullable();
            $table->date('booking_date');
            $table->string('time_slot');
            $table->integer('guest_count')->default(1);
            $table->enum('status', ['confirmed', 'completed', 'cancelled'])->default('confirmed');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_bookings');
        Schema::dropIfExists('facility_operations');
        Schema::dropIfExists('housekeeping_tasks');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('reservation_services');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('guests');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
    }
};
