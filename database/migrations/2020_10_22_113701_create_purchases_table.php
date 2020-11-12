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
      $table->string('invoice_number')->nullable();
      $table->date('purchase_date')->nullable();
      $table->text('description')->nullable();
      $table->timestamps();
      $table->softDeletes();

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
    Schema::dropIfExists('purchases');
  }
}
