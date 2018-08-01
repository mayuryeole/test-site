<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model {
        
    protected $fillable=['name','image'];
    
    public function productStyle() 
            {
        return $this->belongsTo('App\PiplModules\product\Models\ProductStyle','style_id','id');
    }

    

}
