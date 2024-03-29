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

    // Settings
    Permission::insert([
      [
        "name" => "settings", "display_name" => "settings",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
    ]);

    // Point of sale
    Permission::insert([
      [
        "name" => "point-of-sale", "display_name" => "point of sale",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ]
    ]);

    // Customers
    Permission::insert([
      [
        "name" => "create-customer", "display_name" => "create customer",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "read-customer", "display_name" => "view customer",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "update-customer", "display_name" => "update customer",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "delete-customer", "display_name" => "delete customer",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ]
    ]);

    // Stock
    Permission::insert([
      [
        "name" => "create-product", "display_name" => "create product",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "read-product", "display_name" => "view product",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "read-product-report", "display_name" => "view product report",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "update-product", "display_name" => "update product",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "delete-product", "display_name" => "delete product",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "create-purchase", "display_name" => "create purchase",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "read-purchase", "display_name" => "view purchase",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "update-purchase", "display_name" => "update purchase",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
      [
        "name" => "delete-purchase", "display_name" => "delete purchase",
        "created_at" => gmdate("Y-m-d H:i:s"), "updated_at" => gmdate("Y-m-d H:i:s")
      ],
    ]);
  }
}
