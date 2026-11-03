<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'amount' => function (array $attributes) {
                return Booking::find($attributes['booking_id'])?->final_fare ?? 55.00;
            },
            'currency' => 'CAD',
            'payment_method' => 'cash',
            'status' => 'unpaid',
            'collected_by' => null,
            'collected_at' => null,
        ];
    }

    /**
     * Indicate that cash has been physically collected.
     */
    public function paid(?User $rider = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'collected_by' => $rider?->id ?? User::factory()->rider(),
            'collected_at' => now(),
        ]);
    }
}
