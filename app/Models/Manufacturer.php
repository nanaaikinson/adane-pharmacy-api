<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Manufacturer extends Model implements Auditable
{
  use HasFactory;
  use \OwenIt\Auditing\Auditable;

  protected $guarded = [];

  /**
   * Manufacturer has many products
   *
   * @return HasMany
   */
  public function products(): HasMany
  {
    return $this->hasMany(Product::class);
  }
}
