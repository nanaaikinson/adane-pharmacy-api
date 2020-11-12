<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('purchase_items', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger("purchase_id")->nullable();
      $table->unsignedBigInteger("product_id")->nullable();
      $table->date("expiry_date")->nullable()->default(null);
      $table->double("cost_price", 8,2)->nullable()->default(0);
      $table->double("selling_price", 8,2)->nullable()->default(0);
      $table->decimal("quantity")->nullable()->default(0);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('purchase_id')->references('id')
        ->on('purchases')->nullOnDelete();

      $table->foreign('product_id')->references('id')
        ->on('products')->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('purchase_items');
  }
}
