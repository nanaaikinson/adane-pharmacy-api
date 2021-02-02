<?php

namespace App\Console\Commands;

use App\Jobs\ProductMultipleReorderJob;
use Illuminate\Console\Command;

class ReorderNotice extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "adane:product-reorder-scheduler";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Reorder scheduler command';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   */
  public function handle()
  {
    dispatch(new ProductMultipleReorderJob());
  }
}
