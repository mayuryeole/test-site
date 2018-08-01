<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGiftCard extends Model
{

    protected $fillable = ['user_id','gift_card_id','gift_card_code','price','remaining_price','apply_count'];

    public function user()

    {
        return $this->belongsTo('App\User','id','user_id');
    }
    public function giftCard()

    {
        return $this->belongsTo('App\PiplModules\giftcard\Models\GiftCard','id','gift_card_id');
    }

}
