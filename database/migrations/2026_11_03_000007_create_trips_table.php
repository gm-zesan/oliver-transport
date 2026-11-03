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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->restrictOnDelete();
            $table->foreignId('route_id')->constrained('routes')->restrictOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->restrictOnDelete();
            $table->foreignId('rider_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('trip_date');
            $table->time('scheduled_departure_time');
            $table->string('status', 20)->default('scheduled');
            $table->timestamps();

            $table->unique(['schedule_id', 'trip_date'], 'trip_schedule_date_unique');
            $table->index(['trip_date', 'route_id'], 'idx_trips_date_route');
            $table->index(['rider_id', 'trip_date'], 'idx_trips_rider_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
