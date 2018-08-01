<?php
namespace App\PiplModules\story\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
class StoryCategory extends Model 
{

	use \Dimsav\Translatable\Translatable, NodeTrait;
	
	  public $useTranslationFallback = true;
	
	public $translatedAttributes = ['name'];
    
	protected $fillable = ['name','created_by','parent_id','slug'];
	
	public function parentCat()
	{
		return $this->belongsTo('App\PiplModules\story\Models\StoryCategory','parent_id','id');
	}
	public function posts()
	{
		return $this->hasMany('App\PiplModules\story\Models\Story','story_category_id');
	}
}