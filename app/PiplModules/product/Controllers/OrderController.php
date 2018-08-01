<?php

namespace App\PiplModules\product\Controllers;

use App\PiplModules\product\Models\Color;
use App\PiplModules\rivaah\Models\RivaahGallery;
use App\PiplModules\rivaah\Models\RivaahProduct;
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
use App\PiplModules\cart\Models\Order;
use App\PiplModules\cart\Models\OrderItems;
class OrderController extends Controller {

    public function listOrders($status="") {
//        dd($status);
        $all_orders = Order::all();
        return view('product::list-orders', array('orders' => $all_orders,'status'=>$status));
    }

    public function listOrdersData($status="") {
//        dd($status);
        $all_orders = Order::all();
        if($status==""){
            $all_orders = Order::all();
        }
        else if($status==1){
            $all_orders = Order::where("order_status","0")->get();
        }
        else if($status==2){
            $all_orders = Order::where("order_status","1")->get();
        }
        else if($status==3){
            $all_orders = Order::where("order_status","2")->get();
        }
        else if($status==4){
            $all_orders = Order::where("order_status","3")->get();
        }
        else if($status==5){
            $all_orders = Order::where("order_status","4")->get();
        }
        else if($status==6){
            $all_orders = Order::where("order_status","5")->get();
        }
        
        
        $all_orders = $all_orders->sortBy('id');
//        dd($all_orders);
        return Datatables::of($all_orders)
                        ->addColumn('order_id', function($product) {
                            dd($product->orderItems["order_id"]);
                            if (isset($product->orderItems->order_id) && $product->orderItems->order_id != "") {
                                return $product->orderItems->order_id;
                            } else {
                                return "-";
                            }
                        })
//                        ->addColumn('product_name', function($product) {
//                            if (isset($product->orderItems->product_name) && $product->orderItems->product_name != "") {
//                                return stripslashes($product->orderItems->product_name);
//                            } else {
//                                return "-";
//                            }
//                        })
//                        ->addColumn('product_quantity', function($product) {
//                            if (isset($product->orderItems->product_quantity) && $product->orderItems->product_quantity != "") {
//                                return stripslashes($product->orderItems->product_quantity);
//                            } else {
//                                return "-";
//                            }
//                        })
//                        ->addColumn('product_price', function($product) {
//                            if (isset($product->orderItems->product_price) && $product->orderItems->product_price != "") {
//                                return stripslashes($product->orderItems->product_price);
//                            } else {
//                                return "-";
//                            }
//                        })
                        ->addColumn('first_name', function($product) {
                            if (isset($product->first_name) && $product->first_name) {
                                return stripslashes($product->first_name . " " . $product->last_name);
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('shipping_address1', function($product) {

                            if (isset($product->shipping_address1) && $product->shipping_address1 != "") {
//                                
                                return $product->shipping_address1;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('shipping_address2', function($product) {

                            if (isset($product->shipping_address2) && $product->shipping_address2 != "") {
//                                
                                return $product->shipping_address2;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('shipping_state', function($product) {

                            if (isset($product->shipping_state) && $product->shipping_state != "") {
//                                
                                return $product->shipping_state;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('shipping_city', function($product) {

                            if (isset($product->shipping_city) && $product->shipping_city != "") {
//                                
                                return $product->shipping_city;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('order_status', function($product) {

//                            if (isset($product->order_status)) {
                                
//                                } else if ($product->order_status == "1") {
//                                    return "Processed";
//                                } else if ($product->order_status == "2") {
//                                    return "Returned";
//                                } else if ($product->order_status == "3") {
//                                    return "Cancelled";
//                                }
//                                else if ($product->order_status == "4") {
//                                    return "Refund";
//                                }
//                                else if ($product->order_status == "5") {
//                                    return "Completed";
//                                }
                                
//                            }
                        })
                        ->addColumn('payment_status', function($product) {

                            if (isset($product->payment_status)) {
                                if ($product->payment_status == "0") {
                                    return "Unpaid";
                                } else if ($product->payment_status == "1") {
                                    return "Paid";
                                }
                            }
                        })
                        ->addColumn('order_discount', function($product) {

                            if (isset($product->order_discount) && $product->order_discount != "") {
//                                
                                return $product->order_discount;
                            } else {
                                return "-";
                            }
                        })
                        ->make(true);
    }
    
    public function changeOrderStatus(Request $request)
            {
//        dd($request->all());
        $data['status'] = $request->value;
        $item=  OrderItems::where('order_id', $request->order_id)->first();
        $product_id=$item->product_id;
//        dd($product_id);
        if($request->value!=""){
            Order::where('id',$request->order_id)->update(["order_status"=>$request->value]);
        }
       
            }
            
            public function changePaymentStatus(Request $request)
            {
//        dd($request->all());
        $data['status'] = $request->value;
        $item=  OrderItems::where('order_id', $request->order_id)->first();
        $product_id=$item->product_id;
//        dd($product_id);
        if($request->value!=""){
            Order::where('id',$request->order_id)->update(["payment_status"=>$request->value]);
        }
       
            }
            
            public function showOrder($order_id) {
//                dd($order_id);
                $order_items=  OrderItems::where('order_id',$order_id)->get();
                return view("product::show-order-detail",compact("order_items"));
                }
}
