<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use App\Http\Resources\DegreeLevelListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $image
 * @property mixed $name_en
 * @property mixed $name_kh
 * @property mixed $yearly_income
 * @property mixed $job_growth_rate
 * @property mixed $job_do_en
 * @property mixed $job_do_kh
 */
class CareerListResource extends JsonResource
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
            'image' => $this->image ? UrlHelper::resolveUrl($this->image,env('MINIO_BASE_URL',
                null)) : null,
            'name_en' => $this->name_en,
            'name_kh' => $this->name_kh,
            'yearly_income' => $this->yearly_income,
            'job_growth_rate' => $this->job_growth_rate,
            'job_do_en' => $this->job_do_en,
            'job_do_kh' => $this->job_do_kh ,
        ];
    }
}
