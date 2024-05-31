<?php

namespace App\Http\Controllers\Admin\V01;

use App\Http\Requests\Admin\v01\MajorRequest;
use App\Models\Major;

class MajorController extends Controller
{

    public function create(MajorRequest $request): \Illuminate\Http\JsonResponse
    {
        Major::create([
            'department_id' => $request->getDepartmentId(),
            'institute_id' => $request->getInstituteId(),
            'university_id' => $request->getUniversityId(),
            'major_name_id' => $request->getMajorNameId(),
            'description_en' => $request->getDescriptionEn(),
            'description_kh' => $request->getDescriptionKh(),
            'curriculum_url' => $request->getCurriculumUrl(),
            'is_active' => $request->getIsActive()
        ]);

        $this->setCode(200);
        $this->setMessage('create major successfully');
        return $this->returnResults();
    }

}
