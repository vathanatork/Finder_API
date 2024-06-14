<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $image_url
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6)
 */
class ScholarshipListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id','name_en','name_kh','description_en','description_kh','open_date','close_date') + [
            'image' => $this->image_url ? UrlHelper::resolveUrl($this->image_url,env('MINIO_BASE_URL',null)) : null
        ];
    }
}
