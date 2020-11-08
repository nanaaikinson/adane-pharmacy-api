<?php

namespace Database\Seeders;

use App\Functions\Mask;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Customer::create([
      "first_name" => "Walk in",
      "last_name" => "customer",
      "email" => "walkincustomer@store.com",
      "password" => bcrypt("password"),
    ]);
  }
}
