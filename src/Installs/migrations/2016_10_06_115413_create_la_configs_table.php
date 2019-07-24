<?php
/**
 * Migration generated using GlobeAdmin
 * Help: http://deltasoftltd.com
 * GlobeAdmin is open-sourced software licensed under the MIT license.
 * Developed by: DeltaSoft Technologies
 * Developer Website: https://deltasoftltd.com
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 50);
			$table->string('section', 100)->default("");
            $table->string('value', 255);
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
        Schema::drop('la_configs');
    }
}
