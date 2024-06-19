<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $image
 * @property mixed $logo_image
 * @property mixed $type
 * @property mixed $name_en
 * @property mixed $name_kh
 * @method only(string $string, string $string1, string $string2, string $string3)
 */
class UniversityListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'graduation_rate','average_tuition','average_study_year') + [
                'name' => $this->name_en,
                'name_kh' => $this->name_kh,
                'type_en' => $this->type->name_en ?? null,
                'type_kh' => $this->type->name_kh ?? null,
                'logo_image' => $this->logo_image ? UrlHelper::resolveUrl($this->logo_image,env('MINIO_BASE_URL',
                    null)) : null,
                'image' => $this->image ? UrlHelper::resolveUrl($this->image,env('MINIO_BASE_URL',null)) : null
            ];
    }
}
