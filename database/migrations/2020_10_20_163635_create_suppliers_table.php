<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('suppliers', function (Blueprint $table) {
      $table->id();
      $table->string('name')->nullable();
      $table->string('primary_telephone')->nullable();
      $table->string('secondary_telephone')->nullable();
      $table->string('email')->nullable();
      $table->text('info')->nullable();
      $table->string('mask')->nullable()->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('suppliers');
  }
}
