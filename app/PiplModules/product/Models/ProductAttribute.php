<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model {
        
    protected $fillable=['product_id','attribute_id'];
    
	public function getAttr() {
        return $this->belongsTo('App\PiplModules\attribute\Models\Attribute','attribute_id');
    }    

}
