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

  protected $guarded = [];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function getNameAttribute(): string
  {
    return "{$this->first_name} {$this->last_name}";
  }

  public function dewormingNotices()
  {
    return $this->hasMany(CustomerDewormingNotice::class);
  }
}
