<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseItem extends Model
{
  public $incrementing = true;
  public $timestamps;
  public $table = "purchase_items";

  protected $guarded = [];

  public function products(): HasMany
  {
    return $this->hasMany(Product::class);
  }
}
