<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSaleMail extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  protected $data;

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
  public function build(): ProductSaleMail
  {
    return $this->from("sales@adanechemistltd.com", "Sales")
      ->subject("Product(s) Order")
      ->view('emails.product.sale')
      ->with([
        "data" => $this->data
      ]);
  }
}
