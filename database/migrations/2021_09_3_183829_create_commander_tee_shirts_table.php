<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommanderTeeShirtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commander_tee_shirts', function (Blueprint $table) {
            $table->increments('id_c');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('couleur');
            $table->string('col');
            $table->string('taille');
            $table->string('modele');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('qte');
            $table->date('rdv');
            $table->string('note');
            $table->string('marque');
            $table->integer('prix');
            $table->timestamps();

            $table->integer('id_user');
            $table->integer('id_mode_livraison');

            $table->foreign('id_user')
            ->references('id')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->foreign('id_mode_livraison')
            ->references('id')
            ->on('mode_livraisons')
            ->onDelete('restrict')
            ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commander_tee_shirts',function(Blueprint $table){
            $table->dropForeign('id_user');
            $table->dropForeign('id_mode_livraison');
        });
        Schema::drop('commander_tee_shirts');
    }
}
