<?php

namespace App\Http\Controllers\Admin\V01;


use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\EventRequest;
use App\Http\Resources\Admin\EventResource;
use App\Http\Resources\Admin\MajorResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Http\Traits\ValidationFailTrait;
use App\Models\Event;
use App\Models\Major;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @method only(string $string, string $string1, string $string2, string $string3, string $string4, string $string5, string $string6, string $string7, string $string8, string $string9, string $string10, string $string11, string $string12)
 */
class EventController extends Controller
{
    use PaginateTrait, ValidationFailTrait;
    private MediaService $mediaService;

    /**
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        parent::__construct();
        $this->mediaService = $mediaService;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $events = Event::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);

        if(!$validator->fails() && $request->has('is_active')) {
            $events = $events->isActive($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $events = $events->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($events));
        }else{
            $events = $events->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('events',EventResource::collection($events));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $event = Event::findOrFail($id);
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('event',EventResource::make($event));
        return $this->returnResults();
    }

    public function create(EventRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->getThumbnailImage() && (CoreBase::isBase64($request->getThumbnailImage()) || CoreBase::isUrl
                ($request->getThumbnailImage()))) {
            $request->setImageUrl($this->mediaService->uploadBase64($request->getThumbnailImage(), "event"));
        }

        Event::create([
            'university_id' => $request->getUniversityId(),
            'event_category_id' => $request->getEventCategoryId(),
            'name_en' => $request->getNameEn(),
            'name_kh' => $request->getNameKh(),
            'thumbnail_image' => $request->getThumbnailUrl(),
            'event_date' => $request->getEventDate(),
            'location' => $request->getLocation(),
            'location_link' => $request->getLocationLink(),
            'start_at' => $request->getStartAt(),
            'end_at' => $request->getEndAt(),
            'description_en' => $request->getDescriptionEn(),
            'description_kh' => $request->getDescriptionKh(),
            'register_link' => $request->getRegisterLink() ?? null,
            'is_active' => $request->getIsActive() ?? 1
        ]);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully created');
        return $this->returnResults();
    }

    public function update(EventRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $event = Event::findOrFail($id);

        if ($request->getThumbnailImage() && (CoreBase::isBase64($request->getThumbnailImage()) || CoreBase::isUrl
                ($request->getThumbnailImage()))) {
            $request->setImageUrl($this->mediaService->uploadBase64($request->getThumbnailImage(), "event"));
        }

        $updateData = $request->only(
            'university_id',
            'event_category_id',
            'name_en','name_kh',
            'event_date',
            'location',
            'location_link',
            'start_at',
            'end_at',
            'description_en',
            'description_kh',
            'register_link',
            'is_active'
        )+[
            'thumbnail_image' => $request->getThumbnailImage() ? $request->getThumbnailUrl() : $event->thumbnail_url
        ];

        $event->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully deleted');
        return $this->returnResults();
    }
}
