<?php

namespace App\PiplModules\wishlist\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model {

     protected $fillable = ['customer_id','product_id','product_quantity'];

    public function product()
    {
        return $this->hasOne('App\PiplModules\product\Models\Product', 'id', 'product_id');
    }
    
    public function productDescription() 
    {
        return $this->hasOne('App\PiplModules\product\Models\ProductDescription', 'product_id', 'product_id');
    }
    
    public function productColor() 
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductColor', 'product_id', 'product_id');
    }

}
