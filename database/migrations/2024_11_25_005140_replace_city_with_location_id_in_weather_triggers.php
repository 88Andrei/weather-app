<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceCityWithLocationIdInWeatherTriggers extends Migration
{
    public function up()
    {
        Schema::table('weather_triggers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->dropColumn('city'); 
            $table->unsignedBigInteger('location_id')->after('name');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('weather_triggers', function (Blueprint $table) {

            $table->dropForeign(['location_id']); 
            $table->dropColumn('location_id'); 
            $table->string('city')->after('name');
        });
    }
}



