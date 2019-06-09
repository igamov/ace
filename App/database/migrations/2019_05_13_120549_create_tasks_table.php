<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->text('body');
      $table->date('date_start');
      $table->date('date_end');
      $table->dateTime('time_estimate')->nullable();
      $table->dateTime('time_actual')->nullable();
      $table->integer('manager_id');
      $table->integer('priority_id');
      $table->integer('project_id');
      $table->integer('status_id');
      $table->integer('developer_id');
      $table->integer('rank')->unsigned()->default(0);
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
    Schema::dropIfExists('tasks');
  }
}
