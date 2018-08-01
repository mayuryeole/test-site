<?php
namespace App\PiplModules\story\Models;

use Illuminate\Database\Eloquent\Model;

class StoryComment extends Model 
{
	
	protected $fillable = array('commented_by','comment','comment_attachments','story_id');
	
	protected $casts = array(
        'comment_attachments' => 'array',
    );
	
	public function commentUser()
	{
		return $this->belongsTo('App\User','commented_by');
	}
		
}