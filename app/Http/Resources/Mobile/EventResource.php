<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\TimeHelper;
use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $thumbnail_image
 * @property mixed $end_at
 * @property mixed $start_at
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5)
 */
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id',
            'name_en',
            'name_kh',
            'event_date',
            'location',
            'location_link'
            )+ [
                'start_at' => TimeHelper::formatTimeTo12Hour($this->start_at),
                'end_at'=> TimeHelper::formatTimeTo12Hour($this->end_at),
                'thumbnail_image' => $this->thumbnail_image ? UrlHelper::resolveUrl($this->thumbnail_image,env('MINIO_BASE_URL',
                    null)) : null,
            ];
    }
}
