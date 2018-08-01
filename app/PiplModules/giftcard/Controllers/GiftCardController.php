<?php

namespace App\PiplModules\giftcard\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\giftcard\Models\GiftCard;
use Mail;
use Datatables;
use Illuminate\Routing\UrlGenerator;
use App\UserGiftCard;
use GlobalValues;
use App\PiplModules\emailtemplate\Models\EmailTemplate;

class GiftCardController extends Controller {

    public function listGiftCards() {
        return view('giftcard::list-gift-cards');
    }

    public function listGiftCardsData() {

        $arr_gift_cards = GiftCard::all();
        return Datatables::of($arr_gift_cards)
                        ->addColumn('image', function($arr_gift_cards) {
                            $image = $arr_gift_cards->image;
                            return '<img src=' . url('/') . '/storage/app/public/gift_card_image/' . $image . ' class="paper-image" height="150px" width="200px">';
                        })
                        ->make(true);
    }

    public function createGiftCard(Request $request) {
        if ($request->method() == "GET") {
            return view("giftcard::create-gift-card");
        } else {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'image' => 'required'
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
//                dd($request->all());
                $created_gift_card = new GiftCard;

                /* Upload Image */
                if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                    $image_name = time() . '.png';
                    move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/gift_card_image/" . $image_name);
                    $created_gift_card->image = $image_name;
                }

                $created_gift_card->price = isset($request->price)?$request->price:0;
                $created_gift_card->name =isset($request->card_name)?$request->card_name:'';
                $created_gift_card->description =isset($request->description)?$request->description:'';
                $created_gift_card->save();

                return redirect("admin/gift-card-list")->with('status', 'Gift Card created successfully!');
            }
        }
    }

    public function updateGiftCard(Request $request, $card_id) {
        $gift_card_details = GiftCard::find($card_id);

        if ($gift_card_details) {

            if ($request->method() == "GET") {
                return view("giftcard::update-gift-card", array('gift_card_details' => $gift_card_details));
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    if ($request->image != '') {
                        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                            $image_name = time() . '.png';
                            move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/gift_card_image/" . $image_name);
                            $gift_card_details->image = $image_name;
                        }
                        
                    }
                    $gift_card_details->price  = isset($request->price)?$request->price:0;
                    $gift_card_details->name  = isset($request->card_name)?$request->card_name:'';
                    $gift_card_details->description  =isset($request->description)?$request->description:'';
                    $gift_card_details->save();

                    return redirect("admin/gift-card-list")->with('status', 'Gift Card updated successfully!');
                }
            }
        } else {
            return redirect('admin/gift-card-list');
        }
    }

    public function deleteGiftCard($card_id) {
        $gift_card_data = GiftCard::find($card_id);

        if ($gift_card_data) {
            $gift_card_data->delete();
            return redirect("admin/gift-card-list")->with('status', 'gift card deleted successfully!');
        } else {
            return redirect('admin/gift-cad-list');
        }
    }
    public function deleteSelectedGiftCard($card_id) {
        $gift_card_data = GiftCard::find($card_id);

        if ($gift_card_data) {
            $gift_card_data->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function listGiftCardFront(Request $request)
    {
        $giftCards = GiftCard::all();
        return view('gift-card-list',compact('giftCards'));
    }

    public function showGiftCardDetails(Request $request,$giftCardId){

        if($request->method() == "GET")
        {
            $giftCard = GiftCard::find($giftCardId);
            if(isset($giftCard) && count($giftCard)>0){
                return view('gift-card',compact('giftCard'));
            }
            else{
                return redirect('/');
            }
        }
        elseif ($request->method() == "POST")
        {
            if(!empty($request->gift_card_id) && !empty($request->amount))
            {
                $giftCard =GiftCard::find($giftCardId);
                if(isset($giftCard) && count($giftCard)>0){
                    if(Auth::check()){
                        $userGiftCard =new UserGiftCard();
                        $userGiftCard->gift_card_id =$giftCard->id;
                        $userGiftCard->user_id =Auth::user()->id;
                        $userGiftCard->transaction_id =1;
                        $gift_card_code = str_replace(" ", "", $giftCard->name);
                        $gift_card_code .="-". $this->generateRandomGiftCode();
                        $userGiftCard->gift_card_code =$gift_card_code;
                        $userGiftCard->price =isset($request->amount)?$request->amount:0;
                        $userGiftCard->email =isset($request->email)?$request->email:'';
                        $userGiftCard->remaining_price =0;
                        $userGiftCard->apply_count =0;
                        $userGiftCard->save();
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
                                return redirect('gift-card/'. $giftCard->id)->with('appointment-status','Appointment request has been sent successfully');
                            }
                        }
                    }
                }
                else{
                    return redirect()->back();
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

            '1', '2', '3', '4', '5',
            '6', '7', '8', '9', '0');

        for ($rand = 0; $rand < $length; $rand++) {
            $random = rand(0, count($chars) - 1);
            $randstr .= $chars[$random];
        }
        return $randstr;
    }

}
