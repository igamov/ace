<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('invoices', function (Blueprint $table) {
      $table->increments('id');
      $table->string('number');
      $table->date('payment_date');
      $table->decimal('sum', 12, 2);
      $table->integer('manager_id');
      $table->integer('customer_id');
      $table->string('pdf_path')->nullable();
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
    Schema::dropIfExists('invoices');
  }
}
