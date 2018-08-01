<?php
namespace App\PiplModules\story\Models;

use Illuminate\Database\Eloquent\Model;

class StoryTranslation extends Model 
{

	protected $fillable = ['title','short_description','description','story_image'];
        
        public function post(){
            return $this->hasOne('App\PiplModules\story\Models\Story','id','story_id');
        }
	
}