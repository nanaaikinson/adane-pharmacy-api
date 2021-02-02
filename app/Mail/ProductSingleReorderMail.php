<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSingleReorderMail extends Mailable
{
  use Queueable, SerializesModels;

  public $product;

  /**
   * Create a new message instance.
   *
   * @param $product
   */
  public function __construct($product)
  {
    $this->product = $product;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build(): ProductSingleReorderMail
  {
    return $this->from("sales@adanechemistltd.com", "Sales")
      ->subject("REORDER OR RESTOCK NOTICE")
      ->view('emails.notifications.reorder-single');
  }
}
