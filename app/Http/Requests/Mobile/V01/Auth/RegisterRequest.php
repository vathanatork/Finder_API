<?php

namespace App\Http\Requests\Mobile\V01\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'birthday'=>'required|date',
            'gender'=>'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function getName()
    {
        return request()->name;
    }

    public function getEmail()
    {
        return request()->email;
    }

    public function getPassword(): ?string
    {
        return request()->password;
    }

    public function getBirthday()
    {
        return request()->birthday;
    }

    public function getGender()
    {
        return request()->gender;
    }
}
