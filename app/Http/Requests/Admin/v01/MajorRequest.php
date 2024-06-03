<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class MajorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'department_id' => 'integer',
            'institute_id' => 'integer',
            'university_id' => 'required|integer',
            'major_name_id' => 'required|integer',
            'tuition' => 'required',
            'description_en' => 'required|string',
            'description_kh' => 'required|string',
            'is_active' => 'boolean',
            'degree_levels' => 'required|array'
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

    public function getDegreeLevels()
    {
        return request()->degree_levels;
    }
    public function getTuition()
    {
        return  request()->tuition;
    }
    public function getIsActive()
    {
        return request()->is_active ?? true;
    }
    public function getDepartmentId()
    {
        return request()->department_id ?? null;
    }

    public function getInstituteId()
    {
        return request()->institute_id ?? null;
    }

    public function getUniversityId()
    {
        return request()->university_id ?? null;
    }

    public function getMajorNameId()
    {
        return request()->major_name_id;
    }

    public function getDescriptionEn()
    {
        return request()->description_en;
    }

    public function getDescriptionKh()
    {
        return request()->description_kh;
    }

    public function getCurriculumUrl()
    {
        return request()->curriculum_url;
    }
}
