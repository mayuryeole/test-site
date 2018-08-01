<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOccasionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    
            {
        Schema::create('occasions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
        Schema::create('product_occasions', function (Blueprint $table) 
                {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->integer('occasion_id')->unsigned()->index()->nullable();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('set null');
             $table->foreign('occasion_id')->references('id')->on('occasions')->onDelete('set null')->onUpdate('set null');
           
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
                Schema::drop('product_occasions');
                                Schema::drop('occasions');

    }
}
