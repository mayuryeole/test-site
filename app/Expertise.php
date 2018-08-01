<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    
    protected $fillable = ['user_id','category_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function user()
    {
            return $this->belongsTo('App\User');
    }
    
    
    public function category()
    {
            return $this->belongsTo('App\PiplModules\category\Models\Category','category_id');
    }
    public function categoryName()
    {
            return $this->hasOne('App\PiplModules\category\Models\CategoryTranslation','category_id','category_id');
    }
    //19 Feb 2018
    public function userInfo()
    
            {
            return $this->belongsTo('App\UserInformation','user_id','user_id');
    }
    
	
}

