<?php


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
