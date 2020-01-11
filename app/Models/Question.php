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
    // Soru durumları
    // https://youtu.be/enuOArEfqGo ;-)
    public const WAITING_FOR_ACTION = 0; // İşeleme alınmamış
    public const IN_ELECTION = 1; // değerledirme aşamasında
    public const NOT_MUST_ASKED = 2;          // SORULMAMALI
    public const NEED_REVISION = 3;           // Revizyon gerekir
    public const REVISION_COMPLETED = 4; // değerledirme aşamasında
    public const APPROVED = 5;          // Onaylanmış soru

    protected $fillable = [
        "creator_id", "lesson_id", "learning_outcome_id",
        "keywords", "difficulty", "status",
        "content_url"
    ];

    public function evaluations()
    {
        return $this->hasMany(QuestionsEvaluation::class, "question_id");
    }

    public function revisions()
    {
        return $this->hasMany(QuestionRevisions::class, "question_id");
    }
}
