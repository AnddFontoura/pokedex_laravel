<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->renameColumn('pokedex_id', 'api_id')->change();
            $table->unsignedBigInteger('type_id');
            $table->softDeletes();
            
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pokemons', function (Blueprint $table) {
            $table->dropForeign('pokemons_type_id_foreign');
            $table->dropColumn(['type_id']);
            $table->rename('api_id', 'pokedex_id');
        });
    }
};
