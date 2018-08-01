<?php

namespace App\PiplModules\bookappointment\Controllers;

use App\PiplModules\admin\Models\CountryTranslation;
use Auth;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use Datatables;
use App\UserInformation;
use App\PiplModules\blog\Models\Post;
use App\PiplModules\blog\Models\PostCategory;
use App\PiplModules\blog\Models\PostCategoryTranslation;
use App\PiplModules\blog\Models\PostComment;
use App\PiplModules\blog\Models\Tag;
use App\PiplModules\admin\Models\CityTranslation;
//use App\PiplModules\notification\Models\Notification;
use App\PiplModules\admin\Models\StateTranslation;
use App\Models\Appointment;
use App\PiplModules\bookappointment\Models\Rating;
use App\PiplModules\admin\Helpers\GlobalValues;
//use App\PiplModules\admin\Models\FeedbackQuestion;
use App\Models\BookingDateTime;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use App\PiplModules\category\Models\CategoryTranslation;
use App\PiplModules\admin\Models\UserFeedback;
use App\Expertise;
use Aloha\Twilio\Twilio;
//use App\Models\BookingDateTime;
//use Twilio\Rest\Client;
use Mail;
use Illuminate\Support\Facades\DB;
use Image;
use Session;
use App\PiplModules\admin\Models\Country;

class AppointmentController extends Controller {

    public function allExpertListing(Request $request) {

        $all_expert_list = UserInformation::where('user_type', '4')->where('user_status', '1')->get();

        foreach ($all_expert_list as $key => $expert) {
            $avg_rating = Rating::where('to_id', $expert->user_id)->get();
            if (isset($avg_rating) && count($avg_rating) > 0) {
                $rating_count = 0;
                foreach ($avg_rating as $rating) {
                    $rating_count += $rating->rating;
                }
                $all_expert_list[$key]['avg_rating'] = $rating_count / count($avg_rating);
            } else {
                $all_expert_list[$key]['avg_rating'] = '0';
            }
            if ($expert->login_status == 0) {
                //login status 0 means user is offline now. So find user last login time here
                $last_login = $this->time_elapsed_string($expert->last_login_time);
                $all_expert_list[$key]['last_login'] = $last_login;
            } else {
                //login status not 0 means user is online now.
                $all_expert_list[$key]['last_login'] = 'Available Now';
            }
        }
        return view('bookappointment::select-expert', array('all_expert_list' => $all_expert_list, 'request' => $request));
    }

    public function bookBusinessAppointment(Request $request) {
        if (Auth::user()) {
            $country = Country::all();
            return view('bookappointment::book-business-appointment',compact('country'));
        } else {
            return redirect('/login')->with('login-error', 'Please Login to continue booking appointment!!');
        }
    }

    public function contactMode(Request $request, $user_id) {
        if (Auth::user()) {
            $selected_expert_id = base64_decode($user_id);
            $selected_expert_info = UserInformation::where('user_id', $selected_expert_id)->first();
            $contact_modes = \App\PiplModules\admin\Models\ContactMode::all();
            $avg_rating = Rating::where('to_id', $selected_expert_id)->get();
            if (isset($avg_rating) && count($avg_rating) > 0) {
                $rating_count = 0;
                foreach ($avg_rating as $rating) {
                    $rating_count += $rating->rating;
                }
                $selected_expert_info->avg_rating = $rating_count / count($avg_rating);
                $selected_expert_info->total_reviews = count($avg_rating);
            } else {
                $selected_expert_info->avg_rating = 0;
                $selected_expert_info->total_reviews = 0;
            }

            if ($selected_expert_info->login_status == 0) {
                //login status 0 means user is offline now. So find user last login time here
                $last_login = $this->time_elapsed_string($selected_expert_info->last_login_time);
                $selected_expert_info->last_login = $last_login;
            } else {
                //login status not 0 means user is online now.
                $selected_expert_info->last_login = 'Available Now';
            }
            return view('bookappointment::select-mode-of-contact', array("selected_expert_info" => $selected_expert_info, "contact_modes" => $contact_modes));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function searchInCityBk(Request $request) {



        //  $userinfo = User::filterByState()->filterByCity()->filterByActive();

        $city_name = $request->city;
        $is_city_available = CityTranslation::where('name', 'like', '' . $city_name . '%')->get();

        $all_expert = UserInformation::where('user_type', 4)->where('user_status', 1)->get();
        foreach ($all_expert as $key => $expert) {
            $avg_rating = Rating::where('to_id', $expert->user_id)->get();
            if (isset($avg_rating) && count($avg_rating) > 0) {
                $rating_count = 0;
                foreach ($avg_rating as $rating) {
                    $rating_count += $rating->rating;
                }
                $all_expert[$key]['avg_rating'] = $rating_count / count($avg_rating);
            } else {
                $all_expert[$key]['avg_rating'] = '0';
            }
            if ($expert->login_status == 0) {
                //login status 0 means user is offline now. So find user last login time here
                $last_login = $this->time_elapsed_string($expert->last_login_time);
                $all_expert[$key]['last_login'] = $last_login;
            } else {
                //login status not 0 means user is online now.
                $all_expert[$key]['last_login'] = 'Available Now';
            }
        }
        $search_city_array = array();

        if ($city_name == "") {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $all_expert));
        } elseif (count($is_city_available) > 0) {
            foreach ($is_city_available as $city) {
                $search_city_array[] = $city->city_id;
            }

            $expert_valid = $all_expert->filter(function($expert) use($search_city_array) {
                if (isset($expert->userAddress) && in_array($expert->userAddress->user_city, $search_city_array)) {
                    return $expert;
                }
            });
            if (isset($expert_valid) && count($expert_valid) > 0) {

                return view('bookappointment::ajax-search-view', array('all_expert_list' => $expert_valid));
            } else {
                echo "No Record Found";
            }
        } else {
            echo "No Record Found";
        }
    }

    public function searchInCity(Request $request) {

        // getting all expertise users
        $zipcode = $request->zipcode;
        if ($zipcode != '') {
            $all_expert = UserInformation::where('user_type', 4)->where('user_status', 1)->where('zipcode', 'like', $zipcode . '%')->get();
        } else {
            $all_expert = UserInformation::where('user_type', 4)->where('user_status', 1)->get();
        }

        foreach ($all_expert as $key => $expert) {
            $avg_rating = Rating::where('to_id', $expert->user_id)->get();
            if (isset($avg_rating) && count($avg_rating) > 0) {
                $rating_count = 0;
                foreach ($avg_rating as $rating) {
                    $rating_count += $rating->rating;
                }
                $all_expert[$key]['avg_rating'] = $rating_count / count($avg_rating);
            } else {
                $all_expert[$key]['avg_rating'] = '0';
            }
            if ($expert->login_status == 0) {
                //login status 0 means user is offline now. So find user last login time here
                $last_login = $this->time_elapsed_string($expert->last_login_time);
                $all_expert[$key]['last_login'] = $last_login;
            } else {
                //login status not 0 means user is online now.
                $all_expert[$key]['last_login'] = 'Available Now';
            }
        }


        $search_city_array = array();


        $city_name = $request->city;


        //filter all expertise by city, if city data is passed
        if ($city_name != "") {
            $is_city_available = CityTranslation::where('name', 'like', '' . $city_name . '%')->get();


            foreach ($is_city_available as $city) {
                $search_city_array[] = $city->city_id;
            }

            $all_expert = $all_expert->reject(function($expert) use($search_city_array) {
                if (isset($expert->userAddress) && in_array($expert->userAddress->user_city, $search_city_array)) {
                    return false;
                } else {
                    return true;
                }
            });
        }
        //filter all expertise by state, if state data is passed   
        $state_name = $request->state;
        if ($state_name != "") {
            $search_state_array = [];
            $is_state_available = StateTranslation::where('name', 'like', '%' . $state_name . '%')->get();


            foreach ($is_state_available as $state) {
                $search_state_array[] = $state->state_id;
            }
            $all_expert = $all_expert->reject(function($expert) use($search_state_array) {

                if (isset($expert->userAddress) && in_array($expert->userAddress->user_state, $search_state_array)) {
                    return false;
                }
                return true;
            });
        }

        //filter all expertise by category, if category data is passed   

        $category_id = $request->category;
        if ($category_id != "") {
            $all_expert = $all_expert->filter(function($expert)use($category_id) {

                $categories = array();

                foreach ($expert->Expertise as $exp) {

                    $categories[] = $exp->category_id;
                }
                if (in_array($category_id, $categories)) {
                    return $expert;
                }
            });
        }


        if (count($all_expert) > 0) {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $all_expert));
        } else {
            echo "No Record Found";
        }
    }

    public function searchInState(Request $request) {
        $state_name = $request->state;
        $is_state_available = StateTranslation::where('name', 'like', '%' . $state_name . '%')->get();
        $all_expert = UserInformation::where('user_type', 4)->where('user_status', 1)->get();
        foreach ($all_expert as $key => $expert) {
            $avg_rating = Rating::where('to_id', $expert->user_id)->get();
            if (isset($avg_rating) && count($avg_rating) > 0) {
                $rating_count = 0;
                foreach ($avg_rating as $rating) {
                    $rating_count += $rating->rating;
                }
                $all_expert[$key]['avg_rating'] = $rating_count / count($avg_rating);
            } else {
                $all_expert[$key]['avg_rating'] = '0';
            }
            if ($expert->login_status == 0) {
                //login status 0 means user is offline now. So find user last login time here
                $last_login = $this->time_elapsed_string($expert->last_login_time);
                $all_expert[$key]['last_login'] = $last_login;
            } else {
                //login status not 0 means user is online now.
                $all_expert[$key]['last_login'] = 'Available Now';
            }
        }
        $search_state_array = array();

        if ($state_name == "") {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $all_expert));
        } elseif (count($is_state_available) > 0) {
            foreach ($is_state_available as $state) {
                $search_state_array[] = $state->state_id;
            }



            $expert_valid = $all_expert->filter(function($expert) use($search_state_array) {
                if (isset($expert->userAddress) && in_array($expert->userAddress->user_state, $search_state_array)) {
                    return $expert;
                }
            });


            if (isset($expert_valid) && count($expert_valid) > 0) {
                return view('bookappointment::ajax-search-view', array('all_expert_list' => $expert_valid));
            } else {
                echo "No Record Found";
            }
        } else {
            echo "No Record Found";
        }
    }

    public function searchInCategory(Request $request) {
        $category_id = $request->category;
        $all_expert = UserInformation::where('user_type', 4)->where('user_status', 1)->get();


        $expert_valid = $all_expert->filter(function($expert)use($category_id) {

            $categories = array();

            foreach ($expert->Expertise as $exp) {

                $categories[] = $exp->category_id;
            }
            if (in_array($category_id, $categories)) {

                return $expert;
            }
        });
        if (count($expert_valid) > 0) {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $expert_valid));
        } elseif ($category_id == '') {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $all_expert));
        } else {
            echo "No Record Found";
        }
    }

    //19 Feb 2018
    public function searchStudentCounsel(Request $request) {
        $category = CategoryTranslation::where("students", "1")->get();
        $users = '';

        $expert_valid = [];
        $id = [];
        if ($category != "") {
            foreach ($category as $c) {
                $users[] = Expertise::where('category_id', $c->category_id)->get();
            }
        }

        if ($users != '') {
            foreach ($users as $k => $v) {
                foreach ($v as $cat) {
                    if ($cat != '') {
                        if (in_array($cat->user_id, $id)) {
                            continue;
                        } else {
                            $expert_valid[] = $cat->userInfo;
                        }
                        $id[] = $cat->user_id;
                    }
                }
            }
        }

        if (count($expert_valid) > 0) {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        } else {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        }
    }

    public function searchAdultCounsel(Request $request) {
        $category = CategoryTranslation::where("adults", "1")->get();
        $users = "";
        $id = [];
        $expert_valid = [];
        if ($category != "") {
            foreach ($category as $c) {
                $users[] = Expertise::where('category_id', $c->category_id)->get();
            }
        }
        if ($users != '') {
            foreach ($users as $u => $v) {
                foreach ($v as $cat) {
                    if (in_array($cat->user_id, $id)) {
                        continue;
                    } else {
                        $expert_valid[] = $cat->userInfo;
                    }
                    $id[] = $cat->user_id;
                }
            }
        }
        if (count($expert_valid) > 0) {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        } else {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        }
    }

    public function searchInstitutionCounsel(Request $request) {
        $category = CategoryTranslation::where("institutions", "1")->get();
        $users = "";
        $id = [];
        $expert_valid = [];
        if ($category != "") {
            foreach ($category as $c) {
                $users[] = Expertise::where('category_id', $c->category_id)->get();
            }
        }
        if ($users != "") {
            foreach ($users as $u => $v) {
                foreach ($v as $cat) {
                    if (in_array($cat->user_id, $id)) {
                        continue;
                    } else {
                        $expert_valid[] = $cat->userInfo;
                    }
                    $id[] = $cat->user_id;
                }
            }
        }
        if (count($expert_valid) > 0) {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        } else {

            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        }
    }

    public function searchUpbeatCounsel(Request $request) {
        $category = CategoryTranslation::where("upbeat", "1")->get();
        $users = "";
        $expert_valid = [];
        $id = [];
        if ($category != "") {
            foreach ($category as $c) {
                $users[] = Expertise::where('category_id', $c->category_id)->get();
            }
        }
        foreach ($users as $u => $v) {
            foreach ($v as $cat) {
                if (in_array($cat->user_id, $id)) {
                    continue;
                } else {
                    $expert_valid[] = $cat->userInfo;
                }
                $id[] = $cat->user_id;
            }
        }

        if (count($expert_valid) > 0) {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        } else {
            return view('bookappointment::select-expert', array('all_expert_list' => $expert_valid));
        }
    }

    //19 Feb 2018
    public function searchInZipcode(Request $request) {
        $zipcode = $request->zipcode;
        $is_zipcode_available = UserInformation::where('user_type', 4)->where('user_status', 1)->where('zipcode', 'like', '%' . $zipcode . '%')->get();
        $all_expert = UserInformation::where('user_type', 4)->where('user_status', 1)->get();
//       $search_state_array=array();

        if ($zipcode == "") {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $all_expert));
        } elseif (count($is_zipcode_available) > 0) {
            return view('bookappointment::ajax-search-view', array('all_expert_list' => $is_zipcode_available));
        } else {
            echo "No Record Found";
        }
    }

    public function makeCall(Request $request) {

        /* Make a call using Twilio. You can run this file 3 different ways:
         *
         * 1. Save it as call.php and at the command line, run
         *        php call.php
         *
         * 2. Upload it to a web host and load mywebhost.com/call.php
         *    in a web browser.
         *
         * 3. Download a local server like WAMP, MAMP or XAMPP. Point the web root
         *    directory to the folder containing this file, and load
         *    localhost:8888/call.php in a web browser.
         */
        // Step 1: Get the Twilio-PHP library from twilio.com/docs/libraries/php,
        // following the instructions to install it with Composer.
        require_once "Twilio/autoload.php";


        // Step 2: Set our AccountSid and AuthToken from https://twilio.com/console
        $AccountSid = "AC531a32ec242f7b8f40eb4e7a7e51383f";
        $AuthToken = "d5e08aa2ebdbd901a0c0e36f7c7c76cb";
        // Step 3: Instantiate a new Twilio Rest Client
        $client = new Client($AccountSid, $AuthToken);
        try {
            // Initiate a new outbound call
            $call = $client->account->calls->create(
                    // Step 4: Change the 'To' number below to whatever number you'd like 
                    // to call.
                    "+917387401688",
                    // Step 5: Change the 'From' number below to be a valid Twilio number
                    // that you've purchased or verified with Twilio.
                    "+918484988887",
                    // Step 6: Set the URL Twilio will request when the call is answered.
                    array("url" => "http://demo.twilio.com/welcome/voice/")
            );
            echo "Started call: " . $call->sid;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function myAppointment(Request $request) {
//        dd(123);
        if (Auth::user()) {
            $customer_id = Auth::user()->id;
            $user_appointments = Appointment::where('customer_id', $customer_id)->orderBy('id', 'desc')->get();
            return view("bookappointment::customer-appointment-list", array("user_appointments" => $user_appointments));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function userGiveRating(Request $request) {
        if (Auth::user()) {
            $data = $request->all();
            $rating = $request->rating;
            $review = $request->review;
            $appointment_id = $request->appointment_id;
            $appointment_details = Appointment::find($appointment_id);


            $obj = new Rating();
            $obj->to_id = $appointment_details->expert_id;
            $obj->appointment_id = $appointment_details->id;
            $obj->from_id = Auth::user()->id;
            $obj->rating = $rating;
            $obj->review = $review;
            $obj->status = '1';
            $obj->save();
            $rating = "Thanks for rating your Expert advisor, it helps us improve our community";
            \Session::flash('msg-success', $rating);
            return redirect("/my-appointments");
        } else {
            $errorMsg = "Your session has expired. Please login again.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function ratingListdeleteRating(Request $request) {
        if (Auth::user()) {
            return view("bookappointment::Backend/rating-list");
        } else {
            $errorMsg = "Your session has expired. Please login again.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function backendRatingListData() {
        if (Auth::user()) {
            $arr_rating_details = Rating::all();
            $rating = array();
            return Datatables::of($arr_rating_details)
                            ->addColumn('id', function($arr_rating_details) {
                                return $arr_rating_details->id;
                            })
                            ->addColumn('from_id', function($arr_rating_details) {
                                $name = \App\UserInformation::where('user_id', $arr_rating_details->from_id)->select('first_name', 'last_name')->first();
                                $full_name = $name['first_name'] . " " . $name['last_name'];
                                return $full_name;
                            })
                            ->addColumn('to_id', function($arr_rating_details) {
                                $name = \App\UserInformation::where('user_id', $arr_rating_details->to_id)->select('first_name', 'last_name')->first();
                                $full_name = $name['first_name'] . " " . $name['last_name'];
                                return $full_name;
                            })
                            ->addColumn('rating', function($arr_rating_details) {

                                $k = 0;
                                $is_flot = false;
                                $arr_rat = explode('.', $arr_rating_details->rating);
                                if (count($arr_rat) == 1) {
                                    $arr_rat[1] = '0';
                                }
                                if ($arr_rat['1'] != '0') {
                                    $is_flot = "true";
                                }
                                for ($ii = 0; $ii < $arr_rat[0]; $ii++) {
                                    $rating[$k] = "star-on.png";
                                    $k++;
                                }
                                if ($is_flot) {
                                    $rating[$k] = "star-half.png";
                                    $k++;
                                }
                                if ($is_flot) {
                                    $s = $arr_rat[0] + 1;
                                } else {
                                    $s = $arr_rat[0];
                                }
                                if ($s < 5) {
                                    for ($j = $s; $j < 5; $j++) {
                                        $rating[$k] = "star-off.png";
                                        $s++;
                                        $k++;
                                    }
                                }
                                return $rating;
//                                        return json_encode($rating);
                            })
                            ->addColumn('review', function($arr_rating_details) {
                                return $arr_rating_details->review;
                            })
                            ->addColumn('status', function($arr_rating_details) {
                                if ($arr_rating_details->status == 0) {
                                    return $status = "InActive";
                                } else {
                                    return $status = "Active";
                                }
                            })
                            ->make(true);
        } else {
            $errorMsg = "Your session has expired. Please login again.";
            Auth::logout();
            return redirect("admin/login")->with("msg_error", $errorMsg);
        }
    }

    public function changeRatingStatus(Request $request, $rating_id) {
        if (Auth::user()) {
            $rating = Rating::find($rating_id);
            if ($rating->status == '1') {
                $rating->status = '0';
                $rating->save();
                $errorMsg = "Status changed successfully";
                return redirect("admin/rating-list")->with("msg-success", $errorMsg);
            } else {
                $rating->status = '1';
                $rating->save();
                $errorMsg = "Status changed successfully";
                return redirect("admin/rating-list")->with("msg-success", $errorMsg);
            }
        } else {
            $errorMsg = "Your session has expired. Please login again.";
            Auth::logout();
            return redirect("admin/login")->with("msg-error", $errorMsg);
        }
    }

    public function updateRating(Request $request, $id) {

        if ($request->method() == "GET") {
            $rating = Rating::where('id', $id)->get();

            return view('bookappointment::Backend/update-rating', ['rating' => $rating,]);
        } elseif ($request->method() == "POST") {
            $data = $request->all();

            $validate_response = Validator::make($data, array(
                        'review' => 'required|min:8',
                            )
            );

            if ($validate_response->fails()) {
                return redirect('Backend/rating/update/' . $data['rating_id'])
                                ->withErrors($validate_response)
                                ->withInput();
            } else {/** user information goes here *** */
                $rating = $data['rating'];
                $review = $data['review'];
                if ($rating != "") {
                    $array_to_update = array(
                        'rating' => $rating,
                        'review' => $review,
                    );
                } else {
                    $array_to_update = array(
                        'review' => $review,
                    );
                }

                Rating::where('id', $data['rating_id'])->update($array_to_update);

                $succes_msg = "Rating and reviews updated successfully!";

                return redirect("admin/rating-list")->with("msg-success", $succes_msg);
            }
        }
    }

    public function serviceProviderAppointments(Request $request) {
        if (Auth::user()) {
            $service_provider_id = Auth::user()->id;
            $completed_appointments = Appointment::where('expert_id', $service_provider_id)->where('status', '3')->orderBy('id', 'desc')->get();
            $pending_appointments = Appointment::where('expert_id', $service_provider_id)->where('status', '0')->orderBy('id', 'desc')->get();
            $scheduled_appointments = Appointment::where('expert_id', $service_provider_id)->where('status', '1')->orderBy('id', 'desc')->get();
            $cancelled_appointments = Appointment::where('expert_id', $service_provider_id)->where('status', '2')->orderBy('id', 'desc')->get();
            $rescheduled_appointments = Appointment::where('expert_id', $service_provider_id)->where('status', '4')->orderBy('id', 'desc')->get();

            return view("bookappointment::serivce-provider-appointment-list", array("completed_appointments" => $completed_appointments, "scheduled_appointments" => $scheduled_appointments, "cancelled_appointments" => $cancelled_appointments, "rescheduled_appointments" => $rescheduled_appointments, "pending_appointments" => $pending_appointments));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function appointmentDetails(Request $request, $appointment_id) {
        if (Auth::user()) {
            $service_provider_id = Auth::user()->id;
            $appointment = Appointment::where('id', $appointment_id)->first();
            $appointment_day = '';
            $appointment_day = date('y-m-d h:i:s A', strtotime($appointment->appointment_datetime));
//         
            $datetime1 = new \DateTime();
            $datetime2 = new \DateTime($appointment_day);
//            dd($datetime2);
            $interval = $datetime1->diff($datetime2);
            if ($datetime2 > $datetime1) {
                if ($interval->d == 0 && $interval->h == 0 && $interval->i == 0 && $interval->s <= 60) {
                    $appointment->is_appointment_enable = "Active";
                } else {
                    $appointment->is_appointment_enable = "InActive";
                }
            } else {
                if ($interval->d == 0 && $interval->h == 0 && $interval->i <= 60 && $interval->s <= 60) {
                    $appointment->is_appointment_enable = "Active";
                } else {
                    $appointment->is_appointment_enable = "InActive";
                }
            }
//            dd($interval);
            if ($interval->d > 0) {
                $appointment->expired = "true";
            } else {
                $appointment->expired = "false";
            }
            $email = Auth::user()->email;
            $name = explode('@', $email);
            $username = $name[0];

            $appointmentName = 'Appointment-' . $service_provider_id . '-' . date_create($appointment->appointment_datetime)->format('Y-m-d-h:i-A');
//            dd($appointmentName);

            return view("bookappointment::appointment-details", array("appointment" => $appointment, 'username' => $username, 'appointmentName' => $appointmentName));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function acceptAppointment(Request $request, $appointment_id) {
        if (Auth::user()) {
            //Accept appointment by service provider
            $service_provider_id = Auth::user()->id;
//          $customer_info=;
            $appointment = Appointment::where('id', $appointment_id)->first();
            $customer_info = \App\User::find($appointment->customer_id);
            if (!isset($customer_info)) {
                $success_msg = "User Not found!Your Request is not fullfilled.";
                return redirect("/admin/manage-appointments")->with("msg-error", $success_msg);
            }
            
            $appointment->status = "1";
            $appointment->save();
            $arr_keyword_values = array();
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $email_sender_fname = "Paras Fashions";
            $email_from = $site_email;
            $reserved_arr = array
                (
                '{{$FIRST_NAME}}' => $customer_info->userInformation->first_name,
                '{{$LAST_NAME}}' => $customer_info->userInformation->last_name,
            );
            $email_template = EmailTemplate::where("template_key", 'service-provider-accepted')->first();
            $subject = $email_template->subject;
            $mail_subject = $this->getSubject($reserved_arr, $subject);
            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = $customer_info->userInformation->first_name;
            $arr_keyword_values['LAST_NAME'] = $customer_info->userInformation->last_name;
            $arr_keyword_values['APPOINTMENT_ID'] = $appointment_id;
            $arr_keyword_values['COUNSELOR_NAME'] = "Paras Fashions";
            $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
            $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
            $arr_keyword_values['SITE_TITLE'] = $site_title;

            Mail::send('emailtemplate::service-provider-accept-appointment', $arr_keyword_values, function ($message) use ($email_from, $email_sender_fname, $mail_subject, $customer_info, $site_email, $site_title) {
                $message->to($customer_info->email)->subject($mail_subject)->from($email_from, $email_sender_fname);
                ; //>from($site_email,$site_title);
            });

            $success_msg = "Your appointment accepted successfully.";
            return redirect("service-provider/appointments-list")->with("msg-success", $success_msg);
        } else {
            $errorMsg = "Error! Something went wrong.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function cancelAppointment(Request $request, $appointment_id) {
        if (Auth::user()) {
            //Appointment rejected by service provider here
            $service_provider_id = Auth::user()->id;
            $appointment = Appointment::where('id', $appointment_id)->first();
            $booking_entry = BookingDateTime::where('user_id', $appointment->expert_id)->where('booking_datetime', $appointment->appointment_datetime)->first();
            $customer_info = \App\User::find($appointment->customer_id);
            if (!isset($customer_info)) {
                $success_msg = "User Not found!Your Request is not fullfilled.";
                return redirect("/admin/manage-appointments")->with("msg-error", $success_msg);
            }

            if (isset($booking_entry) && count($booking_entry) > 0) {
                $booking_entry->status = '0';
                $booking_entry->save();
            }
            $appointment->status = "2";
            $appointment->message = "Rejected";
            $appointment->save();

            
            $arr_keyword_values = array();
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $email_sender_fname = "Paras Fashions";
            $email_from = $site_email;
            $reserved_arr = array
                (
                '{{$FIRST_NAME}}' => $customer_info->userInformation->first_name,
                '{{$LAST_NAME}}' => $customer_info->userInformation->last_name,
            );

            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = $customer_info->userInformation->first_name;
            $arr_keyword_values['LAST_NAME'] = $customer_info->userInformation->last_name;
            $arr_keyword_values['APPOINTMENT_ID'] = $appointment_id;
            $arr_keyword_values['COUNSELOR_NAME'] = "Paras Fashions";
            $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
            $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $email_template = EmailTemplate::where("template_key", 'service-provider-rejected')->first();
            $subject = $email_template->subject;
            $mail_subject = $this->getSubject($reserved_arr, $subject);


            Mail::send('emailtemplate::service-provider-reject-appointment', $arr_keyword_values, function ($message) use ($mail_subject, $email_sender_fname, $email_from, $customer_info, $site_email, $site_title) {
                $message->to($customer_info->email)->subject($mail_subject)->from($email_from, $email_sender_fname); //>from($site_email,$site_title);
            });


            $success_msg = "Your appointment rejected successfully.";
            return redirect("service-provider/appointments-list")->with("msg-success", $success_msg);
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function rescheduleAppointment(Request $request, $appointment_id) {
        if (Auth::user()) {
            $appointment = Appointment::where('id', $appointment_id)->first();
            return view("bookappointment::service-provider-get-calender", array("appointment" => $appointment));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function postBookBusinessAppointment(Request $request) {
        if (Auth::user()->id) {
            $expert_id = 1;
            if (empty($request->select_slot_time)) {
                $errorMsg = "Please select slot timings";
                \Session::flash('issue-profile', $errorMsg);
                return redirect("/get-appointment/book-business-appointment"); //->with("issue-profile", $errorMsg);
            }
            $expertData = \App\User::where('id', $expert_id)->first();
            $selectedDatetime = BookingDateTime::where('id', $request->select_slot_time)->first();
            if (count($selectedDatetime) < 1) {
                $errorMsg = "May be the timings has been booked,You just missed it";
                \Session::flash('issue-profile', $errorMsg);
                return redirect("/book-business-appointment"); //->with("issue-profile", $errorMsg);
            }
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title'); // contact-email
            $contact_email = GlobalValues::get('contact-email'); // contact-email

            if (isset($expertData) && count($expertData) > 0) {
                // When this boolean is set to True, instead of deleting all appointment times for the package duration
                // It will instead remove all times up to the end of the day, and continue to the next day until the package
                // time is done.
                $overlapDays = FALSE;
                $appointment = new Appointment();
                $appointment->customer_id = Auth::user()->id;
                $appointment->expert_id = $expert_id;
                $appointment->appointment_type = '1';
                $appointment->appointment_datetime = $selectedDatetime->booking_datetime;
                $appointment->customer_phone = isset($request->phone) ? $request->phone : "0000000000";
                $appointment->customer_email = isset($request->email)?$request->email:'';
                $appointment->customer_country = isset($request->country)?$request->country:'';
                /*                 * ****************************************************** */
                $appointment->contact_id = $request->facetime_or_skype_id . ": " . $request->facetime_or_skype_name;
                $appointment->purpose = $request->purpose_of_appointment;

                /*                 * ********************************************************* */
                $appointment->customer_name = $request->first_name;
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


                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = Auth::user()->userInformation->first_name;
                $arr_keyword_values['COUNSELOR_NAME'] = 'Paras Fashions';
                $arr_keyword_values['APPOINTMENT_ID'] = $appointment->id;
                $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
                $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $email_template = EmailTemplate::where("template_key", 'booking-confirmed')->first();
                $subject = $email_template->subject;
                $usr = User::where('id', Auth::user()->id)->first();
                $send_to = $usr->email;
                //$mail_subject = $this->getSubject($reserved_arr, $subject);

                Mail::send('emailtemplate::booking-confirmation', $arr_keyword_values, function ($message) use ( $send_to, $subject, $site_email, $site_title) {
                    $message->to($send_to)->subject($subject)->from($site_email); //>from($site_email,$site_title);
                });

                Mail::send('emailtemplate::booking-confirmation', $arr_keyword_values, function ($message) use ($contact_email, $subject, $site_email, $site_title) {
                    $message->to($contact_email)->subject($subject)->from($site_email); //>from($site_email,$site_title);
                });

//                \Session::flash('msg-success', 'Appointment has been booked successfully.');
                return redirect()->back()->with(array('msg-success'=>'Appointment has been booked successfully.'));
            } else {
                \Session::flash('msg-error', 'Something went wrong, please try again.');
                return redirect(url('/'));
            }
        } else {
            return redirect('/');
        }
    }

    public function bookRescheduleAppointment(Request $request, $appointment_id, $selected_time_id) {
        if (Auth::user()) {
            $appointment = Appointment::where('id', $appointment_id)->first();
            $previous_booking = BookingDateTime::where('booking_datetime', $appointment->appointment_datetime)->first();
            $previous_booking->status = '0'; // make available to previous selected booking timing
            $previous_booking->save();
            $selectedDatetime = BookingDateTime::where('id', $selected_time_id)->first();
            $selectedDatetime->status = '1'; // make booked to currently selected booking timing
            $selectedDatetime->save();
            $appointment->status = '4'; // change appointment status to reschedule
            $appointment->appointment_datetime = isset($selectedDatetime) ? $selectedDatetime->booking_datetime : '';
            $appointment->save();


            $service_provider_id = Auth::user()->id;
            $email_sender_fname = Auth::user()->userInformation->first_name;
            $email_from = Auth::user()->email;
            $customer_info = \App\User::find($appointment->customer_id);
            $arr_keyword_values = array();
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $reserved_arr = array
                (
                '{{$FIRST_NAME}}' => $customer_info->userInformation->first_name,
                '{{$LAST_NAME}}' => $customer_info->userInformation->last_name,
            );


            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = $customer_info->userInformation->first_name;
            $arr_keyword_values['LAST_NAME'] = $customer_info->userInformation->last_name;
            $arr_keyword_values['APPOINTMENT_ID'] = $appointment_id;
            $arr_keyword_values['COUNSELOR_NAME'] = Auth::user()->userInformation->first_name . ' ' . Auth::user()->userInformation->last_name;
            $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
            $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $email_template = EmailTemplate::where("template_key", 'service-provider-accepted')->first();
            $subject = $email_template->subject;
            $mail_subject = $this->getSubject($reserved_arr, $subject);

            Mail::send('emailtemplate::service-provider-rescheduled-appointment', $arr_keyword_values, function ($message) use ( $email_from, $email_sender_fname, $mail_subject, $customer_info, $email_template, $site_email, $site_title) {
                $message->to($customer_info->email)->subject($mail_subject)->from($email_from, $email_sender_fname);
                ; //>from($site_email,$site_title);
            });


            $success_msg = "Your appointment rescheduled successfully.";
            return redirect("service-provider/appointments-list")->with("msg-success", $success_msg);
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function rescheduleAppointmentDetail(Request $request, $appointment_id, $tid) {

        $appointment_data = Appointment::find($appointment_id);
        $customerData = UserInformation::where('user_id', $appointment_data->customer_id)->first();
        $selectedDatetime = BookingDateTime::where('id', $tid)->first();
//        dd($selectedMode);
//        $days = BookingDateTime::all();
        return view('bookappointment::reschedule-app-details', compact('appointment_data', 'customerData', 'selectedDatetime'));
    }

    public static function getSubject($reserved_arr, $subject) {
        foreach ($reserved_arr as $k => $v) {

            $subject = str_replace($k, $v, $subject);
        }
        return $subject;
    }

    public function customerAppointmentDetail(Request $request, $appointment_id) {
        if (Auth::user()) {
            $customer_id = Auth::user()->id;
            $appointment = Appointment::where('id', $appointment_id)->first();
            return view("bookappointment::customer-appointment-details", array("appointment" => $appointment));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function sendAppointmentReminderCron(Request $request) {

        $all_scheduled_appointments = Appointment::where('status', 1)->get();

        foreach ($all_scheduled_appointments as $appointment) {
            $customer_info = \App\User::find($appointment->customer_id);
            $expert_info = \App\User::find($appointment->expert_id);
            $appointment_day = '';
            $appointment_day = date('y-m-d', strtotime($appointment->appointment_datetime));
            $datetime1 = new \DateTime();
            $datetime2 = new \DateTime($appointment_day);
            $interval = $datetime1->diff($datetime2);
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $email_from = GlobalValues::get('booking-reminder');

            if ($interval->h <= 24 && $appointment->day_reminder != 1) {
                // set day reminder to 1 for appointment. means we send notification to our clients.
                $appointment->day_reminder = '1';
                $appointment->save();

                // Here we send notification and email to service provider
                $noti_obj = new Notification();
                $noti_obj->to = $expert_info->id;
                $noti_obj->from = $customer_info->id;
                $noti_obj->content = "Tommorrow your appointment is scheduled with " . $customer_info->userInformation->first_name . " " . $customer_info->userInformation->last_name . ".";
                $noti_obj->notification_type = "Appointment Reminder";
                $noti_obj->appointment_id = $appointment->id;
                $noti_obj->save();


                $reserved_arr = array
                    (
                    '{{$FIRST_NAME}}' => $customer_info->userInformation->first_name,
                    '{{$LAST_NAME}}' => $customer_info->userInformation->last_name,
                );


                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $expert_info->userInformation->first_name;
                $arr_keyword_values['USER_FIRST_NAME'] = $customer_info->userInformation->first_name;
                $arr_keyword_values['USER_LAST_NAME'] = $customer_info->userInformation->last_name;
                $arr_keyword_values['APPOINTMENT_ID'] = $appointment->id;
                $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
                $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $email_template = EmailTemplate::where("template_key", 'appointment-reminder-before-day')->first();
                $subject = $email_template->subject;
                $mail_subject = $this->getSubject($reserved_arr, $subject);

                Mail::send('emailtemplate::appointment-reminder-before-day', $arr_keyword_values, function ($message) use ( $email_from, $mail_subject, $expert_info, $email_template, $site_email, $site_title) {
                    $message->to($expert_info->email)->subject($mail_subject)->from($email_from);
                    ; //>from($site_email,$site_title);
                });

                // Here we send notification and email to customer
                $noti_obj = new Notification();
                $noti_obj->to = $customer_info->id;
                $noti_obj->from = $expert_info->id;
                $noti_obj->content = "Tommorrow your appointment is scheduled with " . $expert_info->userInformation->first_name . " " . $expert_info->userInformation->last_name . ".";
                $noti_obj->notification_type = "Appointment Reminder";
                $noti_obj->appointment_id = $appointment->id;
                $noti_obj->save();

                $reserved_arr = array
                    (
                    '{{$FIRST_NAME}}' => $expert_info->userInformation->first_name,
                    '{{$LAST_NAME}}' => $expert_info->userInformation->last_name,
                );


                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $customer_info->userInformation->first_name;
                $arr_keyword_values['USER_FIRST_NAME'] = $expert_info->userInformation->first_name;
                $arr_keyword_values['USER_LAST_NAME'] = $expert_info->userInformation->last_name;
                $arr_keyword_values['APPOINTMENT_ID'] = $appointment->id;
                $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
                $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $mail_subject = $this->getSubject($reserved_arr, $subject);

                Mail::send('emailtemplate::appointment-reminder-before-day', $arr_keyword_values, function ($message) use ( $email_from, $mail_subject, $customer_info, $email_template, $site_email, $site_title) {
                    $message->to($customer_info->email)->subject($mail_subject)->from($email_from);
                    ; //>from($site_email,$site_title);
                });
            }

            if ($interval->i <= 30 && $appointment->time_reminder != 1) {
                $appointment->time_reminder = '1';
                $appointment->save();

                // Here we send notification and email to service provider
                $noti_obj = new Notification();
                $noti_obj->to = $expert_info->id;
                $noti_obj->from = $customer_info->id;
                $noti_obj->content = "Today your next appointment is scheduled with " . $customer_info->userInformation->first_name . " " . $customer_info->userInformation->last_name . ".";
                $noti_obj->notification_type = "Appointment Reminder";
                $noti_obj->appointment_id = $appointment->id;
                $noti_obj->save();
//                dd($customer_info->userInformation->first_name);
                $reserved_arr = array
                    (
                    '{{$FIRST_NAME}}' => $customer_info->userInformation->first_name,
                    '{{$LAST_NAME}}' => $customer_info->userInformation->last_name,
                );


                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $expert_info->userInformation->first_name;
                $arr_keyword_values['USER_FIRST_NAME'] = $customer_info->userInformation->first_name;
                $arr_keyword_values['USER_LAST_NAME'] = $customer_info->userInformation->last_name;
                $arr_keyword_values['APPOINTMENT_ID'] = $appointment->id;
                $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
                $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $email_template = EmailTemplate::where("template_key", 'appointment-reminder-before-half-hour')->first();
                $subject = $email_template->subject;
                $mail_subject = $this->getSubject($reserved_arr, $subject);

                Mail::send('emailtemplate::appointment-reminder-before-half-hour', $arr_keyword_values, function ($message) use ( $email_from, $mail_subject, $expert_info, $email_template, $site_email, $site_title) {
                    $message->to($expert_info->email)->subject($mail_subject)->from($email_from);
                    ; //>from($site_email,$site_title);
                });


                // Here we send notification and email to customer
                $noti_obj = new Notification();
                $noti_obj->to = $customer_info->id;
                $noti_obj->from = $expert_info->id;
                $noti_obj->content = "Today your next appointment is scheduled with " . $expert_info->userInformation->first_name . " " . $expert_info->userInformation->last_name . ".";
                $noti_obj->notification_type = "Appointment Reminder";
                $noti_obj->appointment_id = $appointment->id;
                $noti_obj->save();

                $reserved_arr = array
                    (
                    '{{$FIRST_NAME}}' => $expert_info->userInformation->first_name,
                    '{{$LAST_NAME}}' => $expert_info->userInformation->last_name,
                );


                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $customer_info->userInformation->first_name;
                $arr_keyword_values['USER_FIRST_NAME'] = $expert_info->userInformation->first_name;
                $arr_keyword_values['USER_LAST_NAME'] = $expert_info->userInformation->last_name;
                $arr_keyword_values['APPOINTMENT_ID'] = $appointment->id;
                $arr_keyword_values['APPOINTMENT_DATE'] = date('d-M-Y', strtotime($appointment->appointment_datetime));
                $arr_keyword_values['TIME_SLOT'] = 'From ' . date('h:i A', strtotime($appointment->appointment_datetime)) . ' To ' . date('h:i A', strtotime($appointment->appointment_datetime) + 60 * 60);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $mail_subject = $this->getSubject($reserved_arr, $subject);

                Mail::send('emailtemplate::appointment-reminder-before-half-hour', $arr_keyword_values, function ($message) use ( $email_from, $mail_subject, $customer_info, $email_template, $site_email, $site_title) {
                    $message->to($customer_info->email)->subject($mail_subject)->from($email_from);
                    ; //>from($site_email,$site_title);
                });
            }
        }
    }

    public function myReviews(Request $request) {
        if (Auth::user()) {
            $all_rating = Rating::where('to_id', Auth::user()->id)->get();

            $my_rating = Rating::where('to_id', Auth::user()->id)->orderBy('id', 'DESC')->limit(5)->get();
            return view("bookappointment::service-provider-review", array('my_rating' => $my_rating, 'all_rating_count' => $all_rating));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function ajaxAddReviews(Request $request) {
        if (Auth::user()) {
            $last_record = $request->last_id;
            $all_rating = Rating::where('to_id', Auth::user()->id)->where('id', '<', $last_record)->get();
            $my_rating = Rating::where('to_id', Auth::user()->id)->where('id', '<', $last_record)->limit(5)->get();

            return view("bookappointment::add-ajax-dynamic-review", array('my_rating' => $my_rating, 'all_rating_count' => $all_rating));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'Available now';
    }

    public function checkAppointmentTime(Request $request) {
        $appointment_id = $request->appointment_id;
        $appointment = Appointment::where('id', $appointment_id)->first();
        $appointment_day = '';
        $appointment_day = date('y-m-d h:i:s A', strtotime($appointment->appointment_datetime));

        $datetime1 = new \DateTime();
        $datetime2 = new \DateTime($appointment_day);
//            dd($datetime2);
        $interval = $datetime1->diff($datetime2);

        if ($datetime2 > $datetime1) {
            if ($interval->d == 0 && $interval->h == 0 && $interval->i == 0 && $interval->s == 0) {
                return "Active";
            } else {
                return "InActive";
            }
        } else {
            if ($interval->d == 0 && $interval->h == 0 && $interval->i <= 60 && $interval->s <= 60) {
                return "Active";
            } else {
                return "InActive";
            }
        }
    }

    public function checkChatStart(Request $request) {
        //$appointment_id=$request->appointment_id;
        $appointment_id = $request->input("appointment_id");
        $appointment = Appointment::where('id', $appointment_id)->first();
        $appointment->chat_start = 1;
        $appointment->save();
        return 'success';
    }

    public function giveFeedback(Request $request, $appointment_id) {
        if (Auth::user()) {
            $feedback_questions = FeedbackQuestion::limit(10)->get();
            $appointment = Appointment::find($appointment_id);
            $appointment->status = 3;
            $appointment->save();
            return view('user-feedback-form', compact('feedback_questions', 'appointment_id'));
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function saveFeedback(Request $request, $appointment_id) {
        if (Auth::user()) {
            $feedback_questions = FeedbackQuestion::limit(10)->get();
            $appointment = Appointment::find($appointment_id);
            $expert_info = \App\User::find($appointment->expert_id);

            $data = $request->all();
            $answer_array = array();
            //removed first element from array
            array_shift($data);
            foreach ($data as $key => $val) {
                $answer_array[] = $val;
                $question_id = explode('-', $key);
                $user_feedback = new UserFeedback();
                $user_feedback->question_id = $question_id[1];
                $user_feedback->answer_id = $val;
                $user_feedback->user_id = Auth::user()->id;
                $user_feedback->expert_id = $appointment->expert_id;
                $user_feedback->save();
            }

            $arr_keyword_values = array();
            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $email_from = GlobalValues::get('support-email');

            $email_template = EmailTemplate::where("template_key", 'user-feedback')->first();
            $subject = $email_template->subject;
            $html_feedback = '';
            $i = 1;
            foreach ($feedback_questions as $question) {
                $html_feedback .= '<div class="feedback-ques" style="position: relative; top: -50px;" >';
                $html_feedback .= '<p class="f-question" style="font-size: 16px;line-height: 15px;">';
                $html_feedback .= $i . '. ' . $question->questions . '?</p>';

                $html_feedback .= '<ul class="f-answers"> <input type="radio" name="question-' . $i . '"  value="' . $question->questionAnswers['0']->id . '" id=question_' . $question->questionAnswers['0']->id . '  ';
                if (in_array($question->questionAnswers['0']->id, $answer_array)) {
                    $html_feedback .= 'checked';
                }
                $html_feedback .= ">";

                $html_feedback .= '<label for=question_' . $question->questionAnswers['0']->id . '> "' . $question->questionAnswers['0']->answer . '" </label>';
                $html_feedback .= ' <input type="radio" name="question-' . $i . '" value="' . $question->questionAnswers['1']->id . '" id=question_' . $question->questionAnswers['1']->id . ' ';
                if (in_array($question->questionAnswers['1']->id, $answer_array)) {
                    $html_feedback .= 'checked';
                }
                $html_feedback .= ">";
                $html_feedback .= '<label for=question_' . $question->questionAnswers['1']->id . '> "' . $question->questionAnswers['1']->answer . '" </label>';
                $html_feedback .= ' <input type="radio" name="question-' . $i . '" value="' . $question->questionAnswers['2']->id . '" id=question_' . $question->questionAnswers['2']->id . ' ';
                if (in_array($question->questionAnswers['2']->id, $answer_array)) {
                    $html_feedback .= 'checked';
                }
                $html_feedback .= ">";
                $html_feedback .= '<label for=question_' . $question->questionAnswers['2']->id . '> "' . $question->questionAnswers['2']->answer . '" </label>';
                $html_feedback .= ' <input type="radio" name="question-' . $i . '" value="' . $question->questionAnswers['3']->id . '"  id=question_' . $question->questionAnswers['3']->id . ' ';
                if (in_array($question->questionAnswers['3']->id, $answer_array)) {
                    $html_feedback .= 'checked';
                }
                $html_feedback .= ">";
                $html_feedback .= '<label for=question_' . $question->questionAnswers['3']->id . '> "' . $question->questionAnswers['3']->answer . '" </label></ul></div>';
                $i++;
            }
//        return view('emailtemplate::user-feedback',array('FEEDBACK'=>$html_feedback));
            //$mail_subject = $this->getSubject($reserved_arr, $subject);
            //Assign values to all macros
            $arr_keyword_values['FIRST_NAME'] = Auth::user()->userInformation->first_name;
            $arr_keyword_values['LAST_NAME'] = Auth::user()->userInformation->last_name;
            $arr_keyword_values['EXPERT_FIRST_NAME'] = $expert_info->userInformation->first_name;
            $arr_keyword_values['EXPERT_LAST_NAME'] = $expert_info->userInformation->last_name;
            $arr_keyword_values['SITE_TITLE'] = $site_title;
            $arr_keyword_values['FEEDBACK'] = $html_feedback;

            Mail::send('emailtemplate::user-feedback', $arr_keyword_values, function ($message) use ($email_from, $subject, $site_email, $site_title) {
                $message->to('mayur.y@panaceatek.com')->subject($subject)->from($email_from);
                ; //>from($site_email,$site_title);
            });
            return redirect('customer-user-dashboard')->with('msg-success', 'Your feedback is recorded successfully.');
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }

    public function thankYou(Request $request) {
        return view('bookappointment::thanks');
    }

    public function manageAppointment(Request $request) {
        if (Auth::user()) {
            return view("bookappointment::appointment-list");
        } else {
            $successMsg = "Your session was expired!";
            Auth::logout();
            return redirect("admin/login")->with("register-success", $successMsg);
        }
    }

    public function manageAppointmentData(Request $request) {

        $all_appointments = Appointment::all();
//        dd($all_appointments);
//        $all_appointments = $all_appointments->sortByDesc('id');
//        return Datatables::collection($all_states)->make(true);
        return Datatables::of($all_appointments)
                        ->addColumn('status', function($appointment) {
                            if (isset($appointment)) {
                                if ($appointment->status == 0) {
                                    $status = 'Pending';
                                } elseif ($appointment->status == 1) {
                                    $status = 'Scheduled';
                                } elseif ($appointment->status == 2 && $appointment->message == "Cancelled By Customer") {
                                    $status = 'Cancel';
                                } elseif ($appointment->status == 2 && $appointment->message == "Rejected") {
                                    $status = 'Rejected';
                                } elseif ($appointment->status == 3) {
                                    $status = 'Completed';
                                } elseif ($appointment->status == 4) {
                                    $status = 'Rescheduled';
                                }
                                return $status;
                            }
                        })
                        ->addColumn('Action', function($appointment) {

                            $html = '';
                            if ($appointment->status == 0) {
                                $html .= "<a class='btn btn-sm btn-primary' id='show-for-loader'  href='" . url('get-appointment/my-appointments/accept-appointment/' . $appointment->id) . "'> Accept </a>";
                                $html .= "<a class='btn btn-sm btn-danger' id='show-for-loader' href='" . url('get-appointment/my-appointments/reject-appointment/' . $appointment->id) . "'> Reject </a>";
                            } elseif ($appointment->status == 1) {
                                $html = "<a class='btn btn-sm btn-danger' id='show-for-loader' href='" . url('get-appointment/my-appointments/reject-appointment/' . $appointment->id) . "'> Reject </a>";
                            } elseif ($appointment->status == 2) {
                                $html = "Appointment Rejected";
                            } elseif ($appointment->status == 3) {
                                $html = "Appointment Completed";
                            } elseif ($appointment->status == 4) {
                                $html = "Appointment Rescheduled";
                            }


                            return $html;
                        })
                        ->addColumn('customer_id', function($appointment) {
                            $name = '';
//                            return $appointment->customer_id;//->customer->userInformation->first_name;// . ' ' . $appointment->customer->userInformation->last_name;

                            $name = isset($appointment->customer->userInformation->first_name) ? $appointment->customer->userInformation->first_name : "No user Found";

                            return $name;
                        })
                        ->addColumn('expert_id', function($appointment) {
                            //return $appointment->expert_id;//->userInformation->first_name;// . ' ' . $appointment->expert->userInformation->last_name;
                            $name = '';
//                            return $appointment->customer_id;//->customer->userInformation->first_name;// . ' ' . $appointment->customer->userInformation->last_name;

                            $name = isset($appointment->expert->userInformation->first_name) ? $appointment->expert->userInformation->first_name : "No user Found";

                            return $name;
                        })
                        ->addColumn('appointment_datetime', function($appointment) {

                            return date('d M Y h:i A', strtotime($appointment->appointment_datetime));
                        })
                        ->make(true);
    }

    public function viewAppointmentDetail(Request $request, $appointment_id) {
        if (Auth::user()) {
            $appointment_details = Appointment::find($appointment_id);
            return view("bookappointment::appointment-details-backend", array("appointment" => $appointment_details));
        } else {
            $successMsg = "Your session was expired!";
            Auth::logout();
            return redirect("admin/login")->with("register-success", $successMsg);
        }
    }

    public function showFullCalendar() {
        return view('bookappointment::set-availability');
    }



}
