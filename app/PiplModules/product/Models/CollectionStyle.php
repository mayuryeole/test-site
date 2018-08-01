<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionStyle extends Model {
        
    protected $fillable=['name','image'];
    
    

    public function collectionStyle() 
            {
       return $this->belongsTo('App\PiplModules\product\Models\ProductCollectionStyle','product_collection_id','id'); 
    }
    
}
