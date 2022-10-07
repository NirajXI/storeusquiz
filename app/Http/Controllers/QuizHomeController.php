<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizHomeController extends Controller
{
    public function index()
    {
        return view('user.quiz.home');
    }

    public function play(Request $request, Quiz $quiz)
    {   
        return view('user.quiz.play',compact(['quiz']));
    }
}
