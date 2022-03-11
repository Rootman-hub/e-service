<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeLivraisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mode_livraisons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mode');
            $table->string('description_mode');
            $table->integer('id_liv');
            $table->timestamps();
   
            $table->foreign('id_liv')->references('id')->on('livraisons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mode_livraisons');
    }
}
