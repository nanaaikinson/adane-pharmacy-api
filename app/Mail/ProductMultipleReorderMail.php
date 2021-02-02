<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductMultipleReorderMail extends Mailable
{
  use Queueable, SerializesModels;

  public $products;

  /**
   * Create a new message instance.
   *
   * @param $products
   */
  public function __construct($products)
  {
    $this->products = $products;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build(): ProductMultipleReorderMail
  {
    return $this->from("sales@adanechemistltd.com", "Sales")
      ->subject("REORDER LEVEL NOTICE")
      ->view('emails.notifications.reorder-multiple');
  }
}
