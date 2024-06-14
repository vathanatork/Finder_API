<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use App\Http\Resources\MajorListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method relationLoaded(string $string)
 * @property mixed $majorName
 * @property mixed $is_active
 * @property mixed $id
 */
class ProgramMajorListResource extends JsonResource
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
            'major_name' => $this->when(
                $this->relationLoaded('majorName') && $this->majorName,
                MajorListResource::make($this->majorName)
            ),
            'major_image' => $this->when(
                $this->relationLoaded('majorName') && $this->majorName && $this->majorName->image_url,
                UrlHelper::resolveUrl($this->majorName->image_url, env('MINIO_BASE_URL', null))
            )
        ];
    }
}
