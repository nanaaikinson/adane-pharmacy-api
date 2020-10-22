<?php

namespace App\Observers;

use App\Functions\Mask;
use App\Models\Product;

class ProductObserver
{
  /**
   * Handle the product "created" event.
   *
   * @param \App\Models\Product $product
   * @return void
   */
  public function created(Product $product)
  {
    $product->update(['mask' => Mask::string($product->id)]);
  }

  /**
   * Handle the product "updated" event.
   *
   * @param \App\Models\Product $product
   * @return void
   */
  public function updated(Product $product)
  {
    //
  }

  /**
   * Handle the product "deleted" event.
   *
   * @param \App\Models\Product $product
   * @return void
   */
  public function deleted(Product $product)
  {
    //
  }

  /**
   * Handle the product "restored" event.
   *
   * @param \App\Models\Product $product
   * @return void
   */
  public function restored(Product $product)
  {
    //
  }

  /**
   * Handle the product "force deleted" event.
   *
   * @param \App\Models\Product $product
   * @return void
   */
  public function forceDeleted(Product $product)
  {
    //
  }
}
