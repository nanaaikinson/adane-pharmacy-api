<?php

namespace App\Listeners;

use App\Events\UpdatePurchaseItemQuantity;
use App\Models\PurchaseItem;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePurchaseItemQuantityEventListener implements ShouldQueue
{
  /**
   * Handle the event.
   *
   * @param UpdatePurchaseItemQuantity $event
   * @return void
   */
  public function handle(UpdatePurchaseItemQuantity $event)
  {
    $item = PurchaseItem::find($event->purchaseItemId);
    if (strtolower($event->action) == "addition") {
      $item->sold_quantity += $event->quantity;
    }

    $item->save();
  }
}
