<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Sınavlarda sorulacak soru tiplerini ve içeriğini ekleyceğimiz sınıf
 * Class Question
 * @package App\Models
 */
class Question extends Model
{
  protected $fillable = [
    "creator_id", "lesson_id", "learning_outcome_id",
    "keywords", "difficulty", "is_passed",
    "content_url"
  ];

  public function evaluations() {
      return $this->hasMany(QuestionsEvaluation::class, "question_id");
  }

  public function revisions() {
      return $this->hasMany(QuestionRevisions::class, "question_id");
  }
}
