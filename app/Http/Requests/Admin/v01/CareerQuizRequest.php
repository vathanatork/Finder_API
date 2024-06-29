<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CareerQuizRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'question_text_en' => 'required|string',
            'question_text_kh' => 'required|string',
            'question_career_mapping' => 'required|array', // Array of arrays & [career_id,weight]
            'is_active' => 'boolean',
        ];

        if($this->isMethod('GET')) {
            $rules = [];
        }

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

    public function getQuestionTextEn()
    {
        return request()->question_text_en;
    }

    public function getQuestionTextKh()
    {
        return request()->question_text_kh;
    }

    public function getQuestionCareerMapping(): array
    {
        $careerMapping = request()->question_career_mapping;

        $AssociativeArray = [];

        foreach ($careerMapping as $value) {
            if (is_array($value) && count($value) == 2) {
                $careerId = $value[0];
                $weight = $value[1];

                $AssociativeArray[] = [
                    'career_id' => $careerId,
                    'weight' => $weight
                ];
            }
        }

        return $AssociativeArray;

    }

    public function getIsActive()
    {
         return request()->is_active;
    }
}
