<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\MajorRequest;
use App\Http\Resources\Admin\MajorResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\Major;
use App\Models\MajorDegreeLevel;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MajorController extends Controller
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

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $major = Major::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);

        if(!$validator->fails() && $request->has('is_active'))
        {
            $major = $major->isActive($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT))
        {
            $major = $major->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($major));
        }else{
            $major = $major->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('major',MajorResource::collection($major));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $major = Major::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('major',MajorResource::make($major));
        return $this->returnResults();
    }

    public function create(MajorRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->getCurriculum() && (CoreBase::isBase64($request->getCurriculum()) || CoreBase::isUrl
                ($request->getCurriculum()))) {
            $request->setCurriculumUrl($this->mediaService->uploadBase64($request->getCurriculum(), "curriculum"));
        }

        $major = Major::create([
            'department_id' => $request->getDepartmentId(),
            'institute_id' => $request->getInstituteId(),
            'university_id' => $request->getUniversityId(),
            'major_name_id' => $request->getMajorNameId(),
            'tuition' => $request->getTuition(),
            'description_en' => $request->getDescriptionEn(),
            'description_kh' => $request->getDescriptionKh(),
            'curriculum_url' => $request->getCurriculumUrl(),
            'is_active' => $request->getIsActive()
        ]);

        if($request->getDegreeLevels())
        {
            foreach ($request->getDegreeLevels() as $degree)
            {
                MajorDegreeLevel::create([
                    'major_id' => $major->id,
                    'degree_level_id' => $degree,
                    'is_active' => true
                ]);
            }
        }

        $this->setCode(200);
        $this->setMessage('create major successfully');
        return $this->returnResults();
    }

    public function update(MajorRequest $request,string $id): \Illuminate\Http\JsonResponse
    {
        $major = Major::findOrFail($id);
        if ($request->getCurriculum() && (CoreBase::isBase64($request->getCurriculum()) || CoreBase::isUrl
                ($request->getCurriculum()))) {
            $request->setCurriculumUrl($this->mediaService->uploadBase64($request->getCurriculum(), "curriculum"));
        }

        $updateData = $request->only('tuition','department_id','institute_id','university_id','major_name_id','description_en','description_kh','is_active')
        +['curriculum_url' => $request->getCurriculum() ? $request->getCurriculumUrl() : $major->curriculum_url];

        $major->update($updateData);

        if($request->getDegreeLevels())
        {
            MajorDegreeLevel::where('major_id', $id)->delete();

            foreach ($request->getDegreeLevels() as $degree)
            {
                MajorDegreeLevel::create([
                    'major_id' => $id,
                    'degree_level_id' => $degree,
                    'is_active' => true
                ]);
            }
        }

        $this->setCode(200);
        $this->setMessage('update major successfully');
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $major = Major::findOrFail($id);
        $major->delete();
        $this->setCode(200);
        $this->setMessage('deleted successfully');
        return $this->returnResults();
    }


}
