<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user && $user->can('create-patient', new Patient());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2'],
            'middle_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string'],
            'address_line_1' => ['required', 'string'],
            'address_line_2' => ['nullable', 'string'],
            'address_barangay' => ['required', 'string'],
            'address_city' => ['required', 'string'],
            'address_province' => ['required', 'string'],
            'address_postal_code' => ['required', 'numeric'],
            'occupation' => ['required', 'string'],
            'religion' => ['required', 'string'],
            'contact_number' => ['required', 'string'],
        ];
    }
}
