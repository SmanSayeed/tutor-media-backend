<?php

namespace App\Http\Requests\Api;

use App\Enums\UserRolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'digits:11', 'regex:/^01[0-9]{9}$/', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'referer' => ['nullable', 'string', 'max:255'],
            'terms' => ['required', 'in:0,1'],
            'role' => ['required', 'in:'.UserRolesEnum::TUTOR->value.', '.UserRolesEnum::GUARDIAN->value],
        ];

        return $rules;
    }

    public function validated($key = null, $default = null)
    {

        $data = parent::validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['referer'])) {
            unset($data['referer']);
        }

        return $data;

    }
}
