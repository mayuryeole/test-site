<?php

namespace App\PiplModules\giftmanage\Models;

use Illuminate\Database\Eloquent\Model;

class GiftManage extends Model {

    protected $fillable = ['receiver_name', 'receiver_mobile_number', 'order_number', 'product_id', 'sender_name', 'user_id', 'order_id', 'gift_text', 'gift_audio', 'gift_video', 'gift_video_thumb'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function Product() {
        return $this->hasOne('App\PiplModules\product\Models\product', 'id', 'product_id');
    }

}
