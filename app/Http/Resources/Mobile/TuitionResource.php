<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $majors
 */
class TuitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];

        // Iterate over majors
        foreach ($this->majors as $major) {
            // Add the major to the data array
            $data[] = [
                'name_en' => $major->majorName->name_en,
                'name_kh' => $major->majorName->name_kh,
                'tuition' => $major->tuition
            ];

            // Iterate over specializations of the major
            foreach ($major->specialize as $specialization) {
                // Add the specialization to the data array
                $data[] = [
                    'name_en' => $specialization->specializeName->name_en,
                    'name_kh' => $specialization->specializeName->name_kh,
                    'tuition' => $specialization->tuition
                ];
            }
        }

        return $data;
    }
}
