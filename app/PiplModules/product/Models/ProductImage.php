<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {

    protected $fillable = ['product_id','color'];

    public function productColorImages()
    {
        return $this->hasmany('App\PiplModules\product\Models\ProductColorImage', 'product_image_id')->orderBy('id','ASC')->take(4);
    }
}