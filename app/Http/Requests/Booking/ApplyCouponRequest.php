<?php

declare(strict_types=1);

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:30'],
            'trip_id' => ['nullable', 'integer'],
            'direction' => ['nullable', 'string'],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'seat_count' => ['required', 'integer', 'min:1', 'max:6'],
        ];
    }
}
