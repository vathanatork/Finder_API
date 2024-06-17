<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Admin\v01\EventCategoryRequest;
use App\Http\Resources\Admin\EventCategoryResource;
use App\Models\EventCategory;

class EventCategoryController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $eventCategories = EventCategory::get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        $this->setResult('event_categories',EventCategoryResource::collection($eventCategories));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $eventCategories = EventCategory::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        $this->setResult('event_categories',EventCategoryResource::make($eventCategories));
        return $this->returnResults();
    }

    public function create(EventCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        EventCategory::create([
            'name_en' => $request->getNameEn(),
            'name_kh' => $request->getNameKh(),
            'is_active' => $request->getIsActive() ?? 1
        ]);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully created');
        return $this->returnResults();

    }

    public function update(EventCategoryRequest $request,string $id): \Illuminate\Http\JsonResponse
    {
        $eventCategory = EventCategory::findOrFail($id);

        $updateData = $request->only('name_en','name_kh','is_active');
        $eventCategory->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        return $this->returnResults();
    }
}
