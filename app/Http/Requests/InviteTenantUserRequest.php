<?php

namespace App\Http\Requests;

use App\Models\Tenant;
use Auth;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class InviteTenantUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->can('invite-user', $this->route('tenant'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'role_id' => ['required', 'string']
        ];
    }
}
