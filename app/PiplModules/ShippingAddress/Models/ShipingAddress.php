<?php

namespace App\PiplModules\ShippingAddress\Models;

use Illuminate\Database\Eloquent\Model;

class ShipingAddress extends Model {
    protected $fillable = ['order_id', 'user_id', 'full_name', 'mobile_no', 'pincode', 'address_line_1', 'address_line_2', 'landmark', 'state_name', 'city_name'];
}
