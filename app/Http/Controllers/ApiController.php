<?php

namespace App\Http\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request as Res;
use Session;
use URL;
use Softon\Indipay\Facades\Indipay as Indipay;
use Softon\Indipay\Gateways\ccavenueGateway;
use App\PiplModules\cart\Models\Order;
use App\PiplModules\giftcard\Models\GiftCard;
use App\UserGiftCard;
use App\PiplModules\admin\Helpers\GlobalValues;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use Mail;
use App\Http\Controllers\DhlController;
class ApiController extends Controller
{
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $gift_card_id="";
        $indiPay = new Indipay();   
    }

    private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    public function ccavenue(Res $request)
    {
        if ($request->method() == "GET")
        {
            return view('frm-ccavenue');
        }
        else
            {
            if(empty($request->amount) || empty($request->email))
            {
                return redirect()->back();
            }
            else
            {
                if (Auth::check())
                {
                    $order=new Order();
                    $order->customer_id=Auth::user()->id;
                    $order->shipping_email=isset($request->email)?trim($request->email):'';
                    $order->order_type=1;
                    $order->payment_amount=isset($request->amount)?trim($request->amount):0;
                    $order->save();
//                dd($order);
//            dd($request->gift_card_id);
                    $gift_card_id=$request->gift_card_id;
                    Session::put("gift_card.gift_card_id",$gift_card_id);
                    Session::put("gift_card.email",$order->shipping_email);
                    Session::save();
//            dd($request->all());
//            $val=\App\Helpers\Helper::getRealPrice($request->amount);
//            dd($val);
//            dd($request->all());
                    //  $ccAvenue = new ccavenueGateway();
                    // $ccAvenue->setCurrency($request->currency);
//            $ccAvenue->setCurrency = $request->currency;
//            dd($ccAvenue);
//            dd(Session::get("gift_card_id"));
                    $tid = time();
                    $order_id=$order->id;
//            $order_id =isset($request->id)?$request->id:time();
                    $parameters = [
                        'tid' => $tid,
                        'order_id' => $order_id,
                        'currency'=> "INR",
                        'amount' => $request->amount,
//                  'amount' => $val,

                    ];
//            dd($parameters);
                    $order = Indipay::gateway('ccavenue')->prepare($parameters);
//            dd($order);
                    return Indipay::process($order);
                }
                else
                {
                   return redirect()->back();
                }
        }
        }
    }

    public function response(Res $request)
    {
//        dd($request->all());
        // For default Gateway
        $response = Indipay::response($request);
        if(Session::has("gift_card"))
        {
        $order_id=$response['order_id'];
        $tracking_id=$response['tracking_id'];
        $bank_ref_no=$response['bank_ref_no'];
        $order_status=$response['order_status'];
        $amount=$response['amount'];
        $payment_mode=$response['payment_mode'];
        $payment_currency=$response['currency'];
        $payment_card_name=$response['card_name'];
        $gift_card_id=Session::get("gift_card.gift_card_id");
        $email=Session::get("gift_card.email");

        if($order_status=="Success")
        {
        $gift_card_detail=array();
        $gift_card_detail=([
                'order_id'=> $order_id,
                'tracking_id'=>$tracking_id,
                'bank_ref_no' => $bank_ref_no,
                'order_status'=> $order_status,
                'gift_card_id'=>$gift_card_id,
                'email'=>$email,
                'amount'=>$amount,
                'payment_mode'=>$payment_mode,
                'payment_currency'=>$payment_currency,
                'payment_card_name'=>$payment_card_name
                ]);
        
        // For Otherthan Default Gateway
        //$response = Indipay::gateway('ccavenue')->response($request);

//        dd($response);
//        dd($gift_card_detail);
        return $this->showGiftCardDetails($gift_card_detail);
//        return redirect("/show-gift-card",$gift_card_detail);
//                ->with('purchase-status','You have purchase gift-card successfully');
        }
        }
        else
        {
            //dd(124);
            if($response['order_status'] == 'Success')
            {
                $order =Order::find($response['order_id']);
                if(isset($order) && count($order)>0)
                {
                    $metaData =[];
                    $serviceData =[];
                    $order->order_tracking_id =$response['tracking_id'];
                    $order->bank_ref_no =$response['bank_ref_no'];
                    $order->payment_mode =$response['payment_mode'];
                    $order->payment_card_name =$response['card_name'];
                    $order->payment_currency =$response['currency'];
                    $order->payment_amount =$response['amount'];
                    $order->payment_status =1;
                    $order->save();
                    $metaData['order']=$order;
                    if(count($metaData)>0)
                    {
                        if($metaData['order']['shipping_service_provider'] == "FEDEX")
                        {
                            $shipObj = new CreateShipController();
                            if($metaData['order']['shipping_service_type'] == 'national')
                            {
                                $status = $shipObj->CreateNationalShipOrder($metaData);
                                if($status == 1)
                                {
                                    return redirect('/order-confirmation');
                                }
                                else
                                {
                                    return redirect('/cart')->with('cart-err','Could not complete shipping process');
                                }
                            }
                            elseif($metaData['order']['shipping_service_type'] == 'international')
                            {
                                $status = $shipObj->CreateInternationalShipOrder($metaData);

                                if($status == 1)
                                {
                                    return redirect('/order-confirmation');
                                }
                                else
                                {
                                    return redirect('/cart')->with('cart-err','Could not complete shipping process');
                                }
                            }
                        }
                        else if($metaData['order']['shipping_service_provider'] == "DHL")
                        {
                            $dhlObj = new DhlController();

                                $dhlObj->createDhlShipment($metaData);

                        }
                    }
                }

            }
            else{
                return redirect('/cart')->with('cart-err','Could not complete payment process');
            }
        }
    }

    public function showGiftCardDetails($giftCardId)
    {
        $gift_card_id=$giftCardId["gift_card_id"];
        $giftCard =GiftCard::find($gift_card_id);
                if(isset($giftCard) && count($giftCard)>0)
                {
                    if(Auth::check()){
                        $userGiftCard =new UserGiftCard();
                        $userGiftCard->gift_card_id =$giftCard->id;
                        $userGiftCard->user_id =Auth::user()->id;
                        $userGiftCard->tracking_id =$giftCardId["tracking_id"];
//                        $userGiftCard->transaction_id =;
                        $userGiftCard->gift_card_code =$this->generateRandomGiftCode();
                        $userGiftCard->price =$giftCardId["amount"];
                        $userGiftCard->email =$giftCardId["email"];
                        $userGiftCard->remaining_price =0;
                        $userGiftCard->apply_count =0;
                        $userGiftCard->save();
                        $order=  Order::where('customer_id',Auth::user()->id)->where('order_type',1)->orderBy('id', 'DESC')->first();
                        $order->order_tracking_id=$userGiftCard->tracking_id;
                        $order->payment_amount=$userGiftCard->price;
                        $order->bank_ref_no=$giftCardId['bank_ref_no'];
                        $order->payment_mode=$giftCardId["payment_mode"];
                        $order->payment_currency=$giftCardId["payment_currency"];
                        $order->payment_card_name=$giftCardId["payment_card_name"];
                        $order->save();
                        if($userGiftCard){
                            $site_email = GlobalValues::get('site-email');
                            $site_title = GlobalValues::get('site-title');
                            $arr_keyword_values = array();
                            $contact_email = GlobalValues::get('contact-email');

                            $arr_keyword_values['FIRST_NAME'] =Auth::user()->userInformation->first_name;
                            $arr_keyword_values['LAST_NAME'] =Auth::user()->userInformation->last_name;
                            $arr_keyword_values['CODE'] =$userGiftCard->gift_card_code;
                            $arr_keyword_values['AMOUNT'] =$userGiftCard->price;
                            $arr_keyword_values['SITE_TITLE'] = $site_title;

//                           dd($arr_keyword_values);
                            $email_template = EmailTemplate::where("template_key", 'purchase-gift-card')->first();

                            $status = Mail::send('emailtemplate::purchase-gift-card', $arr_keyword_values, function ($message) use ($userGiftCard,$site_email, $site_title, $email_template) {

                                $message->to($userGiftCard->email)->subject($email_template->subject)->from($site_email, $site_title);
                            });
                            if($status){
                                Session::forget('gift_card');
                                Session::save();
                                return redirect('gift-card/'. $giftCard->id)->with('purchase-status','You have purchased gift-card successfully');
                            }
                        }
                    }

                }
    }
    
    public function generateRandomGiftCode() {
        $length = 8;
        $randstr='';
        srand((double) microtime(TRUE) * 1000000);
        //our array add all letters and numbers if you wish
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
            'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
            '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        for ($rand = 0; $rand < $length; $rand++) {
            $random = rand(0, count($chars) - 1);
            $randstr .= $chars[$random];
        }
        return $randstr;
    }

}
