<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Authenticatable implements Auditable
{
  use LaratrustUserTrait;
  use HasFactory, Notifiable;
  use \OwenIt\Auditing\Auditable;
  use HasApiTokens;

  /**
   * The attributes that are guarded.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * Get full name of user
   *
   * @return string
   */
  public function getNameAttribute(): string
  {
    return "{$this->first_name} {$this->last_name}";
  }
}
