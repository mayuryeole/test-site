<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOccasion extends Model {
        
    protected $fillable=['product_id','occasion_id'];
    
    
    public function occasion() 
            {
       return $this->hasOne('App\PiplModules\product\Models\Occasion','id','occasion_id'); 
    }
 
    public function productOccasionDetail() 
            {
       return $this->belongsTo('App\PiplModules\product\Models\ProductDescription','product_id','product_id'); 
    }
 
}
