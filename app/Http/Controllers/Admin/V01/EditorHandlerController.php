<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Helpers\CoreBase;
use App\Helpers\UrlHelper;
use App\Http\Traits\ValidationFailTrait;
use App\Service\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EditorHandlerController extends Controller
{
    use ValidationFailTrait;

    private MediaService $mediaService;

    /**
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        parent::__construct();
        $this->mediaService = $mediaService;
    }

    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {
        $image_url = '';

        $validator = Validator::make($request->all(), [
            'image' => 'required|string'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        if ($request->input('image') && (CoreBase::isBase64($request->input('image')) || CoreBase::isUrl
                ($request->input('image')))) {

            $image_url = $this->mediaService->uploadBase64($request->input('image'), "editor");
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully Upload');
        $this->setResult('image_url',UrlHelper::resolveUrl($image_url,env('MINIO_BASE_URL',
            null)));
        return $this->returnResults();
    }


}
