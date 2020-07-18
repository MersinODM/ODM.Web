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
    //Sınava ait durmumsallık bilgileri
    const CREATED = 5000;       //Sınav oluşturuldu
    const PLANNED = 5001;       //Sınava ait dersler ve sorular seçildi
    const CANCELED = 5002;      //İptal edildi
    const COMPLETED = 5003;     //Sınav tamamlandı

    protected $fillable = [
        "creator_id",
        'purpose_id',
        "status",
        'code',
        "title",
        "class_level",
        "planned_date",
        'date_of_occurrence',
        "description"
    ];
}
