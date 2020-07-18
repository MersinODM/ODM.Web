<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Sınavın hangi amaçla yapıldığını tutan model
 * Class ExamPurpose
 * @package App\Models
 */
class ExamPurpose extends Model
{
    protected $fillable = [
        'id',
        'purpose',
        'code'
    ];
}
