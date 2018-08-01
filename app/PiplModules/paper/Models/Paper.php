<?php

namespace App\PiplModules\paper\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model {

    protected $fillable = ['image','price','status', 'order_quantity'];

}
