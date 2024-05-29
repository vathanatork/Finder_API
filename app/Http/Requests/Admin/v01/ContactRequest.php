<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'address' => 'required|string',
            'primary_phone_number' => 'required|string|between:8,10',
            'email' => 'required|email'
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

    public function getAddress()
    {
        return request()->address;
    }

    public function getPrimaryPhoneNumber()
    {
        return request()->primary_phone_number;
    }

    public function getSecondPhoneNumber()
    {
        return request()->second_phone_number;
    }

    public function getThirdPhoneNumber()
    {
        return request()->third_phone_number ;
    }

    public function getIsActive()
    {
        return request()->is_active ?? 1;
    }
}
