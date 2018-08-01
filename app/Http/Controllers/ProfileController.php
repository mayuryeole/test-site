<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInformation;
use App\UserAddress;
use App\PiplModules\roles\Models\Role;
use Validator;
use Auth;
use Mail;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use GlobalValues;
use FileUpload;
use Illuminate\Support\Facades\URL;
use App\PiplModules\admin\Helpers\Email;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Session;

//use App\PiplModules\admin\Models\CountryTranslation
class ProfileController extends Controller {
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

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
//    protected function validator(array $data) {
//        //only common files if we have multiple registration
////        return Validator::make($data, [
////                    'email' => 'required|email|max:355|unique:users',
////                    'password' => 'required|min:6|confirmed',
////                    'password_confirmation' => 'required|min:6',
////                    'first_name' => 'required|regex:/[a-zA-Z]/',
////                    'last_name' => 'required|regex:/[a-zA-Z]/',
////                    'user_country' => 'required|not_in:0',
////                    'user_mobile' => 'required|numeric|regex:/[0-9]{10}/|min:1'
////                        ], array('user_mobile.min' => 'Please enter valid mobile number.')
////        );
//        Validator::extend('phone_number_must_between', function($attribute, $value, $parameters, $validator) {
//
//            if ((strlen($value) != 10) || $value <= 0) {
//                return false;
//            } else {
//                return true;
//            }
//        });
//        $messages = array(
//            'phone_number_must_between' => 'Phone number must be 10 digit'
//        );
//
//
//
//        return Validator::make($data, [
//                    'email' => 'required|email|max:355|unique:users',
//                    'password' => 'required|min:6|confirmed',
//                    'password_confirmation' => 'required|min:6',
//                    'first_name' => 'required|regex:/[a-zA-Z]/',
//                    'last_name' => 'required|regex:/[a-zA-Z]/',
//                    'user_country' => 'required|not_in:0',
//                    'user_mobile' => 'required|numeric|phone_number_must_between'
//                        ], $messages
//        );
//    }

    public function __construct() {
        //  $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function sendMail() {

        $arr_keyword_values = array();
        //Assign values to all macros
        $arr_keyword_values['FIRST_NAME'] = 'afaque';
        $arr_keyword_values['LAST_NAME'] = 'shaikh';
        $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . 123);

        $header['to'][] = array('afaque@panaceatek.com', 'afaque');
//    $header['to'][]=array('dnyaneshwar@panaceatek.com','dnyaneshwar');
//    $header['attachment'][]=base_path()."/public/media/front/bugs.doc";
//    $header['attachment'][]=base_path()."/public/media/front/bugs.doc";
        $header['attachment'] = base_path() . "/public/media/front/bugs.doc";

//    $header['from']=array('afaque@panaceatek.com','afaque');

        dd(Email::mail('admin-registration-successful', $arr_keyword_values, $header));
    }

    public function uploadProfileFile(Request $request) {
        $data = FileUpload::upload(
                        $request, array("file_audio", "file_documents", "profile_image", "file_video"), array("audio", "*", "image", 'video'), array("audio11/", "documents11/", "profile-images11/", "video11/"), array(null,
                    null,
                    array(['resize' => true, 'width' => 120, 'height' => 120, 'destination' => 'img/thumb-small/']
                        , null)
                        ), array(
                    array("custom_messages" => array("audio" => "Not valid audio file", "required" => "Please upload your album song buddy")),
                    array("custom_messages" => array("required" => "select file")),
                    array("custom_messages" => array("image" => "Not valid image file", "required" => "Please select your profile image.")),
                    null,
                        )
        );

        dd($data);
    }

    public function cropExample() {
        return view('examples.crop_example');
    }

    public function cropPostImage(Request $request) {
        $destinationPath = 'images/user-profile-pic/';
        $obj = new Filesystem();
        if (!is_dir(storage_path($destinationPath))) {
            Storage::makeDirectory($destinationPath);
            chmod(storage_path('app/' . $destinationPath), 0777);
        }
        try {
            if (isset($_POST['imagebase64'])) {
                $data = $_POST['imagebase64'];
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $filename = uniqid() . '.png';

                file_put_contents(storage_path('app/' . $destinationPath) . '/' . $filename, $data);
                echo $filename;
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    protected function validator(array $data) {
        //only common files if we have multiple registration
//        return Validator::make($data, [
//                    'first_name' => 'required|regex:/[a-zA-Z]/',
//                    'last_name' => 'required|regex:/[a-zA-Z]/',
//                    'suburb' => 'required',
//                    'zipcode' => 'required|regex:/[0-9]/|min:0',
//        ]);

        Validator::extend('phone_number_must_between', function($attribute, $value, $parameters, $validator) {

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
//                    'user_country' => 'required|not_in:0',
                    'user_mobile' => 'required|unique:user_informations|numeric|phone_number_must_between'
                        ], $messages
        );
    }

    protected function verifyUserEmail($activation_code) {
        $user_informations = UserInformation::where('activation_code', $activation_code)->first();

        if (count($user_informations) > 0 && isset($user_informations->user_status)) {
            $successMsg = "Congratulations! your account has been successfully verified. Please login to continue";
            if ($user_informations->user_status == '0') {

                //updating the user status to active
                $user_informations->user_status = '1';
                $user_informations->activation_code = '';
                $user_informations->save();

                Auth::logout();
                if ($user_informations->user_type == '1') {
                    return redirect("admin/login")->with("register-success", $successMsg);
                } else {
                    return redirect("login")->with("register-success", $successMsg);
                }
            }
//            else {
//                $user_informations->activation_code = '';
//                $user_informations->save();
//                $errorMsg = "Error! this link has been expired";
//                Auth::logout();
//                if ($user_informations->user_type == '1') {
//                    return redirect("admin/login")->with("register-success", $successMsg);
//                } else {
//                    return redirect("login")->with("login-error", $errorMsg);
//                }
//            }
        } else {
            $errorMsg = "Error! this link has been expired";
            Auth::logout();
            if (isset($user_informations->user_type) && $user_informations->user_type == '1') {
                return redirect("admin/login")->with("login-error", $errorMsg);
            } else {
                return redirect("login")->with("login-error", $errorMsg);
            }
        }
    }

    protected function show() {
        if (Auth::user()) {
            $arr_user_data = Auth::user();
            return view('profile', array("user_info" => $arr_user_data));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    protected function updateProfile() {
       
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
            $arr_user_data = User::findOrfail($user_id);
//            dd($arr_user_data);
            return view('update-profile', array("user_info" => $arr_user_data));
        } else {

            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    protected function updateProfileInfo(Request $data) {
//        dd($data);
//        dd(Auth::user()->userInformation->addressUser->countryUser);
//        if(isset(Auth::user()->userInformation->addressUser->countryUser) && Auth::user()->userInformation->addressUser->countryUser==null && Auth::user()->userInformation->facebook_id!=null)
        if (Auth::user()->userInformation->facebook_id != null && $data->user_mobile != "") {
//              dd(1);
            $errorMsg = 'Sorry!!You cannot update mobile number in test environment';
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('profile-updated-failure', $errorMsg);
            return redirect(url('profile'));
//                            ->with('profile-updated','You cannot update mobile number in test environment');
        } else if (Auth::user()->userInformation->facebook_id != null && $data->user_mobile == "") {
            if (Auth::user()) {
                $arr_user_data = Auth::user();
//            dd($arr_user_data->userInformation->user_mobile);
                $hasAddress = 0;
                // update User Information
                /*
                 * Adjusted user specific columns, which may not passed on front end and adjusted with the default values
                 */

//
//            $validator = $this->validator($data->all());
//
//            if ($validator->fails()) {
//                $this->throwValidationException(
//                        $data, $validator
//                );
//            }

                /** user addesss informations goes here *** */
//            dd(2);
//                dd(isset($data["birth_date"]));
                $user_address = UserAddress::where('user_id', $arr_user_data->id)->first();

                if (!isset($user_address) && count($user_address) < 0) {
                    $user_address = UserAddress::create(array('user_id', $arr_user_data->id));
                }
                if ($data["addressline1"] != '') {
                    $user_address->addressline1 = $data["addressline1"];
                    $hasAddress = 1;
                }
                if ($data["addressline2"] != '') {
                    $user_address->addressline2 = $data["addressline2"];
                    $hasAddress = 1;
                }
                if ($data["user_country"] != '') {
                    $user_address->user_country = $data["user_country"];
                    $hasAddress = 1;
                }
                if ($data["user_state"] != '') {
                    $user_address->user_state = $data["user_state"];
                    $hasAddress = 1;
                }
                if ($data["user_city"] != '') {
                    $user_address->user_city = $data["user_city"];
                    $hasAddress = 1;
                }
                if ($data["suburb"] != '') {
                    $user_address->suburb = $data["suburb"];
                    $hasAddress = 1;
                }
                if ($data["user_custom_city"] != '') {
                    $user_address->user_custom_city = $data["user_custom_city"];
                    $hasAddress = 1;
                }
                if ($data["zipcode"] != '') {
                    $user_address->zipcode = $data["zipcode"];
                    $hasAddress = 1;
                }


                if ($hasAddress) {
                    $user_address->save();
                }

//                dd($user_address);
                $user_id = $data["user_id"];
//            dd($arr_user_data->userInformation->user_mobile);
                $new_mobile = $data["user_mobile"];

                $old_mobile = $arr_user_data->userInformation->user_mobile;

                /** user information goes here *** */
                if (isset($data["profile_picture"])) {
                    $arr_user_data->userInformation->profile_picture = $data["profile_picture"];
                }
                if (isset($data["gender"])) {
                    $arr_user_data->userInformation->gender = $data["gender"];
                }
                if (isset($data["user_birth_date"])) {
                    $arr_user_data->userInformation->user_birth_date = $data["user_birth_date"];
                }
                if (isset($data["first_name"])) {
                    $arr_user_data->userInformation->first_name = $data["first_name"];
                }
                if (isset($data["last_name"])) {
                    $arr_user_data->userInformation->last_name = $data["last_name"];
                }
                if (isset($data["about_me"])) {
                    $arr_user_data->userInformation->about_me = $data["about_me"];
                }
                if (isset($data["user_phone"])) {
                    $arr_user_data->userInformation->user_phone = $data["user_phone"];
                }
                
                if (isset($data["birth_date"])) {
                    $arr_user_data->userInformation->birth_date = $data["birth_date"];
                }
                if (isset($data["anniversary_date"])) {
                    $arr_user_data->userInformation->anniversary_date = $data["anniversary_date"];
                }
//                dd($arr_user_data->userInformation);
//                if (isset($data["user_mobile"])) {
//                    $arr_user_data->userInformation->user_mobile = $data["user_mobile"];
//                }
//                $arr_user_data->save();
                $arr_user_data->userInformation->save();
                $successMsg = "Your profile has been updated successfully!";
                \Session::flash('alert-class', 'alert-success');
                \Session::flash('profile-updated', $successMsg);
//           dd(4);
                return redirect("profile");
            }
        }
//        else if (isset(Auth::user()->userInformation->addressUser->countryUser) && Auth::user()->userInformation->addressUser->countryUser != null && Auth::user()->userInformation->facebook_id == null) {
        // @check again this condition with social media integration
        else if (isset(Auth::user()->id)) {
            if (Auth::user()) {
                $arr_user_data = Auth::user();
//            dd($arr_user_data->userInformation->user_mobile);
                $hasAddress = 0;
                // update User Information
                /*
                 * Adjusted user specific columns, which may not passed on front end and adjusted with the default values
                 */

//
//            $validator = $this->validator($data->all());
//
//            if ($validator->fails()) {
//                $this->throwValidationException(
//                        $data, $validator
//                );
//            }

                /** user addesss informations goes here *** */
//            dd(2);
                $user_address = UserAddress::where('user_id', $arr_user_data->id)->first();

                if (!isset($user_address) && count($user_address) < 0) {
                    $user_address = UserAddress::create(array('user_id', $arr_user_data->id));
                }
                if ($data["addressline1"] != '') {
                    $user_address->addressline1 = $data["addressline1"];
                    $hasAddress = 1;
                }
                if ($data["addressline2"] != '') {
                    $user_address->addressline2 = $data["addressline2"];
                    $hasAddress = 1;
                }
                if ($data["user_country"] != '') {
                    $user_address->user_country = $data["user_country"];
                    $hasAddress = 1;
                }
                if ($data["user_state"] != '') {
                    $user_address->user_state = $data["user_state"];
                    $hasAddress = 1;
                }
                if ($data["user_city"] != '') {
                    $user_address->user_city = $data["user_city"];
                    $hasAddress = 1;
                }
                if ($data["suburb"] != '') {
                    $user_address->suburb = $data["suburb"];
                    $hasAddress = 1;
                }
                if ($data["user_custom_city"] != '') {
                    $user_address->user_custom_city = $data["user_custom_city"];
                    $hasAddress = 1;
                }
                if ($data["zipcode"] != '') {
                    $user_address->zipcode = $data["zipcode"];
                    $hasAddress = 1;
                }


                if ($hasAddress) {
                    $user_address->save();
                }

//                dd($user_address);
                $user_id = $data["user_id"];
//            dd($arr_user_data->userInformation->user_mobile);
                $new_mobile = $data["user_mobile"];

                $old_mobile = $arr_user_data->userInformation->user_mobile;

                /** user information goes here *** */
                if (isset($data["profile_picture"])) {
                    $arr_user_data->userInformation->profile_picture = $data["profile_picture"];
                }
                if (isset($data["gender"])) {
                    $arr_user_data->userInformation->gender = $data["gender"];
                }
                if (isset($data["user_birth_date"])) {
                    $arr_user_data->userInformation->user_birth_date = $data["user_birth_date"];
                }
                if (isset($data["first_name"])) {
                    $arr_user_data->userInformation->first_name = $data["first_name"];
                }
                if (isset($data["last_name"])) {
                    $arr_user_data->userInformation->last_name = $data["last_name"];
                }
                if (isset($data["about_me"])) {
                    $arr_user_data->userInformation->about_me = $data["about_me"];
                }
                if (isset($data["user_phone"])) {
                    $arr_user_data->userInformation->user_phone = $data["user_phone"];
                }
                if (isset($data["user_mobile"])) {
                    $arr_user_data->userInformation->user_mobile = $data["user_mobile"];
                }
                if (isset($data["birth_date"])) {
                    $arr_user_data->userInformation->birth_date = $data["birth_date"];
                }
                if (isset($data["anniversary_date"])) {
                    $arr_user_data->userInformation->anniversary_date = $data["anniversary_date"];
                }
//                dd($arr_user_data);
//            dd($user_address);
                if ($data->user_mobile != "" && isset($user_address->user_country)) {
                    if($user_address->user_country == 3) {
//                dd($user_address->user_country);
//          dd($old_mobile);
                        if ($new_mobile != $old_mobile) {
//                            dd(123);
                            $mob = base64_decode($new_mobile);
                            $arr_user_data->userInformation->user_mobile = $new_mobile;
                            $arr_user_data->userInformation->otp_status = 1;    // Change this when as per phase 4 OTP module
                            $arr_user_data->userInformation->save();                            
                            $successMsg = "Your profile has been updated successfully!";
                            \Session::flash('alert-class', 'alert-success');
                            \Session::flash('profile-updated', $successMsg);
                            return redirect("profile");
                            
                            //comment these code to resend otp
//                        $otp = $this->getRandomOtp();
//                        UserInformation::where('user_id', $user_id)->update(array('otp' => $otp));
//                        $status = 'success';
//                if (!empty($status) && $status == 'success') {
//                    Session::put('verification-success', 'OTP has been sent, Please verify');
//                    Auth::logout();
//                    return redirect('update_mobile_otp/' . $user_id);
//                } else {
//                    $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
//                    Auth::logout();
//                    return redirect("login")->with("login-error", $errorMsg);
//                }
//                dd(3);
                            //uncomment these code to resend otp
                            $msg = $this->otpVerification($data["user_mobile"], $user_id);
                            $responseData = explode('|', trim($msg));
                            $status = trim($responseData[0]);
                            // dd(243454);
//                dd($status);
//                dd($user_id);

                            if ($status == 'success') {
//                    dd($mob);
                                $successMsg = 'OTP has been sent, Please verify';
                                \Session::flash('alert-class', 'alert-success');
                                \Session::flash('verification-success', $successMsg);
//                    return redirect(url('update_mobile_otp/' . $user_id."/".$mob));
                                return redirect('get-user-otp/update_mobile_otp/' . $user_id . "/" . $mob);
//                    return redirect(URL::previous());
                            } else {
//                                    dd(453);

                                $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
                                \Session::flash('alert-class', 'alert-danger');
                                \Session::flash('issue-profile', $errorMsg);

                                Auth::logout();
                                return redirect("login");
//                            ->with("issue-profile", $errorMsg);
                            }
                        }
                    }
//                            dd(453);
                }
                $arr_user_data->userInformation->save();
                $successMsg = "Your profile has been updated successfully!";
                \Session::flash('alert-class', 'alert-success');
                \Session::flash('profile-updated', $successMsg);
//           dd(4);
                return redirect("profile");
//                    ->with("profile-updated", $succes_msg);
            }
        } else {
//            dd(5);
            $errorMsg = "Error! Something is wrong going on.";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);

            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    protected function updateEmail() {
        if (Auth::user()) {
            $arr_user_data = Auth::user();
            return view('update-email', array("user_info" => $arr_user_data));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);

            Auth::logout();
            return redirect("login");
//        ->with("issue-profile", $errorMsg);
        }
    }

    protected function updatePassword() {

        if (Auth::user()) {
            $arr_user_data = Auth::user();
            return view('update-password', array("user_info" => $arr_user_data));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);
            Auth::logout();
            return redirect("login");
//        ->with("issue-profile", $errorMsg);
        }
    }

    protected function updateEmailInfo(Request $data) {
        if (Auth::user()->userInformation->facebook_id != "" || Auth::user()->userInformation->google_id != null) {
//            dd(1);
            $errorMsg = "Sorry!! You cannot update email-id as it is linked with your social site account ";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('profile-updated-failure', $errorMsg);
            return redirect(url('profile'));
        }
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = Auth::user();
            $validate_response = Validator::make($data_values, array(
                        'email' => 'required|email|max:500|unique:users,email,' . $arr_user_data->id,
                        'confirm_email' => 'required|same:email',
            ));

            if ($validate_response->fails()) {
                return redirect('change-email')
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                $old_email = $data->old_email;
                $current_email = $data->email;
                //updating user email
                $arr_user_data->email = $data->email;
                $arr_user_data->save();

                //updating user status to inactive
                if ($current_email !== $old_email) {
                    $arr_user_data->userInformation->user_status = 0;
                }

                $arr_user_data->userInformation->save();
                //sending email with verification link
                //sending an email to the user on successfull registration.

                $arr_keyword_values = array();
                $activation_code = $this->generateReferenceNumber();
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);

                // updating activation code                 

                if ($current_email !== $old_email) {
                    $arr_user_data->userInformation->activation_code = $activation_code;

                    Mail::send('emailtemplate::email-change', $arr_keyword_values, function ($message) use ($arr_user_data) {

                        $message->to($arr_user_data->email)->subject("Email Changed Successfully!");
                    });

                    $successMsg = "Congratulations! your email has been updated successfully.We have sent email verification email to your email address. Please verify";
                    \Session::flash('alert-class', 'alert-success');
                    \Session::flash('register-success', $successMsg);
                } else {

                    $successMsg = "Congratulations! your email has been updated successfully.";
                    \Session::flash('alert-class', 'alert-success');
                    \Session::flash('register-success', $successMsg);
                }
                $arr_user_data->userInformation->save();
                Auth::logout();
                return redirect("login");
//                        ->with("register-success", $successMsg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);

            Auth::logout();
            return redirect("login");
//        ->with("issue-profile", $errorMsg);
        }
    }

    protected function updatePasswordInfo(Request $data) {
        $current_password = $data->current_password;
        if (Auth::user()) {
            if ($data->new_password !== $data->confirm_password) {
                $errorMsg = "Error! Something is wrong going on.Make Sure you type correct current password";
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('password-update-fail', $errorMsg);

                return redirect("change-password");
//        ->with("password-update-fail", $errorMsg);
            }
            if ($data->new_password == "" || $data->confirm_password == "") {
                $errorMsg = "Error! Something is wrong going on.Make Sure you type correct current password";
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('password-update-fail', $errorMsg);

                return redirect("change-password");
//        ->with("password-update-fail", $errorMsg);
            }
            $arr_user_data = Auth::user();
            $user_password_chk = Hash::check($current_password, $arr_user_data->password);
//            dd($user_password_chk);
            if ($user_password_chk) {
                $arr_user_data->password = $data->new_password;
                $arr_user_data->save();
                $successMsg = "Congratulations! your password has been updated successfully.";
                \Session::flash('alert-class', 'alert-success');
                \Session::flash('password-update-success', $successMsg);

                return redirect("profile");
//                        ->with("password-update-success", $successMsg);
            } else {
                $errorMsg = "Error! Something is wrong going on.Make Sure you type correct current password";
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('password-update-fail', $errorMsg);

                return redirect("change-password");
//                        ->with("password-update-fail", $errorMsg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on .Make Sure you type correct current password";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);

            Auth::logout();
            return redirect("login");
//        ->with("issue-profile", $errorMsg);
        }
    }

    private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    //check email duplicate
    protected function chkEmailDuplicate(Request $request) {

//        echo "0";
//        exit();
        $email = $request->email;
        if ($email) {
            $user_info = User::where('email', $email)->first();
            $type = $user_info->userInformation->user_type;
            if ($user_info) {
                echo "false";
                exit();
            } else {
                echo "true";
                exit();
            }
        }
    }

    //check current password
    protected function chkCurrentPassword(Request $request) {
        $current_password = $request->current_password;
        $user_info = Auth::User();

        if ($current_password) {
            $user_info = Hash::check($current_password, $user_info->password);
            if ($user_info) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    public function newResendOtp($user_id) {
        $user = UserInformation::where('user_id', $user_id)->first();

        //comment these code to resend otp
//        $otp = $this->getRandomOtp();
//        UserInformation::where('user_id', $user_id)->update(array('otp' => $otp));
//        $status = 'success';
//        if (!empty($status) && $status == 'success') {
//            Session::put('verification-success', 'OTP has been resent, Please verify');
//            return redirect('update_mobile_otp/' . $user_id);
//        } else {
//            $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
//            Auth::logout();
//            return redirect("login")->with("login-error", $errorMsg);
//        }
        //uncomment these code to resend otp
        $msg = $this->otpVerification($user->user_mobile, $user_id);
        $responseData = explode('|', trim($msg));
        $status = trim($responseData[0]);
        return $status;
    }

    public function sendOtp($user_id) {
        $user = UserInformation::where('user_id', $user_id)->first();

        //comment these code to resend otp
//        $otp = $this->getRandomOtp();
//        UserInformation::where('user_id', $user_id)->update(array('otp' => $otp));
//        $status = 'success';
//        if (!empty($status) && $status == 'success') {
//            Session::put('verification-success', 'OTP has been resent, Please verify');
//            return redirect('update_mobile_otp/' . $user_id);
//        } else {
//            $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
//            Auth::logout();
//            return redirect("login")->with("login-error", $errorMsg);
//        }
        //uncomment these code to resend otp
        $msg = $this->otpVerification($user->user_mobile, $user_id);
        $responseData = explode('|', trim($msg));
        $status = trim($responseData[0]);
        if (!empty($status) && $status == 'success') {

            $successMsg = 'OTP has been resent, Please verify';
            \Session::flash('alert-class', 'alert-success');
            \Session::flash('verification-success', $successMsg);

            return redirect('get-user-otp/update_mobile_otp/' . $user_id);
        } else {
            $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);

            Auth::logout();
            return redirect("login");
//        ->with("issue-profile", $errorMsg);
//            return redirect('profile')->with('otp-error', "OTP can't be send on your mobile number. Please Register & try again");
        }
    }

    public function showOtpForm(Request $request, $user_id, $mob) {
        if ($request->method() == "GET") {
            $mob = base64_decode($mob);
//            $successMsg = 'OTP has been sent, Please verify';
//            \Session::flash('alert-class', 'alert-success');
//            \Session::flash('verification-success', $successMsg);
            return view('auth.update_profile_otp_verification')->with(array('user_id' => $user_id, 'error' => '', 'mobile' => $mob));
//              return view('auth.otp_verification')->with(array('user_id' => $user_id, 'error' => '', 'mobile' => $mob));
        } else {
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
//        dd($request->user_id);
            $user = User::where('id', $request->user_id)->first();
//        dd($user);
            $userInfo = UserInformation::where('user_id', $user->id)->first();
//      dd(strtotime($userInfo->updated_at));
//          dd($userInfo);
            $saved_date = $userInfo->updated_at;
//        dd($saved_date);
            $interval = round(abs(time() - strtotime($saved_date)) / 60);  // Difference in time
//            dd($interval);
//        dd(round(abs(time() - strtotime($saved_date)) / 60));
            if ($userInfo->otp == $request->otp) {
                if ($interval > 0) {
                    $userInfo->otp_status = 0;
                    $userInfo->save();
                    $errorMsg = 'OTP has expired, Please try again !';
                    \Session::flash('alert-class', 'alert-danger');
                    \Session::flash('otp-error', $errorMsg);

                    return view('auth.update_profile_otp_verification')->with(array('user_id' => $request->user_id, 'error' => ''));
                } else {
                    $status = $this->newResendOtp($user_id);
//                    dd($status);
                    if (!empty($status) && $status == 'success') {
                        $successMsg = "Your profile has been updated successfully!";
                        \Session::flash('alert-class', 'alert-success');
                        \Session::flash('register-success', $successMsg);
                        $userInfo->otp_status = 1;
                        $userInfo->save();
                        return redirect("profile");
                    } else {
                        $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
                        \Session::flash('alert-class', 'alert-danger');
                        \Session::flash('issue-profile', $errorMsg);
                        Auth::logout();
                        return view('auth.update_profile_otp_verification')->with(array('user_id' => $request->user_id, 'error' => ''));
//        ->with("issue-profile", $errorMsg);
//            return redirect('profile')->with('otp-error', "OTP can't be send on your mobile number. Please Register & try again");
                    }
                }
//            dd(11);

                Session::put('is_sign_up', 'otp');
                Session::save();
                if ($userInfo->user_type == '4') {
                    Session::put('bus_acc_verify', 'bus');
                    Session::save();
//                $successMsg = "Congratulations! You have Registered Successfully! Your Account is under Verification.Once verified you will get verification link on your email. ";
                    $successMsg = "Congratulations! You Mobile Number updated Successfully! ";

                    \Session::flash('alert-class', 'alert-success');
                    \Session::flash('password-update-success', $successMsg);
                    return redirect("profile");
                }
//            dd(2);
                Auth::logout();
                $successMsg = "Your profile has been updated successfully!";
                \Session::flash('alert-class', 'alert-success');
                \Session::flash('register-success', $successMsg);

                return redirect("profile");
//        ->with("register-success", $succes_msg);
            } else {
                $errorMsg = 'Wrong OTP, Please Enter Correct OTP !';
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('otp-error', $errorMsg);
                return view('auth.update_profile_otp_verification')->with(array('user_id' => $user->id, 'error' => ''));
            }
        }
    }

    public function verifyOtp(Request $request) {
//        dd($user_id);
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
//        dd($request->user_id);
        $user = User::where('id', $request->user_id)->first();
//        dd($user);
        $userInfo = UserInformation::where('user_id', $user->id)->first();
//      dd(strtotime($userInfo->updated_at));
//          dd($userInfo);
        $saved_date = $userInfo->updated_at;
//        dd($saved_date);
        $interval = round(abs(time() - strtotime($saved_date)) / 60);  // Difference in time
//            dd($interval);
//        dd(round(abs(time() - strtotime($saved_date)) / 60));
        if ($userInfo->otp == $request->otp) {
            if ($interval > 0) {
                $userInfo->otp_status = 0;
                $userInfo->save();
                $errorMsg = 'OTP has expired, Please try again !';
                \Session::flash('alert-class', 'alert-danger');
                \Session::flash('otp-error', $errorMsg);
                return view('auth.update_profile_otp_verification')->with(array('user_id' => $request->user_id, 'error' => ''));
            }
//            dd(11);
            $userInfo->otp_status = 1;
            $userInfo->save();
            Session::put('is_sign_up', 'otp');
            Session::save();
            if ($userInfo->user_type == '4') {
                Session::put('bus_acc_verify', 'bus');
                Session::save();
//                $successMsg = "Congratulations! You have Registered Successfully! Your Account is under Verification.Once verified you will get verification link on your email. ";
                $successMsg = "Congratulations! You Mobile Number updated Successfully! ";

                \Session::flash('alert-class', 'alert-success');
                \Session::flash('password-update-success', $successMsg);
                return redirect("profile");
            }
//            dd(2);
            Auth::logout();
            $successMsg = "Your profile has been updated successfully!";
            \Session::flash('alert-class', 'alert-success');
            \Session::flash('register-success', $successMsg);

            return redirect("profile");
//        ->with("register-success", $succes_msg);
        } else {
            $errorMsg = 'Wrong OTP, Please Enter Correct OTP !';
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('otp-error', $errorMsg);

            return view('auth.update_profile_otp_verification')->with(array('user_id' => $user->id, 'error' => ''));
        }
    }

    public function resendOtp($user_id) {
//        dd($user_id);
        $user = UserInformation::where('user_id', $user_id)->first();

        //comment these code to resend otp
//        $otp = $this->getRandomOtp();
//        UserInformation::where('user_id', $user_id)->update(array('otp' => $otp));
//        $status = 'success';
//        dd($status);
//        if (!empty($status) && $status == 'success') {
//            Session::put('verification-success', 'OTP has been resent, Please verify');
//            return redirect('update_mobile_otp/' . $user_id);
//        } else {
//            $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
//            Auth::logout();
//            return redirect("login")->with("login-error", $errorMsg);
//        }
        //uncomment these code to resend otp
        $msg = $this->otpVerification($user->user_mobile, $user_id);
        $responseData = explode('|', trim($msg));
        $status = trim($responseData[0]);
        if ($status == 'success') {

//        if (!empty($status) && $status == 'success') {

            $successMsg = 'OTP has been resent, Please verify';
            \Session::flash('alert-class', 'alert-success');
            \Session::flash('verification-success', $successMsg);
//                    dd(1);
            return redirect('get-user-otp/update_mobile_otp/' . $user_id);
        } else {
            $errorMsg = "OTP can't be send on your mobile number. Please enter valid mobile number";
            \Session::flash('alert-class', 'alert-danger');
            \Session::flash('issue-profile', $errorMsg);

            Auth::logout();
            return redirect("login");
//        ->with("issue-profile", $errorMsg);
//            return redirect('profile')->with('otp-error', "OTP can't be send on your mobile number. Please Register & try again");
        }
    }

    public function goBack($user_id) {
        $user = UserInformation::where('user_id', $user_id)->first();
        $successMsg = "Please Login to Continue";
        return redirect('login')->with("register-success", $successMsg);
    }

    public function otpVerification($mobile, $user_id) {

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
//        dd($request);
//remove final (&) sign from the request
        $url = "http://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        UserInformation::where('user_id', $user_id)->update(array('otp' => $otp));
//        dd($curl_scraped_page);
        return $curl_scraped_page;
    }

    public function getRandomOtp() {
        return rand(pow(10, 4 - 1), pow(10, 4) - 1);
    }

}
