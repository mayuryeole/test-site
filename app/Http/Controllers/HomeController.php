<?php

namespace App\Http\Controllers;

use App\PiplModules\artist\Models\Artist;
use App\PiplModules\gallery\Models\Gallery;
use App\PiplModules\gallery\Models\GalleryMedia;
use App\PiplModules\product\Models\Product;
use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Mockery\Exception;
use URL;
use Mail;
use App\Helpers\Helper;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use App\PiplModules\rivaah\Models\RivaahGallery;
use App\PiplModules\rivaah\Models\RivaahGalleryImage;
use Session;
use GlobalValues;
use App\PiplModules\category\Models\Category;
use App\PiplModules\product\Models\ProductDescription;
use App\CurrencyExchangeRate;
class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public  function index()
    {

    }
    public function getCurrencyExchangeRates()
    {
        $exchangeRate = array();
        $currency = 'INR';
        $currencyArr = array('USD','CAD','EUR','GBP');
        foreach($currencyArr as $key=>$val)
        {

            $to = $val;
            $from = 'INR';
            $url = 'http://free.currencyconverterapi.com/api/v5/convert?q='.$to.'_'.$from.'&compact=y';
            try{
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $contents = curl_exec($ch);
//            dd($contents);

                $json_a = json_decode($contents, true);
                if (isset($json_a) && array_key_exists($to.'_'.$from, $json_a) && count($json_a[$to.'_'.$from]) > 0)
                {
                    $exchangeRate[$val] =$json_a[$to.'_'.$from]['val'];
                }
            }catch (Exception $e)
            {
                dd($e);
            }

        }
        if(isset($exchangeRate) && count($exchangeRate)>0)
        {
            // $currencyExRate = CurrencyExchangeRate::orderBy('id','DESC')->limit(1)->first();
//            dd($currencyExRate);
            // if (!isset($currencyExRate) || count($currencyExRate) == 0)
            // {
                $currencyExRate = new CurrencyExchangeRate();
            // }
            $currencyExRate->inr = 1;
            $currencyExRate->usd = isset($exchangeRate['USD']) ? $exchangeRate['USD'] : '';
            $currencyExRate->cad = isset($exchangeRate['CAD']) ? $exchangeRate['CAD'] : '';
            $currencyExRate->eur = isset($exchangeRate['EUR']) ? $exchangeRate['EUR'] : '';
            $currencyExRate->gbp = isset($exchangeRate['GBP']) ? $exchangeRate['GBP'] : '';
            $currencyExRate->updated_at = date('Y-m-d H:i:s');
            $currencyExRate->save();
            if (Session::has('universal_currency'))
            {
                $currency = Session::get('universal_currency');
                if (in_array($currency, $exchangeRate))
                {
                    Session::set('exchange_rate', $exchangeRate[$currency]);
                    Session::save();
                }
                else
                {
                    Session::set('exchange_rate', 1);
                    Session::save();
                }
            }
            else {

                Helper::setSessionDefaultCurrency();
            }
        }
        // else
        // {
        //     $site_email = GlobalValues::get('site-email');
        //     $site_title = GlobalValues::get('site-title');
        //     $arr_keyword_values = array();
        //     $contact_email = GlobalValues::get('contact-email');
        //     $arr_keyword_values['TIME'] = time('H:i:s');
        //     $arr_keyword_values['DATE'] = date('d-m-Y');
        //     $arr_keyword_values['SITE_TITLE'] = $site_title;
        //     $email_template = EmailTemplate::where("template_key", 'currency-exchange-rate')->first();

        //     $status = Mail::send('emailtemplate::currency-exchange-rate', $arr_keyword_values, function ($message) use ($contact_email,$site_email, $site_title, $email_template) {

        //         $message->to($contact_email)->subject($email_template->subject)->from($site_email, $site_title);
        //     });
        // }

    }

    public function goToMainPage(Request $request)
    {
//        var_dump(Session::get('universal_currency'));
        $gallery = Gallery::first();
        $gallery_media = null;
        $all_artist = Artist::all();
        $hot_products = Product::FilterByCategory()->FilterProductCategory()->FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductFeatured()->FilterHideProduct()->FilterProductStatus()->orderBy('id','DESC')->limit(4)->inRandomOrder()->get();
//        $hot_products = Product::FilterByCategory()->FilterProductCategory()->FilterProductName()->FilterProductRange()->FilterProductCollectionStyle()->FilterProductOccasion()->FilterProductStyle()->FilterProductColor()->FilterProductFeatured()->FilterHideProduct()->paginate(12);
        if(isset($gallery) && count($gallery)>0){
            $gallery_media = GalleryMedia::where('gallery_id',$gallery->id)->inRandomOrder()->get();
        }
        $rivaah = RivaahGallery::limit(12)->get();
        $hot_prod=  Product::FilterProductByAvailability()->FilterHideProduct()->FilterProductStatus()->orderBy('id','DESC')->limit(4)->get();;
        $category=  Category::where('parent_id','<>','0')->translatedIn(\App::getLocale())->inRandomOrder()->get();
        $featured= Product::FilterProductByAvailability()->FilterProductFeatured()->FilterHideProduct()->FilterProductStatus()->orderBy('id','DESC')->inRandomOrder()->get();
        $featured_latest= Product::FilterProductByAvailability()->FilterProductFeatured()->FilterHideProduct()->FilterProductStatus()->orderBy('id','DESC')->first();
//        dd($featured);
        return view('welcome',compact('hot_products','rivaah','gallery_media','all_artist','category','featured','hot_prod','featured_latest'));
    }

    public function permissionDenied() {


        $arr_user = Auth::user();
        $arr_user_data = $arr_user->userInformation;
        return view('permission_denied', array("user_info" => $arr_user_data));
    }

    /**
     *
     *  Checks, whether user has role of administrator. If yes, then forwards to Admin Panel. If user registered from front end, then checks it's email verified status 
     *  and redirect to error page is not activated. If valid email, then checks for status and forward to respective dashboard.
     * 	
     */
    public function toDashboard(Request $request) {
//        dd(1);
        $previous_url = URL::previous();
        $previous_url = (explode("/", $previous_url));
        if (end($previous_url) == 'login') {
            Session::put('admin-login_page', 'no');
        }
        // he is admin, redirect to admin panel
        $session_value = Session::get('admin-login_page');
        Session::put('admin-login_page', 'no');
        if (Auth::user()->isSuperadmin() || Auth::user()->isAdmin() || Auth::user()->userInformation->user_type == '1') {
            if (Auth::user()->userInformation->user_status == "1") {
                if (Auth::user()->userInformation->user_type == "1") {
                    return redirect("admin/dashboard");
                    exit;
                }
            } elseif (Auth::user()->userInformation->user_status == "0") {
                $errorMsg = "We found your account is not yet verified. Kindly see the verification email, sent to your email address, used at the time of registration.";
                \Session::flash('alert-class', 'alert-danger');
                        \Session::flash('login-error', $errorMsg);

                
            } elseif (Auth::user()->userInformation->user_status == "2") {
                $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details.";
                \Session::flash('alert-class', 'alert-danger');
                 \Session::flash('login-error', $errorMsg);

                }
            Auth::logout();
            
            return redirect("/admin/login");
//                    ->with("login-error", $errorMsg);
        }
        // he is not admin. check whether he has activated, ask him to verify the account, otherwise forward to profile page.
        else {

            if (Auth::user()->userInformation->user_status == "1") {
                if (Auth::user()->userInformation->user_type == "1") {
                    return redirect("admin/dashboard");
                    exit;
                } else if (Auth::user()->userInformation->user_type == "2") {


                    if ($session_value == 'yes') {
                        Auth::logout();
                        $errorMsg = "Apologies, your email or password is invalid or you does not have admin user privilages.";
                        \Session::flash('alert-class', 'alert-danger');
                        \Session::flash('login-error', $errorMsg);
    
                        return redirect("/admin/login");
//                                ->with("login-error", $errorMsg);
                    } else {
                        return redirect("/login");
                        exit;
                    }
                } else if (Auth::user()->userInformation->user_type == "3") {

                    if ($session_value == 'yes') {
                        Auth::logout();
                    
                        $errorMsg = "Apologies, your email or password is invalid or you does not have admin user privilages.";
                        \Session::flash('alert-class', 'alert-danger');
                        \Session::flash('login-error', $errorMsg);

                        return redirect("/admin/login");
//                                ->with("login-error", $errorMsg);
                    } else {
                        return redirect("/login");
                        exit;
                    }
                } else {
                    return redirect("profile");
                }
            } elseif (Auth::user()->userInformation->user_status == "0" || Auth::user()->userInformation->user_status == "2") {
                // some issue with the account activation. Redirect to login page.

                $is_register = $request->session()->pull('is_sign_up');
                $is_acc_verify = $request->session()->pull('bus_acc_verify');
                if (Auth::user()->userInformation->user_status == "0") {
                    if ($is_register) {
                         if ($is_acc_verify) {
                            $successMsg = "Congratulations! You have Registered Successfully!". "\r\n Your Account is under Verification.Once verified you will get verification link on your email.";
                             Auth::logout();
                    \Session::flash('alert-class', 'alert-success');
                    \Session::flash('register-success', $successMsg);
                        return redirect("login");
//                                ->with("login-error", $successMsg);
                        }
                     $successMsg = "Congratulations! your account is successfully created."."\r\n We have sent email verification email to your email address. Please verify";
                        
                        Auth::logout();
                        \Session::flash('alert-class', 'alert-success');
                        \Session::flash('register-success', $successMsg);
                    
                        return redirect("login");
//                                ->with("register-success", $successMsg);
                    } 
                    else {
                        $errorMsg = "We found your account is not yet verified. Kindly see the verification email, sent to your email address, used at the time of registration.";
                    }
                } else {
                    $errorMsg = "We apologies, your account is blocked by administrator. Please contact to administrator for further details.";
                }

                Auth::logout();
                \Session::flash('alert-class', 'alert-danger');
                 \Session::flash('login-error', $errorMsg);
                    
                return redirect("login");
//                        ->with("login-error", $errorMsg);
            }
        }
    }

    public function changeGlobalCurrency(Request $request,$currency){
        //dd($currency);
        Helper::setSessionCurrency($currency);
        return redirect()->back();

    }

}
