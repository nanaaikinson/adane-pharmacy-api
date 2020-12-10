<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductExpiredMail extends Mailable
{
  use Queueable, SerializesModels;

  private $data;

  /**
   * Create a new message instance.
   *
   * @param $data
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build(): ProductExpiredMail
  {
    return $this->from("sales@adanechemistltd.com", "Sales Team")
      ->subject("Product(s) Expired")
      ->view('emails.product.expired')
      ->with([
        "data" => $this->data
      ]);
  }
}
