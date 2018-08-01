<?php
namespace App\PiplModules\category\Models;

use Illuminate\Database\Eloquent\Model;
use App\PiplModules\product\Models\Product;
use Kalnoy\Nestedset\NodeTrait;


class Category extends Model 
{

	use \Dimsav\Translatable\Translatable;
	use NodeTrait;
	
	public $translatedAttributes = ['name','description','category_id','about_category','image','discount_valid_from'];
    
	protected $fillable = ['parent_id','lft','rgt'];
        
    /**
     * Get child albums owned by a given Album.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\PiplModules\product\Models\Product');
    }


     public function trans()
    {
        return $this->hasMany('App\PiplModules\category\Models\CategoryTranslation');
    }
    public function categorySize()
    {
        return $this->hasMany('App\PiplModules\category\Models\CategorySize');
    }
    public function categoryAttribute()
    {
        return $this->hasMany('App\PiplModules\category\Models\CategoryAttributes');
    }

	
}