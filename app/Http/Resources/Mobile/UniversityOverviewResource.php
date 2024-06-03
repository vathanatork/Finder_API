<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\ContactResource;
use App\Http\Resources\DegreeLevelListResource;
use App\Http\Resources\UniversityTypeListResource;
use App\Http\Traits\GenerateHtmlTrait;
use Illuminate\Http\Request;

/**
 * @property mixed $degreeLevels
 * @property mixed $contact
 * @property mixed $description
 * @method generateHtmlUniversityDescription(mixed $description)
 */
class UniversityOverviewResource extends UniversityListResource
{
    use GenerateHtmlTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //reuse UniversityListResource property
        $data = parent::toArray($request);

        // Remove specific attributes from the parent array
        unset($data['type_en'],$data['type_kh'],$data['logo_image'], $data['image']);

        return $data + [
                'description' => $this->description ? $this->generateHtmlUniversityDescription($this->description) :
                    null,
                'type' => $this->type ? UniversityTypeListResource::make($this->type) : null,
                'study_option' => $this->degreeLevels ? DegreeLevelListResource::collection($this->degreeLevels) : null,
                'contact' => $this->contact ? ContactResource::make($this->contact) : null
            ];
    }

}
