<?php
/*
 * ODM.Web  https://github.com/electropsycho/ODM.Web
 * Copyright (C) 2020 Hakan GÜLEN
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 */

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
