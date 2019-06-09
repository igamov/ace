<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('company_details', function (Blueprint $table) {
      $table->increments('id');
      $table->string('legal_name');
      $table->text('legal_address');
      $table->string('inn');
      $table->string('kpp')->nullable();
      $table->string('rs');
      $table->string('bank');
      $table->string('ks');
      $table->string('bik');
      $table->string('director');
      $table->string('accountant');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('company_details');
  }
}
