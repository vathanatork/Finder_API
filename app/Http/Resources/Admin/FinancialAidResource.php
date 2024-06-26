<?php

namespace App\Http\Resources\Admin;

use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8)
 * @property mixed $image
 */
class FinancialAidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id','university_id','name_en','name_kh','short_description_en','short_description_kh','detail_description_en','detail_description_kh','is_active') + [
                'image' => $this->image ? UrlHelper::resolveUrl($this->image,env('MINIO_BASE_URL',
                    null)) : null,
            ];
    }
}
