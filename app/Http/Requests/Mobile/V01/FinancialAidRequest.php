<?php

namespace App\Http\Requests\Mobile\V01;

use Illuminate\Foundation\Http\FormRequest;

class FinancialAidRequest extends FormRequest
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
}
