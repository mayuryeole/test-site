<?php
namespace App\PiplModules\rivaah\Models;

use Illuminate\Database\Eloquent\Model;

class RivaahGalleryImage extends Model {

    protected $fillable = ['image','rivaah_gallery_id'];

    public function category() {
        return $this->hasOne('App\PiplModules\category\Models\Category');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}