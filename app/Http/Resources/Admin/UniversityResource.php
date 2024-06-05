<?php

namespace App\Http\Resources\Admin;

use App\Helpers\UrlHelper;
use App\Http\Resources\Admin\Configuration\CommuneResource;
use App\Http\Resources\Admin\Configuration\DistrictResource;
use App\Http\Resources\Admin\Configuration\ProvinceResource;
use App\Http\Resources\Admin\Configuration\VillageResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\DegreeLevelListResource;
use App\Http\Resources\MajorListResource;
use App\Http\Resources\UniversityTypeListResource;
use App\Models\MajorAndSpecializeName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8)
 * @property mixed $logo_image
 * @property mixed $image
 * @property mixed $type
 * @property mixed $contact
 * @property mixed $province
 * @property mixed $district
 * @property mixed $commune
 * @property mixed $village
 * @property mixed $majors
 * @property mixed $degreeLevels
 */
class UniversityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only(
            'id',
            'name',
            'description',
            'established_year',
            'ranking',
            'graduation_rate',
            'average_tuition',
            'average_study_year',
            'address',
            'is_active'
        ) + [
                'logo_image' => $this->logo_image ? UrlHelper::resolveUrl($this->logo_image,env('MINIO_BASE_URL',
                    null)) : null,
                'image' => $this->image ? UrlHelper::resolveUrl($this->image,env('MINIO_BASE_URL',null)) : null,
                'type' => $this->type ? UniversityTypeListResource::make($this->type) : null,
                'contact' => $this->contact ? ContactResource::make($this->contact) : null,
                'degree_levels' => $this->degreeLevels ? DegreeLevelListResource::collection
                ($this->degreeLevels) :
                    null,
                'majors' => $this->majors->map(function($major) {
                    return [
                        'id' => $major->id ?? null,
                        'major_name' => MajorListResource::make($this->getMajorName($major->major_name_id)) ?? null
                    ];
                }),
                'province' => $this->province ? ProvinceResource::make($this->province) : null,
                'district' => $this->district ? DistrictResource::make($this->district) : null,
                'commune' => $this->commune ? CommuneResource::make($this->commune) : null,
                'village' => $this->village ? VillageResource::make($this->village) : null
        ];
    }


    public function getMajorName($id)
    {
        $major = MajorAndSpecializeName::find($id);
        if($major){return $major;}
        return null;
    }
}
