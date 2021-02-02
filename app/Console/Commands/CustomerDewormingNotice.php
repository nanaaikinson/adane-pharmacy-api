<?php

namespace App\Console\Commands;

use App\Jobs\CustomerDewormingJob;
use Illuminate\Console\Command;

class CustomerDewormingNotice extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = "adane:customer-deworming-scheduler";

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Customer deworming notice";

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
   *
   */
  public function handle()
  {
    dispatch(new CustomerDewormingJob());
  }
}
