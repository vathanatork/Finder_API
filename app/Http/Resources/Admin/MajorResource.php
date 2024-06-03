<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\MajorListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8, string $string9, string $string10, string $string11, string $string12)
 * @property mixed $majorName
 * @property mixed $university
 */
class MajorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id','department_id','institute_id','description_en','description_kh','tuition','study_duration','future_career_en','future_career_kh','student_number','required_credit','curriculum_url','is_active') + [
            'university' => [
                'id' => $this->university ? $this->university->id : null,
                'name'=>$this->university ? $this->university->name : null
            ],
            'major_name' => $this->majorName ? MajorListResource::make($this->majorName) : null
        ];
    }
}
