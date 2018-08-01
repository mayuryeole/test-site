<?php

namespace App\PiplModules\product\Controllers;

use App\PiplModules\cart\Models\CartItem;
use App\PiplModules\product\Models\Color;
use App\PiplModules\cart\Models\Cart;
use Auth;
use App\UserInformation;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Pagination\Paginator;
use Storage;
use App\PiplModules\product\Models\Product;
use App\PiplModules\product\Models\ProductImage;
use App\PiplModules\product\Models\ProductDescription;
use App\PiplModules\product\Models\ProductTag;
use App\PiplModules\category\Models\Category;
use App\User;
use Mail;
use Illuminate\Filesystem\Filesystem;
use Datatables;
use Image;
use App\PiplModules\attribute\Models\Attribute;
use App\PiplModules\project\Models\Project;
use App\PiplModules\category\Models\CategoryAttributes;
use App\PiplModules\product\Models\ProductAttribute;
use App\PiplModules\attribute\Models\AttributeTranslation;
use App\PiplModules\category\Models\CategoryTranslation;
use App\PiplModules\product\Models\Style;
use App\PiplModules\product\Models\CollectionStyle;
use App\PiplModules\product\Models\ProductCollectionStyle;
use App\PiplModules\product\Models\ProductStyle;
use App\PiplModules\product\Models\Occasion;
use App\PiplModules\product\Models\ProductOccasion;
use App\PiplModules\product\Models\ProductColor;
use App\PiplModules\category\Models\CategorySize;
use App\PiplModules\cart\Controllers\CartController;
use App\Helpers\Helper;




class ProductSearchController extends Controller {

    public function getAjaxProducts($all_products)
    {
        $ajaxProduct  = array();
        if(isset($all_products) && count($all_products)>0)
        {
            foreach($all_products as $key=>$pro)
            {
                $ajaxProduct[$key]['id'] = $pro->id;
                $ajaxProduct[$key]['name'] = $pro->name;
                $ajaxProduct[$key]['long_description'] = "";
                $ajaxProduct[$key]['pro_color'] =$pro->productDescription['color'];
                if(strlen($ajaxProduct[$key]['long_description'])>100)
                {
                    $ajaxProduct[$key]['long_description'] = substr($pro->productDescription['description'],0,100)."...";
                }else{
                    $ajaxProduct[$key]['long_description'] = $pro->productDescription['description'];
                }

                $ajaxProduct[$key]['image'] = $pro->productDescription['image'];
                if($pro->productDescription['is_featured'] == 1)
                {
                    $ajaxProduct[$key]['featured'] = '<span class="featured-product">Featured</span>';
                }else{
                    $ajaxProduct[$key]['featured'] = " ";
                }

                if( \Auth::check())
                {
                    if (isset($pro->productDescription['hide_product_price']) && ($pro->productDescription['hide_product_price'] == "0" || $pro->productDescription['hide_product_price'] == "2") && Auth::user()->userInformation->user_type == "3"){
                        $ajaxProduct[$key]['is_original'] = 2;
                    }
                    elseif(($pro->productDescription['hide_product_price']) && ($pro->productDescription['hide_product_price']=="1" || $pro->productDescription['hide_product_price'] == "2") && Auth::user()->userInformation->user_type == "4")
                    {
                        $ajaxProduct[$key]['is_original'] = 2;
                    }
                    else {
                        if(isset($pro->productDescription['discount_valid_from'])&& strtotime($pro->productDescription['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                        {
//                            number_format((float)$foo, 2, '.', '');
                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                            $ajaxProduct[$key]['is_original'] = 1;
                            $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
                        }
                        elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                        {

                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                            $ajaxProduct[$key]['is_original'] = 1;
                            $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
                        }
                        else
                        {
                            if(isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id']!=0)
                            {
                                $grandParent =Category::find($pro->transCat->trans[0]['parent_id']);
                                if(isset($grandParent) && count($grandParent)>0){
                                    if(isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                    {
                                        $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                        $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                        $ajaxProduct[$key]['is_original'] = 1;
                                        $ajaxProduct[$key]['discount_percent'] = $grandParent->trans[0]['discount_percent'].'% off';
                                    }
                                    elseif(isset($grandParent->parent_id) && $grandParent->parent_id !=0)
                                    {
                                        $grandGrandParent = Category::find($grandParent->parent_id);
                                        if(isset($grandGrandParent) && count($grandGrandParent)>0){
                                            if(isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                            {
                                                $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                                $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                                $ajaxProduct[$key]['is_original'] = 1;
                                                $ajaxProduct[$key]['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'].'% off';
                                            }
                                            else{
                                                $ajaxProduct[$key]['is_original'] = 0;
                                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                            }
                                        }
                                        else{
                                            $ajaxProduct[$key]['is_original'] = 0;
                                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                        }
                                    }
                                    else{
                                        $ajaxProduct[$key]['is_original'] = 0;
                                        $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                    }
                                }
                                else{
                                    $ajaxProduct[$key]['is_original'] = 0;
                                    $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                }

                            }
                            else{
                                $ajaxProduct[$key]['is_original'] = 0;
                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                            }
                        }
                    }
                }
                elseif(Auth::guest())
                {
                    if(isset($pro->productDescription['hide_product_price']) && ($pro->productDescription['hide_product_price'] == "3"))
                    {
                        if(isset($pro->productDescription['discount_valid_from'])&& strtotime($pro->productDescription['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                        {
                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                            $ajaxProduct[$key]['is_original'] = 1;
                            $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
                        }
                        elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                        {

                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                            $ajaxProduct[$key]['is_original'] = 1;
                            $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
                        }
                        else
                        {
                            if(isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id']!=0)
                            {
                                $grandParent =Category::find($pro->transCat->trans[0]['parent_id']);
                                if(isset($grandParent) && count($grandParent)>0){
                                    if(isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                    {
                                        $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                        $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                        $ajaxProduct[$key]['is_original'] = 1;
                                        $ajaxProduct[$key]['discount_percent'] = $grandParent->trans[0]['discount_percent'].'% off';
                                    }
                                    elseif(isset($grandParent->parent_id) && $grandParent->parent_id !=0)
                                    {
                                        $grandGrandParent = Category::find($grandParent->parent_id);
                                        if(isset($grandGrandParent) && count($grandGrandParent)>0){
                                            if(isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                            {
                                                $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                                $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                                $ajaxProduct[$key]['is_original'] = 1;
                                                $ajaxProduct[$key]['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'].'% off';
                                            }
                                            else{
                                                $ajaxProduct[$key]['is_original'] = 0;
                                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                            }
                                        }
                                        else{
                                            $ajaxProduct[$key]['is_original'] = 0;
                                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                        }
                                    }
                                    else{
                                        $ajaxProduct[$key]['is_original'] = 0;
                                        $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                    }
                                }
                                else{
                                    $ajaxProduct[$key]['is_original'] = 0;
                                    $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                }

                            }
                            else{
                                $ajaxProduct[$key]['is_original'] = 0;
                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                            }
                        }
                    }
                    else
                    {
                        $ajaxProduct[$key]['is_original'] = 2;
                    }
                }

            }
        }
        return $ajaxProduct;
    }



    public function getAjaxProductsQuickView($pro)
    {
        $ajaxProduct  = array();
        if(isset($pro) && count($pro)>0)
        {
            $key = 0;
            $ajaxProduct[$key]['id'] = $pro->id;
            $ajaxProduct[$key]['name'] = $pro->name;
            $ajaxProduct[$key]['long_description'] = $pro->productDescription['description'];
            $ajaxProduct[$key]['availability'] = $pro->productDescription['availability'];
            $ajaxProduct[$key]['max_order_qty'] = $pro->productDescription['max_order_qty'];
            $ajaxProduct[$key]['quantity'] = $pro->productDescription['quantity'];
            $ajaxProduct[$key]['product_color'] = $pro->productDescription['color'];

            $colors = $pro->getColor;
            if(isset($colors) && count($colors)>0)
            {
                $ajaxProduct[$key]['colors'] =  $colors;
            }
            //dd($colors);
            $images = $pro->productImages;
//            dd($images);
            if(isset($images) && count($images)>0)
            {
                $ajaxProduct[$key]['product_images'] =  $images;
                $cnt = 0;
                $cnt1 = 0;
                    foreach ($images as $colrImg)
                    {

                        if(!empty($colrImg->productColorImages))
                            {
                              if(isset($colrImg->productColorImages) && count($colrImg->productColorImages)>0)
                              {
                                foreach ($colrImg->productColorImages as $proColrImg)
                                {
                                    $ajaxProduct[$key]['product_color_images'][$cnt][$cnt1] =  $proColrImg;
                                    $cnt1++;
                                }
                             }
                           }
                        $cnt++;
                    }

            }
            $ProductAttribute = $pro->getProductAttribute;
            //dd($ProductAttribute);
            if(isset($ProductAttribute) && count($ProductAttribute)>0)
            {
                $cnt = 0;
                $ajaxProduct[$key]['attribute'] =  $ProductAttribute;
                foreach ($ProductAttribute as $value) {
                    if(!empty($value['value']) && !empty($value->getAttr->trans->name)){
                        $ajaxProduct['attribute_name'][$cnt]= $value->getAttr->trans->name;
                        $ajaxProduct['attribute_value'][$cnt] = trim($value['value']);
                        $cnt++;
                    }
                }

            }
            $ajaxProduct[$key]['image'] = $pro->productDescription['image'];

            if( \Auth::check())
            {
                if (isset($pro->productDescription['hide_product_price']) && ($pro->productDescription['hide_product_price'] == "0" || $pro->productDescription['hide_product_price'] == "2") && Auth::user()->userInformation->user_type == "3")
                {
                    $ajaxProduct[$key]['is_original'] = 2;
                } elseif (($pro->productDescription['hide_product_price']) && ($pro->productDescription['hide_product_price'] == "1" || $pro->productDescription['hide_product_price'] == "2") && Auth::user()->userInformation->user_type == "4")
                {
                    $ajaxProduct[$key]['is_original'] = 2;
                }
                else {
                    if(isset($pro->productDescription['discount_valid_from'])&& strtotime($pro->productDescription['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                    {
                        $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - ($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])/100),2,'.','');
                        $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                        $ajaxProduct[$key]['is_original'] = 1;
                        $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
                    }
                    elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                    {

                        $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                        $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                        $ajaxProduct[$key]['is_original'] = 1;
                        $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
                    }
                    else
                    {
                        if(isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id']!=0)
                        {
                            $grandParent =Category::find($pro->transCat->trans[0]['parent_id']);
                            if(isset($grandParent) && count($grandParent)>0){
                                if(isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                {
                                    $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                    $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                    $ajaxProduct[$key]['is_original'] = 1;
                                    $ajaxProduct[$key]['discount_percent'] = $grandParent->trans[0]['discount_percent'].'% off';
                                }
                                elseif(isset($grandParent->parent_id) && $grandParent->parent_id !=0)
                                {
                                    $grandGrandParent = Category::find($grandParent->parent_id);
                                    if(isset($grandGrandParent) && count($grandGrandParent)>0){
                                        if(isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                        {
                                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                            $ajaxProduct[$key]['is_original'] = 1;
                                            $ajaxProduct[$key]['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'].'% off';
                                        }
                                        else{
                                            $ajaxProduct[$key]['is_original'] = 0;
                                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                        }
                                    }
                                    else{
                                        $ajaxProduct[$key]['is_original'] = 0;
                                        $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                    }
                                }
                                else{
                                    $ajaxProduct[$key]['is_original'] = 0;
                                    $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                }
                            }
                            else{
                                $ajaxProduct[$key]['is_original'] = 0;
                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                            }

                        }
                        else{
                            $ajaxProduct[$key]['is_original'] = 0;
                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                        }
                    }
                }
            }
            elseif(Auth::guest())
            {
                if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "3"))
                {
                    if(isset($pro->productDescription->discount_valid_from)&& strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
                    {
                        $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - ($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])/100),2,'.','');
                        $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                        $ajaxProduct[$key]['is_original'] = 1;
                        $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
                    }
                    elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                    {

                        $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                        $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                        $ajaxProduct[$key]['is_original'] = 1;
                        $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
                    }
                    else
                    {
                        if(isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id']!=0)
                        {
                            $grandParent =Category::find($pro->transCat->trans[0]['parent_id']);
                            if(isset($grandParent) && count($grandParent)>0){
                                if(isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                {
                                    $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                    $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                    $ajaxProduct[$key]['is_original'] = 1;
                                    $ajaxProduct[$key]['discount_percent'] = $grandParent->trans[0]['discount_percent'].'% off';
                                }
                                elseif(isset($grandParent->parent_id) && $grandParent->parent_id !=0)
                                {
                                    $grandGrandParent = Category::find($grandParent->parent_id);
                                    if(isset($grandGrandParent) && count($grandGrandParent)>0){
                                        if(isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                        {
                                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','').'</del>';
                                            $ajaxProduct[$key]['is_original'] = 1;
                                            $ajaxProduct[$key]['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'].'% off';
                                        }
                                        else{
                                            $ajaxProduct[$key]['is_original'] = 0;
                                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                        }
                                    }
                                    else{
                                        $ajaxProduct[$key]['is_original'] = 0;
                                        $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                    }
                                }
                                else{
                                    $ajaxProduct[$key]['is_original'] = 0;
                                    $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                }
                            }
                            else{
                                $ajaxProduct[$key]['is_original'] = 0;
                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                            }

                        }
                        else{
                            $ajaxProduct[$key]['is_original'] = 0;
                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                        }
                    }
                }
                else{
                    $ajaxProduct[$key]['is_original'] = 2;
                }
            }
        }
        return $ajaxProduct;
    }
    public function searchProductFront(Request $request)
    {
        if(Auth::guest())
        {
            if(isset($_GET['sort_by']) && $_GET['sort_by']!="")
            {
              //  dd(24);

                $all_products = Product::FilterByCategory()->FilterProductByAttribute()->FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductFeatured()->FilterProductSortBy()->FilterProductStatus()->FilterHideProduct()->FilterHideProductPrice()->paginate(6);
//                $sorted = $all_products->sortBy(function ($product, $key) {
//                    return $product->productDescription->price;
//                });

            }
            else{
                //     dd(123);
                $all_products = Product::FilterByCategory()->FilterProductByAttribute()->FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductFeatured()->FilterProductStatus()->FilterHideProduct()->FilterHideProductPrice()->paginate(6);
            }

        }else{
            if(isset($_GET['sort_by']) && $_GET['sort_by']!="")
            {
                $all_products = Product::FilterByCategory()->FilterProductByAttribute()->FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductFeatured()->FilterProductSortBy()->FilterProductStatus()->FilterHideProduct()->paginate(6);
                $sorted = $all_products->sortBy(function ($product, $key) {
                    return $product->productDescription->price;
                });
            }
            else
            {
                $all_products = Product::FilterByCategory()->FilterProductByAttribute()->FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductFeatured()->FilterHideProduct()->FilterProductStatus()->paginate(6);
            }

        }
        for ($i=0;$i<count($all_products);$i++) {
            $pro = $all_products[$i];
            if( \Auth::check())
            {
                if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "0" || $pro->productDescription->hide_product_price == "2") && Auth::user()->userInformation->user_type == "3"){
                    $pro['is_original'] = 2;
                }
                elseif(($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price=="1" || $pro->productDescription->hide_product_price == "2") && Auth::user()->userInformation->user_type == "4")
                {
                    $pro['is_original'] = 2;
                }
                else
                {
                    if (isset($pro->productDescription->discount_valid_from) && strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s'))) {

                        $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100), 2,'.','');
                        $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']), 2,'.','') . '</del>';
                        $pro['is_original'] = 1;
                        $pro['discount_percent'] = $pro->productDescription['discount_percent'] . "% off";
                    } elseif (isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                    {
                        $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100),2,'.','');
                        $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','') . '</del>';
                        $pro['is_original'] = 1;
                        $pro['discount_percent'] = $pro->transCat->trans[0]['discount_percent'] . '% off';
                    } else {
                        if (isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id'] != 0) {
                            $grandParent = Category::find($pro->transCat->trans[0]['parent_id']);
                            if (isset($grandParent) && count($grandParent) > 0) {
                                if (isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                    $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100),2,'.','');
                                    $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','') . '</del>';
                                    $pro['is_original'] = 1;
                                    $pro['discount_percent'] = $grandParent->trans[0]['discount_percent'] . '% off';
                                } elseif (isset($grandParent->parent_id) && $grandParent->parent_id != 0) {
                                    $grandGrandParent = Category::find($grandParent->parent_id);
                                    if (isset($grandGrandParent) && count($grandGrandParent) > 0) {
                                        if (isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                            $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100),2,'.','');
                                            $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.',''). '</del>';
                                            $pro['is_original'] = 1;
                                            $pro['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'] . '% off';
                                        } else {
                                            $pro['is_original'] = 0;
                                            $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                        }
                                    } else {
                                        $pro['is_original'] = 0;
                                        $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                    }
                                } else {
                                    $pro['is_original'] = 0;
                                    $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                }
                            } else {
                                $pro['is_original'] = 0;
                                $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                            }

                        } else {
                            $pro['is_original'] = 0;
                            $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                        }
                    }

                }
            }
            elseif (\Auth::guest())
            {
                if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "3"))
                {
                    if (isset($pro->productDescription->discount_valid_from) && strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s'))) {

                        $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100), 2,'.','');
                        $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']), 2,'.','') . '</del>';
                        $pro['is_original'] = 1;
                        $pro['discount_percent'] = $pro->productDescription['discount_percent'] . "% off";
                    } elseif (isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                    {
                        $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100),2,'.','');
                        $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','') . '</del>';
                        $pro['is_original'] = 1;
                        $pro['discount_percent'] = $pro->transCat->trans[0]['discount_percent'] . '% off';
                    } else {
                        if (isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id'] != 0) {
                            $grandParent = Category::find($pro->transCat->trans[0]['parent_id']);
                            if (isset($grandParent) && count($grandParent) > 0) {
                                if (isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                    $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100),2,'.','');
                                    $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','') . '</del>';
                                    $pro['is_original'] = 1;
                                    $pro['discount_percent'] = $grandParent->trans[0]['discount_percent'] . '% off';
                                } elseif (isset($grandParent->parent_id) && $grandParent->parent_id != 0) {
                                    $grandGrandParent = Category::find($grandParent->parent_id);
                                    if (isset($grandGrandParent) && count($grandGrandParent) > 0) {
                                        if (isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                            $pro['discount_rate'] = Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])) / 100),2,'.','');
                                            $pro['price'] = '<del>' . Helper::getCurrencySymbol() . number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.',''). '</del>';
                                            $pro['is_original'] = 1;
                                            $pro['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'] . '% off';
                                        } else {
                                            $pro['is_original'] = 0;
                                            $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                        }
                                    } else {
                                        $pro['is_original'] = 0;
                                        $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                    }
                                } else {
                                    $pro['is_original'] = 0;
                                    $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                                }
                            } else {
                                $pro['is_original'] = 0;
                                $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                            }

                        } else {
                            $pro['is_original'] = 0;
                            $pro['price'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']),2,'.','');
                        }
                    }
                }
                else
                {
                    $pro['is_original'] = 2;
                }
            }

        }
        if($request->ajax())
        {
            $ajaxProduct  = array();
            $ajaxProduct  = $this->getAjaxProducts($all_products);
            echo json_encode(["all_products"=>$ajaxProduct,"msg"=>"hEyyyyyy"]);
            exit();
        }else{
            $all_collection = CollectionStyle::all();
            $all_style =   Style::all();
            $all_category= CategoryTranslation::all();
            $all_occasion = Occasion::all();
            $all_colors = Color::all();
            $browser_url = $request->fullUrl();

            $array_product_id=array();
            if(!Auth::guest()){
                $user_wishlist=Auth::user()->userWishlist;
                if(isset($user_wishlist) && count($user_wishlist)>0)
                {
                    $user_wishlist=Auth::user()->userWishlist;


                    if(isset($user_wishlist) && count($user_wishlist)>0)
                    {
                        foreach($user_wishlist as $wishlist)
                        {
                            array_push($array_product_id,$wishlist['product_id']);
                        }
                    }
                }
            }
            return view('search',array("all_products"=>$all_products,"browser_url"=>$browser_url,"all_occasion"=>$all_occasion,"all_collection"=>$all_collection,"all_style"=>$all_style,"all_category"=>$all_category,"user_wishlist"=>$array_product_id,'all_colors'=>$all_colors));
        }
    }


    public function getAjaxProductDetail(Request $request)
    {
        $cartItem = "";
        $product = Product::where('id',$request->product_id)->first();
        if(isset($product) && count($product)>0){
            if (Auth::check()) {

                $cart = Auth::user()->cart;
                if($cart == null){
                    $cart = new Cart();
                    $cart->customer_id =Auth::user()->id;
                    $cart->save();
                }
            }
            else {
                $cart = Cart::where('ip_address', $request->ip())->first();
                if($cart == null){
                    $cart = new Cart();
                    $cart->ip_address =$request->ip();
                    $cart->save();
                }
            }

            $cartItem =CartItem::where('cart_id',$cart->id)->where('product_id',$product->id)->first();
            if(!isset($cartItem) && count($cartItem)<0){
                $cartItem = "";
            }
        }
        $ajaxProduct  = array();
        $ajaxProduct  = $this->getAjaxProductsQuickView($product);
        $html = view('quick',compact('ajaxProduct','cartItem'));
        echo $html;
        exit();
    }
    public function getAjaxEditCartProductDetail(Request $request){
        $cartItem = "";
        $product = Product::where('id',$request->product_id)->first();
        if(isset($product) && count($product)>0){
            $cartItem =CartItem::where('product_id',$product->id)->first();
            if(!isset($cartItem) && count($cartItem)<0){
                $cartItem = "";
            }
        }
        $ajaxProduct  = array();
        $ajaxProduct  = $this->getAjaxProductsQuickView($product);
        $html = view('edit-cart',compact('ajaxProduct','cartItem'));
        echo $html;
        exit();
    }



    public function checkSlider()
    {
        return view('slider');
    }

    public function ajaxProductLoad(Request $request)
    {
        $all_products = Product::FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductCategory()->orderBy('id', 'DESC')->paginate(6);
    }

    public function getProductDetails(Request $request,$product_id)
    {
        // $all_products =   Product::findOrfail($product_id);
        $pro = Product::FilterHideProduct()->FilterProductStatus()->where('id',$product_id)->first();
        $cartItem = "";
        $catArr = array();
        if(isset($pro) && count($pro)>0)
        {
            if (Auth::check())
            {
                $cart = Auth::user()->cart;
                if($cart == null){
                    $cart = new Cart();
                    $cart->customer_id =Auth::user()->id;
                    $cart->save();
                }
            }
            else {
                $cart = Cart::where('ip_address', $request->ip())->first();
                if($cart == null)
                {
                    $cart = new Cart();
                    $cart->ip_address =$request->ip();
                    $cart->save();
                }
            }
            $cartObj = new CartController();
            $pro =$cartObj->getProductDiscountPrice($pro);
            $cartItem =CartItem::where('cart_id',$cart->id)->where('product_id',$pro->id)->first();
            if($cartItem == null){
                $cartItem = "";
            }
            $recCatArr = array();
            $recCatArr = $this->getRecommendedProducts($pro);
            $rec= Product::FilterHideProduct()->FilterProductStatus()->where("id",'!=',$product_id)->whereIn("category_id",$recCatArr)->get();
            if(isset($rec) && count($rec)>0)
            {

                foreach ($rec as $recprod)
                {
                    $recprod =$cartObj->getProductDiscountPrice($recprod);
                }
            }
            $catArr = $this->getAllParentCategories($pro->productDescription->category_id);
//            dd($catArr);
            $freq = null;
            $parent_cat_names = array();
            if(isset($catArr) && count($catArr)>0){
                $parent_cats = CategoryTranslation::whereIn('category_id',$catArr)->get();
//                if(isset($parent_cats) && count($parent_cats)>0)
//                {
//                    foreach ($parent_cats as $cats)
//                    {
//                        $parent_cat_names[] = $cats->name;
//                    }
//                }
                $freq = Product::FilterHideProduct()->FilterProductStatus()->where("id",'!=',$product_id)->whereIn('category_id',$catArr)->inRandomOrder()->limit(1)->get();
                if(isset($freq) && count($freq)>0)
                {
                    foreach ($freq as $freqProd)
                    {
                        $freqProd = $cartObj->getProductDiscountPrice($freqProd);
                    }

                }
                if(isset($freq) && count($freq)>0)
                {
                    $freq = $freq[0];
                }
            }
            $cartController = new CartController();
            $pro = $cartController->getProductDiscountPrice($pro);
            return view('product-details',compact('pro','rec','cartItem','cart','freq','parent_cats'));
        }
        else{
            return redirect('/');
        }

    }

    public function getAllParentCategories($catId)
    {
        $arrAllCat = array();
        $category = Category::find($catId);
        if(isset($category) && count($category)>0)
        {
            $arrAllCat[]=$category->id;
            if(isset($category->parent_id) && $category->parent_id !=0)
            {
                $getParentCat = Category::find($category->parent_id);
                if(isset($getParentCat) && count($getParentCat)>0)
                {
                    $arrAllCat[]=$getParentCat->id;
                    if(isset($getParentCat->parent_id) && $getParentCat->parent_id !=0)
                    {
                        $getGrandParentCat = Category::find($getParentCat->parent_id);
                        if(isset($getGrandParentCat) && count($getGrandParentCat)>0)
                        {
                            if(isset($getGrandParentCat->parent_id) && $getGrandParentCat->parent_id ==0)
                            {
                                $arrAllCat[]=$getGrandParentCat->id;
                            }
                        }
                    }
                    else
                    {
                        $arrAllCat[]=$getParentCat->id;
                    }
                }
            }
            return $arrAllCat;
        }
        return $arrAllCat;
    }

    public function getRecommendedProducts($pro)
    {
        $min = $pro->productDescription->category_id;
        $cat = Category::where('id', $min)->first();
        if (isset($cat) && count($cat) > 0) {
            $allChilds = Category::where('parent_id', $cat->id)->get();
            if (isset($allChilds) && count($allChilds) > 0)
            {
                foreach ($allChilds as $child)
                {
                    if ($child->parent_id != 0)
                    {
                        $arrOfCat[] = intval($child->id);
                        $allGrandChilds = Category::where('parent_id', $child->id)->get();
                        if (isset($allGrandChilds) && count($allGrandChilds) > 0)
                        {
                            foreach ($allGrandChilds as $gChild)
                            {
                                $arrOfCat[] = intval($gChild->id);
                            }
                        }
                    }
                    else
                    {
                        $arrOfCat[] = intval($child->id);
                    }
                }
            }
            $arrOfCat[] = intval($min);
        }
        return $arrOfCat;
    }
}

?>
