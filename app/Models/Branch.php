<?php
/**
 * Bu yazılım Elektrik Elektronik Teknolojileri Alanı/Elektrik Öğretmeni Hakan GÜLEN tarafından geliştirilmiş olup geliştirilen bütün kaynak kodlar
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0) ile lisanslanmıştır.
 * Ayrıntılı lisans bilgisi için https://creativecommons.org/licenses/by-nc-sa/4.0/legalcode.tr sayfasını ziyaret edebilirsiniz.2019
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
