<?php

namespace App\PiplModules\box\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model {

      protected $fillable = ['image','price', 'status', 'order_quantity'];

}
