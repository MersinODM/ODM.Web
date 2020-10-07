<?php

namespace App;

use App\Models\Branch;
use App\Models\Institution;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use SoftDeletes;
    use CanResetPassword;
    use HasRolesAndAbilities;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'full_name',
      'email',
      'password',
      'phone',
      'inst_id',
      'branch_id',
      'activator_id',
      'activation_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
//    return ["permissions" => $this->getAbilities()->only(["id", "name"])->all()];
    return [];
  }

  public function branch(): BelongsTo
  {
    return $this->belongsTo(Branch::class, "branch_id", "id");
  }

  public function institution(): BelongsTo
  {
    return $this->belongsTo(Institution::class, "inst_id", "id");
  }

  public function lessons(): BelongsToMany
  {
      return $this->belongsToMany(Branch::class, 'user_permitted_lesson', 'user_id', 'lesson_id')
          ->as('permittedLesson')
          ->withTimestamps()
          ->withPivot('is_main', 'creator_id');
  }
}
