<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ScholarShipRequest extends FormRequest
{
    private string $image_url = '';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'university_id' => 'required|integer',
            'name_en' => 'required',
            'name_kh' => 'required',
            'image' => 'required',
            'description_en'=> 'required|string',
            'description_kh' => 'required|string',
            'detail_en' => 'required|string',
            'detail_kh' => 'required|string',
            'is_active' => 'boolean',
            'contact_info_id' => 'nullable|integer',
            'open_date' => 'required|date',
            'close_date' => 'required|date'
        ];

        // If the request method is PUT or PATCH (i.e., update), change 'required' to 'sometimes'
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            foreach ($rules as $key => $rule) {
                if (is_string($rule) && Str::contains($rule, 'required')) {
                    $rules[$key] = str_replace('required', 'sometimes', $rule);
                }
            }
        }

        return $rules;
    }

    public function getDetailEn()
    {
        return request()->detail_en;
    }

    public function getDetailKh()
    {
        return request()->detail_kh;
    }
    public function getOpenDate()
    {
        return request()->open_date;
    }

    public function getCloseDate()
    {
        return request()->close_date;
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

    public function getDescriptionEn()
    {
        return request()->description_en;
    }

    public function getDescriptionKh()
    {
        return request()->description_kh;
    }

    public function getContact()
    {
        return request()->contact_info_id ?: null;
    }

    public function getApplyLink()
    {
        return request()->apply_link;
    }

    public function getIsActive()
    {
        return request()->is_active;
    }
    public function setImage(string $url): void
    {
        $this->image_url = $url;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}
