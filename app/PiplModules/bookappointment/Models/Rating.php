<?php
namespace App\PiplModules\bookappointment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rating extends Model 
{

	
	protected $fillable = ['to_id','from_id','rating','appointment_id','review','status','created_at','updated_at'];
	
        public function ratingGivenBy() {
           return $this->hasOne('App\User','id','from_id'); 
        }
	
	
}