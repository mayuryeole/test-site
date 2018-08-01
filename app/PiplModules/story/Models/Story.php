<?php

namespace App\PiplModules\story\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Story extends Model {

    use \Dimsav\Translatable\Translatable;

    protected $fillable = ['created_by', 'story_category_id', 'title', 'short_description', 'description', 'story_url', 'story_image', 'story_attachments', 'allow_comments', 'seo_description', 'seo_title', 'seo_keywords', 'allow_attachments_in_comments', 'story_status'];
    public $translatedAttributes = ['short_description', 'description', 'title', 'seo_description', 'seo_title', 'seo_keywords'];
    protected $casts = [
        'story_attachments' => 'array',
    ];

    public function category() {
        return $this->hasOne('App\PiplModules\story\Models\StoryCategory', 'id', 'story_category_id');
    }

    public function comments() {
        return $this->hasMany('App\PiplModules\story\Models\StoryComment', 'story_id', 'id');
    }

    public function trans() {
        return $this->belongsTo('App\PiplModules\story\Models\StoryTranslation', 'story_id', 'id');
    }

}
