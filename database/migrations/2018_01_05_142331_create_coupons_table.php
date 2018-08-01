<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_code')->nullable();

            $table->string('name')->nullable();

            $table->dateTime('coupon_valid_from')->nullable();
            $table->dateTime('coupon_valid_to')->nullable();
            $table->double('percentage')->nullable();
            $table->double('amount')->nullable();
            $table->string('image')->nullable();
            
            $table->integer('quantity')->nullable();
            $table->enum('status', array('0', '1'));
            
            $table->string('description')->nullable();

//            $table->integer('category_id')->unsigned()->index()->nullable();
//            $table->integer('product_id')->unsigned()->index()->nullable();
//            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('set null');
//            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('set null');

            $table->timestamps();
        });

        Schema::create('applied_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->unsigned()->index()->nullable();
            $table->integer('product_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('order_id')->nullable();
            $table->dateTime('coupon_used_date')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null')->onUpdate('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null')->onUpdate('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');

            $table->timestamps();
        });
        
        
        Schema::create('coupon_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null')->onUpdate('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('coupons');
        Schema::drop('applied_coupons');
        Schema::drop('coupon_users');
        
        
    }

}
