<?php

namespace App\Http\Requests\Admin\v01;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CareerRequest extends FormRequest
{
    protected  string $image_url = '';
    protected string $logo_url = '';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'image' => 'required|string',
            'logo' => 'required|string',
            'name_en' => 'required|string',
            'name_kh' => 'required|string',
            'yearly_income' => 'required|integer',
            'common_degree_level' => 'required|integer',
            'job_growth_rate' => 'required',
            'job_do_en' => 'required|string',
            'earning_en' => 'required|string',
            'job_outlook_en' => 'required|string',
            'task_en' => 'nullable|string',
            'knowledge_en' => 'nullable|string',
            'skill_en' => 'nullable|string',
            'is_active' => 'boolean',
            'job_do_kh' => 'required|string',
            'earning_kh' => 'required|string',
            'job_outlook_kh' => 'required|string',
            'task_kh' => 'nullable|string',
            'knowledge_kh' => 'nullable|string',
            'skill_kh' => 'nullable|string',
            'career_types' => 'required|array',
            'career_education_levels' => 'required|array'
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

    public function getImage()
    {
        return request()->image;
    }
    public function setImage($url)
    {
        return $this->image_url = $url;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getLogo()
    {
        return request()->logo;
    }
    public function setLogo($url)
    {
        return $this->logo_url = $url;
    }

    public function getLogoUrl(): string
    {
        return $this->logo_url;
    }

    public function getNameEn()
    {
        return request()->name_en;
    }

    public function getNameKh()
    {
        return request()->name_kh;
    }

    public function getYearlyIncome()
    {
        return request()->yearly_income;
    }

    public function getCommonDegreeLevel()
    {
        return request()->common_degree_level;
    }

    public function getJobGrowthRate()
    {
        return request()->job_growth_rate;
    }

    public function getJobDoEn()
    {
        return request()->job_do_en;
    }

    public function getEarningEn()
    {
        return request()->earning_en;
    }

    public function getJobOutlookEn()
    {
        return request()->job_outlook_en;
    }

    public function getTaskEn()
    {
        return request()->task_en ?: null;
    }

    public function getKnowledgeEn()
    {
        return request()->knowledge_en ?: null;
    }

    public function getSkillEn()
    {
        return request()->skill_en ?: null;
    }

    public function getIsActive()
    {
        return request()->is_active;
    }

    public function getJobDoKh()
    {
        return request()->job_do_kh;
    }

    public function getEarningKh()
    {
        return request()->earning_kh;
    }

    public function getJobOutlookKh()
    {
        return request()->job_outlook_kh;
    }

    public function getTaskKh()
    {
        return request()->task_kh ?: null;
    }

    public function getKnowledgeKh()
    {
        return request()->knowledge_kh ?: null;
    }

    public function getSkillKh()
    {
        return request()->skill_kh ?: null;
    }

    public function getCareerTypes()
    {
        return request()->career_types;
    }

    public function getCareerEducationLevels(): array
    {
        $careerEducationLevels = $this->input('career_education_levels');
        $parsedLevels = [];

        foreach ($careerEducationLevels as $level) {
            if (is_array($level) && count($level) == 2) {
                $degreeLevelId = $level[0];
                $percentage = $level[1];
                $parsedLevels[] = [
                    'degree_level_id' => $degreeLevelId,
                    'percentage' => $percentage,
                ];
            }
        }

        return $parsedLevels;
    }
}
