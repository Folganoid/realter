<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('user_id')->unsigned();
            $table->text('desc');
            $table->double('price', 10, 2);
            $table->double('square', 10,2);
            $table->text('address');
            $table->string('operation', 4);
            $table->integer('house_type_id')->unsigned();
            $table->dateTime('openview')->nullable();
            $table->integer('openview_min')->nullable();
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
        Schema::dropIfExists('houses');
    }
}
