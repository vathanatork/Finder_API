<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Resources\Mobile\ProgramMajorDetail;
use App\Http\Resources\Mobile\ScholarshipDetailResource;
use App\Http\Resources\Mobile\ScholarshipListResource;
use App\Models\Scholarship;


class ScholarshipController extends Controller
{
    public function index(string $id): \Illuminate\Http\JsonResponse
    {
        $scholarships = Scholarship::where('university_id',$id)->isActive(1)->get();

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ScholarshipListResource::collection($scholarships));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $scholarship = Scholarship::findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ScholarshipDetailResource::make($scholarship));
        return $this->returnResults();
    }

}
