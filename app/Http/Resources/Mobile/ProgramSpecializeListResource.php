<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use App\Http\Resources\MajorListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $is_active
 * @property mixed $specializeName
 * @method relationLoaded(string $string)
 */
class ProgramSpecializeListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'is_active' => $this->is_active,
        'specialize_name' => $this->when(
            $this->relationLoaded('specializeName') && $this->specializeName,
            MajorListResource::make($this->specializeName)
        ),
        'specialize_image' => $this->when(
            $this->relationLoaded('specializeName') && $this->specializeName && $this->specializeName->image_url,
            UrlHelper::resolveUrl($this->specializeName->image_url, env('MINIO_BASE_URL', null))
        ),
    ];
    }
}
