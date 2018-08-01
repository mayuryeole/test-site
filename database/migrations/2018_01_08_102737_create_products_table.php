<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('images')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->integer('created_by')->unsigned()->index()->nullable();

            $table->integer('sku')->nullable();
            $table->string('color')->nullable();
//            $table->integer('size')->nullable();
            $table->double('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('style')->unsigned()->index()->nullable();
            $table->integer('collection_style')->unsigned()->index()->nullable();
            $table->string('occasion')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('max_quantity')->nullable();
            $table->double('discount_price')->nullable();
            $table->double('discount_percent')->nullable();

            $table->enum('discount_type', array('0', '1'));
            $table->enum('is_featured', array('0', '1'));
            $table->enum('availability', array('0', '1'));
            $table->enum('status', array('0', '1'));
            $table->enum('pre_order', array('0', '1'));
            $table->dateTime('launched_date')->nullable();
            $table->enum('currency', array('0', '1'));
            $table->string('short_description')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('discount_valid_from')->nullable();
            $table->dateTime('discount_valid_to')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });

//        Schema::create('sizes', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('size')->nullable();
//            $table->integer('product_id')->unsigned()->index()->nullable();
//            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
//            $table->timestamps();
//        });
//        Schema::create('colors', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('color')->nullable();
//            $table->integer('product_id')->unsigned()->index()->nullable();	
//            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('set null');
//            $table->timestamps();
//        });

        
        Schema::create('styles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            
            $table->timestamps();
        });
        Schema::create('product_styles', function (Blueprint $table) 
                {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->integer('style_id')->unsigned()->index()->nullable();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('set null');
             $table->foreign('style_id')->references('id')->on('styles')->onDelete('set null')->onUpdate('set null');
           
            $table->timestamps();
        });
        
        Schema::create('collection_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
        Schema::create('product_collection_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('collection_style_id')->unsigned()->index()->nullable();
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->foreign('collection_style_id')->references('id')->on('collection_styles')->onDelete('set null')->onUpdate('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('set null');
    
            $table->timestamps();
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('products');
        Schema::drop('product_images');
        Schema::drop('product_descriptions');
//        Schema::drop('sizes');
//        Schema::drop('colors');
        Schema::drop('styles');
        Schema::drop('product_styles');
        Schema::drop('collection_styles');
        Schema::drop('product_collection_styles');
    }

}
