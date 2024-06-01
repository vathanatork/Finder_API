<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class MajorAndSpecializeNameRequest extends FormRequest
{
    protected string $image_url = '';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name_kh' => 'required|string',
            'name_en' => 'required|string',
            'image_url' => 'required|string',
            'is_active' => 'boolean'
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

    public function getNameKh()
    {
        return request()->name_kh;
    }

    public function getNameEn()
    {
        return request()->name_en;
    }

    public function getIsActive()
    {
        return request()->is_active ?? true;
    }

    public function getImage()
    {
        return request()->image_url;
    }

    public function setImage($url): void
    {
        $this->image_url = $url;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}
