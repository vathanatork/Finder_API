<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\DateHelper;
use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $image
 * @property mixed $created_at
 * @property mixed $updated_at
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6)
 */
class FinancialAidDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id','name_en','name_kh','short_description_en','short_description_kh','detail_description_en','detail_description_kh') + [
                'publish_at'=> DateHelper::format($this->created_at,'j,F,Y'),
                'update_at' => $this->updated_at ? DateHelper::format($this->updated_at,'j,F,Y') : null,
                'image' => $this->image ? UrlHelper::resolveUrl($this->image,env('MINIO_BASE_URL',
                    null)) : null,
            ];
    }
}
