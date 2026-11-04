<?php

declare(strict_types=1);

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isPassenger();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_id' => ['required', 'integer', 'exists:trips,id'],
            'vehicle_seat_ids' => ['required', 'array', 'min:1', 'max:6'],
            'vehicle_seat_ids.*' => ['required', 'integer', 'distinct', 'exists:vehicle_seats,id'],
            'boarding_stop_id' => ['required', 'integer', 'exists:route_stops,id'],
            'dropoff_stop_id' => ['required', 'integer', 'exists:route_stops,id'],
            'coupon_code' => ['nullable', 'string', 'max:30'],
            'idempotency_key' => ['nullable', 'string', 'max:64'],
        ];
    }

    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'vehicle_seat_ids.required' => 'Please select at least one seat on the vehicle cabin diagram.',
            'vehicle_seat_ids.min' => 'You must select at least 1 passenger seat.',
            'vehicle_seat_ids.max' => 'You cannot reserve more than 6 passenger seats in a single booking.',
            'boarding_stop_id.required' => 'Please specify your departure pickup hub.',
            'dropoff_stop_id.required' => 'Please specify your destination drop-off hub.',
        ];
    }
}
