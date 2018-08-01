<?php

namespace App\PiplModules\cart\Controllers;

use App\PiplModules\admin\Models\City;
use App\PiplModules\admin\Models\State;
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
use App\PiplModules\cart\Models\OrderItem;
use PDF;
use GlobalValues;
use App\PiplModules\emailtemplate\Models\EmailTemplate;


class OrderController extends Controller {

    public function listOrders($status="") {
//        dd($status);
        $all_orders = Order::all();
        //dd($all_orders);
        return view('cart::list-orders', array('orders' => $all_orders,'status'=>$status));
    }

    public function listOrdersData($status="0") {
        $all_orders = Order::orderBy('id', 'DESC')->get();
        if($status=="0"){
            $all_orders = Order::orderBy('id', 'DESC')->get();
        }
        else if($status==1){
            $all_orders = Order::where("order_status","0")->orderBy('id', 'DESC')->get();
        }
        else if($status==2){
            $all_orders = Order::where("order_status","1")->orderBy('id', 'DESC')->get();
        }
        else if($status==3){
            $all_orders = Order::where("order_status","2")->orderBy('id', 'DESC')->get();
        }
        else if($status==4){
            $all_orders = Order::where("order_status","3")->orderBy('id', 'DESC')->get();
        }
        else if($status==5){
            $all_orders = Order::where("order_status","4")->orderBy('id', 'DESC')->get();
        }
        else if($status==6){
            $all_orders = Order::where("order_status","5")->orderBy('id', 'DESC')->get();
        }
//        $all_orders = $all_orders->sortBy('id');
//        dd($all_orders);
        return Datatables::of($all_orders)
                        ->addColumn('order_id', function($product) {
                            if (isset($product->orderItems->order_id) && $product->orderItems->order_id != "") {
                                return $product->orderItems->order_id;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('first_name', function($product) {
                            if (isset($product->shipping_name) && $product->shipping_name !='') {
                                return stripslashes($product->shipping_name);
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

                            if (isset($product->shipping_state) && is_string($product->shipping_state) && $product->shipping_state !='') {
//
                            }
                            elseif (isset($product->shipping_state) && is_numeric($product->shipping_state) && $product->shipping_state !=0){
                                  $state = State::find($product->shipping_state);
                                  if(isset($state) && count($state)>0){
                                      return $state->name;
                                  }
                                  else{
                                      return "-";
                                  }
                            }
                            else {
                                return "-";
                            }
                        })
                        ->addColumn('shipping_city', function($product) {

                            if (isset($product->shipping_city) && is_string($product->shipping_city) && $product->shipping_city != "") {
//                                
                                return $product->shipping_city;
                            }
                            elseif (isset($product->shipping_city) && is_numeric($product->shipping_city) && $product->shipping_city !=0){
                                $city = City::find($product->shipping_city);
                                if(isset($city) && count($city)>0){
                                    return $city->name;
                                }
                                else{
                                    return "-";
                                }
                            }
                            else {
                                return "-";
                            }
                        })
                        ->addColumn('order_status', function($product) {

                            if (isset($product->order_status) && $product->order_status !='') {

                               return $product->order_status+1;
                            }
                            else{
                                return '-';
                            }
                        })
                        ->addColumn('payment_status', function($product) {

                            if (isset($product->payment_status) && $product->payment_status!='')
                            {
//                                if ($product->payment_status == "0") {
                                    return $product->payment_status;
//                                } else if ($product->payment_status == "1") {
//                                    return "Paid";
//                                }
                            }
                            else
                                {
                                 return '-';
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
            if($request->value!="")
            {
//                $order = Order::where('id',$request->order_id)->update(["order_status"=>$request->value]);
                $order = Order::find($request->order_id);
                if(isset($order) && count($order)>0)
                {
                    if($request->value == "1")
                    {
                        $site_email = GlobalValues::get('site-email');
                        $site_title = GlobalValues::get('site-title');
                        $arr_keyword_values = array();
                        $contact_email = GlobalValues::get('contact-email');

                        $arr_keyword_values['NAME'] =$order->shipping_name;
                        $arr_keyword_values['ORDER_ID'] =$order->id;
                        $arr_keyword_values['WEBSITE_URL'] =url('www.parasfashions.com');
                        $arr_keyword_values['SITE_TITLE'] = $site_title;

//                           dd($arr_keyword_values);
                        $email_template = EmailTemplate::where("template_key", 'order-placed')->first();

                        $status = Mail::send('emailtemplate::order-placed', $arr_keyword_values, function ($message) use ($order,$site_email, $site_title, $email_template) {

                            $message->to($order->shipping_email)->subject($email_template->subject)->from($site_email, $site_title);
                        });
                        if($status){
                            $order->order_status =$request->value;
                            $order->save();
                            echo json_encode(array("success" => '1', 'msg' => "Order status changed successfully"));
                            exit();
                        }
                    }
                    else if($request->value == "2")
                    {
                        $site_email = GlobalValues::get('site-email');
                        $site_title = GlobalValues::get('site-title');
                        $arr_keyword_values = array();
                        $contact_email = GlobalValues::get('contact-email');

                        $arr_keyword_values['NAME'] =$order->shipping_name;
                        $arr_keyword_values['ORDER_ID'] =$order->id;
                        $arr_keyword_values['WEBSITE_URL'] =url('www.parasfashions.com');
                        $arr_keyword_values['SITE_TITLE'] = $site_title;

//                           dd($arr_keyword_values);
                        $email_template = EmailTemplate::where("template_key", 'dispatch-order')->first();

                        $status = Mail::send('emailtemplate::dispatch-order', $arr_keyword_values, function ($message) use ($order,$site_email, $site_title, $email_template) {

                            $message->to($order->shipping_email)->subject($email_template->subject)->from($site_email, $site_title);
                        });
                        if($status){
                            $order->order_status =$request->value;
                            $order->save();
                            echo json_encode(array("success" => '1', 'msg' => "Order status changed successfully"));
                            exit();
                        }
                    }
                    else{
                        $order->order_status =$request->value;
                        $order->save();
                        echo json_encode(array("success" => '1', 'msg' => "Order status changed successfully"));
                        exit();
                    }

                }
                else{
                    echo json_encode(array("success" => '0', 'msg' => "Failed to change order status"));
                    exit();
                }
            }
        }
            
            public function changePaymentStatus(Request $request)
            {
            if($request->value!="")
            {
//                    $order = Order::where('id',$request->order_id)->update(["payment_status"=>$request->value]);
                $order = Order::find($request->order_id);
                if(isset($order) && count($order)>0)
                        {
                            $order->payment_status = $request->value;
                            $order->save();
                            echo json_encode(array("success" => '1', 'msg' => "Payment status changed successfully"));
                            exit();
                        }
                    else{
                            echo json_encode(array("success" => '1', 'msg' => "Failed to change payment status"));
                            exit();
                        }
            }
       
            }
            
            public function showOrder($order_id) {
              $order = Order::find($order_id);
              $order_items=null;
              if(isset($order) && count($order)>0){
                  $order_items=  OrderItem::where('order_id',$order_id)->get();
                  return view("cart::show-order-detail",compact("order_items",'order'));
              }
            }

    public function htmlToPdfView(Request $request)
    {
//        dd($request->all());
        $order = Order::find($request->order);
        view()->share('order',$order);
        if($request->has('download')){
//            $pdf = PDF::loadView('cart::customer-order-pdf-view');
            $pdf = PDF::loadView('cart::pdf');
            return $pdf->download($order->id.'.pdf');
        }
        return view('cart::show-order-detail');
    }

    public function viewOrder(Request $request,$id)
    {
//        dd(234);
        $order = Order::find($id);
        if(isset($order) && count($order)>0)
        {
//            dd(234);
            return view('cart::view-order',compact('order'));
        }
        else{
            return redirect()->back();
        }


    }
    public function viewOrderDetails(Request $request,$id)
    {
        $order = Order::find($id);
        if(isset($order) && count($order)>0)
        {
//            dd(234);
            return view('cart::view-order-details',compact('order'));
        }
        else{
            return redirect()->back();
        }

    }
    public function vieAllOrders(Request $request)
    {
        if(Auth::check())
        {
            $all_orders = Order::where('customer_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        else
        {
            $all_orders = Order::where('ip_address',$request->ip())->orderBy('id','DESC')->get();
        }
        return view('cart::show-all-orders',compact('all_orders'));
    }
    public function getCurrencyFromIso($currencyIso)
    {  $symbol="";
        switch ($currencyIso) {
            case 'INR' :
                $symbol = '₹';
                break;
            case 'EUR' :
                $symbol = '€';
                break;
            case 'USD' :
                $symbol = '$';
                break;
            case 'CAD' :
                $symbol = 'C$';
                break;
            case 'GBP' :
                $symbol = '£';
                break;
        }
        return $symbol;
    }
    public function getOrderLabel(Request $request,$order_id)
    {

        $order = Order::find($order_id);
        if(isset($order) && count($order)>0)
        {
            $filepath='';
            $filepath = $order->ship_label_pdf;
            if(!empty($filepath) && $filepath !='')
            {
                if (file_exists($filepath))
                {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . ($filepath) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($filepath));
                    flush(); // Flush system output buffer
                    readfile($filepath);
                    exit;
                }
            }
            else
                {
                return redirect()->back()->with('status','Label of this order is not available');
            }

        }
        else
        {
            return redirect()->back()->with('status','This order is unavailable');
        }

    }
}
