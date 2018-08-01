<?php
namespace App\PiplModules\category\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model 
{

	protected $fillable = ['name','description','about_category','image','category_id','discount_valid_from'];
	 public function categoryName()
    {
        return $this->hasOne('App\PiplModules\category\Models\Category','id','category_id');
    }
}