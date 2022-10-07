<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'quiz_user_id';

    protected $fillable = [
        'quiz_id','email','points','is_complete','is_active'
    ];

}
