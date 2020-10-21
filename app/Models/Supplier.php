<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Supplier extends Model implements Auditable, HasMedia
{
  use HasFactory;
  use \OwenIt\Auditing\Auditable;
  use InteractsWithMedia;

  protected $guarded = [];

  /**
   * Supplier has many products
   *
   * @return HasMany
   */
  public function products(): HasMany
  {
    return $this->hasMany(Product::class);
  }
}
