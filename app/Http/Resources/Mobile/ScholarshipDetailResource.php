<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $other_en
 * @property mixed $other_kh
 * @property mixed $image_url
 * @property mixed $contact
 * @property mixed $university
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7)
 */
class ScholarshipDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id','name_en','name_kh','description_en','description_kh','open_date','close_date','apply_link') + [
                'detail_en' => $this->other_en,
                'detail_kh' => $this->other_kh,
                'image' => $this->image_url ? UrlHelper::resolveUrl($this->image_url,env('MINIO_BASE_URL',null)) : null,
                'contact_info' => $this->contact ? ContactResource::make($this->contact) : ContactResource::make
                                    ($this->university->contact)
            ];
    }
}
