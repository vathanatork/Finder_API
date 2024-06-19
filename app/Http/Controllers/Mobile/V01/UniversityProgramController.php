<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Resources\DegreeLevelListResource;
use App\Http\Resources\Mobile\ProgramMajorDetail;
use App\Http\Resources\Mobile\ProgramMajorListResource;
use App\Http\Resources\Mobile\ProgramSpecializeListResource;
use App\Models\Major;
use App\Models\Specialize;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityProgramController extends Controller
{
    public function getMajorProgramDetail(string $id): \Illuminate\Http\JsonResponse
    {
        $programDetail = Major::findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ProgramMajorDetail::make($programDetail));
        return $this->returnResults();
    }

    public function getSpecializeProgramDetail(string $id): \Illuminate\Http\JsonResponse
    {
        $programDetail = Specialize::findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ProgramMajorDetail::make($programDetail));
        return $this->returnResults();
    }

    public function getProgramDegreeLevel(string $id): \Illuminate\Http\JsonResponse
    {
        $university = University::with(['degreeLevels' => function ($query) {
            $query->orderBy('degree_level_id', 'asc');
        }])->findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',DegreeLevelListResource::collection($university->degreeLevels));
        return $this->returnResults();
    }

    public function getProgramMajor(Request $request,string $id): \Illuminate\Http\JsonResponse
    {
        $degreeLevelId = $request->query('degreeLevel');

        $universityQuery = University::with([
            'majors' => function ($query) use ($degreeLevelId) {
                if ($degreeLevelId) {
                    $query->whereHas('degreeLevels', function ($query) use ($degreeLevelId) {
                        $query->where('degree_levels.id', $degreeLevelId);
                    });
                }
                $query->with(['majorName', 'specialize' => function ($query) use ($degreeLevelId) {
                    if ($degreeLevelId) {
                        $query->whereHas('degreeLevels', function ($query) use ($degreeLevelId) {
                            $query->where('degree_levels.id', $degreeLevelId);
                        });
                    }
                    $query->with('specializeName');
                }]);
            },
            'degreeLevels',
        ]);

        $university = $universityQuery->findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ProgramMajorListResource::collection($university->majors));
        return $this->returnResults();
    }

    public function getProgramSpecialize(Request $request,string $id): \Illuminate\Http\JsonResponse
    {
        $degreeLevelId = $request->query('degreeLevel');

        $universityQuery = University::with([
            'majors' => function ($query) use ($degreeLevelId) {
                $query->with(['majorName', 'specialize' => function ($query) use ($degreeLevelId) {
                    if ($degreeLevelId) {
                        $query->whereHas('degreeLevels', function ($query) use ($degreeLevelId) {
                            $query->where('degree_levels.id', $degreeLevelId);
                        });
                    }
                    $query->with('specializeName');
                }]);
            },
            'degreeLevels',
        ]);

        $university = $universityQuery->findOrFail($id);

        $specializes = $university->majors ? $university->majors->pluck('specialize')->flatten()->filter() : collect();

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',ProgramSpecializeListResource::collection($specializes));
        return $this->returnResults();
    }
}
