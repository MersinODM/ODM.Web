<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionDeleteRequest extends Model
{
    protected $fillable = [
        "question_id", "creator_id",
        "comment", "is_accepted",
        "acceptor_id"
    ];
}
