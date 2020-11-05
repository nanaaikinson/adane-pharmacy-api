<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $types = ["Liquid", "Capsules", "Tablet"];

    foreach ($types as $type) {
      ProductType::create([
        "name" => $type
      ]);
    }
  }
}
