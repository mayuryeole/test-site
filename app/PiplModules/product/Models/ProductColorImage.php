<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColorImage extends Model {

    protected $fillable = ['product_id','product_image_id','image'];

}