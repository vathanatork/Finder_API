<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Admin\v01\ContactRequest;
use App\Http\Resources\Admin\ContactInformationResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Http\Traits\ValidationFailTrait;
use App\Models\ContactInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ContactInformationController extends Controller
{
    use PaginateTrait,ValidationFailTrait;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $contact = ContactInformation::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);
        if (!$validator->fails()) {
            $contact = $contact->active($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT))
        {
            $contact = $contact->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($contact));
        }else{
            $contact = $contact->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('successfully get contact');
        $this->setResult('contact_information',ContactInformationResource::collection($contact));
        return $this->returnResults();
    }

    public function create(ContactRequest $request): \Illuminate\Http\JsonResponse
    {
        $contact = ContactInformation::create([
            'name' => $request->getName(),
            'address' => $request->getAddress(),
            'email' => $request->getEmail(),
            'primary_phone_number' => $request->getPrimaryPhoneNumber(),
            'second_phone_number' => $request->getSecondPhoneNumber() ?? null,
            'third_phone_number' => $request->getThirdPhoneNumber() ?? null,
            'is_active' => $request->getIsActive(),
        ]);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully create contact information');
        $this->setResult('contact_information',ContactInformationResource::make($contact));
        return $this->returnResults();
    }

    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'primary_phone_number' => 'sometimes|string|between:8,10',
            'email' => 'sometimes|email'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $contact = ContactInformation::findOrFail($id);
        $updateData = $request->only(['name','address','email','primary_phone_number','second_phone_number','third_phone_number','is_active']);
        $contact->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated contact');
        $this->setResult('contact_information', ContactInformationResource::make($contact));
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $type = ContactInformation::findOrFail($id);
        $type->delete();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully delete contact');
        return $this->returnResults();
    }

}
