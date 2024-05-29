<?php

namespace App\Http\Controllers\Admin\V01;
;
use App\Http\Resources\Admin\Configuration\DistrictResource;
use App\Http\Resources\Admin\Configuration\ProvinceResource;
use App\Http\Resources\Admin\Configuration\VillageResource;
use App\Models\AdrCommune;
use App\Models\AdrDistrict;
use App\Models\AdrProvince;
use App\Models\AdrVillage;

class AdrController extends Controller
{
    public function province(): \Illuminate\Http\JsonResponse
    {
        $provinces = AdrProvince::all();

        if (empty($provinces)) {
            $this->returnError(__('province not found'), 404);
        }

        $this->setCode(200);
        $this->setMessage('OK');
        $this->setResult('provinces', ProvinceResource::collection($provinces));
        return $this->returnResults();
    }

    public function district(string $id): \Illuminate\Http\JsonResponse
    {
        $districts = AdrDistrict::where('adr_province_id', $id)->get();

        if (empty($districts)) {
            $this->returnError(__('district not found'), 404);
        }

        $this->setCode(200);
        $this->setMessage('OK');
        $this->setResult('districts', DistrictResource::collection($districts));
        return $this->returnResults();
    }

    public function commune(string $id): \Illuminate\Http\JsonResponse
    {
        $communes = AdrCommune::where('adr_district_id', $id)->get();

        if (empty($communes)) {
            $this->returnError(__('district not found'), 404);
        }

        $this->setCode(200);
        $this->setMessage('OK');
        $this->setResult('communes', DistrictResource::collection($communes));
        return $this->returnResults();
    }

    public function village(string $id): \Illuminate\Http\JsonResponse
    {
        $village = AdrVillage::where('adr_commune_id', $id)->get();

        if (empty($village)) {
            $this->returnError(__('district not found'), 404);
        }

        $this->setCode(200);
        $this->setMessage('OK');
        $this->setResult('villages', VillageResource::collection($village));
        return $this->returnResults();
    }
}
