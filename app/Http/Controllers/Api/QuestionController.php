<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $questions = Question::all();
        
        return response([ 'questions' =>  QuestionResource::collection($questions), 'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
            'question' => 'required',
            'time' => 'required',
            'options' => 'required',
            'correctanswer' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'message' => 'failure']);
        }

        $question = Question::create($data);

        $question_id = $question->question_id;

        $options = $request->options;
       
        foreach ($options as $option){
            $saveOptions = [];
            $saveOptions['question_id'] = $question_id;    
            if($option['text'] === $request->correctanswer){
                $saveOptions['is_right_choice'] = true;
            }
            $saveOptions['question_id'] = $question_id;
            $saveOptions['choice'] = $option['text'];
            $saveOptions['is_active'] = true;

            $options = QuestionChoice::create($saveOptions);
        }

        return response([ 'question' => new QuestionResource($question), 'message' => 'success'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {   
        $choices = QuestionChoice::where(['question_id' => $question->question_id , 'is_active' => true])->get();
        $question['choices'] = $choices;

        return response([ 'question' => new QuestionResource($question), 'message' => 'success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $question->update($request->all());

        return response([ 'question' => new QuestionResource($question), 'message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
