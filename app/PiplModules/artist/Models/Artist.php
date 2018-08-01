<?php
namespace App\PiplModules\artist\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Artist extends Model 
{
    protected $fillable = ['first_name','last_name','description','email','number','youtube_link','facebook_id','instagram_id','linkedin_id','twitter_id','profile_photo','services','country_flag','video'];
    
    
}