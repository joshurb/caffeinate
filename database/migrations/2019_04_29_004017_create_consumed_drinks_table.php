<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumedDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumed_drinks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('drink_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('consumed_drinks', function (Blueprint $table) {
            $table->foreign('drink_id')->references('id')->on('drinks');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumed_drinks');
    }
}
