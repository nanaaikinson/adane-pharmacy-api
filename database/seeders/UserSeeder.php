<?php

namespace Database\Seeders;

use App\Functions\Mask;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = new User();
    $user->first_name = "Nana";
    $user->last_name = "Aikinson";
    $user->email = "nanaaikinson24@gmail.com";
    $user->username = "nanaaikinson24";
    $user->password = bcrypt("12345678");
    $user->mask = Mask::integer();
    $user->save();

    $user->attachRole(1);

    $user = new User();
    $user->first_name = "Admin";
    $user->last_name = "Admin";
    $user->email = "admin@adanechemistltd.com";
    $user->username = "adminadane";
    $user->password = bcrypt("password");
    $user->mask = Mask::integer();
    $user->save();

    $user->attachRole(2);
  }
}
