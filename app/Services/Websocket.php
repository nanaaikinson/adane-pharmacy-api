<?php

namespace App\Services;

use Pusher\Pusher;

class Websocket
{
  /**
   * @param string $channel
   * @param string $event
   * @param $data
   */
  public static function emit(string $channel, string $event, $data): void
  {
    try {
//      $pusher = new Pusher(
//        env("PUSHER_AUTH_KEY"),
//        env("PUSHER_APP_SECRET"),
//        env("PUSHER_APP_ID"),
//        ["cluster" => env("PUSHER_APP_CLUSTER"),
//          //'useTLS' => true
//        ]
//      );
//      $pusher->trigger($channel, $event, $data);

      $options = array(
        'cluster' => 'us2',
      );
      $pusher = new Pusher(
        '0e2b173955050e48139a',
        '8422e7dc3075d7928f02',
        '1099881',
        $options
      );

      $pusher->trigger($channel, $event, $data);
    }
    catch (\Exception $e) {
      dd($e->getMessage());
    }
  }
}
