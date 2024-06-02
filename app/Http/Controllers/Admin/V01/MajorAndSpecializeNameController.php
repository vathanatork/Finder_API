<?php

namespace App\Http\Controllers\Admin\V01;


use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\MajorAndSpecializeNameRequest;
use App\Http\Resources\Admin\MajorNameResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\MajorAndSpecializeName;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MajorAndSpecializeNameController extends Controller
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

    private function handleImage($request): void
    {
        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl
                ($request->getImage())))
        {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(),"major"));
        }
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $name = MajorAndSpecializeName::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);

        if(!$validator->fails() && $request->has('is_active'))
        {
            $name = $name->isActive($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT))
        {
            $name = $name->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($name));
        }else{
            $name = $name->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('major_name',MajorNameResource::collection($name));
        return $this->returnResults();
    }

    public function create(MajorAndSpecializeNameRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->handleImage($request);

        MajorAndSpecializeName::create([
            'name_kh' => $request->getNameKh(),
            'name_en' => $request->getNameEn(),
            'image_url' => $request->getImageUrl(),
            'is_active' => $request->getIsActive()
        ]);

        $this->setCode(200);
        $this->setMessage('create major and specialize name successfully');
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $name = MajorAndSpecializeName::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('major_name',MajorNameResource::make($name));
        return $this->returnResults();
    }

    public function update(MajorAndSpecializeNameRequest $request,string $id): \Illuminate\Http\JsonResponse
    {
        $this->handleImage($request);

        $updateData = $request->only('name_en','name_kh','is_active');
        if($request->getImage()){ $updateData['image_url'] = $request->getImageUrl();}

        $name = MajorAndSpecializeName::findOrFail($id);
        $name->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Update Successfully');
        return $this->returnResults();
    }

}
