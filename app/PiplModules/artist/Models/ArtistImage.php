<?php
namespace App\PiplModules\artist\Models;

use Illuminate\Database\Eloquent\Model;


class ArtistImage extends Model 
{
    protected $fillable = ['path','artist_id','media_type'];
    protected $table='artist_images';
    
}