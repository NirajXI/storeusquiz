<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUserAnswers extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_user_answer_id';

    protected $fillable = [
        'quiz_user_id','question_id','choice_id','is_correct','is_active'
    ];
}
