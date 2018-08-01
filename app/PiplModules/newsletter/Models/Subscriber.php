<?php
namespace App\PiplModules\newsletter\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model 
{
	protected $fillable = array('email');
}