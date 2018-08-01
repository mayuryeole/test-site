<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','iso_code'];
    protected $fillable = ['name'];

    public function state()
    {
        return $this->hasMany('App\PiplModules\admin\Models\State');
    }

    public function trans(){
        return $this->hasOne('App\PiplModules\admin\Models\CountryTranslation','country_id');
    }
}