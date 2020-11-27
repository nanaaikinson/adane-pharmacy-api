<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('customers', function (Blueprint $table) {
      $table->string("phone_number")->nullable();
      $table->string("height")->nullable();
      $table->string("weight")->nullable();
      $table->date("date_of_birth")->nullable()->default(NULL);
      $table->text("allergies")->nullable();
      $table->longText("others")->nullable();
      $table->dropUnique("customers_email_unique");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('customers', function (Blueprint $table) {
      //
    });
  }
}
