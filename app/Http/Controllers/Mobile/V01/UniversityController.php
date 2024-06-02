<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Requests\Mobile\V01\UniversityRequest;
use App\Http\Resources\Mobile\UniversityListResource;
use App\Http\Resources\Mobile\UniversityOverviewResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\University;


class UniversityController extends Controller
{
    use PaginateTrait;

    public function index(UniversityRequest $request): \Illuminate\Http\JsonResponse
    {
        $university = University::active()->with('type');

        //filter query
        if ($request->getSearch()) { $university = $university->search($request->getSearch()); }
        if ($request->getMajor()) { $university = $university->whereMajorName($request->getMajor()); }
        if ($request->getType()) { $university = $university->type($request->getType()); }
        if ($request->getDegree()) { $university = $university->whereDegree($request->getDegree()); }
        if ($request->getLocation()) { $university = $university->province($request->getLocation()); }

        $university = $university->paginate($request->getPaginate());

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',UniversityListResource::collection($university));
        $this->setResult('paginate',$this->getPaginate($university));
        return $this->returnResults();
    }

    public function getOverview(string $id): \Illuminate\Http\JsonResponse
    {
        $university = University::findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',UniversityOverviewResource::make($university));
        return $this->returnResults();
    }
}
