<?php

namespace App\Http\Controllers\Admin\V01;

use App\Constants\Enum\StatusCodeEnum;
use App\Http\Requests\Admin\v01\CareerQuizRequest;
use App\Http\Resources\Admin\CareerQuizResource;
use App\Http\Traits\Mobile\PaginateTrait;
use App\Models\Question;
use App\Models\QuestionCareerMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CareerQuizController extends Controller
{
    use PaginateTrait;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $questions = Question::with('questionCareerMapping')->latest();

        $validator = Validator::make($request->all(), [
            'is_active' => 'sometimes|boolean'
        ]);

        if(!$validator->fails() && $request->has('is_active')) {
            $questions = $questions->isActive($request->input('is_active'));
        }

        if($request->has('limit') && filter_var($request->input('limit'), FILTER_VALIDATE_INT)) {
            $questions = $questions->paginate($request->input('limit'));
            $this->setResult('paginate',$this->_paginate($questions));
        }else{
            $questions =$questions->get();
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('questions', CareerQuizResource::collection($questions));
        return $this->returnResults();
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $question = Question::with('questionCareerMapping')->findOrFail($id);

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        $this->setResult('question', CareerQuizResource::make($question));
        return $this->returnResults();
    }

    //create question and mapping career for each question and putting weight
    public function create(CareerQuizRequest $request): \Illuminate\Http\JsonResponse
    {
        $question = Question::create([
            'question_text_en' => $request->getQuestionTextEn(),
            'question_text_kh' => $request->getQuestionTextKh(),
            'is_active' => $request->getIsActive(),
        ]);

        foreach ($request->getQuestionCareerMapping() as $item) {
            QuestionCareerMapping::create([
                'career_id' => $item['career_id'],
                'question_id' => $question->id,
                'weight' => $item['weight'],
            ]);
        }

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        return $this->returnResults();
    }

    //update question and mapping career for each question and putting weight
    public function update(CareerQuizRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $question = Question::findOrFail($id);
        $updateData = $request->only('question_text_en','question_text_kh','is_active');
        $question->update($updateData);

        if($request->getQuestionCareerMapping())
        {
            QuestionCareerMapping::where('question_id', $id)->delete();
            foreach ($request->getQuestionCareerMapping() as $item) {
                QuestionCareerMapping::create([
                    'career_id' => $item['career_id'],
                    'question_id' => $question->id,
                    'weight' => $item['weight'],
                ]);
            }
        }


        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        return $this->returnResults();
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $question = Question::findOrFail($id);
        $question->delete();

        $this->setCode(StatusCodeEnum::OK);
        $this->setMessage('Successfully');
        return $this->returnResults();
    }
}
