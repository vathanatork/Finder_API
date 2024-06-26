<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Resources\Admin\ContactInformationResource;
use App\Models\Admissions;
use App\Models\Career;
use App\Models\ContactInformation;
use App\Models\DegreeLevel;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Major;
use App\Models\MajorAndSpecializeName;
use App\Models\Scholarship;
use App\Models\Type;
use App\Models\University;
use App\Models\UniversityType;

class DashboardController extends Controller
{

    private function _counter(): array
    {
        return [
        'university' => University::count(),
        'major' => Major::count(),
        'admission' => Admissions::count(),
        'scholarship' => Scholarship::count(),
        'event' => Event::count(),
        'career' => Career::count(),
        'universityType' => UniversityType::count(),
        'careerType' => Type::count(),
        'contact' => ContactInformation::count(),
        'degreeLevel' => DegreeLevel::count(),
        'majorName' => MajorAndSpecializeName::count(),
        'eventCategory' => EventCategory::count(),
        ];
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $counter = $this->_counter();


        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('successfully');
        $this->setResult('counter',$counter);
        return $this->returnResults();
    }
}
