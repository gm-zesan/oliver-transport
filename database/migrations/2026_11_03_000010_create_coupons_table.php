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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('tab_label', 100)->nullable();
            $table->string('tag', 100)->nullable();
            $table->string('route_tag', 150)->nullable();
            $table->string('headline', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('terms', 255)->nullable();
            $table->string('accent_color', 20)->nullable()->default('#22C55E');
            $table->string('discount_type', 20);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('min_booking_amount', 10, 2)->default(0.00);
            $table->decimal('max_discount_amount', 10, 2)->nullable();
            $table->unsignedInteger('max_total_uses')->nullable();
            $table->unsignedInteger('max_uses_per_user')->default(1);
            $table->unsignedInteger('current_uses')->default(0);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_show')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
