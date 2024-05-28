<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Resources\Admin\UniversityType\UniversityTypeResource;
use App\Http\Resources\Mobile\UserRegisterResource;
use App\Models\UniversityType;
use Illuminate\Http\Request;

class UniversityTypeController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $type = UniversityType::active()->get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('successfully get university type');
        $this->setResult('university_type',UniversityTypeResource::collection($type));
        return $this->returnResults();
    }


    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->has('name')) {
            $universityType = new UniversityType();
            $universityType->name = $request->input('name');
            $universityType->is_active = $request->input('is_active') ?? true;
            $universityType->save();
            $this->setCode(StatusCodeEnum::OK);
            $this->setMessage('Successfully create university type');
            return $this->returnResults();
        }

        $this->setCode(StatusCodeEnum::CONFLICT);
        $this->setMessage('unsuccessfully create university type');
        return $this->returnResults();
    }
}
