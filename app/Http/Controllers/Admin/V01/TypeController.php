<?php

namespace App\Http\Controllers\Admin\V01;


use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Admin\v01\TypeRequest;
use App\Http\Resources\Admin\EventCategoryResource;
use App\Models\Type;

class TypeController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $types = Type::get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        $this->setResult('types',EventCategoryResource::collection($types));
        return $this->returnResults();
    }

    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $type = Type::findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('type',EventCategoryResource::make($type));
        return $this->returnResults();
    }

    public function create(TypeRequest $request): \Illuminate\Http\JsonResponse
    {
        Type::create([
            'name_en' => $request->getNameEn(),
            'name_kh' => $request->getNameKh(),
            'is_active' => $request->getIsActive() ?? 1
        ]);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully created');
        return $this->returnResults();
    }

    public function update(TypeRequest $request,string $id): \Illuminate\Http\JsonResponse
    {
        $type = Type::findOrFail($id);

        $updateData = $request->only('name_en','name_kh','is_active');
        $type->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully updated');
        return $this->returnResults();
    }

}
