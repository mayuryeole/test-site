<?php

namespace App\PiplModules\cart\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {

    protected $fillable = ['order_id','product_id','product_quantity','product_price','product_name'];

    public function product() {
        return $this->hasOne('App\PiplModules\product\Models\Product', 'id', 'product_id');
    }
    public function order()

    {
        return $this->belongsTo('App\PiplModules\cart\Models\Order','id','order_id');
    }
    
    public function productPrice($id) {
        $product = \App\PiplModules\product\Models\Product::find($id);
        
        if (($product->start_date != "") && ($product->end_date != "")) 
            {
                if ((str_replace('/', '', $product->start_date) <= str_replace('/', '', date('m/d/Y'))) && (str_replace('/', '', $product->end_date) >= str_replace('/', '', date('m/d/Y')))) 
                {
                    return $product->sale_price;
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
    
    public function getProductImage($id)
    {
        $image=  \App\PiplModules\product\Models\ProductImage::where('product_id',$id)->where('featured_image',1)->first();
        if(!$image)
        {
            $image=\App\PiplModules\product\Models\ProductImage::where('product_id',$id)->get();
            return $image_name=$image[0]->image;
        }
        else
        {
            return $image_name=$image->image;
        }
    }

}
