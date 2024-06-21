<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Constants\Enum\StatusCodeEnum;

use App\Http\Resources\Admin\CareerResource;
use App\Http\Resources\Admin\EventCategoryResource;
use App\Http\Resources\Mobile\CareerListResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Http\Traits\ValidationFailTrait;
use App\Models\Career;
use App\Models\Type;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    use PaginateTrait, ValidationFailTrait;

    public function type(): \Illuminate\Http\JsonResponse
    {
        $types = Type::where('is_active',1)->get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        $this->setResult('data',EventCategoryResource::collection($types));
        return $this->returnResults();
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $careers = Career::where('is_active',1)->latest();

        if($request->has('search'))
        {
            $careers = $careers->search($request->input('search'));
        }

        if($request->has('type'))
        {
            $careers = $careers->whereType($request->input('type'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $careers = $careers->paginate($request->input('limit'));
            $this->setResult('paginate',$this->getPaginate($careers));
        }else{
            $careers =$careers->paginate(10);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',CareerListResource::collection($careers));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $career = Career::with(['types', 'careerEducationLevels'])->findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',CareerResource::make($career));
        return $this->returnResults();
    }
}
