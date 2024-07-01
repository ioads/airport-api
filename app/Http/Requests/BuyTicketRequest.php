<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyTicketRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'flight_id' => 'required',
            "buyer_name" => 'required',
            "buyer_cpf" => 'required|string|size:11',
            "buyer_birthdate" => 'required|date_format:Y-m-d',
            "buyer_email" => 'required|email',
            'passengers' => 'required|array',
            'passengers.*.class_id' => 'required|integer',
            'passengers.*.seat_number' => 'required|string',
            'passengers.*.passenger_name' => 'required|string',
            'passengers.*.passenger_cpf' => 'required|string|size:11',
            'passengers.*.passenger_birthdate' => 'required|date_format:Y-m-d',
            'passengers.*.check_baggage' => 'sometimes|boolean',
        ];
    }
}
