<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function items(): HasMany
  {
    return $this->hasMany(PurchaseItem::class);
  }

  public function products(): BelongsToMany
  {
    return $this->belongsToMany(Product::class, PurchaseItem::class);
  }

}
