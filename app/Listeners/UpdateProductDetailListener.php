<?php

namespace App\Listeners;

use App\Events\UpdateProductDetailEvent;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductDetailListener implements ShouldQueue
{
  /**
   * Handle the event.
   *
   * @param UpdateProductDetailEvent $event
   * @return void
   */
  public function handle(UpdateProductDetailEvent $event)
  {
    $product = Product::find($event->product);
    if ($product) {
      $product->selling_price = $event->sellingPrice;
      $product->save();
    }
  }
}
