<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_triggers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('parameter');
            $table->string('condition'); //'above' or 'below'
            $table->float('value');
            $table->float('period');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_triggers');
    }
}
