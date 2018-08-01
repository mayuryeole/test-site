<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can create all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::post('ws-get-all-countries', "WebservicesController@getAllCountries");
Route::post('ws-get-menu-catagory', "WebservicesController@getMenuCategory");

Route::get('get-location-from-ip',function(){
    $ip= \Request::ip();
    $data = \Location::get($ip);
   return $data;
});

Route::get('/','HomeController@goToMainPage');

//Route::get('/',function(){
//
//        return 'HomeController';
//});

Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('business-login', 'Auth\AuthController@businessLogin');
Route::post('customer-login',  'Auth\AuthController@customerlogin');

Route::delete('logout-from-facebook/{access_token}','Auth\AuthController@logoutFromFacebook');
Route::get('logout', 'Auth\AuthController@logout');

Route::get('register/{user_type}', 'Auth\AuthController@showRegistrationForm');
Route::post('/register', 'Auth\AuthController@register');

Route::get('business_register/{user_type}', 'Auth\AuthController@showBusinessRegistrationForm');
Route::post('business_register/', 'Auth\AuthController@register');

Route::get('get/register-user/otp/{user_id}', 'Auth\AuthController@showOtpForm');
Route::get('get/register-user/otp', 'Auth\AuthController@verifyOtp');

Route::post('get/register-user/otp', 'Auth\AuthController@verifyOtp');

Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::get('resend-otp/{user_id}', 'Auth\AuthController@resendOtp');
Route::get('back_to_register/{user_id}', 'Auth\AuthController@goBack');

//Route::post('resend-otp/{user_id}', 'Auth\AuthController@resendOtp');
Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/permission/denied', 'HomeController@permissionDenied');
Route::get('/redirect-dashboard', 'HomeController@toDashboard');
Route::get('/user-profile', 'HomeController@toDashboard');

// For User Profile and account settings...
Route::get('verify-user-email/{token}', ['uses' => 'ProfileController@verifyUserEmail']);
//Route::get('chk-email-duplicate', ['uses' => 'ProfileController@chkEmailDuplicate']);
Route::get(/**
 *
 */
    'chk-email-duplicate', function(){
    if($_GET['email']!="")
    {
        $cnt=App\User::where('email',$_GET['email'])->first();
        if(isset($cnt) && count($cnt)>0)
        {
            echo "false";exit();
        }else{
            echo "true";exit();
        }
    }
    
});
Route::get('chk-current-password', ['uses' => 'ProfileController@chkCurrentPassword']);

Route::get('profile', ['middleware' => 'auth', 'uses' => 'ProfileController@show']);
Route::get('update-profile', ['middleware' => 'auth', 'uses' => 'ProfileController@updateProfile']);
Route::post('update-profile-post', ['middleware' => 'auth', 'uses' => 'ProfileController@updateProfileInfo']);

Route::get('get-user-otp/update_mobile_otp/{user_id}/{mob}', ['uses' => 'ProfileController@showOtpForm']);
Route::post('get-user-otp/update_mobile_otp/{user_id}/{mob}', ['uses' => 'ProfileController@showOtpForm']);
//Route::get('get-user-otp/update_mobile_otp/{user_id}', ['uses' => 'ProfileController@showOtpForm']);

//Route::get('get-user-otp/update_mobile_otp', ['uses' => 'ProfileController@verifyOtp']);
//Route::post('get-user-otp/update_mobile_otp', ['uses' => 'ProfileController@verifyOtp']);
Route::get('get-user/update_resend-otp/{user_id}', ['uses' => 'ProfileController@resendOtp']);
Route::get('back/{user_id}', ['uses' => 'ProfileController@goBack']);
Route::get('change-email', ['middleware' => 'auth', 'uses' => 'ProfileController@updateEmail']);
Route::post('change-email-post', ['middleware' => 'auth', 'uses' => 'ProfileController@updateEmailInfo']);

Route::get('change-password', ['middleware' => 'auth', 'uses' => 'ProfileController@updatePassword']);
Route::post('change-password-post', ['middleware' => 'auth', 'uses' => 'ProfileController@updatePasswordInfo']);
Route::post('pi/upload-file', "ProfileController@uploadProfileFile");
Route::get('pi/send-mail', "ProfileController@sendMail");
Route::get('pi/crop-example', "ProfileController@cropExample");
Route::post('pi/crop-example', "ProfileController@cropPostImage");
Route::get('pi/image-gallery', "ExampleController@loadGallery");
Route::get('pi/file-explorer', "ExampleController@fileExplorerView");

Route::get('change-global-currency/{currency}', "HomeController@changeGlobalCurrency");





/************* CC avenue *******************/
Route::get('/indipay/request','ApiController@ccavenue');
Route::post('/indipay/request','ApiController@ccavenue');
Route::post('/indipay/response','ApiController@response');
Route::get('/show-gift-card/{gift-card-detail}','ApiController@showGiftCardDetails');

/*******************************************/


Route::get('dhl/rate-request','HomeController@dhlRateRequest');

/*************************************** Address Validation ******************************************/
Route::get('/fedex/address-int-validation','AddressValidationController@addressInternationalValidation'); // Working Fine
Route::get('/fedex/address-nat-validation','AddressValidationController@addressNationalValidation');   // Working Fine
/****************************************************************************************************/

/******************************************* Rate Request ********************************************/
Route::get('/fedex/rate-int-request','RateRequestController@rateInternationalRequest');   // Warning and service not available
Route::get('/fedex/rate-nat-request','RateRequestController@rateNationalRequest'); // Warning and service not available
/****************************************************************************************************/

/******************************************* Ship Order ********************************************/
Route::get('/fedex/ship-int-order','ShipOrderController@shipInternationalOrder'); // Error: Insufficient Commodity details
Route::get('/fedex/ship-nat-order','ShipOrderController@shipNationalOrder');   // Error: Account not found(All details Sent are perfertly fine)
Route::get('/fedex/ship-cod-order','CreateShipController@shipCodOrder');
Route::get('/fedex/ship-dom-cod-order','CreateShipController@shipDomOrder'); //  Error:At least one freight shipment line item is required.(Provided the detail showing)
/****************************************************************************************************/

/******************************************* Track Order ********************************************/
Route::get('/fedex/track-order/{track_id}','TrackOrderController@getTrackOrder');   // Not checked bcuz no response from above web service (imp)
Route::post('/fedex/track-order','TrackOrderController@trackOrder');   // Not checked bcuz no response from above web service (imp)
Route::get('/fedex/cancel-order','CancelOrderController@cancelOrder'); // Not checked bcuz no response from above web service (imp)
/****************************************************************************************************/

Route::get('call-helper-func','RateRequestController@getHelperFunction');
Route::get('/fedex/create-nat-ship-order','CreateShipController@CreateNationalShipOrder');
Route::get('/fedex/create-int-ship-order','CreateShipController@CreateInternationalShipOrder');
Route::get('/fedex/create-ship-order','CreateShipController@CreateShipOrder');

/* * **************** Routes For appointment And Booking Start Here ****************** */
Route::get('/availabily', "AvailabilityController@index");
Route::get('get-all-availability', 'AvailabilityController@getAllAvailability');
Route::post('set-availability', 'AvailabilityController@setAvailability');
//book an appointment
Route::get('api/get-available-days', 'BookingController@getAvailableDays');
Route::get('api/get-booking-times', 'BookingController@getTimes');
Route::get('appointment/get-calendar/{uid}/{id}', 'BookingController@getCalendar');
Route::get('appointment/booking-detail/{uid}/{id}/{tid}', 'BookingController@bookingDetail');
//submit appointment & payment
Route::post('appointment/book-your-appointment', 'BookingController@bookAppointment');
/*
 * chat route start here
 */
Route::get("/text-chat/{appointment_id}", "ChatController@startTextChat");
Route::get('/getToken', 'ChatController@generateToken');
Route::get("/video-chat/{appointment_id}", "ChatController@startVideoChat");
Route::get("/voice/{appointment_id}", "ChatController@startVoiceChat");
Route::post('fb-signup', 'ProfileController@signupWithFb');
Route::post('/token', 'TokenController@generate');
Route::get('/start-chat/{apt_id}', 'TokenController@startSession');


/*
    DHL Routes
 */
Route::get('/dhl', 'DhlController@index');

Route::get('/dhl/international-shipment', 'DhlController@international');

Route::get('/dhl/create-shipment', 'DhlController@createshipment');

Route::get('/dhl/track-shipment', 'DhlController@trackshipment');
Route::get('/dhl/rate-shipment', 'DhlController@rateshipping');
Route::get('/dhl/test-rate-shipment', 'DhlController@testRateShipping');
Route::get('/currency/get-exchange-rate', 'HomeController@getCurrencyExchangeRates');

/**************************************************************************************/


