<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUploadsAddCategoriesIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uploads', function (Blueprint $table){
           $table->integer('categories_id')->unsigned()->nullable();
           $table->foreign('categories_id')
               ->references('id')
               ->on('categories')
               ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uploads',function(Blueprint $table) {
            $table->dropForeign(['categories_id']);
            $table->dropColumn('categories_id');
        });
    }
}
