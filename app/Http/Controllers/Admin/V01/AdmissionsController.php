<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Admin\v01\AdmissionRequest;
use App\Http\Resources\AdmissionResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\Admissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmissionsController extends Controller
{
    use PaginateTrait;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $admission = Admissions::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);
        if (!$validator->fails() && $request->has('is_active')) {
            $admission = $admission->isActive($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT))
        {
            $admission = $admission->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($admission));
        }else{
            $admission = $admission->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('successfully');
        $this->setResult('admission',AdmissionResource::collection($admission));
        return $this->returnResults();
    }

    public function create(AdmissionRequest $request): \Illuminate\Http\JsonResponse
    {
        Admissions::create([
            'university_id' => $request->getUniversityId(),
            'average_student_acceptance' => $request->getAverageAcceptance(),
            'application_deadline' => $request->getApplicationDeadline(),
            'application_fee' => $request->getApplicationFee(),
            'enroll_type_en' => $request->getEnrollTypeEn(),
            'enroll_type_kh' => $request->getEnrollTypeKh(),
            'description_en' => $request->getDescriptionEn(),
            'description_kh' => $request->getDescriptionKh(),
            'admission_url' => $request->getUrl(),
            'contact_info_id' => $request->getContact(),
            'is_active' => $request->getIsActive()
        ]);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully create admission');
        return $this->returnResults();
    }

    public function update(AdmissionRequest $request,string $id): \Illuminate\Http\JsonResponse
    {
        $admission = Admissions::findOrFail($id);

        $updateData = $request->only(
            'university_id',
            'average_student_acceptance',
            'application_deadline',
            'application_fee',
            'enroll_type_en',
            'enroll_type_kh',
            'description_en',
            'description_kh',
            'admission_url',
            'contact_info_id',
            'is_active'
        );

        $admission->update($updateData);
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully update admission');
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $admission = Admissions::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('admission',AdmissionResource::make($admission));
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $admission = Admissions::findOrFail($id);
        $admission->delete();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully deleted admission');
        return $this->returnResults();
    }
}
