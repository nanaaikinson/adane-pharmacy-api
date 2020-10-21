<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
  use HasFactory;
  use \OwenIt\Auditing\Auditable;

  protected $guarded = [];

  /**
   * Category belongs to several products
   *
   * @return BelongsToMany
   */
  public function products(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, "product_category", "category_id", "product_id")
      ->withTimestamps();
  }
}
