<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method only(string $string, string $string1, string $string2, string $string3)
 * @property mixed $questionCareerMapping
 */
class CareerQuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'question_text_kh', 'question_text_en', 'is_active') + [
                'question_career_mapping' => $this->questionCareerMapping->filter(function ($mapping) {
                    return $mapping->career !== null;
                })->map(function ($mapping) {
                    return [
                        'career_id' => $mapping->career_id,
                        'career_name_en' => $mapping->career->name_en,
                        'career_name_kh' => $mapping->career->name_kh,
                        'weight' => $mapping->weight
                    ];
                })
            ];
    }
}
