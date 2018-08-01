<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
        
    protected $fillable=['customer_id','payment_status','first_name','last_name','apartment','shipping_address1','shipping_address2','shipping_state','shipping_city','order_status'];
    
    
    public function orderItems() 
            {
        return $this->hasMany('App\PiplModules\product\Models\OrderItems','order_id','id');
    }
}
