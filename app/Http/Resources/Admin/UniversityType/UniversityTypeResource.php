<?php

namespace App\Http\Resources\Admin\UniversityType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method only(string $string, string $string1, string $string2)
 */
class UniversityTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'name', 'is_active');
    }
}
