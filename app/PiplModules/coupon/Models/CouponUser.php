<?php

namespace App\PiplModules\coupon\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model {

    protected $fillable = ['coupon_id','user_id'];

    public function userInfo()
    {
        return $this->belongsToMany('App\UserInformation','user_id','user_id');
    }

    public function coupon()
    {
        return $this->belongsTo('App\PiplModules\coupon\Models\Coupon','coupon_id');
    }
}
