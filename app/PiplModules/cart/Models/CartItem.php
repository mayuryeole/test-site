<?php

namespace App\PiplModules\cart\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {

    protected $fillable = ['cart_id', 'product_id', 'product_color_id', 'product_quantity'];

    public function product() {
        return $this->hasOne('App\PiplModules\product\Models\Product', 'id', 'product_id');
    }
    public function productColor() {
        return $this->hasOne('App\PiplModules\product\Models\Color', 'id', 'product_color_id');
    }

    public function productPrice($id) {
        $product = $this->hasOne('App\PiplModules\product\Models\ProductDescription', 'product_id', 'product_id')->where('product_id', $id)->first();

        if(isset($product) && count($product)>0){
        if (isset($product->start_date) && $product->start_date != "" && $product->end_date != "")
            {
                if ((str_replace('/', '', $product->start_date) <= str_replace('/', '', date('m/d/Y'))) && (str_replace('/', '', $product->end_date) >= str_replace('/', '', date('m/d/Y')))) 
                {
                    return $product->price;
                } 
                else
                {
                    return $product->price;
                }   
            }   
        else 
        {
            return $product->price;
        }
        }
        else{
            return 0;
        }
        
    }
    }
    