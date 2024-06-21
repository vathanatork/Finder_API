<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Resources\Admin\EventCategoryResource;
use App\Http\Resources\Mobile\EventDetailResource;
use App\Http\Resources\Mobile\EventResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Http\Traits\ValidationFailTrait;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use PaginateTrait, ValidationFailTrait;
    public function category(): \Illuminate\Http\JsonResponse
    {
        $eventCategories = EventCategory::where('is_active',1)->get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',EventCategoryResource::collection($eventCategories));
        return $this->returnResults();
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $events = Event::where('is_active',1)->latest();

        if($request->has('search'))
        {
            $events = $events->search($request->input('search'));
        }

        if($request->has('category'))
        {
            $events = $events->whereCategory($request->input('category'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $events = $events->paginate($request->input('limit'));
            $this->setResult('paginate',$this->getPaginate($events));
        }else{
            $events =$events->paginate(10);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',EventResource::collection($events));
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
