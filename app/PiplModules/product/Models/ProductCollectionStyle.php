<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCollectionStyle extends Model {
        
    protected $fillable=['product_id','collection_style_id'];
    
    
    public function productCollectionStyle() 
            {
       return $this->hasOne('App\PiplModules\product\Models\CollectionStyle','id','collection_style_id'); 
    }
    
    public function collectionStyleProduct() 
            {
       return $this->belongsTo('App\PiplModules\product\Models\productDescription','product_id','product_id'); 
    }
    
}
