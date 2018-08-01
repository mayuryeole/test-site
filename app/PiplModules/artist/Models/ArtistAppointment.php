<?php
namespace App\PiplModules\artist\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ArtistAppointment extends Model
{
    protected $fillable = ['artist_id','first_name','last_name','description','email','mobile','country'];

    public function getArtist(){
        return $this->belongsTo('App\PiplModules\artist\Models\Artist','artist_id');
    }


}