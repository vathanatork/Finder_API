<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class EventCategoryRequest extends FormRequest
{
    public function rules(): array
    {

        $rules = [
            'name_en' => 'required|string',
            'name_kh' => 'required|string',
            'is_active' => 'boolean'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            foreach ($rules as $key => &$rule) {
                if (is_string($rule) && Str::contains($rule, 'required')) {
                    $rule = Str::replaceFirst('required', 'sometimes', $rule);
                }
            }
        }

        return $rules;
    }

    public function getNameEn()
    {
        return request()->name_en;
    }

    public function getNameKh()
    {
        return request()->name_kh;
    }

    public function getIsActive()
    {
        return request()->is_active;
    }

}
