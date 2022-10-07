<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuizUserAnswers;
use Illuminate\Http\Request;
use App\Http\Resources\QuizUserAnswerResource;

class QuizUserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $QuizUserAnswers = QuizUserAnswers::create($data);
        return response([ 'quizuseranswer' => new QuizUserAnswerResource($QuizUserAnswers), 'message' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizUserAnswers  $quizUserAnswers
     * @return \Illuminate\Http\Response
     */
    public function show(QuizUserAnswers $quizUserAnswers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizUserAnswers  $quizUserAnswers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizUserAnswers $quizUserAnswers)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizUserAnswers  $quizUserAnswers
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizUserAnswers $quizUserAnswers)
    {
        //
    }
}
