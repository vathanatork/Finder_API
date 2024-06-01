<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7)
 */
class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only('id', 'name','email','address','primary_phone_number','second_phone_number','third_phone_number','is_active');
    }
}
