<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->timestamps();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('parent_id')->nullable();

            $table->integer('created_by')->unsigned()->index()->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('about_category')->nullable();
            $table->string('image')->nullable();
            $table->string('locale')->index();
            $table->unique(array('category_id', 'locale'));
//            $table->enum('discount_type',array('0','1'));
            $table->double('discount_price')->nullable();
            $table->double('discount_percent')->nullable();
            $table->dateTime('discount_valid_from')->nullable();
            $table->dateTime('discount_valid_to')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('categoies');
        Schema::drop('category_translations');
    }

}
