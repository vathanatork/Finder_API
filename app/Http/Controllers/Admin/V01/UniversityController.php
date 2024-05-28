<?php

namespace App\Http\Controllers\Admin\V01;


use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\University\CreateRequest;
use App\Models\University;
use App\Service\MediaService;

class UniversityController extends Controller
{
    private MediaService $mediaService;

    /**
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        parent::__construct();
        $this->mediaService = $mediaService;
    }

    public function create(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->getLogoImage() && CoreBase::isBase64($request->getLogoImage()) && !CoreBase::isUrl
            ($request->getLogoImage()))
        {
            $request->setLogoImage($this->mediaService->uploadBase64($request->getLogoImage(),"university_logo"));
        }

        if ($request->getImage() && CoreBase::isBase64($request->getImage()) && !CoreBase::isUrl($request->getImage()))
        {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(),"university_image"));
        }

        University::create([
            'name' => $request->getName(),
            'logo_image' => $request->getLogoImageUrl(),
            'image' => $request->getImageUrl(),
            'description' => $request->getDescription(),
            'university_type_id' => $request->getUniversityTypeId(),
            'established_year' => $request->getEstablishedYear(),
            'ranking' => $request->getRanking(),
            'contact_info_id' => $request->getContactInfoId(),
            'graduation_rate' => $request->getGraduationRate(),
            'average_tuition' => $request->getAverageTuition(),
            'average_study_year' => $request->getAverageStudyYear(),
            'address' => $request->getAddress(),
            'adr_province_id' => $request->getProvinceId(),
            'adr_district_id' => $request->getDistrictId(),
            'adr_commune_id' => $request->getCommuneId(),
            'adr_village_id' => $request->getVillageId(),
            'is_active' => $request->getIsActive()
        ]);

        $this->setCode(200);
        $this->setMessage('create university successfully');
        return $this->returnResults();
    }
}
