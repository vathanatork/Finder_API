<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use App\Http\Resources\DegreeLevelListResource;
use App\Http\Resources\MajorListResource;
use App\Models\MajorAndSpecializeName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $majors
 * @property mixed $degreeLevels
 */
class UniversityProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $specializes = $this->majors ? $this->majors->pluck('specialize')->flatten()->filter() : collect();

        return [
            'degreeLevels' => DegreeLevelListResource::collection($this->whenLoaded('degreeLevels')),
            'majors' => MajorResource::collection($this->whenLoaded('majors')),
            'specialize' => SpecializeResource::collection($specializes),
        ];
    }
}


/**
 * @property mixed $majorName
 * @property mixed $is_active
 * @property mixed $id
 * @method relationLoaded(string $string)
 */
class MajorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
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


/**
 * @method relationLoaded(string $string)
 * @property mixed $specializeName
 * @property mixed $is_active
 * @property mixed $id
 */
class SpecializeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
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




