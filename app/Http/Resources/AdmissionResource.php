<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $contact
 * @property mixed $university
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8)
 */
class AdmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only(
            'average_student_acceptance',
            'application_deadline',
            'application_fee',
            'enroll_type_en',
            'enroll_type_kh',
            'description_en',
            'description_kh',
            'admission_url',
            'is_active'
        ) + [
            'university' => [
                'id' => $this->university->id,
                'name' => $this->university->name
            ],
            'contact' => $this->contact ? ContactResource::make($this->contact) : null,
        ];
    }
}
