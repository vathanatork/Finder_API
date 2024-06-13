<?php

namespace App\Http\Resources\Mobile;

use App\Helpers\UrlHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $curriculum_url
 * @method only(string $string, string $string1, string $string2)
 */
class ProgramMajorDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id','description_en','description_kh') + [
            'curriculum_url' =>  UrlHelper::resolveUrl($this->curriculum_url, env('MINIO_BASE_URL', null))
        ];
    }
}
