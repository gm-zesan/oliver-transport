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
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('trip_id')->constrained('trips')->restrictOnDelete();
            $table->foreignId('vehicle_seat_id')->constrained('vehicle_seats')->restrictOnDelete();
            $table->unsignedTinyInteger('boarding_sequence');
            $table->unsignedTinyInteger('dropoff_sequence');
            $table->timestamps();

            $table->index(
                ['trip_id', 'vehicle_seat_id', 'boarding_sequence', 'dropoff_sequence'],
                'idx_segment_availability'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
