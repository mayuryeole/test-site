<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model 
{
	 use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','iso_code'];
    public $timestamps = true;
    protected $fillable = ['name','country_id'];
	
    public function city()
	{
		return $this->hasMany('App\PiplModules\admin\Models\City');
	}
	public function country()
	{
		return $this->belongsTo('App\PiplModules\admin\Models\Country');
	}
    public function trans(){
        return $this->hasOne('App\PiplModules\admin\Models\StateTranslation','state_id');
    }

}