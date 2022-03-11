<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom_sous_categorie');
            $table->integer('id_categorie')->unsigned();
            $table->timestamps();

            $table->foreign('id_categorie')
            ->references('id')
            ->on('categories');
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
        Schema::table('sous_categories',function(Blueprint $table){
            $table->dropForeign('id_categorie');
        });
        Schema::dropIfExists('sous_categories');
    }
}
