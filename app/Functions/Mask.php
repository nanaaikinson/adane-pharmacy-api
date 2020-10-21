<?php

namespace App\Functions;

class Mask {
  /**
   * @param $id
   * @return string
   */
  public static function string($id): string
  {
    $timestamp = time();
    $hostname = php_uname('n');
    $processId = getmypid();

    // Building binary data.
    $bin = sprintf(
      "%s%s%s%s",
      pack('N', $timestamp),
      substr(md5($hostname), 0, 3),
      pack('n', $processId),
      substr(pack('N', $id), 1, 3)
    );

    // Convert binary to hex.
    $result = '';
    for ($i = 0; $i < 12; $i++) {
      $result .= sprintf("%02x", ord($bin[$i]));
    }

    return $result;
  }

  public static function integer(): int
  {
    return rand(0000001, 9999999);
  }
}
