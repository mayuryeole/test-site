<?php

namespace App\PiplModules\coupon\Models;

use Illuminate\Database\Eloquent\Model;

class AppliedCoupon extends Model {

    protected $fillable = ['coupon_id','product_id','order_id','user_id','coupon_user_date'];

    public function user()
    {
        return $this->belongsToMany('App\User','user_id','user_id');
    }

    public function coupon()
    {
        return $this->belongsTo('App\PiplModules\coupon\Models\Coupon','coupon_id');
    }
}
