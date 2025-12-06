<?php

namespace App\Http\Requests;

use App\Enums\GenderIdentity;
use App\Enums\MaritalStatus;
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

        return $user && $user->can('createPatient', new Patient());
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('gender')) {
            $this->merge([
                'gender' => strtoupper($this->input('gender'))
            ]);
        }

        if ($this->has('biological_sex')) {
            $this->merge([
                'biological_sex' => strtoupper($this->input('biological_sex'))
            ]);
        }

        if ($this->has('marital_status')) {
            $this->merge([
                'marital_status' => strtoupper($this->input('marital_status'))
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $genderIdentity = array_column(GenderIdentity::cases(), 'value');
        $maritalStatus = array_column(MaritalStatus::cases(), 'value');

        return [
            'first_name' => ['required', 'string', 'min:2'],
            'middle_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'gender' => ['required', 'string', 'in:'.join(',', $genderIdentity)],
            'biological_sex' => ['required', 'string', 'in:MALE,FEMALE'],
            'marital_status' => ['required', 'string', 'in:'.join(',', $maritalStatus)],
            'blood_type' => ['required', 'string'],
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
