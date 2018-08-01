<?php

namespace App\PiplModules\cart\Models;

use Illuminate\Database\Eloquent\Model;

class OrderVendor extends Model {

    protected $fillable = [];
    
    public function order() {
        return $this->hasOne('App\PiplModules\cart\Models\Order', 'id', 'order_id');
    }
    
    public function orderItems() {
        return $this->hasMany('App\PiplModules\cart\Models\OrderItems','order_vendor_id','id');
    }
    
    public function orderCoupon() {
        return $this->hasMany('App\PiplModules\cart\Models\OrderCoupon','order_vendor_id','id');
    }

     public function vendorName($id) {
        $vendor_name=  \App\PiplModules\admin\Models\Vendor::find($id);
        $vendor_name=$vendor_name->store_name;
        return $vendor_name;
    }
    
    public function discount($id)
    {
        $coupons= OrderCoupon::where('order_vendor_id',$id)->get();
        $total_discount=0;
        if(count($coupons)>0)
        {
            foreach($coupons as $coupon)
            {
                $total_discount += $coupon->deduct_amount;
            }
        }
        
        return $total_discount;
    }
}
