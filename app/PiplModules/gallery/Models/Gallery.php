<?php
namespace App\PiplModules\gallery\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model 
{

	use \Dimsav\Translatable\Translatable;
	
	public $translatedAttributes = ['name','description','seo_url'];
    
	protected $fillable = ['name','created_by'];
        
    /**
     * Get child albums owned by a given Album.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
        
    public function users() {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
    public function getFiles()
    {
        return $this->hasMany('App\PiplModules\gallery\Models\GalleryMedia');
    }
	
     public function getRatings()
    {
        return $this->hasMany('App\PiplModules\gallery\Models\GalleryRatings');
    }
      public function trans()
    {
        return $this->hasOne('App\PiplModules\gallery\Models\GalleryTranslation','gallery_id');
    }
}
