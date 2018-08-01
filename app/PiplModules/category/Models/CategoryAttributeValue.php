<?php
namespace App\PiplModules\category\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttributeValue extends Model {
    protected $fillable = ['category_attribute_id','value'];

    public function category(){
        return $this->belongsTo('App\PiplModules\category\Models\CategoryAttributes','category_attribute_id');
    }

}
