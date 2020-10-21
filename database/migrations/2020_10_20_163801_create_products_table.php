<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('genetic_name')->nullable();
      $table->string('brand_name')->nullable();
      //$table->unsignedBigInteger('category_id')->nullable();
      $table->unsignedBigInteger('supplier_id')->nullable();
      $table->unsignedBigInteger('manufacturer_id')->nullable();
      $table->integer('quantity')->nullable();
      $table->integer('reorder_level')->nullable();
      $table->double('selling_price')->nullable();
      $table->double('cost_price')->nullable();
      $table->text('description')->nullable();
      $table->text('side_effects')->nullable();
      $table->string('barcode')->nullable();
      $table->string('product_number')->nullable();
      $table->date('purchased_date')->nullable();
      $table->date('expiry_date')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('manufacturer_id')->references('id')
        ->on('manufacturers')->nullOnDelete();

      $table->foreign('supplier_id')->references('id')
        ->on('suppliers')->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
  }
}
