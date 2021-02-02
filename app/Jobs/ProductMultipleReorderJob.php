<?php

namespace App\Jobs;

use App\Mail\ProductMultipleReorderMail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProductMultipleReorderJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $products = Product::where("quantity", "<=", "reorder_level")->get();

    if ($products->isNotEmpty()) {
//      Mail::to("nanaaikinson24@gmail.com")
//        ->send(new ProductMultipleReorderMail($products));

      Mail::to("adanechemistltd@gmail.com")
        ->send(new ProductMultipleReorderMail($products));
    }
  }
}
