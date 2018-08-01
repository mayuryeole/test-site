<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\UserInformation;
use App\UserAddress;
use App\PiplModules\roles\Models\Role;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Mail;
use GlobalValues;
use App\PiplModules\admin\Models\Country;
use Session;
use Carbon;
use App\PiplModules\cart\Models\Cart;
use App\PiplModules\cart\Models\CartItem;

class AuthController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

    use AuthenticatesAndRegistersUsers,
        ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/redirect-dashboard';
//    protected $redirectPath = '/otp';
    protected $flag = 0;
    protected $otp_flag = 0;
    protected $u_type = 0;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getlogout', 'facebooklogout']]);
    }

    public function facebooklogout(\App\AuthenticateUser $authenticateUser, Request $request, $provider = null)
    {
        return $authenticateUser->deauthorize($this, $provider);
    }

    public function userHasLoggedOut()
    {
        return 'Logout completed';
    }

    public function logoutFromFacebook($acess_token)
    {
        return redirect('https://graph.facebook.com/v2.5/me/permissions?access_token=' . $acess_token);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('phone_number_must_between', function ($attribute, $value, $parameters, $validator) {

            if ((strlen($value) != 10) || $value <= 0) {
                return false;
            } else {
                return true;
            }
        });
        $messages = array(
            'phone_number_must_between' => 'Phone number must be 10 digit'
        );


        return Validator::make($data, [
            'email' => 'required|email|max:355|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'first_name' => 'required|regex:/[a-zA-Z]/',
            'last_name' => 'required|regex:/[a-zA-Z]/',
            'gender' => 'required',
            'user_country' => 'required|not_in:0',
            'user_mobile' => 'required|unique:user_informations|numeric|phone_number_must_between'
        ], $messages
        );
    }

    public function businessLogin(Request $request)
    {
        $business_remember = $request->business_remember;

        $email = $request->business_email;
        $password = ($request->business_password);

        if ($business_remember == 'on' && $business_remember != '') {

            setcookie("business_email", $email, time() + (86400 * 30), "/");
            setcookie("business_password", $password, time() + (86400 * 30), "/");
            setcookie("business_remember_flag", $request->business_remember, time() + (86400 * 30), "/");
        } else {
//            unset($_COOKIE['email']);
//            unset($_COOKIE['password']);
//            unset($_COOKIE['remember_flag']);
            setcookie('business_email', null, -1, '/');
            setcookie('business_password', null, -1, '/');
            setcookie('business_remember_flag', null, -1, '/');
        }

        $this->validate($request, [
            'business_email' => 'required|email',
            'business_password' => 'required'
        ]);
        $credentials = [
            'email' => $request->business_email,
            'password' => $request->business_password
        ];
        if (Auth::attempt($credentials, $request->has('business_remember')))
        {
            $user = Auth::user();
            if ($user->userInformation->user_type == "4")
            {
                //new added message to inactive on otp expire
                if($user->userInformation->user_status == '0')
                {
                    Auth::logout();
                    \Session::flash('alert-class', 'alert-danger');
                    \Session::flash('login-error', 'You account is not verified yet. please wait for email verification.');
                    return back()->withInput();
                }
//                elseif ($user->userInformation->verified == '0')
//                {
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'You account is not verified yet. kindly contact to Admin for your account activation.');
//                    return back()->withInput();
//                }
                else
                    {
                        $ipaddress = $request->ip();
//                    dd($ipaddress);
                    $cart = Cart::where('ip_address', $ipaddress)->first();
                    if ($cart != "") {
                        $cart_user = Cart::where("customer_id", Auth::user()->id)->first();
                        $user_cart = CartItem::where('cart_id', $cart->id)->get();
//                       dd($user_cart);
                        CartItem::where('cart_id', $cart->id)->update(['cart_id' => $cart_user->id]);

                        Cart::where('ip_address', $ipaddress)->delete();
//                       $cart->customer_id=Auth::user()->id;
//                    $cart->ip_address="";
//                    $cart->save();
                        $successMsg = "Login successfully.";
                        \Session::flash('alert-class', 'alert-success');
                        \Session::flash('register-success', $successMsg);
                        return redirect(url('/'));

                    } else {
                        $successMsg = "Login successfully.";
                        \Session::flash('alert-class', 'alert-success');
                        \Session::flash('register-success', $successMsg);
                        return redirect(url('/'));
                    }
                    }


//                if (isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3' && $user->userInformation->otp_status == "0" && $user->userInformation->user_status == '1' && $user->userInformation->verified == '1') {
////                    dd($user->id);
//                    $user_info = UserInformation::where('user_id', $user->id)->first();
//                    $user_info->user_status = '0';
////                    $user_info->verified=='1';
//
//                    $user_info->save();
//
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'Your account reverification failed,kindly contact to Admin for your account activation!!');
//                    return back()->withInput();
//                }
//                if (isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3' && $user->userInformation->otp_status != "1" && $user->userInformation->user_status == "1") {
//                    $user_info = UserInformation::where('user_id', $user->id)->first();
//                    $user_info->user_status = '0';
//                    $user_info->otp_status == '1';
//
//                    $user_info->save();
//
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'Your account reverification failed,kindly contact to Admin for your account activation!! ');
//
////                    \Session::flash('login-error', 'Please verify  with OTP send to your mobile number ');
//                    return back()->withInput();
//                }
                //new added

//                if (isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3' && $user->userInformation->otp_status != "1") {
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'Please verify  with OTP send to your mobile number ');
//                    return back()->withInput();
//                } else if ($user->userInformation->user_status != "1") {
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'You account is not verified yet. please wait for email verification.');
//                    return back()->withInput();
//                } else {
//                    $ipaddress = $request->ip();
////                    dd($ipaddress);
//                    $cart = Cart::where('ip_address', $ipaddress)->first();
//                    if ($cart != "") {
//                        $cart_user = Cart::where("customer_id", Auth::user()->id)->first();
//                        $user_cart = CartItem::where('cart_id', $cart->id)->get();
////                       dd($user_cart);
//                        CartItem::where('cart_id', $cart->id)->update(['cart_id' => $cart_user->id]);
//
//                        Cart::where('ip_address', $ipaddress)->delete();
////                       $cart->customer_id=Auth::user()->id;
////                    $cart->ip_address="";
////                    $cart->save();
//                        $successMsg = "Login successfully.";
//                        \Session::flash('alert-class', 'alert-success');
//                        \Session::flash('register-success', $successMsg);
//                        return redirect(url('/'));
//
//                    } else {
//                        $successMsg = "Login successfully.";
//                        \Session::flash('alert-class', 'alert-success');
//                        \Session::flash('register-success', $successMsg);
//                        return redirect(url('/'));
//                    }
//                }
            }
            else
            {
                Auth::logout();
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('login-error', 'You are not business user. Please login with Customer User Form ');
                return back()->withInput();
            }
        } else {
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('login-error', 'Apologies, your email or password is invalid or you does not have admin user privilages.');
            return back()->withInput();
        }
    }

    public function customerlogin(Request $request)
    {
//        dd($request);
        $ipaddress = $request->ip();
//                    dd($ipaddress);
//        dd($request->all());
        $remember = $request->remember;

        $email = $request->email;
        $password = ($request->password);

        if ($remember == 'on' && $remember != '') {

            setcookie("email", $email, time() + (86400 * 30), "/");
            setcookie("password", $password, time() + (86400 * 30), "/");
            setcookie("remember_flag", $request->remember, time() + (86400 * 30), "/");
        } else {
//            unset($_COOKIE['email']);
//            unset($_COOKIE['password']);
//            unset($_COOKIE['remember_flag']);
            setcookie('email', null, -1, '/');
            setcookie('password', null, -1, '/');
            setcookie('remember_flag', null, -1, '/');
        }

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials, $request->has('remember')))
        {
            $user = Auth::user();
//            dd($user->userAddress[0]->user_country);
            if ($user->userInformation->user_type == '3')
            {

//                if(isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3')
//                {
                    if ($user->userInformation->user_status = '0')
                    {
//                      dd(4);
                        Auth::logout();
                        $errorMsg = 'We found your account is not yet verified. Kindly see the verification email, sent to your email address, used at the time of registration. ';
                        \Session::flash('alert-class', 'alert-danger');
                        \Session::flash('login-error', $errorMsg);
                        return back()->withInput();
                    }
                    else{
                        $ipaddress = $request->ip();
                        $cart = Cart::where('ip_address', $ipaddress)->first();
                        if (isset($cart) && count($cart) > 0)
                        {
                            $cart_user = Cart::where("customer_id", Auth::user()->id)->first();
                            if (isset($cart_user) && count($cart_user) > 0)
                            {
                                $user_cart = CartItem::where('cart_id', $cart->id)->get();
                                CartItem::where('cart_id', $cart->id)->update(['cart_id' => $cart_user->id]);
                                Cart::where('ip_address', $ipaddress)->delete();
                            }

                            $successMsg = "Login successfully.";
                            \Session::flash('alert-class', 'alert-success');
                            \Session::flash('register-success', $successMsg);
                            return redirect(url('/'));

                        } else {
                            $successMsg = "Login successfully.";
                            \Session::flash('alert-class', 'alert-success');
                            \Session::flash('register-success', $successMsg);
                            return redirect(url('/'));
                        }
                    }
//                }

                //newly added
//                if (isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3' && $user->userInformation->otp_status == "0" && $user->userInformation->user_status == '1' && $user->userInformation->verified == '1') {
////                        dd(1);
//                    $user_info = UserInformation::where('user_id', $user->id)->first();
//                    $user_info->user_status = '0';
//                    $user_info->save();
//
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'Your account reverification failed,kindly contact to Admin for your account activation!!');
//                    return back()->withInput();
//                }
//                if (isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3' && $user->userInformation->otp_status != "1" && $user->userInformation->user_status == "1") {
////                    dd(2);
//                    $user_info = UserInformation::where('user_id', $user->id)->first();
//                    $user_info->user_status = '0';
//                    $user_info->otp_status == '1';
//
//                    $user_info->save();
//
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'Your account reverification failed,kindly contact to Admin for your account activation!! ');
//
////                    \Session::flash('login-error', 'Please verify  with OTP send to your mobile number ');
//                    return back()->withInput();
//                }
                //new added
//                if (isset($user->userAddress[0]) && $user->userAddress[0]->user_country == '3')
//                { // india
//                    if ($user->userInformation->otp_status != '1')
//                    {
////                        dd(3);
//                        Auth::logout();
//                        $errorMsg = 'Please verify  with OTP send to your mobile number ';
//                        \Session::flash('alert-class', 'alert-danger');
//                        \Session::flash('login-error', $errorMsg);
//                        return back()->withInput();
//                    }
//                    elseif ($user->userInformation->user_status != '1')
//                    {
////                      dd(4);
//                        Auth::logout();
//                        $errorMsg = 'We found your account is not yet verified. Kindly see the verification email, sent to your email address, used at the time of registration. ';
//                        \Session::flash('alert-class', 'alert-danger');
//                        \Session::flash('login-error', $errorMsg);
//                        return back()->withInput();
//                    }
//                }
//                elseif ($user->userInformation->user_status != "1") {
////isset($user->userAddress) && $user->userAddress[0]->user_country != '3' &&
////                    dd(5);
//                    Auth::logout();
//                    \Session::flash('alert-class', 'alert-danger');
//                    \Session::flash('login-error', 'You account is not verified yet. please verify your account.');
//                    return back()->withInput();
//                }
//                else if ($user->userInformation->user_status == "1") {
////                    dd(8);
//                    $ipaddress = $request->ip();
////                    dd($ipaddress);
//                    $cart = Cart::where('ip_address', $ipaddress)->first();
//                    if (isset($cart) && count($cart) > 0) {
//                        $cart_user = Cart::where("customer_id", Auth::user()->id)->first();
//                        if (isset($cart_user) && count($cart_user) > 0) {
//                            $user_cart = CartItem::where('cart_id', $cart->id)->get();
//                            CartItem::where('cart_id', $cart->id)->update(['cart_id' => $cart_user->id]);
//                            Cart::where('ip_address', $ipaddress)->delete();
//                        }
////                       dd($user_cart);
//
////                       $cart->customer_id=Auth::user()->id;
////                    $cart->ip_address="";
////                    $cart->save();
//                        $successMsg = "Login successfully.";
//                        \Session::flash('alert-class', 'alert-success');
//                        \Session::flash('register-success', $successMsg);
//                        return redirect(url('/'));
//
//                    } else {
//                        $successMsg = "Login successfully.";
//                        \Session::flash('alert-class', 'alert-success');
//                        \Session::flash('register-success', $successMsg);
//                        return redirect(url('/'));
//                    }
//
//                } else {
//                    $ipaddress = $ipaddress = $request->ip();;
////                    dd($ipaddress);
//                    $cart = Cart::where('ip_address', $ipaddress)->first();
//                    if ($cart != "") {
//                        $cart_user = Cart::where("customer_id", Auth::user()->id)->first();
//                        $user_cart = CartItem::where('cart_id', $cart->id)->get();
////                       dd($user_cart);
//                        CartItem::where('cart_id', $cart->id)->update(['cart_id' => $cart_user->id]);
//
//                        Cart::where('ip_address', $ipaddress)->delete();
////                    $cart->customer_id=Auth::user()->id;
////                    $cart->ip_address="";
////                    $cart->save();
//                        $successMsg = "Login successfully.";
//                        \Session::flash('alert-class', 'alert-success');
//                        \Session::flash('register-success', $successMsg);
//                        return redirect(url('/'));
//
//                    } else {
//                        $successMsg = "Login successfully.";
//                        \Session::flash('alert-class', 'alert-success');
//                        \Session::flash('register-success', $successMsg);
//                        return redirect(url('/'));
//                    }
////                    dd(10);
//
//                }
            } else {
//                dd(6);
                Auth::logout();
                $errorMsg = 'You are not customer user. Please login with Business User Form ';
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('login-error', $errorMsg);
                return back()->withInput();
            }
        } else
            {
            $errorMsg = 'Apologies, your email or password is invalid.';
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('login-error', $errorMsg);
            return back()->withInput();
        }
//        if ($user->userInformation->user_status == "1" && $user->userInformation->user_type == 3 && $user->userInformation->otp_status == 1) {
//            $ipaddress = $ipaddress = $request->ip();;
//            $cart = Cart::where('ip_address', $ipaddress)->first();
//            if (!$cart) {
//                $cart_user = Cart::where("customer_id", Auth::user()->id)->first();
//                $user_cart = CartItem::where('cart_id', $cart->id)->get();
////                       dd($user_cart);
//                CartItem::where('cart_id', $cart->id)->update(['cart_id' => $cart_user->id]);
//
//                Cart::where('ip_address', $ipaddress)->delete();
////                        $cart->customer_id=Auth::user()->id;
////                    $cart->ip_address="";
////                    $cart->save();
//                $successMsg = "Login successfully.";
//                \Session::flash('alert-class', 'alert-success');
//                \Session::flash('register-success', $successMsg);
//                return redirect(url('/'));
//
//            } else {
//                $successMsg = "Login successfully.";
//                \Session::flash('alert-class', 'alert-success');
//                \Session::flash('register-success', $successMsg);
//                return redirect(url('/'));
//            }
//        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function profUserRegistration()
    {

    }

    public function showOtpForm($user_id)
    {
        $user = UserInformation::where('user_id', $user_id)->first();
        $successMsg = 'OTP has been sent, Please verify';
        \Session::flash('alert-class', 'alert-success');
        \Session::flash('verification-success', $successMsg);

        return view('auth.otp_verification')->with(array('user_id' => $user_id, 'error' => '', 'user_type' => $user->user_type));
    }

    public function showBusinessRegistrationForm($user_type)
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView)->with('user_type', $user_type);
        }

        return view('auth.business_register')->with('user_type', $user_type);
    }

    public function showRegistrationForm($user_type)
    {
//        $flag = 0;
////        $ip = request()->ip();
//        $ip = "8.8.8.8";
//        $geopluginURL = 'http://www.geoplugin.net/php.gp?ip=' . $ip;
//        $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
//        $country = $addrDetailsArr['geoplugin_countryName'];
//        if($country == 'India') {
//            $flag = 1;
//        }        

        $ip = request()->ip();
        $flag = 0;
        if ($ip == "192.168.2.1" || $ip == "127.0.0.1") {
            $ip = "182.72.79.154";
        }
        $location = file_get_contents('http://freegeoip.net/json/' . "182.72.79.154");
        $user_location = json_decode($location);
        if ($user_location->country_name == 'India') {
            $flag = 1;
        }

        if (property_exists($this, 'registerView')) {
            return view($this->registerView)->with(array('user_type' => $user_type, 'flag' => $flag));
        }

        return view('auth.register')->with(array('user_type' => $user_type, 'flag' => $flag));
    }

    public function sendOTP(Request $request)
    {
        $msg = $this->otpVerification($mobile, $user_id);
        $responseData = explode('|', trim($msg));
        $status = trim($responseData[0]);
        if (!empty($status) && $status == 'success') {
//                $this->otp_flag = 1;
            return redirect('get-register-user/otp' . $user_id);
//                return view('auth.otp_verification')->with(array('user_id' => $user_id, 'error' => ''));
        } else {
            $delete_user = User::find($user_id);
            if ($delete_user) {
                $delete_user->delete();
            }
            $errorMsg = "OTP can't be send on your mobile number. Please Register & try again";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('otp-error', $errorMsg);
            return redirect('register/' . $user_type);
//                    ->with('otp-error', "OTP can't be send on your mobile number. Please Register & try again");
        }
    }

    public function register(Request $request)
    {
//        dd($request->all());

//        $validator = $this->validator($request->all());
//
//        if ($validator->fails()) {
//            $this->throwValidationException(
//                    $request, $validator
//            );
//        }

        $obj = $this->create($request->all());
        $user_type = $obj["user_type"];
        /***
         * if ($this->flag == 1) {
         * $mobile = $obj["user_mobile"];
         * $user_id = $obj["user_id"];
         * //            for otp check
         * $msg = $this->otpVerification($mobile, $user_id);
         * $responseData = explode('|', trim($msg));
         * $status = trim($responseData[0]);
         *
         * //for trial
         * //                $status="success";
         * if (!empty($status) && $status == 'success') {
         * //                    if ($status == 'success') {
         * //
         * //                          $this->otp_flag = 1;
         * return redirect('get/register-user/otp/' . $user_id);
         * //                return view('auth.otp_verification')->with(array('user_id' => $user_id, 'error' => ''));
         * } else {
         * $delete_user = User::find($user_id);
         * if ($delete_user) {
         * $delete_user->delete();
         * }
         * $errorMsg="OTP can't be send on your mobile number. Please Register & try again";
         * \Session::flash('alert-class', 'alert-danger');
         * \Session::flash('otp-error', $errorMsg);
         *
         * return redirect('register/' . $user_type);
         * //                        ->with('otp-error', "OTP can't be send on your mobile number. Please Register & try again");
         * }
         * }
         ***/
        Auth::guard($this->getGuard())->login($obj);

        return redirect($this->redirectPath());
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {

            return $this->redirectPath;
        }


        return property_exists($this, 'redirectTo') ? $this->redirectTo : 'home';
    }

    public function verifyOtp(Request $request)
    {
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        $user = User::orderBy('id', 'DESC')->first();
        $user_id = $user->id;
//        $user = User::where('id', $request->user_id)->first();
        $userInfo = UserInformation::where('user_id', $user_id)->first();
        $saved_date = $userInfo->updated_at;

        $interval = round(abs(time() - strtotime($saved_date)) / 60);  // Difference in time

        if ($userInfo->otp == $request->otp) {
            if ($interval > 0) {
                $userInfo->otp_status = 0;
                $userInfo->save();
                $errorMsg = 'OTP has expired, Please try again !';
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('otp-error', $errorMsg);
                return view('auth.otp_verification')->with(array('user_id' => $request->user_id, 'error' => ''));
            }
            $userInfo->otp_status = 1;
            $userInfo->save();
            Session::put('is_sign_up', 'otp');
            Session::save();
            if ($userInfo->user_type == '4') {
                Session::put('bus_acc_verify', 'bus');
                Session::save();
            }

            $arr_keyword_values = array();

//Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = $userInfo->first_name;
            $arr_keyword_values['LAST_NAME'] = $userInfo->last_name;
            $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $userInfo->activation_code);
            $arr_keyword_values['SITE_TITLE'] = $site_title;

            $email_template = EmailTemplate::where("template_key", 'registration-successful')->first();
            if ($userInfo->user_type != '4') {
                Mail::send('emailtemplate::registration-successful', $arr_keyword_values, function ($message) use ($user, $email_template, $site_email, $site_title) {
                    $message->to($user->email, $user->name)->subject($email_template->subject); //>from($site_email,$site_title);
                });
            }
            Auth::guard($this->getGuard())->login($user);
            return redirect($this->redirectPath());
        } else {
            $errorMsg = 'Wrong OTP, Please Enter Correct OTP !';
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('otp-error', $errorMsg);
            return view('auth.otp_verification')->with(array('user_id' => $user->id, 'error' => ''));
        }
    }

    public function resendOtp($user_id)
    {
        $user = UserInformation::where('user_id', $user_id)->first();

        $msg = $this->otpVerification($user->user_mobile, $user_id);
        $responseData = explode('|', trim($msg));
        $status = trim($responseData[0]);
        if (!empty($status) && $status == 'success') {
            return redirect('get/register-user/otp/' . $user_id);
        } else {
            $errorMsg = "OTP can't be send on your mobile number. Please Register & try again";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('otp-error', $errorMsg);

            return redirect('get/register-user/otp/' . $user_id);
//                    ->with('otp-error', "OTP can't be send on your mobile number. Please Register & try again");
        }
    }

    public function goBack($user_id)
    {
        $user = UserInformation::where('user_id', $user_id)->first();
        $delete_user = User::find($user_id);
        if ($delete_user) {
            $delete_user->delete();
        }
        return redirect('register/' . $user->user_type);
    }

    protected function create(array $data)
    {

//getting from global setting
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');


//Variable Declarations
        $arr_userinformation = array();
        $arr_useraddress = array();
        $hasAddress = 0;

        /*         * * here we creating user in user table only with email and password fileds * */
        $created_user = User::create([
            'email' => $data['email'],
            'password' => ($data['password']),
        ]);
// update User Information
        /*
         * Adjusted user specific columns, which may not passed on front end and adjusted with the default values
         */
        $data["user_type"] = isset($data["user_type"]) ? $data["user_type"] : "2";   // 1 may have several mean as per enum stored in the database. Here we 
        $data["role_id"] = isset($data["role_id"]) ? $data["role_id"] : "2";         // 2 means registered user
        $data["user_status"] = isset($data["user_status"]) ? $data["user_status"] : "0";  // 0 means not active
        $data["gender"] = isset($data["gender"]) ? $data["gender"] : "3";     // 3 means not specified
        $data["profile_picture"] = isset($data["profile_picture"]) ? $data["profile_picture"] : "";
        $data["facebook_id"] = isset($data["facebook_id"]) ? $data["facebook_id"] : "";
        $data["twitter_id"] = isset($data["twitter_id"]) ? $data["twitter_id"] : "";
        $data["google_id"] = isset($data["google_id"]) ? $data["google_id"] : "";
        $data["linkedin_id"] = isset($data["linkedin_id"]) ? $data["linkedin_id"] : "";
        $data["pintrest_id"] = isset($data["pintrest_id"]) ? $data["pintrest_id"] : "";
        $data["user_birth_date"] = isset($data["user_birth_date"]) ? $data["user_birth_date"] : "";
        $data["first_name"] = isset($data["first_name"]) ? $data["first_name"] : "";
        $data["last_name"] = isset($data["last_name"]) ? $data["last_name"] : "";
        $data["about_me"] = isset($data["about_me"]) ? $data["about_me"] : "";
        $data["user_phone"] = isset($data["user_phone"]) ? $data["user_phone"] : "";
        $data["user_mobile"] = isset($data["user_mobile"]) ? $data["user_mobile"] : "";
        $data["company_name"] = isset($data["company_name"]) ? $data["company_name"] : "";
        $data["company_type"] = isset($data["company_type"]) ? $data["company_type"] : "";
        $data["pancard_no"] = isset($data["pancard_no"]) ? $data["pancard_no"] : "";
        $data["gst_no"] = isset($data["gst_no"]) ? $data["gst_no"] : "";
        $data["tax_id"] = isset($data["tax_id"]) ? $data["tax_id"] : "";

//getting address Information.

        $data["addressline1"] = isset($data["addressline2"]) ? $data["addressline1"] : "";
        $data["addressline2"] = isset($data["addressline2"]) ? $data["addressline2"] : "";
        $data["user_country"] = isset($data["user_country"]) ? $data["user_country"] : NULL;
        $data["user_state"] = isset($data["user_state"]) ? $data["user_state"] : NULL;
        $data["user_city"] = isset($data["user_city"]) ? $data["user_city"] : NULL;
        $data["suburb"] = isset($data["suburb"]) ? $data["suburb"] : "";
        $data["user_custom_city"] = isset($data["user_custom_city"]) ? $data["user_custom_city"] : "";
        $data["zipcode"] = isset($data["zipcode"]) ? $data["zipcode"] : "";

        /** user information goes here *** */
        $arr_userinformation["profile_picture"] = $data["profile_picture"];
        $arr_userinformation["gender"] = $data["gender"];
        $arr_userinformation["activation_code"] = "";             // By default it'll be no activation code
        $arr_userinformation["facebook_id"] = $data["facebook_id"];
        $arr_userinformation["twitter_id"] = $data["twitter_id"];
        $arr_userinformation["google_id"] = $data["google_id"];
        $arr_userinformation["linkedin_id"] = $data["linkedin_id"];
        $arr_userinformation["pintrest_id"] = $data["pintrest_id"];
        $arr_userinformation["user_birth_date"] = $data["user_birth_date"];
        $arr_userinformation["first_name"] = $data["first_name"];
        $arr_userinformation["last_name"] = $data["last_name"];
        $arr_userinformation["about_me"] = $data["about_me"];
        $arr_userinformation["user_phone"] = $data["user_phone"];
        $arr_userinformation["user_mobile"] = $data["user_mobile"];
        $arr_userinformation["user_status"] = $data["user_status"];
        $arr_userinformation["user_type"] = $data["user_type"];
        $arr_userinformation["user_id"] = $created_user->id;
        $arr_userinformation["company_name"] = $data["company_name"];
        $arr_userinformation["company_type"] = $data["company_type"];
        $arr_userinformation["pancard_no"] = $data["pancard_no"];
        $arr_userinformation["gst_no"] = $data["gst_no"];
        $arr_userinformation["tax_id"] = $data["tax_id"];

        $updated_user_info = UserInformation::create($arr_userinformation);

//        dd($updated_user_info);
        /** user addesss informations goes here *** */
        if ($data["addressline1"] != '') {
            $arr_useraddress["address1"] = $data["addressline1"];
            $hasAddress = 1;
        }
        if ($data["addressline2"] != '') {
            $arr_useraddress["address2"] = $data["addressline2"];
            $hasAddress = 1;
        }
        if ($data["user_country"] != '') {
            $arr_useraddress["user_country"] = $data["user_country"];
            $hasAddress = 1;
        }
        if ($data["user_state"] != '') {
            $arr_useraddress["user_state"] = $data["user_state"];
            $hasAddress = 1;
        }
        if ($data["user_city"] != '') {
            $arr_useraddress["user_city"] = $data["user_city"];
            $hasAddress = 1;
        }
        if ($data["suburb"] != '') {
            $arr_useraddress["suburb"] = $data["suburb"];
            $hasAddress = 1;
        }
        if ($data["user_custom_city"] != '') {
            $arr_useraddress["user_custom_city"] = $data["user_custom_city"];
            $hasAddress = 1;
        }
        if ($data["zipcode"] != '') {
            $arr_useraddress["zipcode"] = $data["zipcode"];
            $hasAddress = 1;
        }
        if ($created_user->id != '') {
            $arr_useraddress["user_id"] = $created_user->id;
        }
        if ($hasAddress) {
            UserAddress::create($arr_useraddress);
        }

// asign role to respective user		
        $userRole = Role::where("slug", "registered.user")->first();

        $created_user->attachRole($userRole);

//sending an email to the user on successfull registration.

        $arr_keyword_values = array();
        $activation_code = $this->generateReferenceNumber();
//Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = $updated_user_info->first_name;
        $arr_keyword_values['LAST_NAME'] = $updated_user_info->last_name;
        $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
        $arr_keyword_values['SITE_TITLE'] = $site_title;
// updating activation code                 
        $updated_user_info->activation_code = $activation_code;
        $country = Country::translatedIn(\App::getLocale())->where('id', $data["user_country"])->first();
        if ($country->name == 'India') {
            $updated_user_info->otp_status = 1;
        }
        $updated_user_info->save();


        /***
         * if ($country->name == 'India') {
         * $this->flag = 1;
         * return $updated_user_info;
         * } else {
         * **/
        if ($data["user_type"] == '4') {
            Session::put('bus_acc_verify', 'bus');
        } else {
            $email_template = EmailTemplate::where("template_key", 'registration-successful')->first();
            Mail::send('emailtemplate::registration-successful', $arr_keyword_values, function ($message) use ($created_user, $email_template, $site_email, $site_title) {
                $message->to($created_user->email, $created_user->name)->subject($email_template->subject); //>from($site_email,$site_title);
            });
        }
        return $created_user;
        /*** } ***/
    }

    public function otpVerification($mobile, $user_id)
    {

        $otp = $this->getRandomOtp();
        $request = ""; //initialise the request variable
        $param['method'] = "sendMessage";
        $param['send_to'] = "91" . $mobile;
        $param['msg'] = $otp;
        $param['userid'] = "2000175289";
        $param['password'] = "temp123";
        $param['v'] = "1.1";
        $param['msg_type'] = "TEXT"; //Can be "FLASH”/"UNICODE_TEXT"/”BINARY”
        $param['auth_scheme'] = "PLAIN";

//Have to URL encode the values
        foreach ($param as $key => $val) {
            $request .= $key . "=" . urlencode($val);
//we have to urlencode the values
            $request .= "&";
//append the ampersand (&) sign after each
//            parameter/value pair
        }
        $request = substr($request, 0, strlen($request) - 1);
//remove final (&) sign from the request
        $url = "http://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        UserInformation::where('user_id', $user_id)->update(array('otp' => $otp));
        return $curl_scraped_page;
    }

    private function generateReferenceNumber()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    public function getRandomOtp()
    {
        return rand(pow(10, 4 - 1), pow(10, 4) - 1);
    }

    public function logout()
    {
        Auth::guard($this->getGuard())->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');
        Validator::make($request, ['email' => 'required|email|max:355|unique:users']);

        if (property_exists($this, 'resetView')) {

            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('auth.passwords.reset')) {

            return view('auth.passwords.reset')->with(compact('token', 'email'));
        }

        return view('auth.reset')->with(compact('token', 'email'));
    }

    public function reset(Request $request)
    {
        $this->validate(
            $request, $this->getResetValidationRules(), $this->getResetValidationMessages(), $this->getResetValidationCustomAttributes()
        );

        $credentials = $this->getResetCredentials($request);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return $this->getResetSuccessResponse($response);
            default:
                return $this->getResetFailureResponse($request, $response);
        }
    }

}
