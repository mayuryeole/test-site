<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
//use Auth\User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input,
    Response,
    View;
use Session;
use DB;
use DateTime;
use App\PiplModules\admin\Helpers\GlobalValues;
use Mail;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
// Declare Models to be used
use App\Models\Package;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\BookingDateTime;
use App\PiplModules\notification\Models\Notification;
use App\PiplModules\admin\Models\ContactMode;

class BookingController extends Controller {

    // Get available days
    function getAvailableDays(Request $request) {
        $expert_id = $request->expert_id;
        $available_days = BookingDateTime::where('user_id', $expert_id)->get();
        return response()->json($available_days);
    }

    /**
     * Function to retrieve datepicker
     *
     * User selects date + time to continue
     * */
    public function getCalendar(Request $request, $uid, $pid) {
        $expertData = User::where('id', base64_decode($uid))->first();
//        dd($expertData);
        /*
          //Add package to the session data
          Session::put('packageID', $pid);
          $package = Package::find($pid);

          // This groups all booking times by date so we can give a list of all days available.
          $data = [
          'packageName' => $package->package_name,
          'days' => BookingDateTime::all()
          ]; */
//        $days = BookingDateTime::all();
        $days = BookingDateTime::where('user_id', base64_decode(\Request::segment(3)))->get();
//        dd($days);
        return view('appointments.appointment-calendar', compact('days', 'expertData'));
    }

    /**
     * Function to get customer details after Date & Time pick
     *
     * */
    public function getDetails($aptID) {

        // Put the passed date time ID into the session
        Session::put('aptID', $aptID);
        $package = Package::find(Session::get('packageID'));

        // Get row of date id
        $dateRow = BookingDateTime::find($aptID);
        $dateFormat = new DateTime($dateRow->booking_datetime);
        $dateFormat = $dateFormat->format('g:i a \o\n l, jS \o\f F Y');
        Session::put('selection', $dateRow->booking_datetime);

        $data = [
            'pid' => Session::get('packageID'),
            'package_name' => $package->package_name,
            'dateRow' => $dateRow,
            'dateFormat' => $dateFormat,
            'aptID' => $aptID,
        ];

        return view('customerInfo', $data);
    }

    /**
     * Function to retrieve times available for a given date
     *
     * View is returned in JSON format
     *
     * */
    public function getTimes(Request $request) {
        // We get the data from AJAX for the day selected, then we get all available times for that day
//        $selectedDay = \Input::get('selectedDay');
        $selectedDay = $request->selectedDay;
//        $availableTimes = DB::table('booking_datetimes')->orderBy('booking_datetime', 'ASC')->get();
        $availableTimes = BookingDateTime::where(['status' => "0"])->orderBy('booking_datetime', 'ASC')->get();

        // We will now create an array of all booking datetimes that belong to the selected day
        // WE WILL NOT filter this in the query because we want to maintain compatibility with every database (ideally)
        // PSEUDO CODE
        // Get package duration of the chosen package
//        $package = Package::find(Session::get('packageID'));
//        $packageTime = $package->package_time;
        $packageTime = 1;
//dd($availableTimes);
        // For each available time...
        foreach ($availableTimes as $t => $value) {
            $startTime = new DateTime($value->booking_datetime);
            if ($selectedDay == date("Y-m-d") && $value->booking_datetime < date("Y-m-d H:i:s")) {
                unset($availableTimes[$t]);
            } else {
                if ($startTime->format("Y-m-d") == $selectedDay && $value->status == "0") {
                    $endTime = new DateTime($value->booking_datetime);
                    date_add($endTime, date_interval_create_from_date_string($packageTime . ' hours'));

                    // Try to grab any appointments between the start time and end time
                    $result = Appointment::timeBetween($startTime->format("Y-m-d H:i"), $endTime->format("Y-m-d H:i"));

                    // If no records are returned, the time is okay, if not, we must remove it from the array
                    if ($result->first()) {
                        unset($availableTimes[$t]);
                    }
                } else {
                    unset($availableTimes[$t]);
                }
            }
            $value->booking_datetime = date('Y-m-d h:i:s a', strtotime($value->booking_datetime));
        }
//        dd($availableTimes);
        return response()->json($availableTimes);
    }

    /*
     * get booking detail on submit page
     */

    function bookingDetail(Request $request, $uId, $mocId, $tid) {
        $expertData = User::where('id', base64_decode($uId))->first();
        $selectedDatetime = BookingDateTime::where('id', $tid)->first();
        $selectedMode = ContactMode::where('id', $mocId)->first();
//        dd($selectedMode);
//        $days = BookingDateTime::all();
        return view('appointments.book-appointment-data', compact('days', 'expertData', 'selectedDatetime', 'selectedMode'));
    }

    function randomString($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    /**
     * Function to post customer info and present confirmation view
     * User Confirms appointment details to continue
     * */
    public function bookAppointment(Request $request) {
//        echo $this->randomString(6);


        $expertData = \App\User::where('id', $request->expert_id)->first();
        $selectedDatetime = BookingDateTime::where('id', $request->datetime_id)->first();
        $selectedMode = ContactMode::where('id', $request->mode_id)->first();
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        $email_from = GlobalValues::get('support-email');

        if (isset($expertData) && count($expertData) > 0) {
            // When this boolean is set to True, instead of deleting all appointment times for the package duration
            // It will instead remove all times up to the end of the day, and continue to the next day until the package
            // time is done.
            $overlapDays = FALSE;

            $customerData = \App\User::where('email', $request->customer_email)->first();
            if (count($customerData) > 0) {
                $cust_id = $customerData->id;
            } else {
                $password = $this->randomString(6);
                $userPassword = \Hash::make($password);
                $user = new User();
                $user->email = $request->customer_email;
                $user->password = $userPassword;
                $user->save();

                // update User Information
                /*
                 * Adjusted user specific columns, which may not passed on front end and adjusted with the default values
                 */
                $data["user_type"] = '2';            // 1 may have several mean as per enum stored in the database. Here we
                $data["role_id"] = isset($data["role_id"]) ? $data["role_id"] : "2";                                    // 2 means registered user
                $data["user_status"] = 0;        // 0 means not active
                $data["gender"] = isset($data["gender"]) ? $data["gender"] : "3";                    // 3 means not specified
                $data["profile_picture"] = isset($fileName) ? $fileName : "";
                $data["upload_cv"] = isset($resumeName) ? $resumeName : "";
                $data["facebook_id"] = isset($data["facebook_id"]) ? $data["facebook_id"] : "";
                $data["twitter_id"] = isset($data["twitter_id"]) ? $data["twitter_id"] : "";
                $data["google_id"] = isset($data["google_id"]) ? $data["google_id"] : "";
                $data["linkedin_id"] = isset($data["linkedin_id"]) ? $data["linkedin_id"] : "";
                $data["pintrest_id"] = isset($data["pintrest_id"]) ? $data["pintrest_id"] : "";
                $data["user_birth_date"] = isset($data["user_birth_date"]) ? $data["user_birth_date"] : "";
                $data["first_name"] = $request->first_name;
                $data["last_name"] = $request->last_name;
                $data["full_name"] = $request->first_name . ' ' . $request->last_name;
                $data["about_me"] = isset($data["about_me"]) ? $data["about_me"] : "";
                $data["description"] = isset($data["description"]) ? $data["description"] : "";
                $data["education"] = isset($data["education"]) ? $data["education"] : "";
                $data["achievement"] = isset($data["achievement"]) ? $data["achievement"] : "";
                $data["associate"] = isset($data["associate"]) ? $data["associate"] : "";
                $data["user_phone"] = isset($data["user_phone"]) ? $data["user_phone"] : "";
                $data["user_mobile"] = isset($data["user_mobile"]) ? $data["user_mobile"] : "";
                $data["name"] = isset($data["name"]) ? $data["name"] : $request->first_name . ' ' . $request->last_name;
                $data["relation"] = isset($data["relation"]) ? $data["relation"] : "";
                $data["phone"] = isset($request->customer_phone) ? $request->customer_phone : "";
                $data["age"] = isset($data["age"]) ? $data["age"] : "";
                $data["zipcode"] = isset($data["zipcode"]) ? $data["zipcode"] : "";

                /** user information goes here *** */
                $arr_userinformation["profile_picture"] = isset($data["profile_picture"]) ? $data["profile_picture"] : '';
                $arr_userinformation["upload_cv"] = isset($data["upload_cv"]) ? $data["upload_cv"] : '';
                $arr_userinformation["gender"] = $data["gender"];
                $activation_code = $this->randomString(50);
                $arr_userinformation["activation_code"] = $activation_code;                                                    // By default it'll be no activation code
                $arr_userinformation["facebook_id"] = $data["facebook_id"];
                $arr_userinformation["twitter_id"] = $data["twitter_id"];
                $arr_userinformation["google_id"] = $data["google_id"];
                $arr_userinformation["linkedin_id"] = $data["linkedin_id"];
                $arr_userinformation["pintrest_id"] = $data["pintrest_id"];
                $arr_userinformation["user_birth_date"] = $data["user_birth_date"];
                $arr_userinformation["first_name"] = $data["first_name"];
                $arr_userinformation["last_name"] = $data["last_name"];
                $arr_userinformation["full_name"] = $data["full_name"];
                $arr_userinformation["about_me"] = $data["about_me"];
                $arr_userinformation["user_phone"] = $data["user_phone"];
                $arr_userinformation["user_mobile"] = $data["user_mobile"];
                $arr_userinformation["description"] = $data["description"];
                $arr_userinformation["user_status"] = $data["user_status"];
                $arr_userinformation["user_type"] = $data["user_type"];
                $arr_userinformation["education"] = $data["education"];
                $arr_userinformation["achievement"] = $data["achievement"];
                $arr_userinformation["association"] = $data["associate"];
                $arr_userinformation["language"] = isset($lang) ? $lang : '';
                $arr_userinformation["age"] = $data["age"];
                $arr_userinformation["zipcode"] = $data["zipcode"];
                $arr_userinformation["user_id"] = $user->id;
                $updated_user_info = UserInformation::create($arr_userinformation);
                $cust_id = $user->id;
            }

            $appointment = new Appointment();
            $appointment->customer_id = $cust_id;
            $appointment->expert_id = $request->expert_id;
            $appointment->appointment_type = $request->mode_id;
            $appointment->appointment_datetime = $selectedDatetime->booking_datetime;
            $appointment->customer_phone = $request->customer_phone;
            $appointment->customer_email = $request->customer_email;
            $appointment->customer_name = $request->customer_name;
            $appointment->status = "0";
            $appointment->save();

            $startTime = new \DateTime($selectedDatetime->booking_datetime);
            $endTime = new \DateTime($selectedDatetime->booking_datetime);
            date_add($endTime, date_interval_create_from_date_string('1 hours'));
//        $newCustomer = Customer::addCustomer();
            $startTime = $startTime->format('Y-m-d H:i');
            $endTime = $endTime->format('Y-m-d H:i');

            if ($overlapDays) {
                // Remove hours up to the last hour of the day, then continue to the next day
                // If necessary
                // PSEUDO CODE
                // We will get the last appointment of the day and see if it's smaller than the package time
                // If the last appointment occurs beyond the package duration, we delete like normal
                // If the last appointment occurs before the package duration
                // We subtract the hours we remove from the package duration to get remaining time
                // Then we go to the next day with appointment times and remove enough appointments
                // To make clearance for the package duration.
            } else {
                // Remove all dates conflicting with the appointment duration
//            BookingDateTime::timeBetween($startTime, $endTime)->delete();
                $dateBetween = BookingDateTime::timeBetween($startTime, $endTime)->first();
                $dateBetween->status = "1";
                $dateBetween->save();
            }
            $noti_obj = new Notification();
            $noti_obj->to = $request->expert_id;
            $noti_obj->from = Auth::user()->id;
            $noti_obj->content = Auth::user()->userInformation->first_name . ' ' . Auth::user()->userInformation->last_name . " has booked your appointment.";
            $noti_obj->notification_type = "Appointment Book";
            $noti_obj->appointment_id = $appointment->id;
            $noti_obj->save();

            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = Auth::user()->userInformation->first_name;
            $arr_keyword_values['COUNSELOR_NAME'] = $expertData->userInformation->first_name . ' ' . $expertData->userInformation->last_name;
            $arr_keyword_values['APPOINTMENT_ID'] = $appointment->id;
            $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
            $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $email_template = EmailTemplate::where("template_key", 'booking-confirmed')->first();
            $subject = $email_template->subject;
            //$mail_subject = $this->getSubject($reserved_arr, $subject);

            Mail::send('emailtemplate::booking-confirmation', $arr_keyword_values, function ($message) use ( $customerData, $email_from, $subject, $site_email, $site_title) {
                $message->to('mayur.y@panaceatek.com')->subject($subject)->from($email_from);
                ; //>from($site_email,$site_title);
            });
            \Session::flash('msg-success', 'Appointment has been booked successfully.');
            return redirect(url('/customer-user-dashboard'));
        } else {
            \Session::flash('msg-error', 'Something went wrong, please try again.');
            return redirect(url('/'));
        }
    }

}
