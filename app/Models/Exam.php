<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Sınav bilgilerini tutacak sınıfımız
 * Class Exam
 * @package App\Models
 */
class Exam extends Model
{
    protected $fillable = [
      "creator_id", "status_id","title",
      "class_level", "plannded_date",
      "description"
    ];
}
