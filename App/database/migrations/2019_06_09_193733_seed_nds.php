<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedNds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('nds')->insert([
        [
          'title' => 'Без НДС',
          'percent' => 0,
        ],
        [
          'title' => 'НДС - 10%',
          'percent' => 10,
        ],
        [
          'title' => 'НДС - 18%',
          'percent' => 18,
        ],
        [
          'title' => 'НДС - 20%',
          'percent' => 20,
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
