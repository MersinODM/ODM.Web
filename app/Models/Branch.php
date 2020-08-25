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
 * Ders ya da branş bilgisini tutan sınıf
 * Class BranchService
 * @package App\Models
 */
class Branch extends Model
{
    protected $table = 'branches';

    protected $fillable = [
        "name", "code"
    ];

    public function users()
    {
        return $this->hasMany(User::class, "branch_id");
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'lesson_id');
    }
}
