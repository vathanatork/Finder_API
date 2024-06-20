<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\CareerRequest;
use App\Http\Resources\Admin\CareerResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Http\Traits\ValidationFailTrait;
use App\Models\Career;
use App\Models\CareerEducationLevel;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CareerController extends Controller
{
    use PaginateTrait, ValidationFailTrait;
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
        $careers = Career::with(['types', 'careerEducationLevels'])->latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);

        if(!$validator->fails() && $request->has('is_active')) {
            $careers = $careers->isActive($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $careers = $careers->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($careers));
        }else{
            $careers =$careers->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('careers',CareerResource::collection($careers));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $career = Career::with(['types', 'careerEducationLevels'])->findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('career',CareerResource::make($career));
        return $this->returnResults();
    }

    public function create(CareerRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl
                ($request->getImage()))) {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(), 'career'));
        }
        if ($request->getLogo() && (CoreBase::isBase64($request->getLogo()) || CoreBase::isUrl
                ($request->getLogo()))) {
            $request->setLogo($this->mediaService->uploadBase64($request->getLogo(), 'career'));
        }

         $career = Career::create([
            'image' => $request->getImageUrl(),
            'logo' => $request->getLogoUrl(),
            'name_en' => $request->getNameEn(),
            'name_kh' => $request->getNameKh(),
            'yearly_income' => $request->getYearlyIncome(),
            'common_degree_level' => $request->getCommonDegreeLevel(),
            'job_growth_rate' => $request->getJobGrowthRate(),
            'job_do_en' => $request->getJobDoEn(),
            'earning_en' => $request->getEarningEn(),
            'job_outlook_en' => $request->getJobOutlookEn(),
            'task_en' => $request->getTaskEn(),
            'knowledge_en' => $request->getKnowledgeEn(),
            'skill_en' => $request->getSkillEn(),
            'is_active' => $request->getIsActive(),
            'job_do_kh' => $request->getJobDoKh(),
            'earning_kh' => $request->getEarningKh(),
            'job_outlook_kh' => $request->getJobOutlookKh(),
            'task_kh' => $request->getTaskKh(),
            'knowledge_kh' => $request->getKnowledgeKh(),
            'skill_kh' => $request->getSkillKh(),
        ]);

        // Attach career types
        $career->types()->attach($request->getCareerTypes());

        // Attach career education levels
        $careerEducationLevels = $request->getCareerEducationLevels();
        foreach ($careerEducationLevels as $level) {
            CareerEducationLevel::create([
                'career_id' => $career->id,
                'degree_level_id' => $level['degree_level_id'],
                'percentage' => $level['percentage'],
            ]);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        return $this->returnResults();
    }

    public function update(CareerRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        // Retrieve the existing career record
        $career = Career::findOrFail($id);

        // Update image if provided
        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl($request->getImage()))) {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(), 'career'));
            $career->image = $request->getImageUrl();
        }

        // Update logo if provided
        if ($request->getLogo() && (CoreBase::isBase64($request->getLogo()) || CoreBase::isUrl($request->getLogo()))) {
            $request->setLogo($this->mediaService->uploadBase64($request->getLogo(), 'career'));
            $career->logo = $request->getLogoUrl();
        }

        // Update career attributes
        $career->name_en = $request->getNameEn();
        $career->name_kh = $request->getNameKh();
        $career->yearly_income = $request->getYearlyIncome();
        $career->common_degree_level = $request->getCommonDegreeLevel();
        $career->job_growth_rate = $request->getJobGrowthRate();
        $career->job_do_en = $request->getJobDoEn();
        $career->earning_en = $request->getEarningEn();
        $career->job_outlook_en = $request->getJobOutlookEn();
        $career->task_en = $request->getTaskEn();
        $career->knowledge_en = $request->getKnowledgeEn();
        $career->skill_en = $request->getSkillEn();
        $career->is_active = $request->getIsActive();
        $career->job_do_kh = $request->getJobDoKh();
        $career->earning_kh = $request->getEarningKh();
        $career->job_outlook_kh = $request->getJobOutlookKh();
        $career->task_kh = $request->getTaskKh();
        $career->knowledge_kh = $request->getKnowledgeKh();
        $career->skill_kh = $request->getSkillKh();

        // Save updated career
        $career->save();

        // Update career types
        if ($request->has('career_types')) {
            $career->types()->sync($request->getCareerTypes());
        }

        // Update career education levels
        if ($request->has('career_education_levels')) {
            // Delete existing career education levels
            $career->careerEducationLevels()->delete();

            // Create new career education levels
            $careerEducationLevels = $request->getCareerEducationLevels();
            foreach ($careerEducationLevels as $level) {
                CareerEducationLevel::create([
                    'career_id' => $career->id,
                    'degree_level_id' => $level['degree_level_id'],
                    'percentage' => $level['percentage'],
                ]);
            }
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        return $this->returnResults();
    }


    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $career = Career::findOrFail($id);
        $career->delete();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully deleted');
        return $this->returnResults();
    }
}
