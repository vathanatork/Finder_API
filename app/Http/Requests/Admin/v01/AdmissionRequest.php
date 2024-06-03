<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AdmissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'university_id' => 'required',
            'average_student_acceptance' => 'integer',
            'application_deadline' => 'date',
            'description_en' => 'required|string',
            'description_kh' => 'required|string',
            'is_active' => 'boolean'
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

    public function getIsActive()
    {
        return request()->is_active;
    }
    public function getUniversityId()
    {
        return request()->university_id;
    }

    public function getAverageAcceptance()
    {
        return request()->average_student_acceptance;
    }

    public function getApplicationDeadline()
    {
        return request()->application_deadline;
    }

    public function getDescriptionEn()
    {
        return request()->description_en;
    }

    public function getDescriptionKh()
    {
        return request()->description_kh;
    }

    public function getEnrollTypeEn()
    {
        return request()->enroll_type_en;
    }

    public function getEnrollTypeKh()
    {
        return request()->enroll_type_kh;
    }
    public function getApplicationFee()
    {
        return request()->application_fee;
    }

    public function getUrl()
    {
        return request()->admission_url;
    }

    public function getContact()
    {
        return request()->contact_info_id;
    }

}

