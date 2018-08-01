<?php
namespace App\PiplModules\newsletter\Models;

use Illuminate\Database\Eloquent\Model;


class Newsletter extends Model 
{
	protected $fillable = array('subject','content','status');
}