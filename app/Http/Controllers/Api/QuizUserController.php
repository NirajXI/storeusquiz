<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuizUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\QuizUserResource;
use App\Models\QuizUserAnswers;

class QuizUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userslist = QuizUser::leftJoin('quizzes', 'quiz_users.quiz_id', '=', 'quizzes.quiz_id')->get();
        
        return response([ 'userslist' =>  QuizUserResource::collection($userslist), 'message' => 'Successful'], 200);
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
            'email' => 'required'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'message' => 'failure']);
        }

        $checkQuizUser = $this->checkQuizUser($data);

        if($checkQuizUser){
            return response([ 'quiz' => new QuizUserResource($checkQuizUser), 'message' => 'completed'], 200);
        }else{

            $updateQuizUser = QuizUser::where('email', $data['email'])
            ->where('quiz_id', $data['quiz_id'])
            ->update(['is_active' => false]);

            $QuizUser = QuizUser::create($data);
            return response([ 'quizuser' => new QuizUserResource($QuizUser), 'message' => 'success'], 200);
        }
        
    }

    public function checkQuizUser($data)
    {
        $QuizUser = QuizUser::where(['email' => $data['email'], 'quiz_id' => $data['quiz_id'] , 'is_active' => true ,'is_complete' => true])->first();
        return $QuizUser;
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizUser  $quizUser
     * @return \Illuminate\Http\Response
     */
    public function show(QuizUser $quizUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizUser  $quizUser
     * @return \Illuminate\Http\Response
     */
    public function compelete(Request $request)
    {
        $quizCorrectAnswers = $this->quizCorrectAnswers($request->quiz_user_id);

        $quizUser = QuizUser::where('quiz_user_id', $request->quiz_user_id)
              ->update(['points' => $quizCorrectAnswers,'is_complete' => true]);

        return response(['message' => 'success','points'=> $quizCorrectAnswers], 200);
    }

    public function quizCorrectAnswers($data)
    {
        $QuizUserAnswers = QuizUserAnswers::where(['quiz_user_id' => $data, 'is_correct' => true])->get();
        return sizeOf($QuizUserAnswers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizUser  $quizUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizUser $quizUser)
    {
        //
    }
}
