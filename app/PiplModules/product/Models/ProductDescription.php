<?php

namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model {

    protected $fillable = ['product_id','category_id','created_by','sku','color', 'size', 'price', 'quantity','style','collection_style','occation','image','video','max_quantity','discount_price','discount_percent','discount_type','is_featured','status','availability','surrentcy','short_description','description','discount_valid_from','discount_valid_to'];

    public function product() {
        return $this->hasOne('App\PiplModules\product\Models\Product', 'id', 'product_id');
    }

    public function category() {
        return $this->hasOne('App\PiplModules\category\Models\CategoryTranslation', 'category_id', 'category_id');
    }
    
    public function productStyle() 
            {
        return $this->hasOne('App\PiplModules\product\Models\ProductStyle', 'product_id', 'product_id');
    }
    public function collectionStyle() 
            
            {
        return $this->hasOne('App\PiplModules\product\Models\ProductCollectionStyle', 'product_id', 'product_id');
    }
    
    public function productOccasion() 
            
            {
        return $this->hasOne('App\PiplModules\product\Models\ProductOccasion', 'product_id', 'product_id');
    }
    
    
    public function productColor(){
                return $this->hasOne('App\PiplModules\product\Models\ProductColor', 'product_id', 'product_id');

    }

        public function productImages() {
        return $this->hasMany('App\PiplModules\product\Models\ProductImage', 'product_id', 'product_id');
    }

    public function scopeFilterByTags($query) {
        $getname = '';
        if (isset($_GET['searchText']) && !empty($_GET['searchText'])) {
            $getname = $_GET['searchText'];
            return $query->where('tags', 'LIKE', '%' . $getname . '%');
        }
    }

    public function scopefilterByPrice($query) {
        $minPrice = '';
        $maxPrice = '';
        if(isset($_GET['minPrice']) && !empty($_GET['minPrice'])) {
            $minPrice = $_GET['minPrice'];
            $maxPrice = $_GET['maxPrice'];
            return $query->whereBetween('price', [$minPrice, $maxPrice]);
        }
    }
    
    public function scopefilterByColor($query) {
        $color = '';
        if(isset($_GET['color']) && !empty($_GET['color'])) {
            $color = $_GET['color'];
            return $query->where('color', $color);
        }
    }

    
}
