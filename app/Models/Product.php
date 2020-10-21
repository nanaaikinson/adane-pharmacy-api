<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
  use HasFactory;
  use \OwenIt\Auditing\Auditable;

  protected $guarded = [];

  /**
   * Product belongs to a manufacturer
   *
   * @return BelongsTo
   */
  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo(Manufacturer::class);
  }

  /**
   * Product belongs to a supplier
   *
   * @return BelongsTo
   */
  public function supplier(): BelongsTo
  {
    return $this->belongsTo(Supplier::class);
  }

  /**
   * Product belongs to several categories
   *
   * @return BelongsToMany
   */
  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, "product_category", "product_id", "category_id")
      ->withTimestamps();
  }
}
