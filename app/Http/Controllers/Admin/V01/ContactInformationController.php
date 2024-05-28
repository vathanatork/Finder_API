<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Admin\v01\ContactRequest;
use App\Http\Resources\Admin\ContactInformationResource;
use App\Models\ContactInformation;



class ContactInformationController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $contact = ContactInformation::active()->get();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('successfully get contact');
        $this->setResult('contact_information',ContactInformationResource::collection($contact));
        return $this->returnResults();
    }

    public function create(ContactRequest $request): \Illuminate\Http\JsonResponse
    {
        ContactInformation::create([
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
        return $this->returnResults();
    }

}
