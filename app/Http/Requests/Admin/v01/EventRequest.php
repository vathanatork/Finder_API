<?php

namespace App\Http\Requests\Admin\v01;

use App\Helpers\TimeHelper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class EventRequest extends FormRequest
{
    protected string $image_url = '';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'university_id' => 'required|integer',
            'event_category_id' => 'required|integer',
            'name_en' => 'required|string',
            'name_kh' => 'required|string',
            'thumbnail_image' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'location_link' => 'required|string',
            'start_at' => ['required','regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            'end_at' => ['required','regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/'],
            'description_en' => 'required|string',
            'description_kh' => 'required|string',
            'register_link' => 'nullable|string',
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

    public function getUniversityId()
    {
        return request()->university_id;
    }

    public function getEventCategoryId()
    {
        return request()->event_category_id;
    }

    public function getNameEn()
    {
        return request()->name_en;
    }

    public function getNameKh()
    {
        return request()->name_kh;
    }

    public function getThumbnailImage()
    {
        return request()->thumbnail_image;
    }

    public function setImageUrl($url)
    {
        return $this->image_url = $url;
    }

    public function getThumbnailUrl(): string
    {
        return $this->image_url;
    }

    public function getEventDate()
    {
        return request()->event_date;
    }

    public function getLocation()
    {
        return request()->location;
    }

    public function getLocationLink()
    {
        return request()->location_link;
    }

    public function getStartAt(): ?string
    {
        return  request()->start_at;
    }

    public function getEndAt(): ?string
    {
        return request()->end_at;
    }

    public function getDescriptionEn()
    {
        return request()->description_en;
    }

    public function getDescriptionKh()
    {
        return request()->description_kh;
    }

    public function getRegisterLink()
    {
        return request()->register_link ?: null;
    }

    public function getIsActive()
    {
        return request()->is_active;
    }
}
