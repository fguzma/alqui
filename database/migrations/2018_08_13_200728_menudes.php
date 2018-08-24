<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Menudes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menudes', function (Blueprint $table) {
            $table->integer("id_descripcion");
            $table->integer("id_menu");
            $table->timestamps();
            $table->foreign('id_menu')
            ->references('id')->on('menu')
            ->onDelete('cascade');
            $table->foreign('id_descripcion')
            ->references('IdDescripcion')->on('descripcion')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
