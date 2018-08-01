<?php
namespace App\PiplModules\attribute\Models;

use Illuminate\Database\Eloquent\Model as Eloquent ;

class AttributeTranslation extends Eloquent
{

    protected $fillable = array('name');
    
    public function attrName() {



           return $this->belongsTo('App\PiplModules\attribute\Models\ProductAttribute','attribute_id','attribute_id');
    }

}