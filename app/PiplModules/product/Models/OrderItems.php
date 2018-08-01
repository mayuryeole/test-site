<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model {
        
    protected $fillable=['product_id','order_id','product_name','product_quantity','product_price'];
    
    public function order() 
            
            {
        return $this->belongsTo('App\PiplModules\product\Models\Order','id','order_id');
    }
    public function product()

    {
        return $this->belongsTo('App\PiplModules\product\Models\Order','id','product_id');
    }

    
}
