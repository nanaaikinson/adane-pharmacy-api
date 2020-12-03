<?php

namespace Database\Seeders;

use App\Functions\Mask;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Role::create([
      "name" => "developer",
      "display-name" => "Developer",
      "mask" => Mask::integer()
    ]);

    Role::create([
      "name" => "admin",
      "display-name" => "Admin",
      "mask" => Mask::integer()
    ]);

    Role::create([
      "name" => "dispenser",
      "display-name" => "Dispenser",
      "mask" => Mask::integer()
    ]);
  }
}
