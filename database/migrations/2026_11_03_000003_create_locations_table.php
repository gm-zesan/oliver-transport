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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable()->unique();
            $table->string('name', 100);
            $table->string('name_fr', 100)->nullable();
            $table->string('city', 100);
            $table->string('city_fr', 100)->nullable();
            $table->string('province', 10);
            $table->string('address', 255)->nullable();
            $table->string('address_fr', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->string('subtitle_fr', 255)->nullable();
            $table->string('dropoff_subtitle', 255)->nullable();
            $table->string('dropoff_subtitle_fr', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
