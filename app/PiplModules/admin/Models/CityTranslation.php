<?php
namespace App\PiplModules\admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent ;

class CityTranslation extends Eloquent
{

    protected $fillable = ['name','iso_code'];

}