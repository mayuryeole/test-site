<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // attributes table
        Schema::create('attributes', function (Blueprint $table) {
         $table->increments('id');
         $table->timestamps();
			
        });
        
        //attribute_translations
        Schema::create('attribute_translations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('attribute_id')->unsigned();
                $table->string('name');
                $table->string('locale')->index();
                $table->unique(array('attribute_id','name', 'locale'));
                $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
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
        //
        Schema::drop('attriutes');
    }
}