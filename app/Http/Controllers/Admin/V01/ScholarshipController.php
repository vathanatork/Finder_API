<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\ScholarShipRequest;
use App\Http\Resources\ScholarShipResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\Scholarship;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScholarshipController extends Controller
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

    private function handleMediaUpload($request): void
    {
        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl($request->getImage()))) {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(), "scholarShip"));
        }
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $scholar = Scholarship::latest();

        $validator = Validator::make($request->all(), ['is_active' => 'sometimes|boolean']);

        if (!$validator->fails() && $request->has('is_active')) {
            $scholar = $scholar->isActive($request->input('is_active'));
        }

        if ($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $scholar = $scholar->paginate($request->input('limit'));
            $this->setResult('paginate', $this->_paginate($scholar));
        } else {
            $scholar = $scholar->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('scholarShip', ScholarShipResource::collection($scholar));
        return $this->returnResults();
    }
    public function create(ScholarShipRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->handleMediaUpload($request);

        Scholarship::create([
            'university_id' => $request->getUniversityId(),
            'name_en' => $request->getNameEn(),
            'name_kh' => $request->getNameKh(),
            'image_url' => $request->getImageUrl(),
            'description_en' => $request->getDescriptionEn(),
            'description_kh' => $request->getDescriptionKh(),
            'contact_info_id' => $request->getContact(),
            'apply_link' => $request->getApplyLink(),
            'is_active' => $request->getIsActive() ?? 1,
            'open_date' => $request->getOpenDate(),
            'close_date' => $request->getCloseDate()

        ]);

        $this->setCode(200);
        $this->setMessage('create scholarShip successfully');
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $scholar = Scholarship::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('scholarShip', ScholarShipResource::make($scholar));
        return $this->returnResults();
    }

    public function update(ScholarShipRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $this->handleMediaUpload($request);
        $scholar = Scholarship::findOrFail($id);

        $updateData = $request->only(
          'university_id',
            'name_en',
            'name_kh',
            'description_en',
            'description_kh',
            'contact_info_id',
            'apply_link',
            'is_active',
            'open_date',
            'close_date'
        );

        if($request->filled('image'))
        {
            $updateData['image_url'] = $request->getImageUrl();
        }

        $scholar->update($updateData);

        $this->setCode(200);
        $this->setMessage('update scholarShip successfully');
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $scholar = Scholarship::findOrFail($id);
        $scholar->delete();

        $this->setCode(200);
        $this->setMessage('deleted successfully');
        return $this->returnResults();
    }
}
