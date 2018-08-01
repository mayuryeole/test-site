<?php

namespace App\PiplModules\gallery\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryRatings extends Model {
    protected $table = "gallery_ratings";
    protected $fillable = ['created_by', 'rating', 'comment', 'gallery_id'];

    public function getUserRating() {
        return $this->belongsTo('App\User', 'created_by');
    }
    
    public function getGallery() {
        return $this->belongsTo('App\PiplModules\gallery\Models\Gallery','gallery_id');
    }
}
