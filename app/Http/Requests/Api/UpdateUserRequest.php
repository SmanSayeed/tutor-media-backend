<?php

namespace App\Http\Requests\Api;

use App\Traits\MediaUploader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    use MediaUploader;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('client')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username,'.auth('client')->id()],
            'phone' => ['nullable', 'string', 'max:255', 'unique:users,phone'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => ['nullable', 'string', 'max:255'],
        ];

        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        if (isset($data['avatar'])) {
            /**
             * @var \App\Models\User $user
             */
            $user = auth('client')->user();
            if ($user->avatar) {
                $this->delete($user->avatar);
            }
            $data['avatar'] = $this->upload($data['avatar'], 'avatar');
        }

        return $data;
    }
}
