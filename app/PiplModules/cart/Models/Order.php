<?php

namespace App\PiplModules\cart\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = ['customer_id','shipping_name','cart_id','email','shipping_country', 'admin_discount', 'shipping_address1', 'shipping_address2', 'shipping_city', 'shipping_state', 'shipping_country','shipping_iso2','shipping_telephone' ,'shipping_zip', 'billing_name','billing_address1', 'billing_address2', 'billing_city', 'billing_state', 'billing_zip', 'billing_country','billing_telephone', 'order_unique_id', 'paymnet_transaction_id', 'order_status','billing_iso2'];

    public function shippingCity() {
        return $this->hasOne('App\PiplModules\admin\Models\City', 'id', 'shipping_city');
    }
    public function user() {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }

    public function shippingState() {
        return $this->hasOne('App\PiplModules\admin\Models\State', 'id', 'shipping_state');
    }
    
    public function billingCity() {
        return $this->hasOne('App\PiplModules\admin\Models\City', 'id', 'billing_city');
    }

    public function billingState() {
        return $this->hasOne('App\PiplModules\admin\Models\State', 'id', 'billing_state');
    }
    
   public function orderVendor() {
        return $this->hasMany('App\PiplModules\cart\Models\OrderVendor','order_id','id');
    }
    
    public function orderCoupon() {
        return $this->hasMany('App\PiplModules\cart\Models\OrderCoupon','order_vendor_id','id');
    }
    public function orderItems()
    {
        return $this->hasMany('App\PiplModules\cart\Models\OrderItem','order_id','id');
    }
    
   
}
