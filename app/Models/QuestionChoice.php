<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'choice_id';

    protected $fillable = [
        'question_id','is_right_choice','choice','is_active'
    ];
}
