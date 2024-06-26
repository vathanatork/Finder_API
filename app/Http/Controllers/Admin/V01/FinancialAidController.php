<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\FinancialAidRequest;
use App\Http\Resources\Admin\EventCategoryResource;
use App\Http\Resources\Admin\FinancialAidResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\FinancialAid;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinancialAidController extends Controller
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
        $financial = FinancialAid::latest();

        $validator = Validator::make($request->all(), ['active' => 'sometimes|boolean']);

        if (!$validator->fails() && $request->has('active')) {
            $financial = $financial->isActive($request->input('active'));
        }

        if ($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $financial = $financial->paginate($request->input('limit'));
            $this->setResult('paginate', $this->_paginate($financial));
        } else {
            $financial = $financial->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('financial_aids',FinancialAidResource::collection($financial));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $financial = FinancialAid::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('financial_aid',FinancialAidResource::make($financial));
        return $this->returnResults();
    }

    public function create(FinancialAidRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl
                ($request->getImage()))) {
            $request->setImageUrl($this->mediaService->uploadBase64($request->getImage(), "financial_aid"));
        }

        FinancialAid::create([
            'university_id' => $request->getUniversityId(),
            'name_en' => $request->getNameEn(),
            'name_kh' => $request->getNameKh(),
            'image' => $request->getImageUrl(),
            'short_description_en' => $request->getShortDescriptionEn(),
            'short_description_kh' => $request->getShortDescriptionKh(),
            'detail_description_en' => $request->getDetailDescriptionEn(),
            'detail_description_kh' => $request->getDetailDescriptionKh(),
            'is_active' => $request->getIsActive()
        ]);


        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        return $this->returnResults();
    }

    public function update(FinancialAidRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $financialAid = FinancialAid::findOrFail($id);

        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl
                ($request->getImage()))) {
            $request->setImageUrl($this->mediaService->uploadBase64($request->getImage(), "financial_aid"));
        }

        $updateData = $request->only('university_id','name_en','name_kh','short_description_en','short_description_kh','detail_description_en','detail_description_kh','is_active') + [
                'image' => $request->getImage() ? $request->getImageUrl() : $financialAid->image
            ];

        $financialAid->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $financialAid = FinancialAid::findOrFail($id);
        $financialAid->delete();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully deleted');
        return $this->returnResults();
    }

}
