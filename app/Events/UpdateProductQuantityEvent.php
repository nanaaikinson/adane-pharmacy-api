<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateProductQuantityEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $product;
  public $quantity;
  public $action;

  /**
   * Create a new event instance.
   *
   * @param int $product_id
   * @param float $quantity
   * @param string $action
   */
  public function __construct(int $product_id, float $quantity, string $action = "addition")
  {
    $this->product = $product_id;
    $this->quantity = $quantity;
    $this->action = $action;
  }
}
