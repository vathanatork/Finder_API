<?php

namespace App\Http\Controllers\Admin\V01;


use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\University\CreateRequest;
use App\Http\Resources\Admin\UniversityResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\University;
use App\Models\UniversityDegreeLevel;
use App\Service\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/**
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8, string $string9, string $string10, string $string11, string $string12, string $string13, string $string14, string $string15, string $string16)
 */
class UniversityController extends Controller
{
    use PaginateTrait;

    private MediaService $mediaService;

    /**
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        parent::__construct();
        $this->mediaService = $mediaService;
    }

    public function index(Request $request): JsonResponse
    {
        $university = University::with(['majors.majorName'])->latest();

        $validator = Validator::make($request->all(), ['is_active' => 'sometimes|boolean']);

        if (!$validator->fails() && $request->has('is_active')) {
            $university = $university->isActive($request->input('is_active'));
        }

        if ($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $university = $university->paginate($request->input('limit'));
            $this->setResult('paginate', $this->_paginate($university));
        } else {
            $university = $university->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('university', UniversityResource::collection($university));
        return $this->returnResults();
    }

    public function show(string $id): JsonResponse
    {
        $university = University::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('university', UniversityResource::make($university));
        return $this->returnResults();
    }

    public function create(CreateRequest $request): JsonResponse
    {
        $this->handleMediaUpload($request);
        $university = University::create($this->prepareData($request));

        if($request->getDegreeLevels())
        {
            foreach ($request->getDegreeLevels() as $degree)
            {
                UniversityDegreeLevel::create([
                    'university_id' => $university->id,
                    'degree_level_id' => $degree,
                    'is_active' => true
                ]);
            }
        }

        $this->setCode(200);
        $this->setMessage('create university successfully');
        return $this->returnResults();
    }

    private function handleMediaUpload($request): void
    {
        if ($request->getLogoImage() && (CoreBase::isBase64($request->getLogoImage()) || CoreBase::isUrl($request->getLogoImage()))) {
            $request->setLogoImage($this->mediaService->uploadBase64($request->getLogoImage(), "university_logo"));
        }

        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl($request->getImage()))) {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(), "university_image"));
        }
    }

    public function update(CreateRequest $request, string $id): JsonResponse
    {
        $this->handleMediaUpload($request);
        $university = University::findOrFail($id);
        $university->update($this->prepareData($request));

        if($request->getDegreeLevels())
        {
            UniversityDegreeLevel::where('university_id',$id)->delete();
            foreach ($request->getDegreeLevels() as $degree)
            {
                UniversityDegreeLevel::create([
                    'university_id' => $id,
                    'degree_level_id' => $degree,
                    'is_active' => true
                ]);
            }
        }

        $this->setCode(200);
        $this->setMessage('update university successfully');
        return $this->returnResults();
    }

    public function destroy(string $id): JsonResponse
    {
        $university = University::findOrFail($id);
        $university->delete();

        $this->setCode(200);
        $this->setMessage('deleted successfully');
        return $this->returnResults();
    }

    private function prepareData($request): array
    {
        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->getName();
        }
        if ($request->filled('logo_image')) {
            $data['logo_image'] = $request->getLogoImageUrl();
        }
        if ($request->filled('image')) {
            $data['image'] = $request->getImageUrl();
        }
        if ($request->filled('description')) {
            $data['description'] = $request->getDescription();
        }
        if ($request->filled('university_type_id')) {
            $data['university_type_id'] = $request->getUniversityTypeId();
        }
        if ($request->filled('established_year')) {
            $data['established_year'] = $request->getEstablishedYear();
        }
        if ($request->filled('ranking')) {
            $data['ranking'] = $request->getRanking();
        }
        if ($request->filled('contact_info_id')) {
            $data['contact_info_id'] = $request->getContactInfoId();
        }
        if ($request->filled('graduation_rate')) {
            $data['graduation_rate'] = $request->getGraduationRate();
        }
        if ($request->filled('average_tuition')) {
            $data['average_tuition'] = $request->getAverageTuition();
        }
        if ($request->filled('average_study_year')) {
            $data['average_study_year'] = $request->getAverageStudyYear();
        }
        if ($request->filled('address')) {
            $data['address'] = $request->getAddress();
        }
        if ($request->filled('adr_province_id')) {
            $data['adr_province_id'] = $request->getProvinceId();
        }
        if ($request->filled('adr_district_id')) {
            $data['adr_district_id'] = $request->getDistrictId();
        }
        if ($request->filled('adr_commune_id')) {
            $data['adr_commune_id'] = $request->getCommuneId();
        }
        if ($request->filled('adr_village_id')) {
            $data['adr_village_id'] = $request->getVillageId();
        }
        if ($request->filled('is_active')) {
            $data['is_active'] = $request->getIsActive();
        }

        return $data;
    }
}
