<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user )],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'dob' => ['required', 'date', 'before:today'],
            'avatar' => ['nullable', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
        ];
    }
}
