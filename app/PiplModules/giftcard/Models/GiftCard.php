<?php

namespace App\PiplModules\giftcard\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model {

    protected $fillable = ['image','description','price','name','code'];

}
