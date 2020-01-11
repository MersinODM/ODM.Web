<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionEvalRequest extends Model
{
    protected $fillable = [
        'elector_id',
        'creator_id',
        'question_id',
        'code',
        'comment',
        'point',
        'is_open'
    ];
}
