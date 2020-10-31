<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrandsRealtimeEvent
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $data;
  public $channel;
  public $event;
  public $type;

  /**
   * Create a new event instance.
   *
   * @param $data
   * @param $channel
   * @param $event
   * @param $type
   */
  public function __construct($data, $channel, $event, $type)
  {
    $this->data = $data;
    $this->channel = $channel;
    $this->event = $event;
    $this->type = $type;
  }

}
