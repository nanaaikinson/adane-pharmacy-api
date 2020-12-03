<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Roles
    Permission::insert([
      [
        "name" => "create-role", "display_name" => "create role",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "read-role", "display_name" => "view role",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "update-role", "display_name" => "update role",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "delete-role", "display_name" => "delete role",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ]
    ]);

    // Users
    Permission::insert([
      [
        "name" => "create-user", "display_name" => "create user",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "read-user", "display_name" => "view user",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "update-user", "display_name" => "update user",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "delete-user", "display_name" => "delete user",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ]
    ]);
  }
}
