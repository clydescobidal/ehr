<?php

namespace App\Http\Requests;

use App\Enums\AdmissionStatus;
use App\Models\Admission;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ListAdmissionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user && $user->can('listAdmissions', new Admission());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string']
        ];
    }
}
