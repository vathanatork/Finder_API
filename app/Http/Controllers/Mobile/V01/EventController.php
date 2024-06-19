<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Resources\Mobile\EventDetailResource;
use App\Http\Resources\Mobile\EventResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\Event;
use App\Models\University;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use PaginateTrait;

    public function index(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $university = University::with(['events' => function ($query) {
            $query->where('is_active', true);
        }])->findOrFail($id);

        $universityEvents = $university->events;

        if ($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $limit = $request->input('limit');
            $universityEvents = $university->events()->where('is_active', true)->paginate($limit);
            $this->setResult('paginate', $this->getPaginate($universityEvents));
            $eventsCollection = EventResource::collection($universityEvents->items());
        } else {
            $eventsCollection = EventResource::collection($universityEvents);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data', $eventsCollection);
        return $this->returnResults();
    }


    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $vent = Event::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',EventDetailResource::make($vent));
        return $this->returnResults();
    }
}
