<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Http\Resources\Mobile\UniversityProgramResource;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityProgramController extends Controller
{
    public function getProgram(string $id): \Illuminate\Http\JsonResponse
    {

        $university = $university = University::with([
            'majors.majorName',
            'degreeLevels',
            'majors.specialize.specializeName'
        ])->findOrFail($id);

        $this->setCode(200);
        $this->setMessage("Success");
        $this->setResult('data',UniversityProgramResource::make($university));
        return $this->returnResults();
    }
}
