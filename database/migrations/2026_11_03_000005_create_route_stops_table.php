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
        Schema::create('route_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->unsignedTinyInteger('stop_sequence');
            $table->time('scheduled_time')->nullable();
            $table->string('stop_type', 20);
            $table->timestamps();

            $table->unique(['route_id', 'stop_sequence'], 'route_stop_seq_unique');
            $table->index(['route_id', 'location_id'], 'idx_route_stops_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_stops');
    }
};
