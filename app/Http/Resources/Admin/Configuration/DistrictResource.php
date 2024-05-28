<?php

namespace App\Http\Resources\Admin\Configuration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'code', 'name_kh', 'name_en', 'type', 'reference', 'name');
    }
}
