<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model {
        
    protected $fillable=['product_id','color1','color2','color3','color4','color5'];
    
    
    public function colorProduct(){
                return $this->belongsTo('App\PiplModules\product\Models\ProductDescription', 'product_id', 'product_id');

    }
}
