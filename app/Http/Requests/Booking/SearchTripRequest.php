<?php

declare(strict_types=1);

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchTripRequest extends FormRequest
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
            'direction' => ['nullable', 'string'],
            'pickup' => ['nullable', 'string'],
            'dropoff' => ['nullable', 'string'],
            'from' => ['nullable', 'string'],
            'to' => ['nullable', 'string'],
            'date' => ['nullable', 'date_format:Y-m-d'],
        ];
    }
}
