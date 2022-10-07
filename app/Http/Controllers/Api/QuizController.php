<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizQuestionsResource;
use Illuminate\Http\Request;
use App\Models\QuizQuestions;
use App\Models\Quiz;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzez = Quiz::all();
        
        return response([ 'quizzez' =>  QuizResource::collection($quizzez), 'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'value' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'message' => 'failure']);
        }

        $quiz = Quiz::create($data);

        $quiz_id = $quiz->quiz_id;

        $values = $request->value;
       
        foreach ($values as $value){
            $saveOptions = [];
            $saveOptions['quiz_id'] = $quiz_id;    
            $saveOptions['question_id'] = $value['question_id'];
            $saveOptions['is_active'] = true;

            $options = QuizQuestions::create($saveOptions);
        }

        return response([ 'quiz' => new QuizResource($quiz), 'message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->all());

        return response([ 'quiz' => new QuizResource($quiz), 'message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }

    public function active()
    {
        $quizzez = Quiz::where(['is_active' => true])->get();
        
        return response([ 'quizzez' =>  QuizResource::collection($quizzez), 'message' => 'Successful'], 200);
    }

    public function questions(Request $request)
    {
        $questions = QuizQuestions::Select('question_id')->where(['is_active' => true,'quiz_id' => $request->quiz_id])->get();
        
        return response([ 'questions' =>  QuizQuestionsResource::collection($questions), 'message' => 'Successful'], 200);
    }
}
