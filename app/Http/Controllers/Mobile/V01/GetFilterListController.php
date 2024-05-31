<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Resources\Admin\Configuration\ProvinceResource;
use App\Http\Resources\DegreeLevelListResource;
use App\Http\Resources\MajorListResource;
use App\Http\Resources\UniversityTypeListResource;
use App\Models\AdrProvince;
use App\Models\DegreeLevel;
use App\Models\Major;
use App\Models\MajorAndSpecializeName;
use App\Models\UniversityType;

class GetFilterListController extends Controller
{
    public function getMajors(): \Illuminate\Http\JsonResponse
    {
        $major = MajorAndSpecializeName::active()->get();

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',MajorListResource::collection($major));
        return $this->returnResults();
    }

    public function getTypes(): \Illuminate\Http\JsonResponse
    {
        $type = UniversityType::isActive()->get();

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',UniversityTypeListResource::collection($type));
        return $this->returnResults();
    }

    public function getLocations(): \Illuminate\Http\JsonResponse
    {
        $provinces = AdrProvince::all();

        if (empty($provinces)) {
            $this->returnError(__('province not found'), 404);
        }

        $this->setCode(200);
        $this->setMessage('OK');
        $this->setResult('data', ProvinceResource::collection($provinces));
        return $this->returnResults();
    }

    public function getDegrees(): \Illuminate\Http\JsonResponse
    {
        $degree = DegreeLevel::isActive()->get();

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',DegreeLevelListResource::collection($degree));
        return $this->returnResults();
    }
}
