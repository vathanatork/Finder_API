<?php

namespace App\Http\Requests\Mobile\V01;

use Illuminate\Foundation\Http\FormRequest;

class UniversityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getSearch()
    {
        return request()->search;
    }

    public function getPaginate()
    {
        return request()->limit ?? 10;
    }

    public function getMajor()
    {
        return request()->major;
    }

    public function getType()
    {
        return request()->type;
    }

    public function getDegree()
    {
        return request()->degree;
    }

    public function getLocation()
    {
        return request()->location;
    }
}
