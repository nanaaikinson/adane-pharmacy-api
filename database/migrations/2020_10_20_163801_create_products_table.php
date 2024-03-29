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
      $table->string('generic_name')->nullable();
      $table->string('brand_name')->nullable();
      //$table->unsignedBigInteger('category_id')->nullable();
      $table->unsignedBigInteger('product_type_id')->nullable();
      $table->unsignedBigInteger('shelf_id')->nullable();
      $table->unsignedBigInteger('supplier_id')->nullable();
      $table->unsignedBigInteger('manufacturer_id')->nullable();
      $table->decimal('quantity')->nullable()->default(0);
      $table->integer('reorder_level')->nullable();
      $table->double('selling_price', 8, 2)->nullable()->default(0);
      $table->double('cost_price', 8, 2)->nullable()->default(0);
      $table->text('description')->nullable();
      $table->text('side_effects')->nullable();
      $table->string('barcode')->nullable();
      $table->string('product_number')->nullable();
      $table->date('purchased_date')->nullable();
      $table->date('expiry_date')->nullable();
      $table->string('mask')->unique()->nullable();
      $table->string("slug")->nullable();
      $table->double('discount')->nullable()->default(0);
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('manufacturer_id')->references('id')
        ->on('manufacturers')->nullOnDelete();

      $table->foreign('supplier_id')->references('id')
        ->on('suppliers')->nullOnDelete();

      $table->foreign('shelf_id')->references('id')
        ->on('shelves')->nullOnDelete();

      $table->foreign('product_type_id')->references('id')
        ->on('product_types')->nullOnDelete();
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
