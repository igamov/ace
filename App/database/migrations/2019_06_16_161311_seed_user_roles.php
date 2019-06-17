<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      {
        DB::table('user_roles')->insert([
          [
            'name' => 'admin',
          ],
          [
            'name' => 'manager',
          ],
          [
            'name' => 'developer',
          ],
          [
            'name' => 'customer',
          ],
        ]);
      }
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
