<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateProductDetailEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $product;
  public $sellingPrice;

  /**
   * Create a new event instance.
   *
   * @param int $product_id
   * @param float $selling_price
   */
  public function __construct(int $product_id, float $selling_price)
  {
    $this->product = $product_id;
    $this->sellingPrice = $selling_price;
  }
}
