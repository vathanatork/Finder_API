<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Resources\Mobile\ProgramMajorDetail;
use App\Http\Resources\Mobile\UniversityProgramResource;
use App\Models\Major;
use App\Models\Specialize;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityProgramController extends Controller
{
    public function getProgram(Request $request, string $id): \Illuminate\Http\JsonResponse
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
        $this->setResult('data',UniversityProgramResource::make($university));
        return $this->returnResults();
    }

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
}
