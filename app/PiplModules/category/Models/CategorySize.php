<?php
namespace App\PiplModules\category\Models;

use Illuminate\Database\Eloquent\Model;
use App\PiplModules\product\Models\Product;


class CategorySize extends Model
{

//    use \Dimsav\Translatable\Translatable;

    protected $fillable = ['name','category_id'];

    /**
     * Get child albums owned by a given Album.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function category()
    {
        return $this->belongsTo('App\PiplModules\category\Models\category');
    }


}