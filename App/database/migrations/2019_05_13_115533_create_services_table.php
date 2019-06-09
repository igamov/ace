<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('services', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->decimal('price', 12, 2);
      $table->integer('count');
      $table->decimal('sum', 12, 2);
      $table->integer('nds_id');
      $table->integer('invoice_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('services');
  }
}
