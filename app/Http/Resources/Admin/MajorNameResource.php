<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\MajorListResource;
use Illuminate\Http\Request;

/**
 * @property mixed $image_url
 * @property mixed $is_active
 */
class MajorNameResource extends MajorListResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        return $data + [
            'image_url' => $this->image_url,
            'is_active' => $this->is_active
        ];
    }
}
