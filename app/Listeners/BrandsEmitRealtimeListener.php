<?php

namespace App\Listeners;

use App\Services\Websocket;
use Illuminate\Contracts\Queue\ShouldQueue;

class BrandsEmitRealtimeListener implements ShouldQueue
{
  /**
   * Handle the event.
   *
   * @param object $event
   * @return void
   */
  public function handle(object $event)
  {
    Websocket::emit($event->channel, $event->event, [
      "type" => $event->type,
      "data" => $event->data
    ]);
  }
}
