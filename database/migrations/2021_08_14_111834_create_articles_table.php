<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_article')->unique();
            $table->integer('prix_article');
            $table->string('image1_article');
            $table->string('image2_article');
            $table->string('image3_article');
            $table->string('image4_article');
            $table->string('description_article');
            $table->string('caraterisque_article');
            $table->string('poid_article');
            $table->string('taille_tee_shirt');
            $table->string('col_tee_shirt');
            $table->string('pilage_brochure');
            $table->string('relire_brochure');
            $table->string('couleur');
            $table->string('type_papier');
            $table->string('type_impression');
            $table->string('type_plascification');
            $table->string('format_papier');
            $table->integer('Nb_page_depliant');
            $table->string('Largeur');
            $table->string('Hauteur');
            $table->integer('status');
            $table->integer('id_sous_categorie');
            $table->integer('id_marque');
            $table->timestamps();
          
            // $table->integer('id_couleur')->unsigned();
            // $table->integer('id_papier')->unsigned();
            // $table->integer('id_impression')->unsigned();
            // $table->integer('id_plascification');
            // $table->integer('id_commande')->unsigned();
            $table->foreign('id_sous_categorie')
            ->references('id')
            ->on('sous_categories');
            // ->onDelete('restrict')
            // ->onUpdate('restrict');
            // $table->foreign('id_couleur')
            // ->references('id')
            // ->on('couleurs')
            // ->onDelete('restrict')
            // ->onUpdate('restrict');
            $table->foreign('id_marque')
            ->references('id')
            ->on('marques');
            // ->onDelete('restrict')
            // ->onUpdate('restrict');

            // $table->foreign('id_papier')
            // ->references('id')
            // ->on('papiers')
            // ->onDelete('restrict')
            // ->onUpdate('restrict');

            // $table->foreign('id_impression')
            // ->references('id')
            // ->on('impressions')
            // ->onDelete('restrict')
            // ->onUpdate('restrict');

            // $table->foreign('id_plascification')
            // ->references('id')
            // ->on('plascifications')
            // ->onDelete('restrict')
            // ->onUpdate('restrict');
            // $table->foreign('id_commande')->references('id')->on('commandes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles',function(Blueprint $table){
            $table->dropForeign('id_sous_categorie');
            $table->dropForeign('id_marque');
            // $table->dropForeign('id_commande');
        });
        Schema::drop('articles');
        
    }
}
