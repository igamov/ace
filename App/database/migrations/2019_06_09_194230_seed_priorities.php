<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedPriorities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('priorities')->insert([
        [
          'title' => 'Низкий',
          'color' => 'badge-primary',
        ],
        [
          'title' => 'Средний',
          'color' => 'badge-success',
        ],
        [
          'title' => 'Высокий',
          'color' => 'badge-danger',
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
