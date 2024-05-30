<?php

namespace App\Http\Controllers\Admin\V01;


use App\Constants\Enum\StatusCodeEnum;
use App\Http\Resources\Admin\DegreeLevelResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Http\Traits\ValidationFailTrait;
use App\Models\DegreeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @property $is_active
 */
class DegreeLevelController extends Controller
{
    use PaginateTrait, ValidationFailTrait;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $degree = DegreeLevel::latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);
        if(!$validator->fails())
        {
            $degree = $degree->active($request->input('is_active'));
        }
        $degree = $degree->get();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('degree_level',DegreeLevelResource::collection($degree));
        return $this->returnResults();

    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name_en' => 'required|string',
            'name_kh' => 'required|string',
            'description_en' => 'string',
            'description_kh' => 'string',
            'is_active' => 'sometimes|boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }

        $createData = $request->only('name_kh','name_en','description_kh','description_en','description') + [
            'is_active' => $request->has('is_active') ? $request->input('is_active') : true
        ];
        DegreeLevel::create($createData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully create degree level');
        return $this->returnResults();
    }

    public function update(Request $request,string $id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name_en' => 'sometimes|string',
            'name_kh' => 'sometimes|string',
            'description_en' => 'sometimes|string',
            'description_kh' => 'sometimes|string',
            'is_active' => 'sometimes|boolean'
        ]);

        $validationResponse = $this->validationFail($validator);
        if ($validationResponse) {
            return $validationResponse;
        }
        $updateData = $request->only('name_kh','name_en','description_kh','description_en',"is_active") ;

        $degree = DegreeLevel::findOrFail($id);
        $degree->update($updateData);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully update degree level');
        $this->setResult('degree_level', DegreeLevelResource::make($degree));
        return $this->returnResults();
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $degree = DegreeLevel::findOrFail($id);
        $degree->delete();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully delete degree level');
        $this->setResult('degree_level', DegreeLevelResource::make($degree));
        return $this->returnResults();
    }
}
