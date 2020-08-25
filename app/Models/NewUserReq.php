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
 * Sistem kullanıcısı(soru yazıcı...) olmak isteyenlerin bilgilerini tutacak olan sınıf
 * Class NewUserReq
 * @package App\Models
 */
class NewUserReq extends Model
{
  protected $fillable = [
    "confirmatory_id", "full_name", "title", "phone", "email",
    "inst_id", "branch_id"
  ];
}
