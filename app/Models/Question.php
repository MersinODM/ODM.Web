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
    "title", "header", "body", "footer", "item_root",
    "content_url"
  ];
}
