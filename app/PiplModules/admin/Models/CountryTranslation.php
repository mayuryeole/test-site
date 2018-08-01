<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent ;

class CountryTranslation extends Eloquent
{

    protected $fillable = array('name');

    public function usercountry(){
        return $this->belongsTo('App\UserAddress','user_country','country_id');
    }

}