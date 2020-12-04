<?php

namespace Database\Seeders;

use App\Functions\Mask;
use App\Models\Permission;
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
    $permissions = Permission::select("id")->get()->toArray();

    $developer = Role::create([
      "name" => "developer",
      "display_name" => "Developer",
      "mask" => Mask::integer()
    ]);

    $developer->attachPermissions($permissions);

    $admin = Role::create([
      "name" => "admin",
      "display_name" => "Admin",
      "mask" => Mask::integer()
    ]);

    $admin->attachPermissions($permissions);

    Role::create([
      "name" => "dispenser",
      "display_name" => "Dispenser",
      "mask" => Mask::integer()
    ]);
  }
}
