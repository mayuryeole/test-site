<?php

namespace App\PiplModules\product\Models;

use App\PiplModules\category\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model
{

    protected $fillable = ['name', 'category_id'];

    public function productDescription()
    {
        return $this->hasOne('App\PiplModules\product\Models\ProductDescription', 'product_id');
    }

    public function getCollectionStyle()
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductCollectionStyle');
    }

    public function getOccasion()
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductOccasion');
    }

    public function getProductAttribute()
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductAttribute');
    }

    public function getStyle()
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductStyle');
    }


    public function getRivaah()
    {
        return $this->hasMany('App\PiplModules\rivaah\Models\RivaahProduct');
    }


    public function scopeFilterGetRivaah($query)
    {
        $getName = '18';
        return $query->whereHas('getRivaah', function ($q) use ($getName) {
            $q->where('rivaah_id', $getName);
        });
    }


    public function getColor()
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductColor');
    }

    public function productImages()
    {
        return $this->hasMany('App\PiplModules\product\Models\ProductImage');
    }

    public function category()
    {
        return $this->belongsTo('App\PiplModules\category\Models\Category');
    }


    public function transCat()
    {
        return $this->belongsTo('App\PiplModules\category\Models\Category', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function scopeSearch(Builder $query, $key = array(), $value = '', $locale = null)
    {

        return $query->whereHas('translations', function (Builder $query) use ($key, $value, $locale) {

            foreach ($key as $num => $keyword) {
                if ($num < 1) {
                    $query->where($this->getTranslationsTable() . '.' . $keyword, 'LIKE', $value);
                } else {
                    $query->orWhere($this->getTranslationsTable() . '.' . $keyword, 'LIKE', $value);
                }
            }

            if ($locale) {
                $query->where($this->getTranslationsTable() . '.' . $this->getLocaleKey(), 'LIKE', $locale);
            }
        })->orWhereHas('tags', function (Builder $query) use ($key, $value, $locale) {

            $query->where('tags.name', 'LIKE', $value);
        });
    }

    public function scopeFilterProductName($query)
    {
        $getName = '';
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $getName = $_GET['name'];
            return $query->where('name', 'LIKE', '%' . $getName . '%'); //->orWhere('text', 'LIKE', '%'.$getName.'%');
        }
    }

    public function scopeFilterByCategory($query)
    {
        $arrOfCat = array();
        if (isset($_GET['category']) && $_GET['category'] != "")
        {
            $min = $_GET['category'];
            $cat = \App\PiplModules\category\Models\Category::where('id', $min)->first();
            if (isset($cat) && count($cat) > 0) {
                $allChilds = \App\PiplModules\category\Models\Category::where('parent_id', $cat->id)->get();
                if (isset($allChilds) && count($allChilds) > 0) {
                    foreach ($allChilds as $child) {
                        if ($child->parent_id != 0) {
                            $arrOfCat[] = intval($child->id);
                            $allGrandChilds = \App\PiplModules\category\Models\Category::where('parent_id', $child->id)->get();
                            if (isset($allGrandChilds) && count($allGrandChilds) > 0) {
                                foreach ($allGrandChilds as $gChild) {
                                    $arrOfCat[] = intval($gChild->id);
                                }
                            }
                        } else {
                            $arrOfCat[] = intval($child->id);
                        }
                    }
                }
                $arrOfCat[] = intval($min);
            }
//                $arr = implode(",",array_values($arrOfCat));
//                    dd($arrOfCat);
//              $result = $query->whereHas('category', function($q) use ($arrOfCat) {
            $result = $query->whereIn('category_id', $arrOfCat);
            return $result;
        }
    }

    public function scopeFilterProductByInStock($query)
    {
//        dd($_GET['stock']);

        if (isset($_GET['stock']) && $_GET['stock'] != "") {
            $min = $_GET['stock'];
            return $query->whereHas('productDescription', function ($q) use ($min) {
                $q->where('availability', $min);
            });
        }
    }
    public function scopeFilterProductByAvailability($query)
    {
        $getName = '';
            return $query->whereHas('productDescription', function ($q) use ($getName) {
                $q->where('availability', 0);
            });
    }
    public function scopeFilterProductByAttribute($query)
    {
//        dd($_GET['stock']);
        if (isset($_GET['brand']) && $_GET['brand'] != "") {
            $min = $_GET['brand'];
            return $query->whereHas('getProductAttribute', function ($q) use ($min) {
                $q->where('attribute_id', 19)->where('value', $min);
            });
        }
    }


    public function scopeFilterProductRange($query)
    {
        if (isset($_GET['min']) && isset($_GET['max']) && $_GET['min'] != "" && $_GET['max'] != "") {
            $min = $_GET['min'];
            $max = $_GET['max'];
            return $query->whereHas('productDescription', function ($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            });
        }
    }

    public function scopeFilterProductCollectionStyle($query)
    {
        $getName = array();
        if (isset($_GET['collection_style']) && count($_GET['collection_style']) > 0) {
            $getName = $_GET['collection_style'];
            return $query->whereHas('getCollectionStyle', function ($q) use ($getName) {

                $q->whereIn('collection_style_id', $getName);
            });
        }
    }

    public function scopeFilterProductOccasion($query)
    {
        $getName = array();
        if (isset($_GET['occasion']) && count($_GET['occasion']) > 0) {
            $getName = $_GET['occasion'];
            return $query->whereHas('getOccasion', function ($q) use ($getName) {

                $q->whereIn('occasion_id', $getName);
            });
        }
    }

    public function scopeFilterProductStyle($query)
    {
        $getName = array();
        if (isset($_GET['style']) && count($_GET['style']) > 0) {
            $getName = $_GET['style'];
            return $query->whereHas('getStyle', function ($q) use ($getName) {
                $q->whereIn('style_id', $getName);
            });
        }
    }

    public function scopeFilterProductColor($query)
    {
        $getName = array();
        if (isset($_GET['color']) && count($_GET['color']) > 0) {
            $getName = $_GET['color'];
            return $query->whereHas('getColor', function ($q) use ($getName) {
                $q->whereIn('color', $getName);
            });
        }
    }

    public function scopeFilterProductAverageRating($query)
    {
        $getName = '';
        if (isset($_GET['rating']) && !empty($_GET['rating'])) {
            $getName = $_GET['rating'];
            return $query->whereHas('getColor', function ($q) use ($getName) {
                $q->whereIn('color', $getName);
            });
        }
    }

    public function scopeFilterProductCategory($query)
    {
        $getName = '';
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $getName = $_GET['category'];
            // return $query->whereHas('productDescription', function($q) use ($getName) {
//                              return  $query->where('category_id', $getName)->where('name','LIKE', '%' .$getName->categoryName->name.'%');

            return $query->where('category_id', $getName);
        }
    }

    public function scopeFilterProductSortBy($query)
    {
        $getName = '';
        $userType = 0;
        $type = 0;
        if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
            $getName = $_GET['sort_by'];
//            dd($getName);
            if ($getName == 2) {
                // dd($getName);
                $sort = 'ASC';
                if (Auth::check()) {
                    $userType = Auth::user()->userInformation->user_type;
                    $type = $userType;

                    if ($userType == 3) {
                        return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                            $q->where('hide_product_price', '<>', 0)->where('hide_product_price', '<>', 2)->orderBy('price', $sort);
                        });
                    }
                    if ($userType == 4) {

                        return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                            $q->where('hide_product_price', '<>', 1)->where('hide_product_price', '<>', 2)->orderBy('price', $sort);
                        });
                    }
                    if ($userType == 1) {

                        return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                            $q->where('hide_product_price', '>=', 0)->orderBy('price', $sort);
                        });
                    }
                }
                return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                    $q->where('hide_product_price', '=', 3)->orderBy('price', $sort);
                });

            } else if ($getName == 1) {
                $sort = 'DESC';
                if (Auth::check()) {

                    $userType = Auth::user()->userInformation->user_type;
                    $type = $userType;
                    if ($userType == 3) {

                        return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                            $q->where('hide_product_price', '<>', 0)->where('hide_product_price', '<>', 2)->orderBy('price', $sort);
                        });
                    }
                    if ($userType == 4) {

                        return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                            $q->where('hide_product_price', '<>', 1)->where('hide_product_price', '<>', 2)->orderBy('price', $sort);
                        });
                    }
                    if ($userType == 1) {

                        return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                            $q->where('hide_product_price', '>=', 0)->orderBy('price', $sort);
                        });
                    }
                }

                return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                    $q->where('hide_product_price', '=', 3)->orderBy('price', $sort);
                });

                return $query->whereHas('productDescription', function ($q) use ($getName, $sort, $type) {
                    $q->where('hide_product_price', '=', 3)->orderBy('price', $sort);
                });
            }
        }
        return $query->orderBy('id', 'DESC');
    }


    public function scopeFilterProductFeatured($query)
    {
        $getName = '';
        $getName = 1;
        return $query->whereHas('productDescription', function ($q) use ($getName) {
            $q->orderBy('is_featured', 1);
        });
    }
    public function scopeFilterProductStatus($query)
    {
        $getName='';
        return $query->whereHas('productDescription', function ($q) use ($getName) {
            $q->where('status', 1);
        });
    }


    public function scopeFilterHideProduct($query)
    {
        $getName = '';
        if (!Auth::guest()) {
            $userType = Auth::user()->userInformation->user_type;
            $getName = $userType;
            if ($userType == 3) {
                return $query->whereHas('productDescription', function ($q) use ($getName) {
                    $q->where('hide_product', '<>', 0)->where('hide_product', '<>', 1);
                });
            }

            if ($userType == 4) {
                return $query->whereHas('productDescription', function ($q) use ($getName) {
                    $q->where('hide_product', '<>', 1)->where('hide_product', '<>', 2);;
                });
            }


            if ($userType == 1) {
                return $query->whereHas('productDescription', function ($q) use ($getName) {
                    $q->where('hide_product', '>=', 0);//->where('hide_product','<>', 2);;
                });
            }
        }
        return $query->whereHas('productDescription', function ($q) use ($getName) {
            $q->where('hide_product', '=', 3);//->where('hide_product',<>, 2);
        });

    }

    public function scopeFilterHideProductPrice($query)
    {
        $getName = '';
        if (Auth::guest()) {
            return $query->whereHas('productDescription', function ($q) use ($getName) {
                $q->where('hide_product_price',3);
            });
        }
    }


}