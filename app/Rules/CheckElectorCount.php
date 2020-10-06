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

namespace App\Rules;

use App\Models\QuestionEvalRequest;
use App\Models\Setting;
use Illuminate\Contracts\Validation\Rule;

class CheckElectorCount implements Rule
{
    private $count = 0;
    private $max = 0;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($questionId, $code)
    {
        $this->count = QuestionEvalRequest::where('question_id', $questionId)
            ->where('code', $code)
            ->count();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // TODO Toplam değerlendirici sayısı Settings tablosu içine atılıp parametrik hale getirilebilir.
        // Toplam değerlendirici sayısı 5 i geçemez
        $max = Setting::select('max_elector_count')->first()->max_elector_count;
        return $max >= $this->count + count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Toplam değerlendirici sayısı azami '.$this->max.' olmalıdır';
    }
}
