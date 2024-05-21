<?php

namespace App\Http\Requests\Mobile\V01;

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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
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
}
