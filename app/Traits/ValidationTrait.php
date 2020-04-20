<?php
/**
 *  Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 *  Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 *  Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz. 2019
 */

namespace App\Traits;


trait ValidationTrait
{
    public $MESSAGES = [
            'password.regex' => 'Şifre en az bir adet rakam,'.
                ' bir adet küçük harf, bir adet özel karakter(.,+@#%)'.
                ' içermelidir ve en az 8 en fazla 16 karakter olmalıdır',
        ];

    public $ATTRIBUTES = [
        'learning_outcome_id' => 'Kazanım',
        'difficulty' => 'Zorluk',
        'question_file' => 'Soru dosyası',
        'password' => 'Şifre',
        'token' => 'Jeton',
        'email' => 'E-Posta',
    ];
}