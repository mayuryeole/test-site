<?php
namespace App\PiplModules\admin\Models;
use Illuminate\Database\Eloquent\Model;

class City extends Model 
{
	use \Dimsav\Translatable\Translatable;

        public $translatedAttributes = ['name','iso_code'];
        protected $fillable = ['name','state_id','country_id'];
	
	public function state()
	{
		return $this->belongsTo('App\PiplModules\admin\Models\State','state_id');
	}
        public function country()
	{
		return $this->belongsTo('App\PiplModules\admin\Models\Country','country_id');
	}
    public function trans(){
        return $this->hasOne('App\PiplModules\admin\Models\CityTranslation','city_id');
    }

}