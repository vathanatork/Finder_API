<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;

class MajorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'department_id' => 'integer',
            'institute_id' => 'integer',
            'university_id' => 'required|integer',
            'major_name_id' => 'required|integer',
            'description_en' => 'required|string',
            'description_kh' => 'required|string',
            'curriculum_url' => 'string',
            'is_active' => 'boolean'
        ];
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
