<?php

namespace App\PiplModules\cart\Controllers;

use App\Http\Controllers\CreateShipController;
use App\Http\Controllers\RateRequestController;
use App\PiplModules\admin\Models\CityTranslation;
use App\PiplModules\admin\Models\StateTranslation;
use App\PiplModules\admin\Models\CountryTranslation;
use App\PiplModules\attribute\Models\AttributeTranslation;
use App\PiplModules\box\Models\Box;
use App\PiplModules\display\Models\Display;
use App\PiplModules\coupon\Models\AppliedCoupon;
use App\PiplModules\coupon\Models\CouponUser;
use App\PiplModules\paper\Models\Paper;
use App\PiplModules\product\Models\Color;
use App\PiplModules\product\Models\ProductAttribute;
use App\PiplModules\wishlist\Models\Wishlist;
use App\UserGiftCard;
use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use Mail;
use Hash;
use App\PiplModules\admin\Models\State;
use App\PiplModules\admin\Models\City;
use App\UserAddress;
use App\PiplModules\cart\Models\Cart;
use App\PiplModules\cart\Models\CartItem;
use App\PiplModules\cart\Models\Order;
use App\PiplModules\cart\Models\OrderItem;
use \App\PiplModules\coupon\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\PiplModules\cart\Models\OrderCoupon;
use Carbon\Carbon;
use App\PiplModules\product\Models\Product;
use App\PiplModules\product\Models\ProductDescription;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\PiplModules\admin\Models\Country;
use App\PiplModules\category\Models\Category;
use App\Helpers\Helper;
use Softon\Indipay\Facades\Indipay as Indipay;
use Softon\Indipay\Gateways\ccavenueGateway;
use stdClass;

class CartController extends Controller
{
    private $placeholder_img;

    public function __construct()
    {
        $this->placeholder_img = asset('media/front/img/avatar-placeholder.svg');
    }

    public function showCart(Request $request)
    {
        $totalAmount =0;
        $totalCount =0;
        $totalWeight =0.00;
        $totSavings =0;
        $arrCartData = [];
        $totalMinusCoupon =0;
        $all_countries = Country::translatedIn(\App::getLocale())->get();
        /*
         *
         *
         *
         *  */
        $all_boxes = Box::all();
        $all_papers = Paper::all();
        $all_displays = Display::all();
       // dd($all_papers);
        if (Auth::check())
        {
            
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
//        dd(Session::get('usr_details'));
//        if(Session::has('usr_details') && $cart->shipping_country != Session::get('usr_details.country_id'))
//        {
//            dd(234);
//        }
//        dd(23453);
//        dd($cart->shipping_country);

        if (isset($cart) && count($cart)>0)
        {
            foreach ($cart->cartItems as $items)
            {
              $all_products = Product::find($items->product_id);
              if(isset($all_products) && count($all_products)>0)
              {
                  $totalAmount += $items->product_amount * $items->product_quantity;
                  $totalCount += $items->product_quantity;
              }
            }
            if(Session::has('all_cart_data'))
            {
                $totSavings = Session::get('all_cart_data.total_savings');
            }

            $grandTotal =$this->calTotalCredit($cart,$totalAmount)-$totSavings;
            $arrCartData['box_amount']=isset($cart->box_amount)?$cart->box_amount:0.00;
            $arrCartData['paper_amount']=isset($cart->paper_amount)?$cart->paper_amount:0.00;
            $arrCartData['display_amount']=isset($cart->display_amount)?$cart->display_amount:0.00;
            $arrCartData['grand_total']=$grandTotal;
            $arrCartData['shipping_charge']=isset($cart->shipping_charge)?$cart->shipping_charge:0.00;
            $arrCartData['total']=$totalAmount;
            if(Session::has('all_cart_data') == false)
            {
                Session::put('all_cart_data.total_savings',0.00);
                Session::put('all_cart_data.gift_voucher',0.00);
                Session::put('all_cart_data.user_gift_id',null);
                Session::put('all_cart_data.refer_points',0.00);
                Session::put('all_cart_data.coupon_amount',0.00);
                Session::put('all_cart_data.promo_amount',0.00);
                Session::put('all_cart_data.coupon_code','');
                Session::put('all_cart_data.promo_code','');
                Session::save();
            }
        }

        return view('cart::view-cart', ['cart' => $cart,'all_countries'=>$all_countries,'all_boxes'=>$all_boxes,'all_papers'=>$all_papers,'all_displays'=>$all_displays,'arrCartData'=>$arrCartData]);
    }

    public function getCartTotalAmt($request)
    {
        $totalAmount =0;
        if (Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if (isset($cart) && count($cart)>0) {
            foreach ($cart->cartItems as $items) {
                $all_products = Product::find($items->product_id);
                if(isset($all_products) && count($all_products))
                {
                    $totalAmount += $items->product_amount * $items->product_quantity;
                }
            }
        }
        return $totalAmount;
    }
    public function getCartTotalWeight($request)
    {
        $totalWeight =0;
        if (Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if (isset($cart) && count($cart)>0)
        {
            foreach ($cart->cartItems as $items)
            {
                $all_products = Product::find($items->product_id);
                if(isset($all_products) && count($all_products))
                {
                    $totalWeight += floatval($items->product_weight) * floatval($items->product_quantity);
                }
            }
            if(isset($cart->box_weight) && $cart->box_weight !='')
            {
                $totalWeight +=floatval($cart->box_weight);
            }
            if(isset($cart->display_weight) && $cart->display_weight !='')
            {
                $totalWeight +=floatval($cart->display_weight);
            }
        }
        return $totalWeight;
    }


    public function updateProductToCart(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $totalCount =0;
        $totalAmount = 0;
        if($request->product_id != '')
        {
            $product = Product::find($request->product_id);
            if(isset($product) && count($product)>0)
            {
                $productData = $this->getProductDiscountPrice($product);
            }
        }
//        dd($productData);
        if($productData['is_original'] == 0){
            $prodAmt =$productData['price'];
        }
        elseif ($productData['is_original'] == 1){
            $prodAmt =$productData['discount_rate'];
        }
        elseif($productData['is_original'] == 1)
        {
            return redirect('/');
        }
        $attrTrans = AttributeTranslation::where('name','Gross Weight')->first();
//           dd($attrTrans->attribute_id);
        if(isset($attrTrans->attribute_id) && $attrTrans->attribute_id !='')
            $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attrTrans->attribute_id)->first();
        //dd($data);
        if (Auth::check()) {

            $cart = Auth::user()->cart;
        }
        else {
            $cart = Cart::where('ip_address', $request->ip())->first();
        }
        if(isset($cart) && count($cart)>0){
            $cartItem = CartItem::where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
            if(isset($cartItem) && count($cartItem)>0){
                    $cartItem->product_amount = $prodAmt;
                    if(isset($request->color_name) && $request->color_name!='')
                    {
                        $cartItem->product_color_name = $request->color_name;
                    }
                    if(isset($request->size_name) && $request->size_name !='')
                    {
                        $cartItem->product_size_name = $request->size_name;
                    }
                    $cartItem->product_quantity =isset($request->ip_prod_count)?$request->ip_prod_count:1;
                    $cartItem->product_weight =isset($prodAttr)?$prodAttr->value:0;
                    $cartItem->save();
            }

            foreach ($cart->cartItems as $items) {
                $all_products = Product::find($items->product_id);
                if (isset($all_products) && count($all_products)) {
                    $totalAmount += $items->product_amount * $items->product_quantity;
                    $totalCount += $items->product_quantity;
                }
            }
            return redirect('/cart');
        }
        else{
            return redirect('/');
        }
    }
   public function getProductDiscountPrice($pro)
     {
         if( \Auth::check())
         {
             if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "0" || $pro->productDescription->hide_product_price == "2") && Auth::user()->userInformation->user_type == "3"){
                 $pro['is_original'] = 2;
             }
             elseif(($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price=="1" || $pro->productDescription->hide_product_price == "2") && Auth::user()->userInformation->user_type == "4")
             {
                 $pro['is_original'] = 2;
             }
             else {
                 if (isset($pro->productDescription->discount_valid_from) && strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
                 {
                     $pro['discount_rate'] = ($pro->productDescription['price']- ($pro->productDescription['discount_percent'] * $pro->productDescription['price']) / 100);
                     $pro['price'] = '<del>' . $pro->productDescription['price'] . '</del>';
                     $pro['is_original'] = 1;
                     $pro['discount_percent'] = $pro->productDescription['discount_percent'] . "% off";
                 }
                 elseif (isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                 {

                     $pro['discount_rate'] = ($pro->productDescription['price'] - ($pro->transCat->trans[0]['discount_percent'] * $pro->productDescription['price']) / 100);
                     $pro['price'] = '<del>' . ($pro->productDescription['price']) . '</del>';
                     $pro['is_original'] = 1;
                     $pro['discount_percent'] = $pro->transCat->trans[0]['discount_percent'] . '% off';
                 }
                 else
                 {
                     if (isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id'] != 0) {
                         $grandParent = Category::find($pro->transCat->trans[0]['parent_id']);
                         if (isset($grandParent) && count($grandParent) > 0) {
                             if (isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                 $pro['discount_rate'] = (($pro->productDescription['price']) - ($grandParent->trans[0]['discount_percent'] * $pro->productDescription['price']) / 100);
                                 $pro['price'] = '<del>' . ($pro->productDescription['price']) . '</del>';
                                 $pro['is_original'] = 1;
                                 $pro['discount_percent'] = $grandParent->trans[0]['discount_percent'] . '% off';
                             } elseif (isset($grandParent->parent_id) && $grandParent->parent_id != 0) {
                                 $grandGrandParent = Category::find($grandParent->parent_id);
                                 if (isset($grandGrandParent) && count($grandGrandParent) > 0) {
                                     if (isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                         $pro['discount_rate'] = ($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * $pro->productDescription['price']) / 100);
                                         $pro['price'] = '<del>' . ($pro->productDescription['price']) . '</del>';
                                         $pro['is_original'] = 1;
                                         $pro['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'] . '% off';
                                     } else {
                                         $pro['is_original'] = 0;
                                         $pro['price'] = ($pro->productDescription['price']);
                                     }
                                 } else {
                                     $pro['is_original'] = 0;
                                     $pro['price'] = ($pro->productDescription['price']);
                                 }
                             } else {
                                 $pro['is_original'] = 0;
                                 $pro['price'] = ($pro->productDescription['price']);
                             }
                         } else {
                             $pro['is_original'] = 0;
                             $pro['price'] = ($pro->productDescription['price']);
                         }

                     } else {
                         $pro['is_original'] = 0;
                         $pro['price'] = ($pro->productDescription['price']);
                     }
                 }
             }

         }
         elseif (\Auth::guest())
         {
             if (isset($pro->productDescription->hide_product_price) && ($pro->productDescription->hide_product_price == "3"))
             {
                 if (isset($pro->productDescription->discount_valid_from) && strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
                 {
                     $pro['discount_rate'] = ($pro->productDescription['price']- ($pro->productDescription['discount_percent'] * $pro->productDescription['price']) / 100);
                     $pro['price'] = '<del>' . $pro->productDescription['price'] . '</del>';
                     $pro['is_original'] = 1;
                     $pro['discount_percent'] = $pro->productDescription['discount_percent'] . "% off";
                 }
                 elseif (isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                 {

                     $pro['discount_rate'] = ($pro->productDescription['price'] - ($pro->transCat->trans[0]['discount_percent'] * $pro->productDescription['price']) / 100);
                     $pro['price'] = '<del>' . ($pro->productDescription['price']) . '</del>';
                     $pro['is_original'] = 1;
                     $pro['discount_percent'] = $pro->transCat->trans[0]['discount_percent'] . '% off';
                 }
                 else
                 {
                     if (isset($pro->transCat->trans[0]['parent_id']) && $pro->transCat->trans[0]['parent_id'] != 0) {
                         $grandParent = Category::find($pro->transCat->trans[0]['parent_id']);
                         if (isset($grandParent) && count($grandParent) > 0) {
                             if (isset($grandParent->trans[0]['discount_valid_from']) && strtotime($grandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                 $pro['discount_rate'] = (($pro->productDescription['price']) - ($grandParent->trans[0]['discount_percent'] * $pro->productDescription['price']) / 100);
                                 $pro['price'] = '<del>' . ($pro->productDescription['price']) . '</del>';
                                 $pro['is_original'] = 1;
                                 $pro['discount_percent'] = $grandParent->trans[0]['discount_percent'] . '% off';
                             } elseif (isset($grandParent->parent_id) && $grandParent->parent_id != 0) {
                                 $grandGrandParent = Category::find($grandParent->parent_id);
                                 if (isset($grandGrandParent) && count($grandGrandParent) > 0) {
                                     if (isset($grandGrandParent->trans[0]['discount_valid_from']) && strtotime($grandGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($grandGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s'))) {
                                         $pro['discount_rate'] = ($pro->productDescription['price']) - (($grandGrandParent->trans[0]['discount_percent'] * $pro->productDescription['price']) / 100);
                                         $pro['price'] = '<del>' . ($pro->productDescription['price']) . '</del>';
                                         $pro['is_original'] = 1;
                                         $pro['discount_percent'] = $grandGrandParent->trans[0]['discount_percent'] . '% off';
                                     } else {
                                         $pro['is_original'] = 0;
                                         $pro['price'] = ($pro->productDescription['price']);
                                     }
                                 } else {
                                     $pro['is_original'] = 0;
                                     $pro['price'] = ($pro->productDescription['price']);
                                 }
                             } else {
                                 $pro['is_original'] = 0;
                                 $pro['price'] = ($pro->productDescription['price']);
                             }
                         } else {
                             $pro['is_original'] = 0;
                             $pro['price'] = ($pro->productDescription['price']);
                         }

                     } else {
                         $pro['is_original'] = 0;
                         $pro['price'] = ($pro->productDescription['price']);
                     }
                 }
             }
             else
             {
                 $pro['is_original'] = 2;
             }
         }
        return $pro;
    }

    public function addProductToCart(Request $request)
    {
        $data = $request->all();
        $totalAmount =0;
        $totalCount =0;
        $productData = null;
        $prodAmt =0.00;
        $prodWeight =0.00;
        if($request->product_id != '')
        {
           $product = Product::find($request->product_id);
           if(isset($product) && count($product)>0)
           {
               $productData = $this->getProductDiscountPrice($product);

           }

           if($productData['is_original'] == 0)
           {
                $prodAmt =$productData['price'];
           }
            elseif ($productData['is_original'] == 1)
            {
                $prodAmt =$productData['discount_rate'];
            }
            elseif($productData['is_original'] == 2)
            {
                return redirect('/');

            }
            $prodAmt =trim($prodAmt,'');
           $attrTrans = AttributeTranslation::where('name','Gross Weight')->first();
           if(isset($attrTrans->attribute_id) && $attrTrans->attribute_id !='')
            $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attrTrans->attribute_id)->first();
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
                if($cart == null){
                    $cart = new Cart();
                    $cart->ip_address =$request->ip();
                    $cart->save();
                }
            }
            if(isset($cart) && count($cart)>0){
                $cartItem =null;
                if($request->product_id != ''){
                    $cartItem = CartItem::where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
                }
                if($cartItem == null){
                    $cartItem = new CartItem();
                    $cartItem->cart_id =$cart->id;
                    $cartItem->product_id =$request->product_id;
                    $cartItem->product_amount =$prodAmt;
                    $cartItem->product_color_name = isset($request->color_name)?$request->color_name:'';
                    $cartItem->product_quantity =isset($request->ip_prod_count)?$request->ip_prod_count:1;
                    $cartItem->product_size_name =isset($request->size_name)?$request->size_name:'';
                    $cartItem->product_weight =isset($prodAttr)?$prodAttr->value:0.00;
                    $cartItem->save();
                }
                else{
                    $cartItem->product_amount =$prodAmt;
                    $cartItem->product_color_name = isset($request->color_name)?$request->color_name:'';
                    $cartItem->product_quantity =isset($request->ip_prod_count)?$request->ip_prod_count:1;
                    $cartItem->product_size_name =isset($request->size_name)?$request->size_name:'';
                    $cartItem->product_weight =isset($prodAttr)?$prodAttr->value:0.00;
                    $cartItem->save();
                }

                if(Session::has('all_cart_data') == false)
                {
                    Session::put('all_cart_data.total_savings',0.00);
                    Session::put('all_cart_data.gift_voucher',0.00);
                    Session::put('all_cart_data.user_gift_id',null);
                    Session::put('all_cart_data.refer_points',0.00);
                    Session::put('all_cart_data.coupon_amount',0.00);
                    Session::put('all_cart_data.promo_amount',0.00);
                    Session::put('all_cart_data.coupon_code','');
                    Session::put('all_cart_data.promo_code','');
                    Session::save();
                }
                return redirect('/cart');
            }
            else{
                return redirect('/');

            }
        }

        else{
            echo json_encode(array("success" => '0', 'msg' => "Something Went Wrong!!"));
            exit();
        }
    }

    public function addToCart(Request $request)
    {
        $proId = $request->product_id;
        $product = Product::find($proId);
        $product_quantity = $request->quantity;

        if (Auth::check()) {
            $cart = Cart::where('customer_id', Auth::user()->id)->first();
        }
        else
        {
            $cart = Cart::where('ip_address', $request->ip())->first();
        }

        if (isset($cart) && count($cart)>0) {
            $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id',$request->product_id)->first();

            if ($cart_item) {
                $product_quantity += $cart_item->product_quantity;
            }
        }

        if($product_quantity > $product->productDescription->quantity || $product_quantity > $product->productDescription->max_order_qty)
        {
            if($product_quantity > $product->productDescription->quantity){
                echo json_encode(array("success" => '0', 'msg' => "This quantity Unavailable"));
                exit();
            }
            elseif ($product_quantity > $product->productDescription->max_order_qty){
                echo json_encode(array("success" => '0', 'msg' => "You can only order max ".$product->productDescription->max_order_qty." quantity"));
                exit();
            }

        } else {
            if (Auth::check()) {
                $cutomer_id = Auth::user()->id;

                $cart = Cart::where('customer_id', $cutomer_id)->orWhere('ip_address',$request->ip())->first();
                if (!$cart) {
                    $cart = new Cart();
                }

                $cart->customer_id = $cutomer_id;
                $cart->ip_address = $request->ip();
                $cart->save();

                $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

                if (!$cart_item) {
                    $cart_item = new CartItem();
                    $cart_item->cart_id = $cart->id;
                    $cart_item->product_id = $request->product_id;
                    $cart_item->product_quantity = 0;
                }
                $cart_item->product_quantity = $cart_item->product_quantity + $request->quantity;

                $cart_item->save();
                echo json_encode(array("success" => '1', 'msg' => Auth::user()->cartItemCount(Auth::user()->id)));
                exit();
            } else {

                $cutomer_ip = $request->ip();

                $cart = Cart::where('ip_address', $cutomer_ip)->first();
                if (!$cart) {
                    $cart = new Cart();
                }

                $cart->customer_id = 0;
                $cart->ip_address = $cutomer_ip;
                $cart->save();

                $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

                if (!$cart_item) {
                    $cart_item = new CartItem();
                    $cart_item->cart_id = $cart->id;
                    $cart_item->product_id = $request->product_id;
                    $cart_item->product_quantity = 0;
                }
                $cart_item->product_quantity = $cart_item->product_quantity + $request->quantity;

                $cart_item->save();

                $cart_total_items=  CartItem::where('cart_id', $cart->id)->get();
                $total_count=0;
                foreach($cart_total_items as $item)
                {
                    $total_count+=$item->product_quantity;
                }
                echo json_encode(array("success" => '1', 'msg' => $total_count));
                exit();
            }
        }
    }

    public function updateToCart(Request $request){
        $data =$request->all();
        echo json_encode(array("success" => '1', 'msg' => $data));
        exit();
    }

    public function proceedCustomerShippingDetails(Request $request)
    {
        $data = $request->all();
        $cart = Cart::find($request->ip_cart_id);
        if(isset($cart) && count($cart)>0) {
            $cartItems = CartItem::where('cart_id',$cart->id)->get();
            if(isset($cartItems) && count($cartItems)>0){
                $data["customer_id"] = isset($cart->customer_id) && ($cart->customer_id!=0 || $cart->customer_id!='') ? $cart->customer_id : $cart->ip_address;
                $data["name_initial"] = isset($data["name_initial"]) ? $data["name_initial"] : "";
                $data["first_name"] = isset($data["first_name"]) ? $data["first_name"] : "";
                $data["last_name"] = isset($data["last_name"]) ? $data["last_name"] : "";
                $data["email"] = isset($data["email"]) ? $data["email"] : "";
                $cart->shipping_name =$data["name_initial"].' '.$data["first_name"].' '.$data["last_name"];
                $cart->shipping_email =$data["email"];
                $cart->save();
                return redirect('cart');
            }
        }
        }
        public function checkoutAllCart($data)
        {
         // dd($data->id);
          $totalAmount = 0;
           if(isset($data) && $data !=''){
               $cart = Cart::find($data->id);
//               dd($cart);
               if(isset($cart) && count($cart)>0)
               {
                   $cartItems =CartItem::where('cart_id',$cart->id)->get();
                  // dd($cartItems);
                   if(isset($cartItems) && count($cartItems)>0)
                   {
                      // return 'success';
                           $order = new Order();
                           $order->cart_id =$cart->id;
                           $order->customer_id = isset($cart->customer_id)?$cart->customer_id:null;
                           $order->ip_address = isset($cart->ip_address)?$cart->ip_address:"";
                           $order->shipping_name = isset($cart->shipping_name)?$cart->shipping_name:"";
                           $order->shipping_email = isset($cart->shipping_email)?$cart->shipping_email:"";
                           $order->shipping_address1 = isset($cart->shipping_address1)?$cart->shipping_address1:"";
                           $order->shipping_address2 = isset($cart->shipping_address2)?$cart->shipping_address2:"";
                           if(isset($cart->shipping_city) && $cart->shipping_city !='')
                           {
                               $cityTrans = CityTranslation::where('city_id',$cart->shipping_city)->first();
                               if(isset($cityTrans) && count($cityTrans)>0)
                               {
                                   $order->shipping_city=$cityTrans->name;
                               }
                           }
                           if(isset($cart->shipping_state) && $cart->shipping_state !='')
                           {
                               $stateTrans = StateTranslation::where('state_id',$cart->shipping_state)->first();
                               if(isset($stateTrans) && count($stateTrans)>0)
                               {
                                   $order->shipping_state=$stateTrans->iso_code;
                               }
                           }
                           if(isset($cart->shipping_country) && $cart->shipping_country !='')
                           {
                               $countryTrans = CountryTranslation::where('country_id',$cart->shipping_country)->first();
                               if(isset($countryTrans) && count($countryTrans)>0)
                               {
                                   $order->shipping_country=$countryTrans->iso_code;
                               }
                           }
                           $order->shipping_zip = isset($cart->shipping_zip)?$cart->shipping_zip:"";
                           $order->shipping_iso2 = isset($cart->shipping_iso2)?$cart->shipping_iso2:"in";
                           $order->shipping_telephone = isset($cart->shipping_telephone)?$cart->shipping_telephone:"";

                           $order->billing_name = isset($cart->billing_name)?$cart->billing_name:"";
                           $order->billing_email = isset($cart->billing_email)?$cart->billing_email:"";
                           $order->billing_address1 = isset($cart->billing_address1)?$cart->billing_address1:"";
                           $order->billing_address2 =isset($cart->billing_address2)? $cart->billing_address2:"";

                           if(isset($cart->billing_city) && $cart->billing_city !='')
                                {
                                   $cityTrans = CityTranslation::where('city_id',$cart->billing_city)->first();
                                   if(isset($cityTrans) && count($cityTrans)>0)
                                   {
                                       $order->billing_city=$cityTrans->name;
                                   }
                                }

                           if(isset($cart->billing_state) && $cart->billing_state !='')
                           {
                               $stateTrans = StateTranslation::where('state_id',$cart->billing_state)->first();
                               if(isset($stateTrans) && count($stateTrans)>0)
                               {
                                   $order->billing_state=$stateTrans->iso_code;
                               }
                           }

                           if(isset($cart->billing_country) && $cart->billing_country !='')
                           {
                               $countryTrans = CountryTranslation::where('country_id',$cart->billing_country)->first();
                               if(isset($countryTrans) && count($countryTrans)>0)
                               {
                                   $order->billing_country=$countryTrans->iso_code;
                               }
                           }
                           $order->billing_zip = isset($cart->billing_zip)?$cart->billing_zip:"";
                           $order->billing_iso2 = isset($cart->billiing_iso2)?$cart->billiing_iso2:"";
                           $order->billing_telephone = isset($cart->billing_telephone)?$cart->billing_telephone:"";
                           $order->order_status =1;
                           $order->order_shipping_cost =isset($cart->shipping_charge)?$cart->shipping_charge:0;
                           $order->order_tax =isset($cart->tax)?$cart->tax:0;
                           $order->box_id =isset($cart->box_id)?$cart->box_id:null;
                           $order->paper_id =isset($cart->paper_id)?$cart->paper_id:null;
                           $order->display_id =isset($cart->display_id)?$cart->display_id:null;
                           $order->box_amount =isset($cart->box_amount)?$cart->box_amount:0;
                           $order->paper_amount =isset($cart->paper_amount)?$cart->paper_amount:0;
                           $order->display_amount =isset($cart->display_amount)?$cart->display_amount:0;
                           $order->save();

                           foreach ($cartItems as $items)
                           {
                           $orderItems = new OrderItem();
                           $orderItems->order_id =$order->id;
                           $orderItems->product_id = isset($items->product_id)?$items->product_id:null;
                           $orderItems->product_amount = isset($items->product_amount)?$items->product_amount:0;
                           $orderItems->product_quantity =isset($items->product_quantity)? $items->product_quantity:1;
                           $orderItems->product_color_name = isset($items->product_color_name)?$items->product_color_name:"";
                           $orderItems->product_size_name = isset($items->product_size_name)?$items->product_size_name:"";
                           $orderItems->weight = isset($items->product_weight)?$items->product_weight:"";
                               $proLen = ProductAttribute::where('product_id',$items->product_id)->where('attribute_id',37)->first();
                               $proWidth = ProductAttribute::where('product_id',$items->product_id)->where('attribute_id',62)->first();
                               $proHeight = ProductAttribute::where('product_id',$items->product_id)->where('attribute_id',57)->first();
                               if(isset($proLen) && count($proLen)>0)
                               {
                                   $orderItems->length = $proLen->value*$items->product_quantity;
                               }
                               if(isset($proWidth) && count($proWidth)>0)
                               {
                                   $orderItems->width = $proWidth->value*$items->product_quantity;
                               }
                               if(isset($proHeight) && count($proHeight)>0)
                               {
                                   $orderItems->height = $proHeight->value*$items->product_quantity;
                               }
                           $orderItems->save();
                           $totalAmount += $items->product_amount * $items->product_quantity;
                               $order_product= ProductDescription::where("product_id",$items->product_id)->first();
                               if(isset($order_product) && count($order_product)>0)
                               {
                                   $available_product = $order_product->quantity - $items->product_quantity;
                                   if($available_product > 0)
                                   {
                                       $order_product->availability="0";
                                       if($available_product <= 10)
                                       {
                                           $order_product->max_order_qty =1;
                                       }
                                       $order_product->quantity =$available_product;
                                       $order_product->save();
                                   }
                                   else
                                   {
                                       $order_product->availability="1";
                                       $order_product->quantity=0;
                                       $order_product->max_order_qty=0;
                                       $order_product->save();
                                   }
                               }
                           $items->delete();
                           }

                           if(Session::has('all_cart_data'))
                           {
                               $order->coupon_amount = Session::get('all_cart_data.coupon_amount');
                               $order->promo_amount = Session::get('all_cart_data.promo_amount');
                               $order->gift_card_amount = Session::get('all_cart_data.gift_voucher');
                               $order->user_gift_id = Session::get('all_cart_data.user_gift_id');
                               $order->order_subtotal =$totalAmount;
                               $totlCredit = $this->calTotalCredit($cart,$totalAmount);
                               $order->order_discount =Session::get('all_cart_data.total_savings');
                               $order->order_total =$totlCredit-Session::get('all_cart_data.total_savings');
                           }
                           if(Session::has('service_details'))
                           {
                               $order->shipping_service_name = Session::get('service_details.service_name');
                               $order->shipping_service_provider = Session::get('service_details.service_provider');
                               $order->shipping_service_price = Session::get('service_details.service_price');
                               $order->shipping_service_date = Session::get('service_details.service_time');
                               $order->shipping_total_weight = Session::get('service_details.service_total_weight');
                               $order->shipping_service_type = Session::get('service_details.service_type');
                               if(Session::get('service_details.service_provider') =='DHL')
                               {
                                   $order->shipping_service_estimated_days =Session::get('service_details.service_estimated_days');
                               }
                               Session::forget('service_details');
                               Session::save();
                           }
                           $order->order_currency = Helper::getCurrency();
                           $order->save();
                           if(Session::get('all_cart_data.user_gift_id') !=null && Session::get('all_cart_data.gift_voucher') !='')
                           {
                               $userGiftCard = UserGiftCard::find(Session::get('all_cart_data.user_gift_id'));
                               if($userGiftCard)
                               {
                                   $userGiftCard->remaining_price =  $userGiftCard->price -($userGiftCard->remaining_price + Session::get('all_cart_data.gift_voucher') );
                                   $userGiftCard->apply_count +=1;
                                   $userGiftCard->save();
                               }
                           }
                       if(Session::get('all_cart_data.coupon_amount') !=null && Session::get('all_cart_data.coupon_code') !='')
                       {
                           $coupon = Coupon::where('coupon_code',Session::get('all_cart_data.coupon_code'))->first();
                           if(isset($coupon) && count($coupon)>0)
                           {
                               $appliedCoupon = new AppliedCoupon;
                               $appliedCoupon->coupon_id =$coupon->id;
                               $appliedCoupon->user_id =Auth::user()->id;
                               $appliedCoupon->order_id =$order->id;
                               $appliedCoupon->code_type ="0";
                               $appliedCoupon->save();
                           }
                       }
                       if(Session::get('all_cart_data.promo_amount') !=null && Session::get('all_cart_data.promo_code') !='')
                       {
                           $coupon = Coupon::where('coupon_code',Session::get('all_cart_data.promo_code'))->first();
                           if(isset($coupon) && count($coupon)>0)
                           {
                               $appliedCoupon = new AppliedCoupon;
                               $appliedCoupon->coupon_id =$coupon->id;
                               $appliedCoupon->user_id =Auth::user()->id;
                               $appliedCoupon->order_id =$order->id;
                               $appliedCoupon->code_type ="1";
                               $appliedCoupon->save();
                           }
                       }
                           $orderArr['order_id']= $order->id;
                           $orderArr['grand_total']= $order->order_total;
                       return $orderArr;
                   }
                   else{
//                       dd('zero');
                       return 'failure';
                   }

                   }
                   else{
                       return 'failure';
                   }
               }
            return 'failure';
        }
    public function proceedShippingDetails(Request $request)
    {
        $data = $request->all();
//         dd($data);
        $data['shipping_name'] = isset($request->shipping_name)?$request->shipping_name:'';
        $data['shipping_email'] = isset($request->shipping_email)?$request->shipping_email:'';
        $data['house_no'] = isset($request->house_no)?$request->house_no:'';
        $data['address_line'] = isset($request->address_line)?$request->address_line:'';
        $data['city'] = isset($request->city)?$request->city:'';
        $data['region'] = isset($request->region)?$request->region:'';
        $data['postal_code'] = isset($request->postal_code)?$request->postal_code:'';
        $data['country'] = isset($request->country)?$request->country:'';
        $data['shipping_iso2'] = isset($request->shipping_iso2)?$request->shipping_iso2:'';
        $data['telephone'] = isset($request->telephone)?$request->telephone:'';
        if(!$data['billing_address']){
            $data['billing_name'] = isset($request->billing_name)?$request->billing_name:'';
            $data['billing_email'] = isset($request->billing_email)?$request->billing_email:'';
            $data['billing_house_no'] = isset($request->billing_house_no)?$request->billing_house_no:'';
            $data['billing_address_line'] = isset($request->billing_address_line)?$request->billing_address_line:'';
            $data['billing_city'] = isset($request->billing_city)?$request->billing_city:'';
            $data['billing_region'] = isset($request->billing_region)?$request->billing_region:'';
            $data['billing_postal_code'] = isset($request->billing_postal_code)?$request->billing_postal_code:'';
            $data['billing_telephone'] = isset($request->billing_telephone)?$request->billing_telephone:'';
            $data['billing_country'] = isset($request->billing_country)?$request->billing_country:'';
            $data['billing_iso2'] = isset($request->billing_iso2)?$request->billing_iso2:'';
        }
        //dd($data);
        $cart = Cart::find($request->ip_cart_id);

        if(isset($cart) && count($cart)>0){
            $cartItems = CartItem::where('cart_id',$cart->id)->get();
            if(isset($cartItems) && count($cartItems)>0){
            // Save Shipping Information for respective cart
                $cart->shipping_name = $data['shipping_name'];
                $cart->shipping_email = $data['shipping_email'];

                $cart->shipping_address1 = $data['house_no'];
                $cart->shipping_address2 = $data['address_line'];
                $cart->shipping_city = $data['city'];
                $cart->shipping_state = $data['region'];
                $cart->shipping_zip = $data['postal_code'];
                $cart->shipping_country = $data['country'];
                $cart->shipping_iso2 = $data['shipping_iso2'];
                $cart->shipping_telephone = $data['telephone'];

                if($data['billing_address']){
                    $cart->billing_name = $data['shipping_name'];
                    $cart->billing_email = $data['shipping_email'];
                    $cart->billing_address1 = $data['house_no'];
                    $cart->billing_address2 = $data['address_line'];
                    $cart->billing_city = $data['city'];
                    $cart->billing_state = $data['region'];
                    $cart->billing_zip = $data['postal_code'];
                    $cart->billing_telephone = $data['telephone'];
                    $cart->billing_country = $data['country'];
                    $cart->billing_iso2 = $data['shipping_iso2'];
                } else {
                    $cart->billing_name = $data['billing_name'];
                    $cart->billing_email = $data['billing_email'];
                    $cart->billing_address2 = $data['billing_house_no'];
                    $cart->billing_address2 = $data['billing_address_line'];
                    $cart->billing_city = $data['billing_city'];
                    $cart->billing_state = $data['billing_region'];
                    $cart->billing_zip = $data['billing_postal_code'];
                    $cart->billing_telephone = $data['billing_telephone'];
                    $cart->billing_country = $data['billing_country'];
                    $cart->billing_iso2 = $data['billing_iso2'];
                }
                $cart->is_shipping_details_filled='1';
                $cart->save();

            }

            return redirect('cart');

        }

    }

    public function addRemoveProductQuantity(Request $request)
    {
        $product_count = 0;
        $product_weight = 0;
        $cart_total = 0;

        $cardItemProdQty = 0;
        $tot_amt = 0;
        $userType = "";
        if (Auth::check()) {
            $userType =  Auth::user()->userInformation->user_type;
        }
        if ($request->cart_item_id && $request->action)
        {
            if(is_numeric($request->cart_item_id)){
                $cart_item = CartItem::find($request->cart_item_id);
                if (isset($cart_item) && count($cart_item) > 0)
                {
                    if ($request->action == 'add') {
                        $cardItemProdQty += $cart_item->product_quantity + 1;
                        if($userType !=4){
                            if ($cardItemProdQty > $cart_item->product->productDescription->max_order_qty) {
                                echo json_encode(array("success" => '0', 'msg' => "You can only order max ".$cart_item->product->productDescription->max_order_qty." products"));
                                exit();
                            } elseif($cardItemProdQty > $cart_item->product->productDescription->quantity) {
                                echo json_encode(array("success" => '0', 'msg' => "Only ".$cart_item->product->productDescription->quantity." products are available in stock"));
                                exit();
                            }
                            else{
                                $cart_item->product_quantity = $cardItemProdQty;
                            }
                        }
                        else{
                            if($cardItemProdQty > $cart_item->product->productDescription->quantity) {
                                echo json_encode(array("success" => '0', 'msg' => "Only ".$cart_item->product->productDescription->quantity." products are available in stock"));
                                exit();
                            }
                            else{
                                $cart_item->product_quantity = $cardItemProdQty;
                            }

                        }
                    }
                    else
                    {
                        if ($cart_item->product_quantity > 1)
                        {
                            $cart_item->product_quantity = $cart_item->product_quantity - 1;
                        }
                    }
                    $cart_item->save();
                }
            }
        }

        if(Auth::check())
        {
            $cart = Cart::where('customer_id', Auth::user()->id)->first();
        }
        else
        {
            $cart = Cart::where('ip_address', $request->ip())->first();
        }
        if(isset($cart) && count($cart)>0)
        {

            foreach ($cart->cartItems as $index => $cart_item)
            {
                $product_count += $cart_item->product_quantity;
                $data[$index]['quantity'] = $cart_item->product_quantity;
                $product_weight += $cart_item->product_weight *$cart_item->product_quantity;
                $data[$index]['id'] = $cart_item->id;
                $tmp_subtotal = $cart_item->product_quantity * $cart_item->product_amount;
                $data[$index]['subtotal'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($cart_item->product_quantity * $cart_item->product_amount),2,'.','');
                $cart_total+= $tmp_subtotal;
            }
            if($cart->box_weight != '')
            {
                $product_weight += $cart->box_weight;
            }
            if($cart->display_weight != '')
            {
                $product_weight += $cart->display_weight;
            }
            $data['product_count'] = $product_count;
            $data['product_weight'] = $product_weight;
            $data['coupon_percent'] = $cart->coupon_percentage;

            $cartTotCredit = $this->calTotalCredit($cart,$cart_total);
            $sessionData = Session::get('all_cart_data');
            $totalSavings = $this->calTotalSavings($sessionData);
            $sessionData['total_savings']=$totalSavings;
            Session::put('all_cart_data',$sessionData);
            Session::save();
            $data['grand_total'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($cartTotCredit - Session::get('all_cart_data.total_savings')),2,'.','');
            $data['main_total'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($cart_total),2,'.','');
            echo json_encode(array("success" => '1', 'msg' => $data));
            exit();
        }

    }

    public function changeCartProductColor(Request $request)
    {
        $cartItemId = $request->cart_item_id;
        $cartItem =CartItem::find($cartItemId);
        if(isset($cartItem) && count($cartItem)>0){
            $cartItem->product_color_name =$request->color;
            $cartItem->save();
            echo json_encode(array("success" => '1', 'msg' => "Product Color changed Successfully"));
            exit();
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Cart Item could not found"));
            exit();
        }
    }

    public function moveProductToWishlist(Request $request)
    {
        if(Auth::check())
        {
            $data =array();
            $totalAmt =0;
            $totalAmount=0.00;
            $sessionData =array();
            $totalCount=0;
            $totalWeight=0.00;
            $cartItemDetails = CartItem::find($request->cartItemId);

            if(isset($cartItemDetails) && count($cartItemDetails)>0)
            {
                $cartId =$cartItemDetails->cart_id;

                $is_already_added=  Wishlist::where('customer_id',Auth::user()->id)->where('product_id',$cartItemDetails->product_id)->first();
                if(isset($is_already_added) && count($is_already_added)>0)
                {
                    $is_already_added->product_quantity = isset($request->count)?$request->count:1;
                    $is_already_added->product_color_name = isset($cartItemDetails->product_color_name)?$cartItemDetails->product_color_name:'';
                    $is_already_added->product_amount = isset($cartItemDetails->product_amount)?$cartItemDetails->product_amount:0;
                    $is_already_added->product_size_name = isset($cartItemDetails->product_size_name)?$cartItemDetails->product_size_name:'';
                    $is_already_added->product_weight = isset($cartItemDetails->product_weight)?$cartItemDetails->product_weight:0;
                    $is_already_added->save();
                    $cartItemDetails->delete();
                }
                else
                {
                    $create_new = Wishlist::create(['customer_id'=>Auth::user()->id,'product_id'=>$cartItemDetails->product_id]);
                    if(isset($create_new) && count($create_new)>0)
                    {
                        $create_new->product_quantity = isset($request->count)?$request->count:1;
                        $create_new->product_color_name = isset($cartItemDetails->product_color_name)?$cartItemDetails->product_color_name:'';
                        $create_new->product_amount = isset($cartItemDetails->product_amount)?$cartItemDetails->product_amount:0;
                        $create_new->product_size_name = isset($cartItemDetails->product_size_name)?$cartItemDetails->product_size_name:'';
                        $create_new->product_weight = isset($cartItemDetails->product_weight)?$cartItemDetails->product_weight:0;
                        $create_new->save();
                        $cartItemDetails->delete();
                    }
                }
                $cart = Cart::find($cartId);
                if(isset($cart) && count($cart))
                {
                    $totalAmt = $this->getCartTotalAmt($request);
                    if(Session::has('all_cart_data'))
                    {

                        if(Session::get('all_cart_data.coupon_code')!='' && Session::get('all_cart_data.coupon_amount') !=0)
                        {
                            $couponCode = Session::get('all_cart_data.coupon_code');
                            $couponObj = Coupon::where('coupon_code',$couponCode)->where('code_type','0')->where('user_type',Auth::user()->userInformation->user_type)->first();
                            if(isset($couponObj) && count($couponObj)>0){
                                if($totalAmt < $couponObj->min_purchase_amt)
                                {
                                    Session::put('all_cart_data.coupon_code','');
                                    Session::put('all_cart_data.coupon_amount',0);
                                    Session::save();
                                }
                            }
                        }
                        if(Session::get('all_cart_data.promo_code')!='' && Session::get('all_cart_data.promo_amount') !=0)
                        {
                            $promoCode = Session::get('all_cart_data.promo_code');
                            $promoObj = Coupon::where('coupon_code',$promoCode)->where('code_type','1')->where('user_type',Auth::user()->userInformation->user_type)->first();
                            if(isset($promoObj) && count($promoObj)>0){
                                if($totalAmt < $promoObj->min_purchase_amt){
                                    Session::put('all_cart_data.promo_code','');
                                    Session::put('all_cart_data.promo_amount',0);
                                    Session::save();
                                }
                            }
                        }
                    }
                }
                if (isset($cart) && count($cart)>0)
                {
                    if(count($cart->cartItems)>0)
                    {
                        foreach ($cart->cartItems as $items)
                        {
                            $all_products = Product::find($items->product_id);
                            if (isset($all_products) && count($all_products) > 0)
                            {
                                $totalAmount += $items->product_amount * $items->product_quantity;
                                $totalCount += $items->product_quantity;
                            }
                        }
                    }
                }
                if(Session::has('all_cart_data'))
                {
                    $sessionData =Session::get('all_cart_data');
                    $totalSavings = $this->calTotalSavings($sessionData);
                    Session::put('all_cart_data.total_savings',$totalSavings);
                    Session::save();
                }
                $data['total_amount']=Helper::getRealPrice($totalAmount);
                $data['total_count']=$totalCount;
                $data['coupon_amount']= Helper::getRealPrice(Session::get('all_cart_data.coupon_amount'));
                $data['promo_amount']= Helper::getRealPrice(Session::get('all_cart_data.promo_amount'));
                $data['total_savings'] =Helper::getRealPrice($totalSavings);
                $data['currency'] =Helper::getCurrencySymbol();
                $data['grand_total']=Helper::getRealPrice($this->calTotalCredit($cart,$totalAmt)-$totalSavings);
                echo json_encode(array("success" => '1', 'msg' => "Added in wishlist",'arr'=>$data));
                exit();
            }
            else{
                echo json_encode(array("success" => '0', 'msg' => "Something Went Wrong"));
                exit();
            }
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Please login to add items in wishlist"));
            exit();
        }

    }
    public function validateShippingPincode(Request $request)
    {

        if($request->country !='' && $request->pin_code !=''){
            $countryTrans = CountryTranslation::where('country_id',$request->country)->first();
            if(isset($countryTrans) && count($countryTrans)>0){
                $data = array();
                $data['country_code']=$countryTrans->iso_code;
                $data['pin_code']=$countryTrans->pin_code;
                $rateRequestObj = new RateRequestController();
                $getData =$rateRequestObj->rateNationalRequest($data);
                echo json_encode(array("success" => '0', 'msg' => $getData));
                exit();
            }

        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Please select country or enter pincode"));
            exit();
        }

    }

    public function removeCartItems(Request $request)
    {
        $totalAmt =0;
        $couponCode = '';
        $promoCode = '';
        $totalAmount=0.00;
        $totalWeight=0.00;
        $cart_item = CartItem::find($request->cart_item_id);
        $totalCount =0;
        //dd($cart_item);
        if(isset($cart_item) && count($cart_item)>0){
            $cartItemCartId =$cart_item->cart_id;
            $cart_item->delete();
            $cart = Cart::find($cartItemCartId);
//            dd($cart);
            if(isset($cart) && count($cart)>0)
            {
                $totalAmt = $this->getCartTotalAmt($request);
//                dd($totalAmt);
                if(Auth::check())
                {
                    if(Session::has('all_cart_data'))
                    {

                        if(Session::get('all_cart_data.coupon_code')!='' && Session::get('all_cart_data.coupon_amount') !=0){
                            $couponCode = Session::get('all_cart_data.coupon_code');
                            $couponObj = Coupon::where('coupon_code',$couponCode)->where('code_type','0')->where('user_type',Auth::user()->userInformation->user_type)->first();
                            if(count($couponObj)>0){
                                 if($totalAmt < $couponObj->min_purchase_amt){
                                     Session::put('all_cart_data.coupon_code','');
                                     Session::put('all_cart_data.coupon_amount',0);
                                     Session::save();
                                 }
                            }
                        }
                        if(Session::get('all_cart_data.promo_code')!='' && Session::get('all_cart_data.promo_amount') !=0){
                            $promoCode = Session::get('all_cart_data.promo_code');
                            $promoObj = Coupon::where('coupon_code',$promoCode)->where('code_type','1')->where('user_type',Auth::user()->userInformation->user_type)->first();
                            if(count($promoObj)>0){
                                if($totalAmt < $promoObj->min_purchase_amt){
                                    Session::put('all_cart_data.promo_code','');
                                    Session::put('all_cart_data.promo_amount',0);
                                    Session::save();
                                }
                            }
                        }
                    }
                }
                $ckCartItems = CartItem::where('cart_id',$cartItemCartId)->first();
                if(!$ckCartItems)
                {
                    $cart->shipping_charge =0;
                    $cart->tax =0;
                    $cart->box_id =null;
                    $cart->paper_id =null;
                    $cart->display_id =null;
                    $cart->box_amount =0;
                    $cart->paper_amount =0;
                    $cart->display_amount =0;
                    $cart->coupon_amount =0;
                    $cart->promo_amount =0;
                    $cart->shipping_charge =0;
                    $cart->box_weight =0;
                    $cart->display_weight =0;
                    $cart->tax =0;
                    $cart->save();
                    if (Session::has('service_details'))
                    {
                        Session::forget('service_details');
                        Session::save();
                    }
                }
                if (isset($cart) && count($cart)>0)
                    {
                        foreach ($cart->cartItems as $items) {
                            $all_products = Product::find($items->product_id);
                            if (isset($all_products) && count($all_products) > 0) {
                                $totalAmount += $items->product_amount * $items->product_quantity;
                                $totalCount += $items->product_quantity;
                                $totalWeight += $items->product_weight;
                            }
                        }
                    }
                    if($cart->box_weight !='')
                    {
                        $totalWeight +=$cart->box_weight;
                    }
                    if($cart->display_weight !='')
                    {
                        $totalWeight +=$cart->display_weight;
                    }
            }
            if(Session::has('all_cart_data'))
            {
                $sessionData =Session::get('all_cart_data');
                $totalSavings = $this->calTotalSavings($sessionData);
                Session::get('all_cart_data.total_savings',$totalSavings);
                Session::save();
            }
            $data['total_amount']=Helper::getRealPrice($totalAmount);
            $data['total_count']=$totalCount;
            $data['coupon_amount']= Helper::getRealPrice(Session::get('all_cart_data.coupon_amount'));
            $data['promo_amount']= Helper::getRealPrice(Session::get('all_cart_data.promo_amount'));
            $data['total_savings'] =Helper::getRealPrice($totalSavings);
            $data['currency'] =Helper::getCurrencySymbol();
            $data['grand_total']=Helper::getRealPrice($this->calTotalCredit($cart,$totalAmt)-$totalSavings);
            echo json_encode(array("success" => '1', 'msg' => "Cart Item Removed Successfully",'arr'=>$data));
            exit();
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Cart Item could not found"));
            exit();
        }

    }

    public function viewShippingCheckOut()
    {
        $customer_address = UserAddress::where('user_id', Auth::user()->id)->where('default_address', 1)->first();
        $states = State::all();
        return view('cart::shipping-check-out', ['address' => $customer_address, 'states' => $states]);
    }

    public function viewPaymentCheckOut(Request $request)
    {
        $data = $request->all();
        $states = State::all();
        $validate_response = Validator::make($data, array(
                    'last_name' => 'required',
                    'first_name' => 'required',
                    'street' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip_code' => 'required|between:1,999999',
        ));
//dd(1111);
        if ($validate_response->fails()) {
            return redirect()->back()
                            ->withErrors($validate_response)
                            ->withInput();
        } else {
//            dd($request->all());
            if ($request->address_id) {//checking customer add a single shipping address already
                $address = UserAddress::find($request->address_id);
                if (!($address->first_name == $request->first_name && $address->last_name == $request->last_name && $address->apartment == $request->apt && $address->street == $request->street && $address->user_state == $request->state && $address->user_city == $request->business_city && $address->zipcode == $request->zip_code)) {
                    //its updating the existing address
                    $new_address = new UserAddress();

                    if ($request->default_address) {
                        $new_address->default_address = $new_address->default_address = '1';
                        $address->default_address = '0';
                    }

                    $new_address->user_id = Auth::user()->id;
                    $new_address->first_name = $request->first_name;
                    $new_address->last_name = $request->last_name;
                    $new_address->street = $request->street;
                    $new_address->apartment = $request->apt;
                    $new_address->user_city = $request->business_city;
                    $new_address->user_state = $request->state;
                    $new_address->zipcode = $request->zip_code;

                    $new_address->save();
                    $address->save();
                }
            } else {
                if ($request->default_address) {
                    $new_address = new UserAddress();

                    $new_address->default_address = $new_address->default_address = '1';
                    $new_address->user_id = Auth::user()->id;
                    $new_address->first_name = $request->first_name;
                    $new_address->last_name = $request->last_name;
                    $new_address->street = $request->street;
                    $new_address->apartment = $request->apt;
                    $new_address->user_city = $request->business_city;
                    $new_address->user_state = $request->state;
                    $new_address->zipcode = $request->zip_code;

                    $new_address->save();
                }
            }

            $order = Order::where('customer_id', Auth::user()->id)->where('is_temp', 1)->first();
            if (!$order) {
                $order = new Order();
            }
            $order->customer_id = Auth::user()->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->apartment = $request->apt;
            $order->shipping_address_1 = $request->street;
            $order->shipping_city = $request->business_city;
            $order->shipping_state = $request->state;
            $order->shipping_zip = $request->zip_code;

            $order->save();



            $payment = CustomerPayment::where('customer_id', Auth::user()->id)->where('default_payment', 1)->first();

            return view('cart::payment-check-out', ['payment' => $payment, 'order' => $order, 'states' => $states]);
        }
    }

    public function viewReviewCheckOut(Request $request)
    {
        $data = $request->all();

        if ($request->method() == "POST") {
            $validate_response = Validator::make($data, array(
                        'last_name' => 'required',
                        'first_name' => 'required',
                        'street' => 'required',
                        'city' => 'required',
                        'state' => 'required',
                        'zip_code' => 'required_if:sampleRadio,1|between:1,999999',
                        'new_last_name' => 'required_if:sampleRadio,1',
                        'new_first_name' => 'required_if:sampleRadio,1',
                        'new_street' => 'required_if:sampleRadio,1',
                        'new_city' => 'required_if:sampleRadio,1',
                        'new_state' => 'required_if:sampleRadio,1',
                        'name' => 'required',
                        'cvv' => 'required|numeric|between:1,999',
                        'card_number' => 'required|numeric',
                        'year' => 'required',
                        'month' => 'required',
            ));
//dd(1111);
            if ($validate_response->fails()) {
                return redirect()->back()
                                ->withErrors($validate_response)
                                ->withInput();
            } else {

                $order = Order::where('customer_id', Auth::user()->id)->where('is_temp', 1)->first();
                if (!$order) {
                    $order = new Order();
                }
                //adding payment info to order table
                $order->billing_card_number = $request->card_number;
                $order->billing_name = $request->name;
                $order->billing_cvv = $request->cvv;
                $order->billing_year = $request->year;
                $order->billing_month = $request->month;
                $order->billing_card_token = Session::get('token');

                if ($request->sampleRadio) {//checking is it new information?
                    $order->first_name = $request->new_first_name;
                    $order->last_name = $request->new_last_name;
                    $order->apartment = $request->new_apt;
                    $order->shipping_address_1 = $request->new_street;
                    $order->shipping_city = $request->new_business_city;
                    $order->shipping_state = $request->new_state;
                    $order->shipping_zip = $request->zip_code;

                    if ($order->default_address) {//checking is it set to default?
                        $address = UserAddress::where('user_id', Auth::user()->id)->where('default_address', 1)->first();
                        $address->default_address = '0';
                        $address->save();


                        $address = new UserAddress(); //create new default address

                        $order->first_name = $request->new_first_name;
                        $order->last_name = $request->new_last_name;
                        $order->apartment = $request->new_apt;
                        $order->street = $request->new_street;
                        $order->user_city = $request->new_business_city;
                        $order->user_state = $request->new_state;
                        $order->zipcode = $request->zip_code;
                        $order->default_address = '1';
                    }
                } else {//use shipping information
                    $order->first_name = $request->first_name;
                    $order->last_name = $request->last_name;
                    $order->apartment = $request->apt;
                    $order->shipping_address_1 = $request->street;
                    $order->shipping_city = $request->business_city;
                    $order->shipping_state = $request->state;
                    $order->shipping_zip = $request->zip_code;
                    $order->billing_address_1 = $request->street;
                    $order->billing_city = $request->business_city;
                    $order->billing_state = $request->state;
                    $order->billing_zip = $request->zip_code;
                }

                $order->save();

                $states = State::all();

                $vendor_id = [];
                $cart = Auth::user()->cart;
                if ($cart) {
                    foreach ($cart->cartItems as $products) {
                        if (!in_array($products->product->created_by, $vendor_id))
                            $vendor_id[] = $products->product->created_by;
                    }
                }

                return view('cart::review-check-out', ['order' => $order, 'states' => $states, 'vendor_ids' => $vendor_id, 'cart' => $cart]);
            }
        }
        else {
            $states = State::all();

            $vendor_id = [];
            $cart = Auth::user()->cart;
            if ($cart) {
                foreach ($cart->cartItems as $products) {
                    if (!in_array($products->product->created_by, $vendor_id))
                        $vendor_id[] = $products->product->created_by;
                }
            }

            $order = Order::where('customer_id', Auth::user()->id)->where('is_temp', 1)->first();
            return view('cart::review-check-out', ['order' => $order, 'states' => $states, 'vendor_ids' => $vendor_id, 'cart' => $cart]);
        }
    }

//    public function checkCard(Request $request) {
//        $stripe = new Stripe();
//        $error = '';
//
//        try {
//            $card_token = $stripe::tokens()->create(array(
//                "card" => array(
//                    "number" => $request->card_number,
//                    "exp_month" => $request->month,
//                    "exp_year" => $request->year,
//                    "cvc" => $request->cvv
//                )
//            ));
//            $arr_return = array('res' => '1', 'msg' => "Success");
//            Session::put('token', $card_token['id']);
//            Session::save();
//        } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
//            $arr_return = array('res' => '0', 'msg' => $e->getMessage());
//            // Invalid parameters were supplied to Stripe's API
//        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
//            $arr_return = array('res' => '0', 'msg' => $e->getMessage());
//            // Invalid parameters were supplied to Stripe's API
//        } catch (\Cartalyst\Stripe\Exception\UnauthorizedException $e) {
//            $arr_return = array('res' => '0', 'msg' => $e->getMessage());
//        } catch (\Cartalyst\Stripe\Exception\ApiLimitExceededException $e) {
//            $arr_return = array('res' => '0', 'msg' => $e->getMessage());
//        } catch (\Cartalyst\Stripe\Exception\StripeException $e) {
//            $arr_return = array('res' => '0', 'msg' => $e->getMessage());
//        } catch (Exception $e) {
//            $arr_return = array('res' => '0', 'msg' => $e->getMessage());
//        }
//        return response()->json($arr_return);
//    }

    public function changePaymentInfo(Request $request)
    {
        $data = $request->all();
        $validate_response = Validator::make($data, array(
                    'name' => 'required',
                    'cvv' => 'required|numeric|between:1,999',
                    'card_number' => 'required|numeric',
                    'year' => 'required',
                    'month' => 'required',
        ));
        if ($validate_response->fails()) {
            return redirect()->back()
                            ->withErrors($validate_response)
                            ->withInput();
        } else {

            $order = Order::where('customer_id', Auth::user()->id)->where('is_temp', 1)->first();
            if (!$order) {
                $order = new Order();
            }

            $order->billing_name = $request->name;
            $order->billing_card_number = $request->card_number;
            $order->billing_month = $request->month;
            $order->billing_year = $request->year;
            $order->billing_cvv = $request->cvv;
            $order->billing_card_token = Session::get('token');

            $order->save();
            $states = State::all();

            $vendor_id = [];
            $cart = Auth::user()->cart;
            if ($cart) {
                foreach ($cart->cartItems as $products) {
                    if (!in_array($products->product->created_by, $vendor_id))
                        $vendor_id[] = $products->product->created_by;
                }
            }

            return view('cart::review-check-out', ['order' => $order, 'states' => $states, 'vendor_ids' => $vendor_id, 'cart' => $cart]);
        }
    }

    public function setCustomerZipcode(Request $request) {
        $order = Order::where('customer_id', Auth::user()->id)->get();
        $order = $order->last();
        $order->shipping_zip = $request->zip;
        $order->save();
    }

    public function replaceCoupon($arr_coupon) {

        $arr_new_session = Session::get('coupon_code');
        $flag = 1;


        for ($i = 0; $i < count($arr_new_session); $i++) {
            $ids[] = $arr_new_session[$i][1];
        }
        if (in_array($arr_coupon[1], $ids)) {
            for ($i = 0; $i < count($arr_new_session); $i++) {
                if ($arr_new_session[$i][1] == $arr_coupon[1]) {
                    $arr_new_session[$i] = $arr_coupon;
                }
            }
        } else {
            $flag = 2;
        }
        Session::forget('coupon_code');
        Session::save();

        if ($flag == 2) {
            $arr_new_session[] = $arr_coupon;
        }
        Session::put('coupon_code', $arr_new_session);
        Session::save();
    }

    public function removeCouponFromCart(Request $request)
    {
        $totlSavings =0;
        if (Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }

            $sessionData = Session::get('all_cart_data');
            $sessionData['coupon_amount']=0;
            $sessionData['coupon_code']= '';
            $totalSavings = $this->calTotalSavings($sessionData);
            $sessionData['total_savings']=$totalSavings;
            Session::put('all_cart_data',$sessionData);
            Session::save();

            $finalSessionData =Session::get('all_cart_data');

        $totlAmt = $this->getCartTotalAmt($request);
        if(Session::has('all_cart_data.total_savings'))
        {
            $totlSavings = Session::get('all_cart_data.total_savings');
        }
        $finalSessionData['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,',','');
        $finalSessionData['currency']=Helper::getCurrencySymbol();

            echo json_encode(array("success" => '1', 'msg' => "Coupon code has removed successfully",'arr'=>$finalSessionData));
            exit();
    }

    public function removePromoCodeFromCart(Request $request)
    {
        $totlSavings =0.00;
        if (Auth::check()) {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }

        $sessionData = Session::get('all_cart_data');
        $sessionData['promo_amount']= 0.00;
        $sessionData['promo_code']= '';
        $totalSavings = $this->calTotalSavings($sessionData);
        $sessionData['total_savings']=$totalSavings;
        Session::put('all_cart_data',$sessionData);
        Session::save();
        $finalSessionData =Session::get('all_cart_data');

        $totlAmt = $this->getCartTotalAmt($request);
        if(Session::has('all_cart_data.total_savings'))
        {
            $totlSavings = Session::get('all_cart_data.total_savings');
        }
        $finalSessionData['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
        $finalSessionData['currency']=Helper::getCurrencySymbol();
        echo json_encode(array("success" => '1', 'msg' => "Promo code has removed successfully",'arr'=>$finalSessionData));
        exit();
    }

    public function removeBoxFromCart(Request $request)
    {
        $arr = [];
        if (Auth::check()) {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if($cart){
            $cart->box_id = null;
            $cart->box_amount = 0.00;
            $cart->box_weight = 0;
            $cart->save();
            $totlSavings=0.00;
            $bx_amt =isset($cart->box_amount)?$cart->box_amount:0.00;
            $papr_amt =isset($cart->paper_amount)?$cart->paper_amount:0.00;
            $arr['box_amount']=number_format($bx_amt,2,'.','');
            $arr['paper_amount']=number_format(Helper::getRealPrice($papr_amt),2,'.','');
            $arr['currency']=Helper::getCurrencySymbol();
            $totlAmt = $this->getCartTotalAmt($request);
            if(Session::has('all_cart_data.total_savings'))
            {
                $totlSavings = Session::get('all_cart_data.total_savings');
            }
            $arr['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
        }
        echo json_encode(array("success" => '1', 'msg' => "Gift wrap box has removed successfully",'arr'=>$arr));
        exit();

    }
    public function removeGiftCardFromCart(Request $request)
    {
        $arr = [];
        if (Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if($cart)
        {
            $totlAmt =0;
            $totlAmt = $this->getCartTotalAmt($request);
            $totalCredit = $this->calTotalCredit($cart,$totlAmt);
            if(Session::has('all_cart_data'))
            {
                Session::put('all_cart_data.gift_voucher',0);
                Session::put('all_cart_data.user_gift_id',null);
                Session::save();
                $data = Session::get('all_cart_data');
                $totalSavings = $this->calTotalSavings($data);
                Session::put('all_cart_data.total_savings',$totalSavings);
                Session::save();
                $grandTotal =number_format(Helper::getRealPrice($totalCredit - $totalSavings),2,'.','');
                $arr['gift_voucher'] =0;
                $arr['currency'] =Helper::getCurrencySymbol();
                $arr['total_savings'] =number_format(Helper::getRealPrice($totalSavings),2,'.','');
            }
            $arr['grand_total']=$grandTotal;
            echo json_encode(array("success" => '1', 'msg' => "Gift Voucher has removed successfully",'arr'=>$arr));
            exit();
        }
        echo json_encode(array("success" => '0', 'msg' => "something went wrong",$arr));
        exit();

    }
    public function removePaperFromCart(Request $request)
    {
        $arr = [];
        if (Auth::check()) {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if($cart){
            $cart->paper_id = null;
            $cart->paper_amount = 0.00;
            $cart->save();
            $totlSavings=0.00;
            $box_amt = isset($cart->box_amount)?$cart->box_amount:0.00;
            $paper_amt = isset($cart->paper_amount)?$cart->paper_amount:0.00;
            $arr['box_amount']=isset($cart->paper_amount)?number_format(Helper::getRealPrice($box_amt),2,'.',''):0;
            $arr['paper_amount']=number_format($paper_amt,2,'.','');
            $arr['currency']=Helper::getCurrencySymbol();
            $totlAmt = $this->getCartTotalAmt($request);
            if(Session::has('all_cart_data.total_savings')){
                $totlSavings = Session::get('all_cart_data.total_savings');
            }
            $arr['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
            echo json_encode(array("success" => '1', 'msg' => "Gift wrap paper has removed successfully",'arr'=>$arr));
            exit();
        }
        echo json_encode(array("success" => '0', 'msg' => "Something went wrong",'arr'=>$arr));
        exit();
    }

    public function removeDisplayFromCart(Request $request)
    {
        $arr = [];
        if (Auth::check()) {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if($cart)
        {
            $cart->display_id = null;
            $cart->display_amount = 0.00;
            $cart->display_weight = 0;
            $cart->save();
            $totlSavings=0.00;
            $disp_amt =isset($cart->display_amount)?$cart->display_amount:0.00;
            $arr['display_amount']=$disp_amt;
            $arr['currency']=Helper::getCurrencySymbol();
            $totlAmt = $this->getCartTotalAmt($request);
            if(Session::has('all_cart_data.total_savings'))
            {
                $totlSavings = Session::get('all_cart_data.total_savings');
            }
            $arr['total_savings']=number_format(Helper::getRealPrice(Session::get('all_cart_data.total_savings')),2,'.','');
            $arr['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');

            echo json_encode(array("success" => '1', 'msg' => "Display item has removed successfully",'arr'=>$arr));
            exit();
        }
        echo json_encode(array("success" => '0', 'msg' => "Something went wrong",'arr'=>$arr));
        exit();
    }
    public function saveCouponDataToSession($code_type)
    {
        if($code_type == 0)
        {
            $sessionData = Session::get('all_cart_data');
            $sessionData['coupon_amount']=0.00;
            $sessionData['coupon_code']='';
            $totalSavings = $this->calTotalSavings($sessionData);
            $sessionData['total_savings']=$totalSavings;
            Session::put('all_cart_data',$sessionData);
            Session::save();
        }
        elseif ($code_type == 1)
        {
            $sessionData = Session::get('all_cart_data');
            $sessionData['promo_amount']=0.00;
            $sessionData['promo_code']='';
            $totalSavings = $this->calTotalSavings($sessionData);
            $sessionData['total_savings']=$totalSavings;
            Session::put('all_cart_data',$sessionData);
            Session::save();
        }
    }

    public function addCouponToCart(Request $request)
    {
        $sessionData = array();
        $finalSessionData=array();
        $product_count=0;
        $date = date('Y-m-d H:i:s');
        $coupon=null;
        $totalAmount = 0;
        $couponUserCnt = 0;
        $totlSavings=0.00;
        $coupon_code = $request->coupon_code;
        $code_type = $request->code_type;
        if($coupon_code!='' && $code_type !='')
        {
          $coupon = Coupon::where('coupon_code',$coupon_code)->where('code_type',$code_type)->where('status',1)->first();
          if(isset($coupon) && count($coupon)>0)
          {
              $AppliedCouponUser = AppliedCoupon::where('coupon_id',$coupon->id)->get();
              if(isset($AppliedCouponUser) && count($AppliedCouponUser)>0)
              {
                  $couponUserCnt =$AppliedCouponUser->count();
              }
              if($couponUserCnt >= $coupon->quantity)
              {
                        $this->saveCouponDataToSession($code_type);
//                  if($code_type == 0){
//                      $sessionData = Session::get('all_cart_data');
//                      $sessionData['coupon_amount']=0.00;
//                      $sessionData['coupon_code']='';
//                      $totalSavings = $this->calTotalSavings($sessionData);
//                      $sessionData['total_savings']=$totalSavings;
//                      Session::put('all_cart_data',$sessionData);
//                      Session::save();
//                  }
//                  elseif ($code_type == 1){
//                      $sessionData = Session::get('all_cart_data');
//                      $sessionData['promo_amount']=0.00;
//                      $sessionData['promo_code']='';
//                      $totalSavings = $this->calTotalSavings($sessionData);
//                      $sessionData['total_savings']=$totalSavings;
//                      Session::put('all_cart_data',$sessionData);
//                      Session::save();
//                  }
                  if (Auth::check())
                  {
                      $cart = Auth::user()->cart;
                  }
                  else
                  {
                      $cart=  Cart::where('ip_address',$request->ip())->first();
                  }
                  $finalSessionData =Session::get('all_cart_data');
                  $totlAmt = $this->getCartTotalAmt($request);
                  if(Session::has('all_cart_data.total_savings'))
                  {
                      $totlSavings = Session::get('all_cart_data.total_savings');
                  }

                  $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                  $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                  $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                  $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');

                      echo json_encode(array("success" => '0', 'msg' => "Invalid code",'arr'=>$finalSessionData));
                      exit();

              }
          }
          else{
//              if($code_type == 0){
//                  $sessionData = Session::get('all_cart_data');
//                  $sessionData['coupon_amount']=0.00;
//                  $sessionData['coupon_code']='';
//                  $totalSavings = $this->calTotalSavings($sessionData);
//                  $sessionData['total_savings']=$totalSavings;
//                  Session::put('all_cart_data',$sessionData);
//                  Session::save();
//              }
//              elseif ($code_type == 1){
//                  $sessionData = Session::get('all_cart_data');
//                  $sessionData['promo_amount']=0.00;
//                  $sessionData['promo_code']='';
//                  $totalSavings = $this->calTotalSavings($sessionData);
//                  $sessionData['total_savings']=$totalSavings;
//                  Session::put('all_cart_data',$sessionData);
//                  Session::save();
//              }
              $this->saveCouponDataToSession($code_type);
              $finalSessionData =Session::get('all_cart_data');

              if (Auth::check())
              {
                  $cart = Auth::user()->cart;
              }
              else
              {
                  $cart=  Cart::where('ip_address',$request->ip())->first();
              }
              $totlAmt = $this->getCartTotalAmt($request);
              if(Session::has('all_cart_data.total_savings')){
                  $totlSavings = Session::get('all_cart_data.total_savings');
              }
              $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
              $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
              $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
              $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
              echo json_encode(array("success" => '0', 'msg' => "Invalid Code",'arr'=>$finalSessionData));
              exit();
          }
         if(Auth::check())
                {
                    $cart = Cart::where('customer_id', Auth::user()->id)->first();
//            if($code_type == 0)
//            {
//                if(Session::get('all_cart_data.coupon_code') !='')
//                {
//                    $totlAmt = $this->getCartTotalAmt($request);
//                    if(Session::has('all_cart_data.total_savings')){
//                        $totlSavings = Session::get('all_cart_data.total_savings');
//                    }
//                    $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
//                    $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
//                    $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
//                    $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
//                    echo json_encode(array("success" => '0', 'msg' => "This code is already applied",'arr'=>$finalSessionData));
//                    exit();
//                }
//            }
//            else if($code_type == 1)
//            {
//                if(Session::get('all_cart_data.promo_code') !='')
//                {
//                    $totlAmt = $this->getCartTotalAmt($request);
//                    if(Session::has('all_cart_data.total_savings'))
//                    {
//                        $totlSavings = Session::get('all_cart_data.total_savings');
//                    }
//                    $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
//                    $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
//                    $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
//                    $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
//                    echo json_encode(array("success" => '0', 'msg' => "This code is already applied",'arr'=>$finalSessionData));
//                    exit();
//                }
//            }
                    if(isset($cart) && count($cart)>0 && $coupon != null)
                    {
                            foreach ($cart->cartItems as $items)
                            {
                                $all_products = Product::find($items->product_id);
                                if(isset($all_products) && count($all_products))
                                {
                                    $totalAmount += $items->product->productDescription->price * $items->product_quantity;
                                }
                            }

                        if($totalAmount < $coupon->min_purchase_amt)
                        {
                            $this->saveCouponDataToSession($code_type);
//                            if($code_type == 0){
//                                $sessionData = Session::get('all_cart_data');
//                                $sessionData['coupon_amount']=0.00;
//                                $sessionData['coupon_code']='';
//                                $totalSavings = $this->calTotalSavings($sessionData);
//                                $sessionData['total_savings']=$totalSavings;
//                                Session::put('all_cart_data',$sessionData);
//                                Session::save();
//                            }
//                            elseif ($code_type == 1){
//                                $sessionData = Session::get('all_cart_data');
//                                $sessionData['promo_amount']=0.00;
//                                $sessionData['promo_code']='';
//                                $totalSavings = $this->calTotalSavings($sessionData);
//                                $sessionData['total_savings']=$totalSavings;
//                                Session::put('all_cart_data',$sessionData);
//                                Session::save();
//                            }
                            $finalSessionData =Session::get('all_cart_data');

                            $totlAmt = $this->getCartTotalAmt($request);
                            if(Session::has('all_cart_data.total_savings'))
                            {
                                $totlSavings = Session::get('all_cart_data.total_savings');
                            }
                            $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                            $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                            $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                            $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
                            echo json_encode(array("success" => '0', 'msg' => "This Code is applicable for amount greater than ".Helper::getCurrencySymbol().number_format(Helper::getRealPrice($coupon->min_purchase_amt),2,'.',''),'arr'=>$finalSessionData));
                            exit();
                        }
                        $chkCouponUseStatus =$coupon->chkCouponUsedStatus($coupon->id,Auth::user()->id);
                        if($chkCouponUseStatus == "0")
                        {
                            $chkDate =$coupon->validateCouponDate($coupon->id,$date);
                            if($chkDate == "1")
                            {
                                $userType = Auth::user()->userInformation->user_type;
                                $chkUserType =$coupon->validateCouponUserType($coupon_code,$userType);
                                if($chkUserType == "1")
                                {
                                    if($code_type == 0)
                                    {
                                        if($cart->coupon_amount == null)
                                        {
                                            $cart->coupon_amount = $coupon->amount;

                                        }
                                        $finalCouponAmt =$cart->coupon_amount;
                                        $cart->save();
                                        $sessionData = Session::get('all_cart_data');
                                        $sessionData['coupon_amount']=$finalCouponAmt;
                                        $sessionData['coupon_code']=$coupon->coupon_code;
                                        $totalSavings = $this->calTotalSavings($sessionData);
                                        $sessionData['total_savings']=$totalSavings;
                                        $totlAmt = $this->getCartTotalAmt($request);
                                        $gndTot =$this->calTotalCredit($cart,$totlAmt)-$totalSavings;
                                        if($gndTot <= 0)
                                        {
//                                            $sessionData = Session::get('all_cart_data');
//                                            $sessionData['coupon_amount']=0.00;
//                                            $sessionData['coupon_code']='';
//                                            $totalSavings = $this->calTotalSavings($sessionData);
//                                            $sessionData['total_savings']=$totalSavings;
//                                            Session::put('all_cart_data',$sessionData);
//                                            Session::save();
                                            $this->saveCouponDataToSession($code_type);
                                            $finalSessionData =Session::get('all_cart_data');
                                            $totlAmt = $this->getCartTotalAmt($request);
                                            if(Session::has('all_cart_data.total_savings')){
                                                $totlSavings = Session::get('all_cart_data.total_savings');
                                            }
                                            $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                            $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                            $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                            $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
                                            echo json_encode(array("success" => '0', 'msg' => "This Code is applicable for amount greater than".$coupon->min_purchase_amt,'arr'=>$finalSessionData));
                                            exit();
                                        }
                                        else
                                        {
                                            Session::put('all_cart_data',$sessionData);
                                            Session::save();
                                        }
                                    }
                                    else{
                                        if($cart->promo_amount == null)
                                        {
                                            $cart->promo_amount = $coupon->amount;
                                        }
                                        $finalCouponAmt =$cart->promo_amount;
                                        $cart->save();
                                        $sessionData = Session::get('all_cart_data');
                                        $sessionData['promo_amount']=$finalCouponAmt;
                                        $sessionData['promo_code']=$coupon->coupon_code;
                                        $totalSavings = $this->calTotalSavings($sessionData);
                                        $sessionData['total_savings']=$totalSavings;
                                        $totlAmt = $this->getCartTotalAmt($request);
                                        $gndTot =$this->calTotalCredit($cart,$totlAmt)-$totalSavings;
                                        if($gndTot <= 0){
//                                            $sessionData = Session::get('all_cart_data');
//                                            $sessionData['promo_amount']=0.00;
//                                            $sessionData['coupon_code']='';
//                                            $totalSavings = $this->calTotalSavings($sessionData);
//                                            $sessionData['total_savings']=$totalSavings;
//                                            Session::put('all_cart_data',$sessionData);
//                                            Session::save();
                                            $this->saveCouponDataToSession($code_type);
                                            $finalSessionData =Session::get('all_cart_data');

                                            $totlAmt = $this->getCartTotalAmt($request);
                                            if(Session::has('all_cart_data.total_savings')){
                                                $totlSavings = Session::get('all_cart_data.total_savings');
                                            }
                                            $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                            $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                            $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                            $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
                                            echo json_encode(array("success" => '0', 'msg' => "This Code is applicable for amount greater than ".Helper::getCurrencySymbol().number_format(Helper::getRealPrice($coupon->min_purchase_amt),2,'.',''),'arr'=>$finalSessionData));
                                            exit();
                                        }
                                        else{
                                            Session::put('all_cart_data',$sessionData);
                                            Session::save();
                                        }

                                    }
                                    $finalSessionData =Session::get('all_cart_data');
                                    $totlAmt = $this->getCartTotalAmt($request);
                                    if(Session::has('all_cart_data.total_savings')){
                                        $totlSavings = Session::get('all_cart_data.total_savings');
                                    }
                                    $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                    $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                    $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                    $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');

                                    echo json_encode(array("success" => '1', 'msg' => "Code Applied Successfull",'arr'=>$finalSessionData));
                                    exit();
                                }
                                else{
                                    $this->saveCouponDataToSession($code_type);
//                                    if($code_type == 0){
//                                        $sessionData = Session::get('all_cart_data');
//                                        $sessionData['coupon_amount']=0.00;
//                                        $sessionData['coupon_code']='';
//                                        $totalSavings = $this->calTotalSavings($sessionData);
//                                        $sessionData['total_savings']=$totalSavings;
//                                        Session::put('all_cart_data',$sessionData);
//                                        Session::save();
//                                    }
//                                    elseif ($code_type == 1){
//                                        $sessionData = Session::get('all_cart_data');
//                                        $sessionData['promo_amount']=0.00;
//                                        $sessionData['promo_code']='';
//                                        $totalSavings = $this->calTotalSavings($sessionData);
//                                        $sessionData['total_savings']=$totalSavings;
//                                        Session::put('all_cart_data',$sessionData);
//                                        Session::save();
//                                    }

                                    $finalSessionData =Session::get('all_cart_data');
                                    $totlAmt = $this->getCartTotalAmt($request);
                                    if(Session::has('all_cart_data.total_savings')){
                                        $totlSavings = Session::get('all_cart_data.total_savings');
                                    }
                                    $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                    $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                    $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                    $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');

                                    echo json_encode(array("success" => '0', 'msg' => "Invalid Code",'arr'=>$finalSessionData));
                                    exit();
                                }
                            }
                            else
                            {
                                $this->saveCouponDataToSession($code_type);
//                                if($code_type == 0){
//                                    $sessionData = Session::get('all_cart_data');
//                                    $sessionData['coupon_amount']=0.00;
//                                    $sessionData['coupon_code']='';
//                                    $totalSavings = $this->calTotalSavings($sessionData);
//                                    $sessionData['total_savings']=$totalSavings;
//                                    Session::put('all_cart_data',$sessionData);
//                                    Session::save();
//                                }
//                                elseif ($code_type == 1){
//                                    $sessionData = Session::get('all_cart_data');
//                                    $sessionData['promo_amount']=0.00;
//                                    $sessionData['promo_code']='';
//                                    $totalSavings = $this->calTotalSavings($sessionData);
//                                    $sessionData['total_savings']=$totalSavings;
//                                    Session::put('all_cart_data',$sessionData);
//                                    Session::save();
//                                }
                                $finalSessionData =Session::get('all_cart_data');

                                $totlAmt = $this->getCartTotalAmt($request);
                                if(Session::has('all_cart_data.total_savings')){
                                    $totlSavings = Session::get('all_cart_data.total_savings');
                                }
                                $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                                $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
                                echo json_encode(array("success" => '0', 'msg' => "Invalid code",'arr'=>$finalSessionData));
                                exit();
                            }
                        }
                        else{
                            $this->saveCouponDataToSession($code_type);
//                            if($code_type == 0){
//                                $sessionData = Session::get('all_cart_data');
//                                $sessionData['coupon_amount']=0.00;
//                                $sessionData['coupon_code']='';
//                                $totalSavings = $this->calTotalSavings($sessionData);
//                                $sessionData['total_savings']=$totalSavings;
//                                Session::put('all_cart_data',$sessionData);
//                                Session::save();
//                            }
//                            elseif ($code_type == 1){
//                                $sessionData = Session::get('all_cart_data');
//                                $sessionData['promo_amount']=0.00;
//                                $sessionData['promo_code']='';
//                                $totalSavings = $this->calTotalSavings($sessionData);
//                                $sessionData['total_savings']=$totalSavings;
//                                Session::put('all_cart_data',$sessionData);
//                                Session::save();
//                            }
                            $finalSessionData =Session::get('all_cart_data');
                            $totlAmt = $this->getCartTotalAmt($request);
                            if(Session::has('all_cart_data.total_savings'))
                            {
                                $totlSavings = Session::get('all_cart_data.total_savings');
                            }
                            $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                            $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                            $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                            $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
                            echo json_encode(array("success" => '0', 'msg' => "This Coupon is Already used",'arr'=>$finalSessionData));
                            exit();
                        }
                    }
                }
                else{
                    $this->saveCouponDataToSession($code_type);
//                    if($code_type == 0){
//                        $sessionData = Session::get('all_cart_data');
//                        $sessionData['coupon_amount']=0.00;
//                        $sessionData['coupon_code']='';
//                        $totalSavings = $this->calTotalSavings($sessionData);
//                        $sessionData['total_savings']=$totalSavings;
//                        Session::put('all_cart_data',$sessionData);
//                        Session::save();
//                    }
//                    elseif ($code_type == 1){
//                        $sessionData = Session::get('all_cart_data');
//                        $sessionData['promo_amount']=0.00;
//                        $sessionData['promo_code']='';
//                        $totalSavings = $this->calTotalSavings($sessionData);
//                        $sessionData['total_savings']=$totalSavings;
//                        Session::put('all_cart_data',$sessionData);
//                        Session::save();
//                    }
                    $finalSessionData =Session::get('all_cart_data');

                    if (Auth::check()) {
                        $cart = Auth::user()->cart;
                    }
                    else
                    {
                        $cart=  Cart::where('ip_address',$request->ip())->first();
                    }

                    $totlAmt = $this->getCartTotalAmt($request);
                    if(Session::has('all_cart_data.total_savings'))
                    {
                        $totlSavings = Session::get('all_cart_data.total_savings');
                    }
                    $finalSessionData['total_savings']= (isset($finalSessionData['total_savings']) && $finalSessionData['total_savings']>0)?Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['total_savings']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                    $finalSessionData['coupon_amount']=$finalSessionData['coupon_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['coupon_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                    $finalSessionData['promo_amount']=$finalSessionData['promo_amount']>0? Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalSessionData['promo_amount']),2,'.',''):Helper::getCurrencySymbol().'0.00';
                    $finalSessionData['grand_total']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
                    echo json_encode(array("success" => '0', 'msg' => "Invalid code",'arr'=>$finalSessionData));
                    exit();
                }
        }
        else{
            if(Session::has('all_cart_data'))
            {
                $finalSessionData =Session::get('all_cart_data');
                $finalSessionData['coupon_amount'] =number_format($finalSessionData['coupon_amount'],2,'.','');
                $finalSessionData['promo_amount'] =number_format($finalSessionData['promo_amount'],2,'.','');
                if($finalSessionData['total_savings'] == 0)
                {
                    $finalSessionData['total_savings'] =number_format($finalSessionData['total_savings'],2,'.','');
                }
                $finalSessionData['currency'] =Helper::getCurrencySymbol();
            }
            echo json_encode(array("success" => '0', 'msg' => "Please enter code",'arr'=>$finalSessionData));
            exit();
        }
    }

    public function addGiftCardToCart(Request $request)
    {
        $totalAmount=0;
        $totalCredit=0;
        $totalSavings=0;
        $grandTotal=0;
        $data = array();
        $arr = [];
        if( $request->gift_code !='')
        {
            if(Auth::check())
            {
                $cart = Auth::user()->cart;

                if(isset($cart) && count($cart)>0)
                {
                  $chkUserGiftCards =UserGiftCard::where('gift_card_code',$request->gift_code)->first();
                  if(isset($chkUserGiftCards) && count($chkUserGiftCards)>0)
                  {
                      $totalAmount = $this->getCartTotalAmt($request);
                      $totalCredit = $this->calTotalCredit($cart,$totalAmount);
                      if(Session::has('all_cart_data'))
                      {
                          $data = Session::get('all_cart_data');
                      }
                      $totalSavings = $this->calTotalSavings($data);
                      $grandTotal =$totalCredit - $totalSavings;
                      if($chkUserGiftCards->remaining_price >0)
                      {
//                          if($chkUserGiftCards->remaining_price >= )
                          if($chkUserGiftCards->remaining_price >= $grandTotal)
                          {
                              Session::put('all_cart_data.gift_voucher',$grandTotal);
                              Session::save();
                          }
                          else
                          {
//                              $remAmt = $grandTotal-$chkUserGiftCards->remaining_price;
                              Session::put('all_cart_data.gift_voucher', $chkUserGiftCards->remaining_price);
                              Session::save();
                          }
                              Session::put('all_cart_data.user_gift_id',$chkUserGiftCards->id);
                              Session::save();
                              $data = Session::get('all_cart_data');
                              $totalSavings = $this->calTotalSavings($data);
                              Session::put('all_cart_data.total_savings',$totalSavings);
                              Session::save();
                              $arr['grand_total'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($totalCredit - $totalSavings),2,'.','');
                              $arr['gift_voucher'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice(Session::get('all_cart_data.gift_voucher')),2,'.','');
                              $arr['total_savings'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice(Session::get('all_cart_data.total_savings')),2,'.','');
                              echo json_encode(array("success" => '1', 'msg' => "Gift voucher code removed successfully",'arr'=>$arr));
                              exit();
                          }
                      else{
                          if($chkUserGiftCards->price >= $grandTotal)
                          {
                              Session::put('all_cart_data.gift_voucher', $grandTotal);
                              Session::save();
                          }
                          else
                          {
//                              $remAmt = $grandTotal-$chkUserGiftCards->price;
                              Session::put('all_cart_data.gift_voucher', $chkUserGiftCards->price);
                              Session::save();
                          }
                              Session::put('all_cart_data.user_gift_id',$chkUserGiftCards->id);
                              Session::save();
                              $data = Session::get('all_cart_data');
                              $totalSavings = $this->calTotalSavings($data);
                              Session::put('all_cart_data.total_savings',$totalSavings);
                              Session::save();
                              $arr['grand_total'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($totalCredit - $totalSavings),2,'.','');
                              $arr['gift_voucher'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice(Session::get('all_cart_data.gift_voucher')),2,'.','');
                              $arr['total_savings'] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice(Session::get('all_cart_data.total_savings')),2,'.','');
                              echo json_encode(array("success" => '1', 'msg' => "Gift voucher code applied successfully",'arr'=>$arr));
                              exit();
                      }
                  }
                  else{
                      echo json_encode(array("success" => '0', 'msg' => "Invalid code"));
                      exit();
                  }
                }
            }
            else{
                echo json_encode(array("success" => '0', 'msg' => "Wrong cart Id"));
                exit();
            }
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Please enter code"));
            exit();
        }

    }


    public function addBoxToCart(Request $request,$boxId)
    {
        $box = Box::find($boxId);
        $arr =[];
        if(isset($box) && count($box)>0){
            if (Auth::check()) {
                $cart = Auth::user()->cart;
            }
            else
            {
                $cart=  Cart::where('ip_address',$request->ip())->first();
            }

            if($cart){
                $cart->box_id = $box->id;
                $cart->box_amount = $box->price;
                $cart->box_weight = $box->box_weight;
                $cart->save();
                $totlSavings=0.00;
                $bx_amt =isset($cart->box_amount)?$cart->box_amount:0.00;
                $papr_amt =isset($cart->paper_amount)?$cart->paper_amount:0.00;
                $arr['box_amount']=number_format(Helper::getRealPrice($bx_amt),2,'.','');
                $arr['paper_amount']=number_format(Helper::getRealPrice($papr_amt),2,'.','');
                $arr['currency']=Helper::getCurrencySymbol();
                $totlAmt = $this->getCartTotalAmt($request);
                if(Session::has('all_cart_data.total_savings')){
                    $totlSavings = Session::get('all_cart_data.total_savings');
                }
                $arr['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
            }

            echo json_encode(array("success" => '1', 'msg' => "Box Added Successfully",'arr'=>$arr));
            exit();
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Something went wrong"));
            exit();
        }
    }

    public function addPaperToCart(Request $request,$paperId)
    {
        $paper = Paper::find($paperId);
        $arr=[];
        if(isset($paper) && count($paper)>0){

            if (Auth::check()) {
                $cart = Auth::user()->cart;
            }
            else
            {
                $cart=  Cart::where('ip_address',$request->ip())->first();
            }
            if($cart){
                $cart->paper_id = $paper->id;
                $cart->paper_amount = $paper->price;
                $cart->save();
                $totlSavings=0.00;
                $bx_amt =isset($cart->box_amount)?$cart->box_amount:0.00;
                $papr_amt =isset($cart->paper_amount)?$cart->paper_amount:0.00;
                $arr['box_amount']=number_format(Helper::getRealPrice($bx_amt),2,'.','');
                $arr['paper_amount']=number_format(Helper::getRealPrice($papr_amt),2,'.','');
                $arr['currency']=Helper::getCurrencySymbol();
                $totlAmt = $this->getCartTotalAmt($request);
                if(Session::has('all_cart_data.total_savings')){
                    $totlSavings = Session::get('all_cart_data.total_savings');
                }
                $arr['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
            }

            echo json_encode(array("success" => '1', 'msg' => "Paper Added Successfully",'arr'=>$arr));
            exit();
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Something went wrong"));
            exit();
        }
    }
    public function addDisplayToCart(Request $request,$displayId)
    {
        $display = Display::find($displayId);
        $arr=[];
        if(isset($display) && count($display)>0)
        {

            if (Auth::check()) {
                $cart = Auth::user()->cart;
            }
            else
            {
                $cart=  Cart::where('ip_address',$request->ip())->first();
            }
            if($cart){
                $cart->display_id = $display->id;
                $cart->display_amount = $display->price;
                $cart->display_weight = $display->display_weight;
                $cart->save();
                $totlSavings=0.00;
                $dsply_amt=isset($cart->display_amount)?$cart->display_amount:0.00;
                $arr['display_amount']=number_format(Helper::getRealPrice($dsply_amt),2,'.','');
                $totlAmt = $this->getCartTotalAmt($request);
                if(Session::has('all_cart_data.total_savings')){
                    $totlSavings = Session::get('all_cart_data.total_savings');
                }
                $arr['currency']=Helper::getCurrencySymbol();
                $arr['grand_total']=number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totlAmt)-$totlSavings),2,'.','');
            }

            echo json_encode(array("success" => '1', 'msg' => "Display item Added Successfully",'arr'=>$arr));
            exit();
        }
        else{
            echo json_encode(array("success" => '0', 'msg' => "Something went wrong"));
            exit();
        }
    }



    public function checkoutFromCart(Request $request)
    {
//        dd($request->all());
         $option =$request->payment_val;
        if (Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        $orderArr = [];

        if(isset($cart) && $cart !='') {
            $flag = $this->checkoutAllCart($cart);
//            dd($flag);

            if(is_array($flag))
            {
//                dd($flag);
                $orderArr = $flag;
//                $cart = Cart::find($cart->id);
                if($cart)
                {
                    $cart->shipping_charge =0;
                    $cart->tax =0;
                    $cart->box_id =null;
                    $cart->paper_id =null;
                    $cart->display_id =null;
                    $cart->box_amount =0;
                    $cart->paper_amount =0;
                    $cart->display_amount =0;
                    $cart->coupon_amount =0;
                    $cart->promo_amount =0;
                    $cart->box_weight =0;
                    $cart->display_weight =0;
                    $cart->shipping_charge =0;
                    $cart->tax =0;
                    $cart->save();
                }
                if(Session::has('all_cart_data'))
                {
                    Session::forget('all_cart_data');
                    Session::save();
                }
                if(Session::has('usr_details'))
                {
                    Session::forget('usr_details');
                    Session::save();
                }

                if($option !='' && $option == 1)
                {
                    $orderData = Order::find($orderArr['order_id']);
                    if(isset($orderData) && count($orderData)>0)
                    {

                        if(Session::has('service_details'))
                        {
                            if(Session::get('service_details.service_provider') == 'DHL')
                            {
                                $orderData->shipping_service_estimated_days =Session::get('service_details.service_estimated_days');
                            }
                            $orderData->shipping_service_name =Session::get('service_details.service_name');
                            $orderData->shipping_service_provider =Session::get('service_details.service_provider');
                            $orderData->shipping_service_price =Session::get('service_details.service_price');
                            $orderData->shipping_service_date =Session::get('service_details.service_time');
                            $orderData->shipping_service_type =Session::get('service_details.service_type');
                            $orderData->shipping_total_weight =Session::get('service_details.service_total_weight');
                            $orderData->save();
                            Session::forget('service_details');
                            Session::save();
                         }
                         $createShipObj =new CreateShipController();
                         $status = $createShipObj->shipCodOrder($orderData);
                         if($status == '1')
                         {
                             return redirect('/order-confirmation');
                         }
                         else
                             {
                                 return redirect('/cart')->with('cart-err','Could not complete COD process');
                             }
                    }
                     return redirect('/order-confirmation');
                }
                elseif($option !='' && $option == 0)
                {
                    //dd(123);
                    $tid = time();
                    $order_id = isset($orderArr['order_id'])?$orderArr['order_id']:time();
                    $order_amount = $orderArr['grand_total'];
                    $parameters = [
                        'tid' => $tid,
                        'order_id' => $order_id,
                        'amount' => $order_amount,
                        'currency' => 'INR'
                    ];
                    $order = Indipay::gateway('ccavenue')->prepare($parameters);
                    return Indipay::process($order);
                }
            }
            else
            {
                return redirect()->back();
            }
        }
    }
    public function calCartTotalLBH($cart)
    {
        $len=0;
        $width =0;
        $height =0;
        $arr = array();

        foreach ($cart->cartItems as $item)
        {
            $proLen = ProductAttribute::where('product_id',$item->product_id)->where('attribute_id',37)->first();
            $proWidth = ProductAttribute::where('product_id',$item->product_id)->where('attribute_id',62)->first();
            $proHeight = ProductAttribute::where('product_id',$item->product_id)->where('attribute_id',57)->first();
           if(isset($proLen) && count($proLen)>0)
           {
               $len += $proLen->value;
           }
            if(isset($proWidth) && count($proWidth)>0)
            {
                $width += $proWidth->value;
            }
            if(isset($proHeight) && count($proHeight)>0)
            {
                $height += $proHeight->value;
            }
        }
        $arr['length']=$len;
        $arr['width']=$width;
        $arr['height']=$height;
        return $arr;
    }

    public function orderConfirm(Request $request){
        return view('cart::order-confirmation');
    }

    public function calGrandTotal($credit,$saving){
       return $credit-$saving;
    }
    public function calTotalSavings($data){
       $getAllSaving =0;
        $getAllSaving = $data['coupon_amount']+$data['promo_amount']+$data['refer_points']+$data['gift_voucher'];
       return $getAllSaving;
    }
    public function calTotalCredit($cart,$totalAmount)
    {
        $getAllCredit = 0;
        if($cart){
          $dis_amt = isset($cart->display_amount)? $cart->display_amount:0.00;
          $tax = isset($cart->tax)? $cart->tax:0.00;
          $ship_chrg = isset($cart->shipping_charge)? $cart->shipping_charge:0.00;
          $box_amt = isset($cart->box_amount)? $cart->box_amount:0.00;
          $paper_amt = isset($cart->paper_amount)? $cart->paper_amount:0.00;

          $getAllCredit = $dis_amt + $tax + $ship_chrg + $box_amt + $paper_amt + $totalAmount;
        }
        return $getAllCredit;
    }
    public function addDhlServiceDetails(Request $request)
    {
//        echo json_encode(array("success" => '0', 'msg' => $request->all()));
//        exit();
        if($request->service_name!='' && $request->service_price !='' && $request->service_currency!='')
        {
            $finalAmt =0.00;
            $totalWeight =0;
            $totalWeight = $this->getCartTotalWeight($request);
            if(Session::has('service_details'))
            {
                /**
                service_days	7
                service_name	DHL Express
                service_price	2630.55
                service_currency	₹
                service_estimated_days	4
                service_type	0

                 **/

//                dd(234);
                Session::put('service_details.service_provider','DHL');
                Session::put('service_details.service_name',isset($request->service_name)?$request->service_name:'');
                Session::put('service_details.service_time',isset($request->service_days)?$request->service_days:'');
                Session::put('service_details.service_estimated_days',isset($request->service_estimated_days)?$request->service_estimated_days:'');

                $toCurrency = $this->getCurrencySymbol($request->service_currency);
//                dd($toCurrency);
                $fromCurrency = "INR";
                $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
                if($getRate !=-1)
                {
                    $finalAmt = $request->service_price * $getRate;
                }
                else{
                    $finalAmt = $request->service_price;
                }
                Session::put('service_details.service_price',$finalAmt);
                Session::put('service_details.service_total_weight',$totalWeight);
                Session::put('service_details.service_type',isset($request->service_type)?$request->service_type:'');
                Session::save();
            }
            else{
                Session::put('service_details.service_provider','DHL');
                Session::put('service_details.service_name',isset($request->service_name)?$request->service_name:'');
                $toCurrency =$this->getCurrencySymbol($request->service_currency);
                $fromCurrency = "INR";
                $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
                if($getRate !=-1)
                {
                    $finalAmt = $request->service_price * $getRate;
                }
                else{
                    $finalAmt = $request->service_price;
                }
                Session::put('service_details.service_price',$finalAmt);
                Session::put('service_details.service_total_weight',$totalWeight);
                Session::put('service_details.service_time',isset($request->service_days)?$request->service_days:'');
                Session::put('service_details.service_type',isset($request->service_type)?$request->service_type:'');
                Session::put('service_details.service_estimated_days',isset($request->service_estimated_days)?$request->service_estimated_days:'');
                Session::save();
            }
            if(Auth::check())
            {
                $cart = Auth::user()->cart;
            }
            else
            {
                $cart=  Cart::where('ip_address',$request->ip())->first();
            }
            if($cart)
            {
                $cart->shipping_charge = $finalAmt;
                $cart->save();
            }
            $totalAmt = $this->getCartTotalAmt($request);
            $arr['grand_total'] =Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totalAmt)-Session::get('all_cart_data.total_savings')),2,'.','');
            $arr['shipping_charge']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalAmt),2,'.','');
            echo json_encode(array("success" => '1', 'msg' => "Service Selected Successfully",'arr'=>$arr));
            exit();
        }
        echo json_encode(array("success" => '0', 'msg' => "something went wrong"));
        exit();
    }

    public function validateCartForCheckout(Request $request)
    {
            if(Auth::check())
            {
                $cart = Auth::user()->cart;
            }
            else
            {
                $cart=  Cart::where('ip_address',$request->ip())->first();
            }
            if(isset($cart) && count($cart)>0)
            {
                if(Session::has('service_details') == false)
                {
                  echo json_encode(array("success" => '0', 'msg' => "Please select shipping services and check availability"));
                  exit();
                }
                elseif($cart->is_shipping_details_filled == '0')
                {
                 echo json_encode(array("success" => '0', 'msg' => "Please fill shipping and billing details to checkout"));
                  exit();   
                }
                elseif(Session::has('usr_details') == false)
                {
                    echo json_encode(array("success" => '0', 'msg' => "Please select shipping services and check availability"));
                    exit();   
                }
                elseif(Session::has('usr_details') && $cart->shipping_country != Session::get('usr_details.country_id'))
                {
                    echo json_encode(array("success" => '0', 'msg' => "Shipping country doesn't match with selected services country"));
                    exit();   
                }
                elseif(Session::has('usr_details') && $cart->shipping_zip != Session::get('usr_details.pin_code'))
                {
                    echo json_encode(array("success" => '0', 'msg' => "Shipping postal code doesn't match with selected services postal code"));
                    exit();   
                }
                else{
                    echo json_encode(array("success" => '1', 'msg' => "Success"));
                    exit();   
                }
            }
            else{
                echo json_encode(array("success" => '0', 'msg' => "something went wrong"));
                exit();
            }
    }


    public function addServiceDetails(Request $request)
    {
//        $toCurrency = $this->getCurrencySymbol($request->service_currency);
        if($request->service_name!='' && $request->service_price!='' && $request->service_time!='' && 
            $request->service_type!='')
        {
       //      echo json_encode(array("success" => '1', 'msg' => $request->all()));
       // exit();

            $finalAmt =0.00;
            $totalWeight =0;
            $totalWeight = $this->getCartTotalWeight($request);
            if(Session::has('service_details'))
            {
//                dd(234);
                Session::put('service_details.service_provider','FEDEX');
                Session::put('service_details.service_name',isset($request->service_name)?$request->service_name:'');
                Session::put('service_details.service_time',isset($request->service_time)?$request->service_time:'');

                $toCurrency = $this->getCurrencySymbol($request->service_currency);
//                dd($toCurrency);
                $fromCurrency = "INR";
                $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
                if($getRate !=-1)
                {
                    $finalAmt = $request->service_price * $getRate;
                }
                else{
                    $finalAmt = $request->service_price;
                }
                Session::put('service_details.service_price',$finalAmt);
                Session::put('service_details.service_total_weight',$totalWeight);
                Session::put('service_details.service_type',isset($request->service_type)?$request->service_type:'');
                Session::save();
            }
            else{
                Session::put('service_details.service_provider','FEDEX');
                Session::put('service_details.service_name',isset($request->service_name)?$request->service_name:'');
                $toCurrency =$this->getCurrencySymbol($request->service_currency);
                $fromCurrency = "INR";
                $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
                if($getRate !=-1)
                {
                    $finalAmt = $request->service_price * $getRate;
                }
                else{
                    $finalAmt = $request->service_price;
                }
                Session::put('service_details.service_price',$finalAmt);
                Session::put('service_details.service_total_weight',$totalWeight);
                Session::put('service_details.service_time',isset($request->service_time)?$request->service_time:'');
                Session::put('service_details.service_type',isset($request->service_type)?$request->service_type:'');
                Session::save();
            }
            if(Auth::check())
            {
                $cart = Auth::user()->cart;
            }
            else
            {
                $cart=  Cart::where('ip_address',$request->ip())->first();
            }
            if($cart)
            {
                $cart->shipping_charge = $finalAmt;
                $cart->save();
            }
            $totalAmt = $this->getCartTotalAmt($request);
            $arr['grand_total'] =Helper::getCurrencySymbol().number_format(Helper::getRealPrice($this->calTotalCredit($cart,$totalAmt)-Session::get('all_cart_data.total_savings')),2,'.','');
            $arr['shipping_charge']=Helper::getCurrencySymbol().number_format(Helper::getRealPrice($finalAmt),2,'.','');
            echo json_encode(array("success" => '1', 'msg' => "Service Selected Successfully",'arr'=>$arr));
            exit();
        }
        echo json_encode(array("success" => '0', 'msg' => "something went wrong"));
        exit();
    }
    public function getGrandTotal(Request $request)
    {
        $status=0;
        $chkDom=0;
        if(Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }
        if($request->option_val == 1 && Session::get('service_details.service_provider') != 'DHL')
        {
            if($request->option_val == 1 && Session::get('service_details.service_type') == 'national')
            {

                $totalAmt = $this->getCartTotalAmt($request);
                $grandTotal =$this->calTotalCredit($cart,$totalAmt)-Session::get('all_cart_data.total_savings');
                if($grandTotal >= 20000)
                {
                    $status = 1;
                }
                $grandTotal =Helper::getRealPrice($grandTotal);
                echo json_encode(array("success" => '1', 'msg' => "success",'optional'=>$request->option_val,'status'=>$status,'domestic'=>$chkDom));
                exit();
            }
            elseif ($request->option_val == 1 && Session::get('service_details.service_type') == 'international')
            {
                $status = 1;
                $chkDom = 1;
                echo json_encode(array("success" => '1', 'msg' => "success",'optional'=>$request->option_val,'status'=>$status,'domestic'=>$chkDom));
                exit();
            }
        }
        else if($request->option_val == 0)
            {
                    echo json_encode(array("success" => '1', 'msg' => "success",'optional'=>$request->option_val,'status'=>$status,'domestic'=>$chkDom));
                    exit();
            }
        else{
            echo json_encode(array("success" => '0'));
            exit();
            }
    }

    public function getCurrencySymbol($currencySymbol)
    {
        switch ($currencySymbol) {
            case '₹' :
                $symbol = 'INR';
                break;
            case '€' :
                $symbol = 'EUR';
                break;
            case '$' :
                $symbol = 'USD';
                break;
            case 'C$' :
                $symbol = 'CAD';
                break;
            case '£' :
                $symbol = 'GBP';
                break;
        }
        return $symbol;
    }
    public function getServiceDetails(Request $request)
    {
        $arr =[];
        if(Session::has('service_details'))
        {
            $arr['service_name']= Session::get('service_details.service_name');
            $arr['service_provider']= Session::get('service_details.service_provider');
            $arr['service_price']=Helper::getCurrencySymbol().Helper::getRealPrice(Session::get('service_details.service_price'));
            $arr['service_time']= Session::get('service_details.service_time');
            $arr['service_type']= Session::get('service_details.service_type');
            if(Session::get('service_details.service_provider') =='DHL')
            {
                $arr['service_estimated_days']= Session::get('service_details.service_estimated_days');
            }
        }
        echo json_encode(array("success" => '1', 'msg' =>$arr));
        exit();
    }

    public function getCartDataByAjax(Request $request){
        echo json_encode(array("success" => '0', 'msg' => $request->all()));
        exit();
    }
    public function validateFinalRateRequest(Request $request)
    {
        $cartTotalWeight = $this->getCartTotalWeight($request);
     if(Session::has('service_details'))
     {
         $sessionTotalWeight = Session::get('service_details.service_total_weight');
         if(($sessionTotalWeight == $cartTotalWeight))
         {
             echo json_encode(array("success" => '1'));
             exit();
         }
         else
         {
             echo json_encode(array("success" => '0','msg'=>"Please reselect shipping services for updated cart"));
             exit();
         }
     }
     else{
         echo json_encode(array("success" => '0','msg'=>'Please select Shipping services and check availability'));
         exit();
     }


    }

    public function addBothToCart(Request $request,$product_id1,$product_id2)
    {
//        dd($product_id1." ".$product_id2);
//        dd($request->price1);
        $data = $request->all();
//        dd($request->product_id2);
        $totalAmount =0;
        $totalCount =0;
        if($product_id1 !='' && $product_id2 !='')
        {
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

            if(isset($cart) && count($cart)>0)
            {
                $cartItem = null;

                if ($request->product_id1 != '')
                {
                    $product1 = Product::find($request->product_id1);
                    if (isset($product1) && count($product1) > 0) {
                        $productData1 = $this->getProductDiscountPrice($product1);

                    }

                    if ($productData1['is_original'] == 0) {
                        $prodAmt1 = $productData1['price'];
                    } elseif ($productData1['is_original'] == 1) {
                        $prodAmt1 = $productData1['discount_rate'];
                    } elseif ($productData1['is_original'] == 2) {
                        return redirect('/');

                    }
                    $prodAmt1 = trim($prodAmt1);
//                $prodAmt = isset($request->price1)?$request->price1:'$0';
//                $prodAmt = ltrim(trim($prodAmt),'$');
                    $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id1)->first();
                    if ($cartItem == null) {
                        $cartItem = new CartItem();
                        $cartItem->cart_id = $cart->id;
                        $cartItem->product_id = $request->product_id1;
                        $cartItem->product_amount = $prodAmt1;
                        $cartItem->product_color_name = isset($request->color_name) ? $request->color_name : '';
                        $cartItem->product_quantity = isset($request->ip_prod_count) ? $request->ip_prod_count : 1;
                        $cartItem->product_size_name = isset($request->size_name) ? $request->size_name : '';
                        $cartItem->save();
                    } else {
                        $cartItem->product_amount = $prodAmt1;
                        $cartItem->product_color_name = isset($request->color_name) ? $request->color_name : '';
                        $cartItem->product_quantity = isset($request->ip_prod_count) ? $request->ip_prod_count : 1;
                        $cartItem->product_size_name = isset($request->size_name) ? $request->size_name : '';
                        $cartItem->save();
                    }
                }

                if ($request->product_id2 != '')
                {
                    $product2 = Product::find($request->product_id2);
                    if (isset($product2) && count($product2) > 0) {
                        $productData2 = $this->getProductDiscountPrice($product2);

                    }

                    if ($productData2['is_original'] == 0) {
                        $prodAmt2 = $productData2['price'];
                    } elseif ($productData2['is_original'] == 1) {
                        $prodAmt2 = $productData2['discount_rate'];
                    } elseif ($productData2['is_original'] == 2) {
                        return redirect('/');

                    }
                    $prodAmt2 = trim($prodAmt2, '');

                    $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id2)->first();

                    if ($cartItem == null) {
                    $cartItem = new CartItem();
                    $cartItem->cart_id = $cart->id;
                    $cartItem->product_id = $request->product_id2;
                    $cartItem->product_amount = $prodAmt2;
                    $cartItem->product_color_name = isset($request->color_name) ? $request->color_name : '';
                    $cartItem->product_quantity = isset($request->ip_prod_count) ? $request->ip_prod_count : 1;
                    $cartItem->product_size_name = isset($request->size_name) ? $request->size_name : '';
                    $cartItem->save();
                    }
                    else {
                    $cartItem->product_amount = $prodAmt2;
                    $cartItem->product_color_name = isset($request->color_name) ? $request->color_name : '';
                    $cartItem->product_quantity = isset($request->ip_prod_count) ? $request->ip_prod_count : 1;
                    $cartItem->product_size_name = isset($request->size_name) ? $request->size_name : '';
                    $cartItem->save();
                    }
                }

                if(Session::has('all_cart_data') == false)
                {
                    Session::put('all_cart_data.total_savings',0.00);
                    Session::put('all_cart_data.gift_voucher',0.00);
                    Session::put('all_cart_data.user_gift_id',null);
                    Session::put('all_cart_data.refer_points',0.00);
                    Session::put('all_cart_data.coupon_amount',0.00);
                    Session::put('all_cart_data.promo_amount',0.00);
                    Session::put('all_cart_data.coupon_code','');
                    Session::put('all_cart_data.promo_code','');
                    Session::save();
                }
                return redirect('/cart');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect('/');
        }
    }
}
