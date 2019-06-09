<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('customers', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name')->unique();
      $table->string('email')->unique();
      $table->string('phone');
      $table->string('site');
      $table->string('legal_name');
      $table->text('legal_address')->nullable();
      $table->string('inn');
      $table->string('kpp')->nullable();
      $table->integer('manager_id');
      $table->integer('spokesman_id');
      $table->integer('area_activity_id');
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
    Schema::dropIfExists('customers');
  }
}
