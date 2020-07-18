<?php

namespace App\Rules;

use App\Models\QuestionEvalRequest;
use Illuminate\Contracts\Validation\Rule;

class CheckElectorCount implements Rule
{
    private $count = 0;

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
        return 5 >= $this->count + count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Toplam değerlendirici sayısı 5(beş)\'i geçemez';
    }
}
