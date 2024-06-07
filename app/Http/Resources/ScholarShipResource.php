<?php

namespace App\Http\Resources;

use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $image_url
 * @property mixed $university
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7)
 */
class ScholarShipResource extends JsonResource
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
            'name_en',
            'name_kh',
            'description_en',
            'description_kh',
            'contact_info_id',
            'apply_link',
            'is_active'
        ) + [
            'contact' => $this->contact ? ContactResource::make($this->contact) : ContactResource::make
            ($this->university->contact),
           'university' => [
                'id' => $this->university ? $this->university->id : null,
                'name'=>$this->university ? $this->university->name : null
            ],
            'image' => $this->image_url ? UrlHelper::resolveUrl($this->image_url,env('MINIO_BASE_URL',null)) : null
        ];
    }
}
