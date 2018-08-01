<?php

namespace App\PiplModules\gallery\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryMedia extends Model {

//    protected $table = 'gallery_medias';
    protected $fillable = ['gallery_id', 'content_type', 'path', 'created_by'];

    public function getUser() {
        return $this->belongsTo('App\User', 'created_by');
    }

     public function getTranslation() {
        return $this->belongsTo('App\PiplModules\gallery\Models\Gallery','gallery_id');
    }
    
}

?>