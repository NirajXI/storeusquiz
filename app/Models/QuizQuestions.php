<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestions extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_question_id';

    protected $fillable = [
        'quiz_id','question_id','is_active'
    ];


}
