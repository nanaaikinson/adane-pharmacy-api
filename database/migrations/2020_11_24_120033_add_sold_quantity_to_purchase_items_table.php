<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoldQuantityToPurchaseItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('purchase_items', function (Blueprint $table) {
      $table->decimal("sold_quantity", 8, 2)->nullable()->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('purchase_items', function (Blueprint $table) {

    });
  }
}
