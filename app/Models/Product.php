<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements Auditable, HasMedia
{
  use HasFactory;
  use \OwenIt\Auditing\Auditable;
  use InteractsWithMedia;

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
   * Product belongs to a shelf
   *
   * @return BelongsTo
   */
  public function shelf(): BelongsTo
  {
    return $this->belongsTo(Shelf::class);
  }

  /**
   * Product belongs to a type
   *
   * @return BelongsTo
   */
  public function type(): BelongsTo
  {
    return $this->belongsTo(ProductType::class);
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

  public function productCategory(): HasMany
  {
    return $this->hasMany(ProductCategory::class);
  }

  public function registerMediaConversions(Media $media = null): void
  {
//    $this->addMediaConversion('thumb')
//      ->width(368)
//      ->height(232)
//      ->sharpen(10);
//
//    $this->addMediaConversion('square')
//      ->width(350)
//      ->height(350)
//      ->sharpen(10);
  }

  public function orderItems(): HasMany
  {
    return $this->hasMany(OrderItem::class);
  }

  public function purchaseItems(): HasMany
  {
    return $this->hasMany(PurchaseItem::class);
  }

  public function purchases(): BelongsToMany
  {
    return $this->belongsToMany(Purchase::class, PurchaseItem::class)
      ->withPivot("cost_price", "selling_price", "quantity", "expiry_date", "product_id", "purchase_id", "id");
  }
}
