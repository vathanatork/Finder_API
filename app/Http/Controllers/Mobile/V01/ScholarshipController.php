<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Requests\Mobile\V01\FinancialAidRequest;
use App\Http\Resources\Mobile\ProgramMajorDetail;
use App\Http\Resources\Mobile\ScholarshipDetailResource;
use App\Http\Resources\Mobile\ScholarshipListResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\Scholarship;


class ScholarshipController extends Controller
{
    use PaginateTrait;
    public function index(string $id): \Illuminate\Http\JsonResponse
    {
        $scholarships = Scholarship::where('university_id',$id)->isActive(1)->get();

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ScholarshipListResource::collection($scholarships));
        return $this->returnResults();
    }

    public function getList(FinancialAidRequest $request): \Illuminate\Http\JsonResponse
    {
        $scholarships = Scholarship::isActive(1)->latest();

        if($request->getSearch())
        {
            $scholarships = $scholarships->search($request->getSearch());
        }
        if ($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $scholarships = $scholarships->paginate($request->input('limit'));
            $this->setResult('paginate', $this->getPaginate($scholarships));
        } else {
            $scholarships = $scholarships->get();
        }

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
