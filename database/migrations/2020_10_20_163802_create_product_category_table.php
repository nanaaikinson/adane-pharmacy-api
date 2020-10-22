<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_category', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('category_id')->nullable();
      $table->unsignedBigInteger('product_id')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('category_id')->references('id')
        ->on('categories')->cascadeOnDelete();

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
    Schema::dropIfExists('product_category');
  }
}
