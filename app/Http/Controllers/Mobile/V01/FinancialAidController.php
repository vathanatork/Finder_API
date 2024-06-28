<?php

namespace App\Http\Controllers\Mobile\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Mobile\V01\FinancialAidRequest;
use App\Http\Resources\Admin\FinancialAidResource;
use App\Http\Resources\Mobile\FinancailAidResource;
use App\Http\Resources\Mobile\FinancialAidDetailResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\FinancialAid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinancialAidController extends Controller
{
    use PaginateTrait;

    public function index(FinancialAidRequest $request): \Illuminate\Http\JsonResponse
    {
        $financial = FinancialAid::where('is_active',1)->latest();

        if($request->getSearch())
        {
            $financial = $financial->search($request->getSearch());
        }
        if ($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $financial = $financial->paginate($request->input('limit'));
            $this->setResult('paginate', $this->getPaginate($financial));
        } else {
            $financial = $financial->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',FinancailAidResource::collection($financial));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $financial = FinancialAid::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',FinancialAidDetailResource::make($financial));
        return $this->returnResults();
    }

    public function moreArticle(string $id): \Illuminate\Http\JsonResponse
    {
        $latest = FinancialAid::where('id', '!=', $id)->where('is_active',1)->latest()->take(3)->get();
        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('data',FinancailAidResource::collection($latest));
        return $this->returnResults();
    }
}
