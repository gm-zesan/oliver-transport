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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique('payment_booking_unique')->constrained('bookings')->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('CAD');
            $table->string('payment_method', 20)->default('cash');
            $table->string('status', 20)->default('unpaid');
            $table->foreignId('collected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('collected_at')->nullable();
            $table->timestamps();

            $table->index('status', 'idx_payments_status');
            $table->index('collected_by', 'idx_payments_collected_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
