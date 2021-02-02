<?php

namespace App\Jobs;

use App\Mail\ProductSingleReorderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProductSingleReorderJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $product;

  /**
   * Create a new job instance.
   *
   * @param $product
   */
  public function __construct($product)
  {
    $this->product = $product;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    if ($this->product->quantity <= $this->product->reorder_level) {
      Mail::to("adanechemistltd@gmail.com")
        ->send(new ProductSingleReorderMail($this->product));
    }
  }
}
