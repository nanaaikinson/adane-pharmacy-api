<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('purchases', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('supplier_id')->nullable();
      $table->unsignedBigInteger('product_id')->nullable();
      $table->integer('quantity')->nullable();
      $table->date('purchase_date')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('supplier_id')->references('id')
        ->on('suppliers')->nullOnDelete();

      $table->foreign('product_id')->references('id')
        ->on('products')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('purchases');
  }
}
