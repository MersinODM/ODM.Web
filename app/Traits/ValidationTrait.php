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

namespace App\Traits;


trait ValidationTrait
{
    public $MESSAGES = [
            'password.regex' => 'Şifre en az: 1 büyük harf, 1 küçük harf, 1 rakam, ve bir özel karakter içermelidir(. , + @ # % vs.)',
        ];

    public $ATTRIBUTES = [
        'learning_outcome_id' => 'Kazanım',
        'difficulty' => 'Zorluk',
        'question_file' => 'Soru dosyası',
        'password' => 'Şifre',
        'token' => 'Jeton',
        'email' => 'E-Posta',
        'full_name' => 'Ad soyad',
        'phone' => 'Telefon numarası',
        'inst_id' => 'Okul/Kurum kodu',
        'branch_id' => 'Alan/Branş'
    ];
}