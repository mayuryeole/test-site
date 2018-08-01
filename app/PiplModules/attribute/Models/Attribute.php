<?php
namespace App\PiplModules\attribute\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model 
{
 use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['name'];

    public function categoryAttribute()
            {
        return $this->belongsTo('App\PiplModules\category\Models\CategoryAttributes','attribute_id','id');
    }
    
    public function trans()
           
            {
        return $this->hasOne('App\PiplModules\attribute\Models\AttributeTranslation','attribute_id','id');
    }
}