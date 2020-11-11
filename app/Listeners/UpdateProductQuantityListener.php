<?php

namespace App\Listeners;

use App\Events\UpdateProductQuantityEvent;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductQuantityListener implements ShouldQueue
{
  /**
   * Handle the event.
   *
   * @param UpdateProductQuantityEvent $event
   * @return void
   */
  public function handle(UpdateProductQuantityEvent $event)
  {
    $product = Product::find($event->product);
    if (strtolower($event->action) == "addition") {
      $product->quantity += $event->quantity;
    }
    if (strtolower($event->action) == "subtraction") {
      $product->quantity -= $event->quantity;
    }
    $product->save();
  }
}
