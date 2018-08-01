<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    
    protected $fillable = ['profile_picture','gender','activation_code','facebook_id','twitter_id','google_id','linkedin_id','pintrest_id','user_birth_date','first_name','last_name','about_me','user_phone','user_mobile','user_status','user_type','user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['facebook_id','twitter_id','google_id','linkedin_id'];
    public function user()
    {
            return $this->belongsTo('App\User');
    }	
    
    public function addressUser()
    {
            return $this->hasOne('App\UserAddress','user_id','user_id');
    }
}
