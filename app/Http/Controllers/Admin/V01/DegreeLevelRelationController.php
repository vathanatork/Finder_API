<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Traits\ValidationFailTrait;
use App\Models\MajorDegreeLevel;
use App\Models\SpecializeDegreeLevel;
use App\Models\UniversityDegreeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DegreeLevelRelationController extends Controller
{
    use ValidationFailTrait;
    public function createMajorDegree(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
           'major_id' => 'required|integer',
           'degree_level_id' => 'required|integer',
           'is_active' => 'boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $createData = $request->only('major_id','degree_level_id','is_active');
        MajorDegreeLevel::create($createData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully created');
        return $this->returnResults();
    }

    public function createSpecializeDegree(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'specialize_id' => 'required|integer',
            'degree_level_id' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $createData = $request->only('specialize_id','degree_level_id','is_active');
        SpecializeDegreeLevel::create($createData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully created');
        return $this->returnResults();
    }

    public function createUniversityDegree(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'university_id' => 'required|integer',
            'degree_level_id' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $createData = $request->only('university_id','degree_level_id','is_active');
        UniversityDegreeLevel::create($createData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully created');
        return $this->returnResults();
    }

}
