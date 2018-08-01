<?php
namespace App\PiplModules\product\Models;

use Illuminate\Database\Eloquent\Model;

class Occasion extends Model {
        
    protected $fillable=['name'];
    
    
 public function productOccasion() 
            {
        return $this->belongsTo('App\PiplModules\product\Models\ProductOccasion','occasion_id','id');
    }
    
}
