<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\TimeHelper;
use App\Helpers\UrlHelper;
use App\Http\Resources\EventCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $start_at
 * @property mixed $end_at
 * @property mixed $thumbnail_image
 * @property mixed $eventCategory
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8, string $string9)
 */
class EventDetailResource extends JsonResource
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
            'event_date',
            'location',
            'location_link',
            'description_en',
            'description_kh',
            'register_link',
            'is_active'
        ) + [
                'category' => EventCategoryResource::make($this->eventCategory),
                'start_at' => TimeHelper::formatTimeTo12Hour($this->start_at),
                'end_at'=> TimeHelper::formatTimeTo12Hour($this->end_at),
                'thumbnail_image' => $this->thumbnail_image ? UrlHelper::resolveUrl($this->thumbnail_image,env('MINIO_BASE_URL',
                    null)) : null,
        ];
    }
}
