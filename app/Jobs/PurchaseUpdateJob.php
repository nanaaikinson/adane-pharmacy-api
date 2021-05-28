<?php

namespace App\Jobs;

use App\Events\UpdateProductDetailEvent;
use App\Events\UpdateProductQuantityEvent;
use App\Models\PurchaseItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchaseUpdateJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $purchaseItems;
  private $purchase;
  private $validated;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($purchaseItems, $purchase, $validated)
  {
    $this->purchaseItems = $purchaseItems;
    $this->purchase = $purchase;
    $this->validated = $validated;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    foreach ($this->validated->items as $item) {
      $item = (object)$item;

      PurchaseItem::create([
        "purchase_id" => $this->purchase->id,
        "product_id" => $item->product_id,
        "expiry_date" => $item->has_expiry ? $item->expiry_date : NULL,
        "cost_price" => $item->cost_price,
        "selling_price" => $item->selling_price,
        "quantity" => $item->quantity,
      ]);

      // Update product quantity
      event(new UpdateProductQuantityEvent($item->product_id, $item->quantity, "addition"));

      // Update product detail
      if ($item->is_selling_price) {
        event(new UpdateProductDetailEvent($item->product_id, $item->selling_price));
      }
    }

    foreach ($this->purchaseItems as $item) {
      $item->delete();

      // Update product quantity
      event(new UpdateProductQuantityEvent($item->product_id, $item->quantity, "subtraction"));
    }
  }
}
