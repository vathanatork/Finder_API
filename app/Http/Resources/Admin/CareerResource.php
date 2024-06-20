<?php

namespace App\Http\Resources\Admin;

use App\Helpers\UrlHelper;
use App\Http\Resources\DegreeLevelListResource;
use App\Models\DegreeLevel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $image
 * @property mixed $logo
 * @property mixed $name_en
 * @property mixed $name_kh
 * @property mixed $yearly_income
 * @property mixed $commonDegreeLevel
 * @property mixed $job_growth_rate
 * @property mixed $job_do_en
 * @property mixed $earning_en
 * @property mixed $job_outlook_en
 * @property mixed $is_active
 * @property mixed $job_do_kh
 * @property mixed $earning_kh
 * @property mixed $job_outlook_kh
 * @property mixed $types
 * @property mixed $careerEducationLevels
 */
class CareerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? UrlHelper::resolveUrl($this->image,env('MINIO_BASE_URL',
        null)) : null,
            'logo' => $this->logo ? UrlHelper::resolveUrl($this->logo,env('MINIO_BASE_URL',
                null)) : null,
            'name_en' => $this->name_en,
            'name_kh' => $this->name_kh,
            'yearly_income' => $this->yearly_income,
            'common_degree_level' => DegreeLevelListResource::make($this->commonDegreeLevel) ?? null,
            'job_growth_rate' => $this->job_growth_rate,
            'job_do_en' => $this->job_do_en,
            'earning_en' => $this->earning_en,
            'job_outlook_en' => $this->job_outlook_en,
            'task_en' => $this->task_en ?? null,
            'knowledge_en' => $this->knowledge_en ?? null,
            'skill_en' => $this->skill_en ?? null,
            'is_active' => $this->is_active,
            'job_do_kh' => $this->job_do_kh ,
            'earning_kh' => $this->earning_kh,
            'job_outlook_kh' => $this->job_outlook_kh,
            'task_kh' => $this->task_kh ?? null,
            'knowledge_kh' => $this->knowledge_kh ?? null,
            'skill_kh' => $this->skill_kh ?? null,
            'career_types' => $this->whenLoaded('types', function () {
                return DegreeLevelListResource::collection($this->types) ?? null;
            }),
            'career_education_levels' => $this->whenLoaded('careerEducationLevels', function () {
                return $this->careerEducationLevels->map(function ($level) {
                    return [
                        'degree_level' => DegreeLevelListResource::make($this->getDegreeLevelById($level->degree_level_id)),
                        'percentage' => $level->percentage,
                    ];
                })->toArray();
            }),
        ];
    }

    public function getDegreeLevelById($id)
    {
        return DegreeLevel::findOrFail($id);
    }
}
