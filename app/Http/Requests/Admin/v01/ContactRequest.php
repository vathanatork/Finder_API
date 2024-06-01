<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ContactRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string',
            'address' => 'required|string',
            'primary_phone_number' => 'required|string|between:8,10',
            'email' => 'required|email'
        ];

        // If the request method is PUT or PATCH (i.e., update), change 'required' to 'sometimes'
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            foreach ($rules as $key => $rule) {
                if (is_string($rule) && Str::contains($rule, 'required')) {
                    $rules[$key] = 'sometimes|' . Str::after($rule, 'required|');
                }
            }
        }

        return $rules;
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
