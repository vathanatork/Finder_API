<?php

namespace App\Http\Controllers\Admin\V01;


use App\Helpers\CoreBase;
use App\Http\Requests\Admin\v01\MajorAndSpecializeNameRequest;
use App\Models\MajorAndSpecializeName;
use App\Service\MediaService;

class MajorAndSpecializeNameController extends Controller
{
    private MediaService $mediaService;

    /**
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        parent::__construct();
        $this->mediaService = $mediaService;
    }

    public function create(MajorAndSpecializeNameRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->getImage() && (CoreBase::isBase64($request->getImage()) || CoreBase::isUrl
                ($request->getImage())))
        {
            $request->setImage($this->mediaService->uploadBase64($request->getImage(),"major"));
        }

        MajorAndSpecializeName::create([
            'name_kh' => $request->getNameKh(),
            'name_en' => $request->getNameEn(),
            'image_url' => $request->getImageUrl(),
            'is_active' => $request->getIsActive()
        ]);

        $this->setCode(200);
        $this->setMessage('create major and specialize name successfully');
        return $this->returnResults();
    }

}
