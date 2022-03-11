<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommantairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commantaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commantaire');
            $table->integer('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('id_user')
            ->references('id')
            ->on('users');
            // ->onDelete('restrict')
            // ->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commantaires',function(Blueprint $table){
            $table->dropForeign('id_user');
        });
        Schema::dropIfExists('commantaires');
    }
}
