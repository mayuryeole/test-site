<?php
namespace App\PiplModules\rivaah\Models;

use Illuminate\Database\Eloquent\Model;

class RivaahProduct extends Model {

    protected $fillable = ['rivaah_id','product_id'];

    public function category() {
        return $this->hasOne('App\PiplModules\category\Models\Category');
    }
    public function categoryTans() {
        return $this->hasOne('App\PiplModules\category\Models\CategoryTranslation', 'category_id', 'category_id');
    }
    public function userProduct() {
        return $this->belongsTo('App\PiplModules\product\Models\Product','product_id');
    }

    public function getRivaahImages() {
        return $this->hasMany('App\PiplModules\rivaah\Models\RivaahGalleryImage','rivaah_gallery_id','rivaah_id');
    }

}