<?php

namespace App\PiplModules\socialconnect\Controllers;

use Auth;
use App\User;
use App\UserInformation;
use App\PiplModules\Roles\Models\Role;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use GlobalValues;
use Laravel\Socialite\Two\AbstractProvider;
use App\Http\Controllers\Auth\AuthController;
use Mail;
use App\PiplModules\emailtemplate\Models\EmailTemplate;

class SocialConnectController extends Controller {

//     const facebookScope = [
//        'user_birthday',
//        'user_location',
//    ];
//    
//     
//    const facebookFields = [
//        'name', // Default
//        'email', // Default
//        'gender', // Default
//        'birthday', // I've given permission
//        'location', // I've given permission
//    ];
    public function redirectToFacebook() {
//            return Socialite::driver('facebook')->fields(self::facebookFields)->scopes(self::facebookScope)->redirect();
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToTwitter() {
        return Socialite::driver('twitter')->redirect();
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToInstagram() {
        return Socialite::driver('instagram')->redirect();
    }

    public function handleFacebookCallback() {

//             $user = Socialite::driver('facebook')->fields(self::facebookFields)->user();
        $user = Socialite::driver('facebook')->user();
//        dd($user);
        if ((!isset($user) && count($user) <= 0 )|| is_numeric($user) )
        {
            Auth::logout();
            return redirect('/login')->with('login-error', "We haven't get any response from facebook,please try again later.");
        }
        $email = $user->email;



//        dd($user);
//        $client = new \GuzzleHttp\Client();
//        $url = "https://graph.facebook.com/v2.5/me/permissions?access_token=".$user->token;
//        $request = $client->delete($url);
//        $response = $request->send();
//        dd($response);
//        return redirect('logout-from-facebook/' . $user->token);
//        Socialite::driver('facebook')->deauthorize($user->token);
//        AbstractProvider::deauthorize($user->token);
//        $this->socialite->driver($provider)->deauthorize(\Auth::user()->access_token);


        if (!isset($email) || $email == '') {

            Auth::logout();
            return redirect('/login')->with('login-error', "Make sure your email and phone number is updated and shared publically on facebook.Please logout your account from facebook.");
        }

        $first_name = "";
        $last_name = "";
        if ($user->name != '') {
            $full_name = explode(" ", $user->name);

            $first_name = isset($full_name[0]) ? $full_name[0] : '';
            $last_name = isset($full_name[1]) ? $full_name[1] : '';
        }

        $gender = (isset($user->user['gender']) && $user->user['gender'] == "male") ? "1" : (isset($user->user['gender']) && $user->user['gender'] == "female") ? "2" : "3";
        $id = $user->id;

        $redirect_url = $this->handleSocialConnect($email, $gender, $first_name, $last_name, $id, "facebook", "facebook_id");
        return redirect($redirect_url);
    }

    public function handleTwitterCallback() {
        $user = Socialite::driver('twitter')->user();
        // TO login and sign up
        $email = $user->name . "_" . $user->id . "@twitter.com";
        $first_name = "";
        $last_name = "";
        if ($user->name != '') {
            $full_name = explode(" ", $user->name);
            $first_name = isset($full_name[0]) ? $full_name[0] : '';
            $last_name = isset($full_name[1]) ? $full_name[1] : '';
        }

        $gender = (isset($user->user['gender']) && $user->user['gender'] == "male") ? "1" : (isset($user->user['gender']) && $user->user['gender'] == "female") ? "2" : "3";
        $id = $user->id;

        $redirect_url = $this->handleSocialConnect($email, $gender, $first_name, $last_name, $id, "twitter", "twitter_id");
        return redirect($redirect_url);
    }

    public function handleGoogleCallback() {
        $user = Socialite::with('google')->user();
//                dd($user);
//                dd($user->email);
        // TO login and sign up
        if (!isset($user) && count($user) <= 0) {
            Auth::logout();
            return redirect('/login')->with('login-error', "We haven't get any response from google,please try again later.");
        }
        $email = $user->email;
        $first_name = "";
        $last_name = "";
        if ($user->name != '') {
            $full_name = explode(" ", $user->name);
            $first_name = isset($full_name[0]) ? $full_name[0] : '';
            $last_name = isset($full_name[1]) ? $full_name[1] : '';
        }
        
        $gender = (isset($user->user['gender']) && $user->user['gender'] == "male") ? "1" : (isset($user->user['gender']) && $user->user['gender'] == "female") ? "2" : "3";
        $id = $user->id;
        
        $redirect_url = $this->handleSocialConnect($email, $gender, $first_name, $last_name, $id, "google", "google_id");
        return redirect($redirect_url);
    }

    public function handleInstagramCallback() {
        $user = Socialite::driver('instagram')->user();

        $email = $user->user['username'] . "_" . $user->id . "@instagram.com";
        dd($email);
        $first_name = "";
        $last_name = "";
        if ($user->name != '') {
            $full_name = explode(" ", $user->name);
            $first_name = isset($full_name[0]) ? $full_name[0] : '';
            $last_name = isset($full_name[1]) ? $full_name[1] : '';
        }
        $gender = (isset($user->user['gender']) && $user->user['gender'] == "male") ? "1" : (isset($user->user['gender']) && $user->user['gender'] == "female") ? "2" : "3";
        $id = $user->id;
        $redirect_url = $this->handleSocialConnect($email, $gender, $first_name, $last_name, $id, "instagram", 'instagram_id');
//                dd($redirect_url);
        return redirect($redirect_url);
    }

    private function handleSocialConnect($email, $gender, $first_name, $last_name, $social_id, $social_type, $connect_id)
    {
        //getting from global setting
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');

        $newUser = User::where('email', $email)->first();
        $userExist = 0;

        if (!empty($newUser)) {
            $user_info = UserInformation::where('user_id', $newUser->id)->where('facebook_id', '<>', NULL)->orWhere('instagram_id','<>',NULL)->orWhere('google_id','<>',NULL);
            if (isset($user_info) && count($user_info) > 0) {
                $userExist = 1;
            }
        }



        if ($userExist) {
            // user is already exists, make login
            \Auth::loginUsingId($newUser->id);
            return '/';
        } else {
            // make registration
            $password = str_random(8);
            $created_user = User::create([
                        'email' => $email,
                        'password' => $password,
            ]);

            $arr_userinformation = array();

            $arr_userinformation["profile_picture"] = "";
            $arr_userinformation["gender"] = $gender;
            $arr_userinformation["activation_code"] = "";             // By default it'll be no activation code

            if ($social_type == "facebook") {
                $arr_userinformation["facebook_id"] = $social_id;
            }

            if ($social_type == "twitter") {
                $arr_userinformation["twitter_id"] = $social_id;
            }

            if ($social_type == "google") {
                $arr_userinformation["google_id"] = $social_id;
            }
            if ($social_type == "instagram") {
                $arr_userinformation["instagram_id"] = $social_id;
            }


            $arr_userinformation["linkedin_id"] = "";
            $arr_userinformation["pintrest_id"] = "";
            $arr_userinformation["user_birth_date"] = "";
            $arr_userinformation["first_name"] = $first_name;
            $arr_userinformation["last_name"] = $last_name;
            $arr_userinformation["about_me"] = "";
            $arr_userinformation["user_phone"] = "";
            $arr_userinformation["user_mobile"] = "";
            $arr_userinformation["user_status"] = "1"; // Active and Verified
            $arr_userinformation["user_type"] = "3";
            $arr_userinformation["user_id"] = $created_user->id;


            $updated_user_info = UserInformation::create($arr_userinformation);

            // asign role to respective user
//		$userRole = Role::where("slug","registereduser")->first();
//		dd($userRole);
//		$created_user->attachRole($userRole);
            //sending an email to the user on successfull registration.
//            if ($social_type == "facebook" || $social_type == "google") {
            $arr_keyword_values = array();
            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = $updated_user_info->first_name;
            $arr_keyword_values['LAST_NAME'] = $updated_user_info->last_name;
            $arr_keyword_values['EMAIL'] = $created_user->email;
            $arr_keyword_values['PASSWORD'] = $password;
            $arr_keyword_values['SITE_TITLE'] = $site_title;

            $email_template = EmailTemplate::where("template_key", 'social-registration-successful')->first();
             $status = Mail::send('emailtemplate::registration-successfull-social', $arr_keyword_values, function ($message) use ($created_user, $social_type, $site_email, $site_title,$email_template)
            {

                $message->to($created_user->email, $created_user->first_name)->subject("Registration Successful")->from($site_email, $site_title);
            });
//            }
            if($status){
                \Auth::loginUsingId($created_user->id);
                return '/';
            }
        }
    }

    public function socialMessage($social_type) {
        $is_email_found = 1;
        if ($social_type == "twitter" || $social_type == "instagram") {
            $is_email_found = 0;
        }

        return view("socialconnect::social-message", array('social_type' => $social_type, "is_email_found" => $is_email_found));
    }

}
