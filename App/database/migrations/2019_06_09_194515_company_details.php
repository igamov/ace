<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::table('company_details')->insert([
        [
          'legal_name' => 'ИП КОЛОМЕЙЦЕВ АЛЕКСЕЙ ОЛЕГОВИЧ',
          'legal_address' => '124575, РОССИЯ, Г МОСКВА, Г ЗЕЛЕНОГРАД, УЛ ПАНФИЛОВА, Д 15А, КВ 48',
          'inn' => '773582723132',
          'kpp' => '',
          'rs' => '40802810000000886007',
          'bank' => 'АО "ТИНЬКОФФ БАНК"',
          'ks' => '30101810145250000974',
          'bik' => '044525974',
          'director' => 'Коломейцев А.О.',
          'accountant' => 'Коломейцев А.О.'
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
