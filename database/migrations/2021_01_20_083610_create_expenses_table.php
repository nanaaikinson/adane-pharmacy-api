<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('expenses', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger("expense_category_id")->nullable();
      $table->string("name")->nullable();
      $table->double("amount", 8, 2)->nullable()->default(0);
      $table->text("note")->nullable();
      $table->string("mask")->unique();
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
    Schema::dropIfExists('expenses');
  }
}
