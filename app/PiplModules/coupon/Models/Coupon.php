<?php

namespace App\PiplModules\coupon\Models;

use Illuminate\Database\Eloquent\Model;
use App\PiplModules\coupon\Models\CouponUser;
use App\PiplModules\coupon\Models\AppliedCoupon;

class Coupon extends Model {

     protected $fillable = ['name','user_type','code_type','coupon_code','coupon_valid_from','image','coupon_valid_to','quantity','percentage','amount','min_purchase_amt','status','image','description'];

    public function couponUser()
    {
        return $this->hasmany('App\PiplModules\coupon\Models\CouponUser','coupon_id','id');
    }
    public function validateCouponDate($id,$current_date){

        $res = Coupon::where('id',$id)->whereDate('coupon_valid_from','<=',$current_date)->whereDate('coupon_valid_to','>=',$current_date)->first();
        if(isset($res) && count($res)>0){
            return "1";
        }
        else{
            return "0";
        }
    }
    public function validateCouponUserType($code,$user_type){
        $res = Coupon::where('coupon_code',$code)->where('user_type',$user_type)->first();
        if(isset($res) && count($res)>0){
            return "1";
        }
        else{
            return "0";
        }
    }
    public function chkCouponUsedStatus($id,$user_id){
        $res = AppliedCoupon::where('coupon_id',$id)->where('user_id',$user_id)->first();
        if(isset($res) && count($res)>0){
            return "1";
        }
        else{
            return "0";
        }

    }
}
