<?php
namespace App\PiplModules\rivaah\Models;

use Illuminate\Database\Eloquent\Model;

class RivaahGallery extends Model {
    
    protected $fillable = ['name','category_id','image','description'];

    public function category() {
        return $this->hasOne('App\PiplModules\category\Models\Category');
    }
    
    public function user() {
       return $this->belongsTo('App\User', 'user_id', 'id');
   }
    public function categoryTans() {
        return $this->hasOne('App\PiplModules\category\Models\CategoryTranslation', 'category_id', 'category_id');
    }



}