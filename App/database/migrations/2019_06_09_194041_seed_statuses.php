<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('statuses')->insert([
        [
          'title' => 'Новая',
        ],
        [
          'title' => 'В работе',
        ],
        [
          'title' => 'Проверка',
        ],
        [
          'title' => 'Выполнена',
        ],
      ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
