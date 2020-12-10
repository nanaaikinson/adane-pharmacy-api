<?php

namespace App\Jobs;

use App\Mail\ProductExpiredMail;
use App\Mail\ProductSaleMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $data;
  protected $email;

  /**
   * Create a new job instance.
   *
   * @param $data
   * @param $email
   */
  public function __construct($data, $email)
  {
    $this->data = $data;
    $this->email = $email;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    switch ($this->email) {
      case "product.expired":
        Mail::to("nanaaikinson24@gmail.com")->send(new ProductExpiredMail($this->data));
        break;
      default:
        Mail::to("nanaaikinson24@gmail.com")->send(new ProductSaleMail($this->data));
        break;
    }
  }
}
