<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionRevisions extends Model
{
    protected $fillable = [
        "question_id",
        "title",
        "comment"
    ];
}
