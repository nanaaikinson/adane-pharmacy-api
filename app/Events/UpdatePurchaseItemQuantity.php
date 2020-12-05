<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatePurchaseItemQuantity
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $quantity;
  public $action;
  public $purchaseItemId;

  /**
   * Create a new event instance.
   *
   * @param int $purchaseItemId
   * @param int $quantity
   * @param string $action
   */
  public function __construct(int $purchaseItemId, int $quantity, $action = "addition")
  {
    $this->quantity = $quantity;
    $this->action = $action;
    $this->purchaseItemId = $purchaseItemId;
  }


}
