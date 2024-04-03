<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:50',
            'email' => request()->route('user')
                ? 'required|email|max:255|unique:users,email,NULL,' . request()->route('user')
                : 'required|email|max:255|unique:users,email,NULL,id',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
    }
}
