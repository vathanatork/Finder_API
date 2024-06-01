<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Resources\Admin\UniversityType\UniversityTypeResource;
use App\Http\Resources\Mobile\UserRegisterResource;
use App\Http\Traits\ValidationFailTrait;
use App\Models\UniversityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UniversityTypeController extends Controller
{
    use ValidationFailTrait;
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $typeQuery = UniversityType::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);
        if (!$validator->fails()) {
            $typeQuery = $typeQuery->active($request->input('is_active'));
        }

        // Executing the query and getting the results
        $types = $typeQuery->get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('successfully get university type');
        $this->setResult('university_type',UniversityTypeResource::collection($types));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $type = UniversityType::findOrFail($id);
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('university_type', $type);
        return $this->returnResults();
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $universityType = new UniversityType();
        $universityType->name_en = $request->input('name_en');
        $universityType->name_kh = $request->input('name_kh');
        $universityType->is_active = $request->input('is_active') ?? true;
        $universityType->save();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully create university type');
        return $this->returnResults();
    }

    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'name_en' => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $type = UniversityType::findOrFail($id);
        $updateData = $request->only(['name_en','name_kh','is_active']);
        $type->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated university type');
        $this->setResult('university_type', $type);
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $type = UniversityType::findOrFail($id);
        $type->delete();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully delete university type');
        return $this->returnResults();
    }
}
