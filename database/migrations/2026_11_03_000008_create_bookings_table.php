<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference', 20)->unique();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('trip_id')->constrained('trips')->restrictOnDelete();
            $table->foreignId('boarding_stop_id')->constrained('route_stops')->restrictOnDelete();
            $table->foreignId('dropoff_stop_id')->constrained('route_stops')->restrictOnDelete();
            $table->unsignedTinyInteger('seat_count')->default(1);
            $table->decimal('base_fare', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('final_fare', 10, 2);
            $table->string('currency', 3)->default('CAD');
            $table->string('status', 20)->default('confirmed');
            $table->dateTime('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('user_id', 'idx_bookings_user');
            $table->index('trip_id', 'idx_bookings_trip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
