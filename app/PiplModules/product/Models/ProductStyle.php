<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStyle extends Model {
        
    protected $fillable=['product_id','style_id'];
    
    public function style() 
            {
        return $this->hasOne('App\PiplModules\product\Models\Style','id','style_id');
    }

    
}
