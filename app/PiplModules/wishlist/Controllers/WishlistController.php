<?php

namespace App\PiplModules\wishlist\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\coupon\Models\Coupon;
use Mail;
use Image;
use Datatables;
use GlobalValues;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use App\User as MainUser;
use App\UserInformation;
use Illuminate\Routing\UrlGenerator;
use App\PiplModules\coupon\Models\CouponUser;
use App\PiplModules\wishlist\Models\Wishlist;
use App\PiplModules\product\Controllers\ProductController;
use App\PiplModules\product\Models\ProductImage;
use App\PiplModules\product\Models\Product;
use App\PiplModules\coupon\SendCouponEmail;
use App\PiplModules\cart\Models\CartItem;
use App\PiplModules\cart\Models\Cart;
use App\PiplModules\category\Models\Category;
use App\Helpers\Helper;

class WishlistController extends Controller {


    public function addToWishlist(Request $request)
    {
//        dd($request->all());
        if(Auth::check())
        {
           $product_id=$request->product_id;
           $product=  Product::find($request->product_id);
           if(isset($product) && $product!="")
           {
               $cart=new App\PiplModules\cart\Controllers\CartController();
               $wishlist = $cart->getProductDiscountPrice($product);
           if($wishlist['is_original'] == 0)
           {
                $price =$wishlist['price'];
           }
            elseif ($wishlist['is_original'] == 1)
            {
                $price =$wishlist['discount_rate'];
            }
            elseif ($wishlist['is_original'] == 2)
            {
                $price =0;
            }
            $price =trim($price);
           $customer_id=Auth::user()->id;
           $is_already_added=  Wishlist::where('customer_id',$customer_id)->where('product_id',$product_id)->first();
           if(isset($is_already_added) && count($is_already_added)>0)
           {
              $is_already_added->delete();
               echo json_encode(array("success" => '1', 'msg' => "Removed From Wishlist"));
               exit();
           }
           else
               {
                $wishlist_obj=new Wishlist();
                $wishlist_obj->customer_id=$customer_id;
                $wishlist_obj->product_id=$product_id;
                $wishlist_obj->product_amount=$price;
                $wishlist_obj->product_quantity=1;
                $wishlist_obj->product_color_name=$request->color;
                $wishlist_obj->product_size_name=$request->size;
               $wishlist_obj->save();
               echo json_encode(array("success" => '1', 'msg' => "Added In Wishlist"));
               exit();
           }
           }
        }else {
            $errorMsg = "Error! Your Session timed out.";
            Auth::logout();
            return redirect("/")->with("issue-profile", $errorMsg);
        }
      
    }
    public function viewWishlist(Request $request) {
        if(Auth::check())
        {
          return view('wishlist::view-wishlist');   
        }
        else{
            $errorMsg = "Please login to your account.";
            Auth::logout();
            return redirect("/")->with("issue-profile", $errorMsg);
        }
    }
 
    public function removeFromWishlist(Request $request) {
         $product_id=$request->product_id;
         $customer_id=Auth::user()->id;
         $remove_wishlist=Wishlist::where('product_id',$product_id)->where('customer_id',$customer_id)->first();
         if(isset($remove_wishlist) && count($remove_wishlist)>0){
             $remove_wishlist->delete();
             echo json_encode(array("success" => '1', 'msg' => "Deleted Successfull"));
             exit();
         }
         else{
             echo json_encode(array("success" => '0', 'msg' => "This product is not fount in wishlist"));
             exit();
         }
//         return view('wishlist::ajax-view-wishlist');
    }
    
    public function updateWishlist(Request $request)
    {
        $product_id=$request->product_id;
        $customer_id=Auth::user()->id; 
//        $product_obj= new ProductController();
       if($product_id!=""){
        $product = Product::where('id',$product_id)->first();
        if(isset($product) && count($product)>0)
            {
            $cart=new App\PiplModules\cart\Controllers\CartController();
               $productData=$cart->getProductDiscountPrice($product);
            }
        }
//        dd($productData);
        if($productData['is_original'] == 0){
            $prodAmt =$productData['price'];
        }
        elseif ($productData['is_original'] == 1){
            $prodAmt =$productData['discount_rate'];
        }
        elseif ($productData['is_original'] == 2){
            $prodAmt =0;
        }
        $ajaxProduct  = array();
        $ajaxProduct  = $this->getAjaxProductsQuickView($product);
        
        $wishlist=Wishlist::where('product_id',$product_id)->where('customer_id',$customer_id)->first();

        return view('wishlist::modal-quick-view',array('ajaxProduct'=>$ajaxProduct));
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
            if(isset($images) && count($images)>0)
            {
                $ajaxProduct[$key]['product_images'] =  $images;
            }
            $ProductAttribute = $pro->getProductAttribute;
            // dd($ProductAttribute);
            if(isset($ProductAttribute) && count($ProductAttribute)>0)
            {
                $cnt = 0;
                $ajaxProduct[$key]['attribute'] =  $ProductAttribute;
                foreach ($ProductAttribute as $value) {
                    if(!empty($value->getAttr->trans->name)){
                        $ajaxProduct['attribute_name'][$cnt]= $value->getAttr->trans->name;
                        $ajaxProduct['attribute_value'][$cnt] = trim($value['value']);
                        $cnt++;
                    }

                }
            }
            $ajaxProduct[$key]['image'] = $pro->productDescription['image'];
//            if(isset($pro->productDescription->discount_valid_from)&& strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
//            {
//
//                $ajaxProduct[$key]['discount_rate'] = '$'.($pro->productDescription['price'] - (($pro->productDescription['discount_percent'] * $pro->productDescription['price'])/100));
//
//                $ajaxProduct[$key]['price'] = '<del>'.'$'.$pro->productDescription['price'].'</del>';
//                $ajaxProduct[$key]['is_original'] = 1;
//                $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
//            }
//            elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
//            {
//
//                $ajaxProduct[$key]['discount_rate'] = '$'.($pro->productDescription['price'] - (($pro->transCat->trans[0]['discount_percent'] * $pro->productDescription['price'])/100));
//                $ajaxProduct[$key]['price'] = '<del>'.'$'. $pro->productDescription['price'].'</del>';
//                $ajaxProduct[$key]['is_original'] = 1;
//                $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
//            }
//            else{
//                $ajaxProduct[$key]['is_original'] = 0;
//                $ajaxProduct[$key]['price'] = $pro->productDescription['price'];
//            }
            if( \Auth::check()) {
                if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "0" || $pro->productDescription->hide_product_price == "2") && Auth::user()->userInformation->user_type == "3") {
                    $ajaxProduct[$key]['is_original'] = 2;
                } elseif (($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "1" || $pro->productDescription->hide_product_price == "2") && Auth::user()->userInformation->user_type == "4") {
                    $ajaxProduct[$key]['is_original'] = 2;
                } else {
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
            }
            elseif (Auth::guest())
            {
                if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "3"))
                {
                    if(isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id']!=0)
                    {
                        $grandParent =Category::find($pro->transCat->trans[0]['parent_id']);
                        if(isset($grandParent) && count($grandParent)>0){
                            if(isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                            {
                                $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),2,'.','');
                                $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($pro->productDescription['price']),4).'</del>';
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

                else
                {
                    $ajaxProduct[$key]['is_original'] = 2;
                }
            }

        }
        return $ajaxProduct;
    }

    
//    public function getAjaxProductsQuickView($pro)
//    {
//        $ajaxProduct  = array();
//        if(isset($pro) && count($pro)>0)
//        {
//            $key = 0;
//            $ajaxProduct[$key]['id'] = $pro->id;
//            $ajaxProduct[$key]['name'] = $pro->name;
//            $ajaxProduct[$key]['long_description'] = $pro->productDescription['description'];
//            $ajaxProduct[$key]['availability'] = $pro->productDescription['availability'];
//            $ajaxProduct[$key]['max_order_qty'] = $pro->productDescription['max_order_qty'];
//            $ajaxProduct[$key]['quantity'] = $pro->productDescription['quantity'];
//            $ajaxProduct[$key]['product_color'] = $pro->productDescription['color'];
//
//            $colors = $pro->getColor;
//            if(isset($colors) && count($colors)>0)
//            {
//                $ajaxProduct[$key]['colors'] =  $colors;
//            }
//            //dd($colors);
//            $images = $pro->productImages;
//            if(isset($images) && count($images)>0)
//            {
//                $ajaxProduct[$key]['product_images'] =  $images;
//            }
//            $ProductAttribute = $pro->getProductAttribute;
//            //dd($ProductAttribute);
//            if(isset($ProductAttribute) && count($ProductAttribute)>0)
//            {
//                $cnt = 0;
//                $ajaxProduct[$key]['attribute'] =  $ProductAttribute;
//                foreach ($ProductAttribute as $value) {
//                    if($value->getAttr != null){
//                        $ajaxProduct['attribute_name'][$cnt]= $value->getAttr->trans->name;
//                        $ajaxProduct['attribute_value'][$cnt] = trim($value['value']);
//                        $cnt++;
//                    }
//                }
//
//            }
//            $ajaxProduct[$key]['image'] = $pro->productDescription['image'];
//
////            if(isset($pro->productDescription->discount_valid_from)&& strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
////            {
////
////                $ajaxProduct[$key]['discount_rate'] = '$'.($pro->productDescription['price'] - (($pro->productDescription['discount_percent'] * $pro->productDescription['price'])/100));
////
////                $ajaxProduct[$key]['price'] = '<del>'.'$'.$pro->productDescription['price'].'</del>';
////                $ajaxProduct[$key]['is_original'] = 1;
////                $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
////            }
////            elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
////            {
////
////                $ajaxProduct[$key]['discount_rate'] = '$'.($pro->productDescription['price'] - (($pro->transCat->trans[0]['discount_percent'] * $pro->productDescription['price'])/100));
////                $ajaxProduct[$key]['price'] = '<del>'.'$'. $pro->productDescription['price'].'</del>';
////                $ajaxProduct[$key]['is_original'] = 1;
////                $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
////            }
////            else{
////                $ajaxProduct[$key]['is_original'] = 0;
////                $ajaxProduct[$key]['price'] = $pro->productDescription['price'];
////            }
//            if(isset($pro->productDescription->discount_valid_from)&& strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
//            {
//                $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']) - ($pro->productDescription['discount_percent'] * Helper::getRealPrice($pro->productDescription['price'])/100),4);
//                $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']),4).'</del>';
//                $ajaxProduct[$key]['is_original'] = 1;
//                $ajaxProduct[$key]['discount_percent'] = $pro->productDescription['discount_percent']."% off";
//            }
//            elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
//            {
//
//                $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']) - (($pro->transCat->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),4);
//                $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). round(Helper::getRealPrice($pro->productDescription['price']),4).'</del>';
//                $ajaxProduct[$key]['is_original'] = 1;
//                $ajaxProduct[$key]['discount_percent'] = $pro->transCat->trans[0]['discount_percent'].'% off';
//            }
//            else
//            {
//                if(isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id']!=0)
//                {
//                    $grandParent =Category::find($pro->transCat->trans[0]['parent_id']);
//                    if(isset($grandParent) && count($grandParent)>0){
//                        if(isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
//                        {
//                            $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']) - (($grandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),4);
//                            $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). round(Helper::getRealPrice($pro->productDescription['price']),4).'</del>';
//                            $ajaxProduct[$key]['is_original'] = 1;
//                            $ajaxProduct[$key]['discount_percent'] = $grandParent->trans[0]['discount_percent'].'% off';
//                        }
//                        elseif(isset($grandParent->parent_id) && $grandParent->parent_id !=0)
//                        {
//                            $grandGrandParent = Category::find($grandParent->parent_id);
//                            if(isset($grandGrandParent) && count($grandGrandParent)>0){
//                                if(isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
//                                {
//                                    $ajaxProduct[$key]['discount_rate'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * Helper::getRealPrice($pro->productDescription['price']))/100),4);
//                                    $ajaxProduct[$key]['price'] = '<del>'.Helper::getCurrencySymbol(). round(Helper::getRealPrice($pro->productDescription['price']),4).'</del>';
//                                    $ajaxProduct[$key]['is_original'] = 1;
//                                    $ajaxProduct[$key]['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'].'% off';
//                                }
//                                else{
//                                    $ajaxProduct[$key]['is_original'] = 0;
//                                    $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']),4);
//                                }
//                            }
//                            else{
//                                $ajaxProduct[$key]['is_original'] = 0;
//                                $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']),4);
//                            }
//                        }
//                        else{
//                            $ajaxProduct[$key]['is_original'] = 0;
//                            $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']),4);
//                        }
//                    }
//                    else{
//                        $ajaxProduct[$key]['is_original'] = 0;
//                        $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']),4);
//                    }
//
//                }
//                else{
//                    $ajaxProduct[$key]['is_original'] = 0;
//                    $ajaxProduct[$key]['price'] = Helper::getCurrencySymbol().round(Helper::getRealPrice($pro->productDescription['price']),4);
//                }
//            }
//        }
//        return $ajaxProduct;
//    }
    
    
    public function productImage(Request $request) {
        $color_id=$request->color_id;
        $product_id=$request->product_id;
        if($color_id!='' && $product_id!='')
        {
            $product_image=ProductImage::where('color_id',$color_id)->where('product_id',$product_id)->first();
            $image_src=array();
            $image_src=array('msg'=>'success','src'=>$product_image->images);
            return json_encode($image_src);
        }
    }
    public function moveProductToCart(Request $request)
    {
//        dd($request->all());
            if(Auth::check())
            {
                $cart=null;
                $cartItem=null;
                $wishlistDetails = Wishlist::find($request->wishlistId);
//                dd($wishlistDetails);
                if(isset($wishlistDetails) && count($wishlistDetails)>0){
                    $cart = Cart::where('customer_id',Auth::user()->id)->first();
//                    dd($cart == null);
                    if($cart == null){
                        $cart = Cart::create(['customer_id'=>Auth::user()->id]);
                        if(isset($cart) && count($cart)>0)
                        {
                            $cartItem = CartItem::create(['cart_id'=>$cart->id,'product_id'=>$wishlistDetails->product_id]);
                            if(isset($cartItem) && count($cartItem)>0){
                                $cartItem->product_amount=isset($wishlistDetails->product_amount)?$wishlistDetails->product_amount:0;
                                $cartItem->product_quantity=isset($request->count)?$request->count:1;
                                $cartItem->product_color_name = isset($wishlistDetails->product_color_name)?$wishlistDetails->product_color_name:'';
                                $cartItem->product_size_name = isset($wishlistDetails->product_size_name)?$wishlistDetails->product_size_name:'';
                                $cartItem->save();
                                $wishlistDetails->delete();
                                echo json_encode(array("success" => '1', 'msg' => "Added in cart"));
                                exit();
                            }
                        }
                    }
                    else{
                        $is_already_added = CartItem::where('cart_id',$cart->id)->where('product_id',$wishlistDetails->product_id)->first();
                        if(isset($is_already_added) && count($is_already_added)>0)
                        {
                            $is_already_added->product_quantity = isset($request->count)?$request->count:1;
                            $is_already_added->product_color_name = $wishlistDetails->product_color_name != ''?$wishlistDetails->product_color_name:'';
                            $is_already_added->product_size_name = $wishlistDetails->product_size_name != ''?$wishlistDetails->product_size_name:'';
                            $is_already_added->product_amount=isset($wishlistDetails->product_amount)?$wishlistDetails->product_amount:0;
                            $is_already_added->save();
                            $wishlistDetails->delete();
                            echo json_encode(array("success" => '1', 'msg' => "Added in cart"));
                            exit();
                        }
                        else{
                            $create_new = CartItem::create(['cart_id'=>$cart->id,'product_id'=>$wishlistDetails->product_id]);
                            if(isset($create_new) && count($create_new)>0){
                                $create_new->product_quantity=isset($request->count)?$request->count:1;
                                $create_new->product_amount=isset($wishlistDetails->product_amount)?$wishlistDetails->product_amount:0;
                                $create_new->product_color_name = $wishlistDetails->product_color_name != ''?$wishlistDetails->product_color_name:'';
                                $create_new->product_size_name = $wishlistDetails->product_size_name != ''?$wishlistDetails->product_size_name:'';
                                $create_new->save();

                                $wishlistDetails->delete();
                                echo json_encode(array("success" => '1', 'msg' => "Added in cart"));
                                exit();
                            }
                        }
                    }
                }
                else{
                    echo json_encode(array("success" => '0', 'msg' => "Wrong wishlist id"));
                    exit();
                }
            }
            else{
                echo json_encode(array("success" => '0', 'msg' => "Please login to add items in cart"));
                exit();
            }
    }
}
