<?php
namespace App\PiplModules\category\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttributes extends Model {
    protected $fillable = ['category_id','attribute_id'];

    public function attribute(){
        return $this->hasOne('App\PiplModules\attribute\Models\Attribute','id','attribute_id');
    }
    public function category(){
        return $this->belongsTo('App\PiplModules\category\Models\Category','id','category_id');
    }

}
