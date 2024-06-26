<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FinancialAidRequest extends FormRequest
{
    protected string $image_url = '';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        if ($this->isMethod('GET')) {
            $rules = [];
        }

        $rules = [
            'university_id' => 'nullable|integer',
            'name_en' => 'required|string',
            'name_kh' => 'required|string',
            'image' => 'required|string',
            'short_description_en' => 'required|string',
            'short_description_kh' => 'required|string',
            'detail_description_en' => 'required|string',
            'detail_description_kh' => 'required|string',
            'is_active' => 'boolean'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            foreach ($rules as $key => &$rule) {
                if (is_string($rule) && Str::contains($rule, 'required')) {
                    $rule = Str::replaceFirst('required', 'sometimes', $rule);
                }
            }
        }

        if ($this->isMethod('GET')) {
            $rules = [];
        }

        return $rules;

    }

    public function getLimit()
    {
        return request()->limit;
    }

    public function getActive() : bool
    {
        return request()->active;
    }
    public function getUniversityId()
    {
        return request()->university_id;
    }

    public function getNameEn()
    {
        return request()->name_en;
    }

    public function getNameKh()
    {
        return request()->name_kh;
    }

    public function getImage()
    {
        return request()->image;
    }

    public function setImageUrl($url): void
    {
        $this->image_url = $url;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }


    public function getShortDescriptionEn()
    {
        return request()->short_description_en;
    }

    public function getShortDescriptionKh()
    {
        return request()->short_description_kh;
    }

    public function getDetailDescriptionEn()
    {
        return request()->detail_description_en;
    }

    public function getDetailDescriptionKh()
    {
        return request()->detail_description_kh;
    }

    public function getIsActive()
    {
        return request()->is_active;
    }

}
