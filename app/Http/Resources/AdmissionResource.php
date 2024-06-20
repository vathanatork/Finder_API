<?php

namespace App\Http\Resources;

use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $contact
 * @property mixed $university
 * @property mixed $admission_url
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5,string $string6, string $string7, string $string8)
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
            'id',
            'average_student_acceptance',
            'application_deadline',
            'application_fee',
            'enroll_type_en',
            'enroll_type_kh',
            'description_en',
            'description_kh',
            'is_active'
        ) + [
            'admission_url' => $this->admission_url ? UrlHelper::resolveUrl($this->admission_url,env('MINIO_BASE_URL',
                null)) : null,
            'university' => [
                'id' => $this->university ? $this->university->id : null,
                'name' => $this->university ? $this->university->name_en : null,
                'name_kh' => $this->university ? $this->university->name_kh : null
            ],
                'contact' => $this->contact ? ContactResource::make($this->contact) : (
                $this->university ? (
                $this->university->contact ? ContactResource::make($this->university->contact) : null
                ) : null
                ),
        ];
    }
}
