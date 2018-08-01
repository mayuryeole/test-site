<?php
namespace App\PiplModules\emailtemplate\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model 
{
	 protected $fillable = ['subject','html_content','template_key','template_keywords'];
	 protected $hidden = ['template_key'];	
}