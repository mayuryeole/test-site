<?php

namespace App\PiplModules\coupon\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\coupon\Models\Coupon;
use Mail;
use Image;
use Datatables;
use GlobalValues;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use App\User as MainUser;
use App\UserInformation;
use Illuminate\Routing\UrlGenerator;
use App\PiplModules\coupon\Models\CouponUser;
use App\PiplModules\coupon\SendCouponEmail;
use Carbon;

class CouponController extends Controller {

    private $thumbnail_size = array("width" => 50, "height" => 50);

    public function listCoupons() {
        return view('coupon::list-coupons');
    }

    public function listCouponsData() {
        $arr_coupon = Coupon::all();
        $currentTime = Carbon\Carbon::now()->toDateTimeString();

        $arr_coupon = $arr_coupon->reject(function ($coupon)use($currentTime) {

            $is_valid=$coupon->validateCouponDate($coupon->id,$currentTime);
            if($is_valid=='0')
            {
                return $coupon;
            }
        });
        return Datatables::of($arr_coupon)
                        ->addColumn('status', function($arr_coupon) {
                            if ($arr_coupon->status == '0') {
                                return 'Inactive';
                            }
                            if ($arr_coupon->status == '1') {
                                return 'Active';
                            }
                        })
                        ->addColumn('code_type', function($arr_coupon) {
                                if ($arr_coupon->code_type == '0') {
                                    return 'Coupon';
                                }
                                if ($arr_coupon->code_type == '1') {
                                    return 'Promo';
                                }
                        })
                        ->addColumn('user_type', function($arr_coupon) {
                            if ($arr_coupon->user_type == '3') {
                                return 'Customer User';
                            }
                            else if ($arr_coupon->user_type == '4') {
                                return 'Business User';
                            }
                            else{
                                return "-";
                            }
                        })
                        ->make(true);
    }

    public function createCoupon(Request $request) {
        if ($request->method() == "GET") {
            return view("coupon::create-coupon");
        } else {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'coupon_code' => 'required|unique:coupons'
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {

                $created_coupon = new Coupon;

                $amount = $request->amount != '' ? $request->amount : 0;
                $percentage = $request->percentage != '' ? $request->percentage : 0;
                $minPurchaseAmt = $request->min_purchase_amt != '' ? $request->min_purchase_amt : 0;

                $created_coupon->coupon_code =isset($request->coupon_code)?$request->coupon_code:'';
                $created_coupon->name =isset($request->name)?$request->name:'';
                $created_coupon->user_type =isset($request->user_type)?$request->user_type:'3';
                $created_coupon->code_type =isset($request->code_type)?$request->code_type:'0';
                $created_coupon->amount = $amount;
                $created_coupon->percentage = $percentage;
                $created_coupon->min_purchase_amt = $minPurchaseAmt;
                $created_coupon->coupon_valid_from = $request->valid_from;
                $created_coupon->coupon_valid_to = $request->valid_to;
                $created_coupon->status =isset($request->status)?$request->status:"0";
                $created_coupon->quantity = $request->quantity;
                $created_coupon->description = $request->description;
                 if ($request->hasFile('images')) {
                        $extension= $request->file('images')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                        if (!is_dir(storage_path('app/public/coupon/image/'))) {
                            Storage::makeDirectory('public/coupon/image/');
                        }

                        Storage::put('public/coupon/image/' . $new_file_name, file_get_contents($request->file('images')->getRealPath()));

                        if (!is_dir(storage_path('app/public/coupon/image/thumbnail/'))) {
                            Storage::makeDirectory('app/public/coupon/image/thumbnail/');
                        }
                        $thumbnail = Image::make(storage_path('app/public/coupon/image/' . $new_file_name));
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(storage_path('app/public/coupon/image/thumbnail/' . $new_file_name));

                        $created_coupon->image=$new_file_name;
                }


                $created_coupon->save();

                return redirect("admin/coupons-list")->with('status', 'Coupon/Promo Code created successfully!');
            }
        }
    }

    public function updateCoupon(Request $request, $coupon_id) {
        $coupon_details = Coupon::find($coupon_id);

        if (isset($coupon_details) && count($coupon_details)>0) {


            if ($request->method() == "GET") {
                return view("coupon::update-coupon", array('coupon_details' => $coupon_details));
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'coupon_code' => 'required|unique:coupons,coupon_code,'.$coupon_id, 
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    $amount = $request->amount != '' ? $request->amount : '';
                    $percentage = $request->percentage != '' ? $request->percentage : '';
                    $minPurchaseAmt = $request->min_purchase_amt != '' ? $request->min_purchase_amt : '';
                 

                    $coupon_details->coupon_code = isset($request->coupon_code)?$request->coupon_code:'';
                    $coupon_details->name =isset($request->name)?$request->name:'';
                    $coupon_details->code_type =isset($request->code_type)?$request->code_type:'0';
                    $coupon_details->user_type = isset($request->user_type)?$request->user_type:'0';
                    $coupon_details->amount = $amount;
                    $coupon_details->percentage = $percentage;
                    $coupon_details->min_purchase_amt = $minPurchaseAmt;
                    $coupon_details->coupon_valid_from = $request->valid_from;
                    $coupon_details->coupon_valid_to = $request->valid_to;
                    $coupon_details->status = $request->status;
                    $coupon_details->quantity = $request->quantity;
                    $coupon_details->description = $request->description;

                    if ($request->hasFile('images')) {
                        $extension= $request->file('images')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                        if (!is_dir(storage_path('app/public/coupon/image/'))) {
                            Storage::makeDirectory('public/coupon/image/');
                        }

                        Storage::put('public/coupon/image/' . $new_file_name, file_get_contents($request->file('images')->getRealPath()));

                        if (!is_dir(storage_path('app/public/coupon/image/thumbnail/'))) {
                            Storage::makeDirectory('public/coupon/image/thumbnail/');
                        }
                        $thumbnail = Image::make(storage_path('app/public/coupon/image/' . $new_file_name));
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(storage_path('app/public/coupon/image/thumbnail/' . $new_file_name));

                        $coupon_details->image=$new_file_name;
                }

                
                    $coupon_details->save();

                    return redirect("admin/coupons-list")->with('status', 'Coupon/Promo Code updated Successfully!');
                }
            }
        } else {
            return redirect('admin/coupons-list');
        }
    }

    public function deleteCoupon($coupon_id) {
        $coupon_details = Coupon::find($coupon_id);

        if ($coupon_details) {
            $coupon_details->delete();
            return redirect("admin/coupons-list")->with('status', 'Coupon/Promo Code deleted successfully!');
        } else {
            return redirect('admin/coupons-list');
        }
    }

    public function deleteSelectedCoupon($coupon_id) {
        $coupon_details = Coupon::find($coupon_id);

        if ($coupon_details) {
            $coupon_details->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }
    public function chkCouponCodeDuplicate(Request $request){
       // dd($request->all());
        $coupon_code = $request->coupon_code;
       
        $chk_coupon_code = Coupon::where('coupon_code',$coupon_code)->first();
         // dd($coupon_code);
        // dd($chk_coupon_code);
//        if(isset($chk_coupon_code) && count($chk_coupon_code)>0){
        if(isset($chk_coupon_code) && count($chk_coupon_code)>1){
        
            return "false";
        }
        else{
            return "true";
        }
        
    }
    public function listCouponRegisteredUsers(Request $request,$coupon_id) {
                
        $coupon = Coupon::where('id',$coupon_id)->first();
        if($coupon->status=="0"){
            return back()->with("error","The coupon is inactive! So you can't send the coupon.");
        }
        else if($coupon->status=="1"){
        $quantity =0;
        $remaining_coupon_count =0;
        if(isset($coupon) && count($coupon)>0){
            $quantity = $coupon->quantity;
            $user_type = $coupon->user_type;
            $coupon_user_count = CouponUser::where('coupon_id',$coupon_id)->count();

            if($coupon_user_count > 0){
               // dd(134);
                $remaining_coupon_count =$quantity - $coupon_user_count;
            }
            else{
                $remaining_coupon_count = $quantity;
            }
            if(isset($_GET['served_from']) && $_GET['served_from']=="notice")
            {
                return redirect('/admin/manage-coupon-users/'.$coupon_id.'/'.$user_type)->with('delete-user-status', 'Coupons has been sent Successfully!');
            }
                return view("coupon::list-users")->with(array('coupon_id' => $coupon_id, 'rem_coupon_count' => $remaining_coupon_count,'user_type'=>$user_type,'code_type'=>$coupon->code_type));
            }
    }
    }
    public function listCouponRegisteredUsersData($coupon_id,$para = "") {
        $all_users = UserInformation::all();
        $filtered_record=$all_users->filter(function ($user)use($coupon_id){
            $coupon_already_use=CouponUser::where('user_id',$user->user_id)->where('coupon_id',$coupon_id)->first();
            if(count($coupon_already_use)==0)
            {
              return $user;
            }
        });


        $all_users = $filtered_record->where('user_status','1')->sortByDesc('id');
       // $all_users =$all_users->getExceptCouponUsers($coupon_id);
       // dd($all_users);
        if ($para == "") {
            $registered_users = $all_users->reject(function ($user) {
                return (!($user->user->hasRole('businessuser') || $user->user->hasRole('registereduser')) && $user->user_type == 1 );
            });
        } else if ($para == 4) {
            $registered_users = $all_users->reject(function ($user, $para) {
                return (!($user->user->hasRole('businessuser')) && $user->user_type != 4);
            });
        } else if ($para == 3) {
            $registered_users = $all_users->reject(function ($user, $para) {
                return (!($user->user->hasRole('registereduser')) && $user->user_type != 3);
            });
        }
        if (isset($registered_users) && count($registered_users) > 0) {
            $usr = $registered_users->first();
        } else {
            $usr = $all_users->first();
        }


        return Datatables::of($registered_users)
            ->addColumn('first_name', function($regsiter_user) {
                if(isset($regsiter_user->first_name) && $regsiter_user->first_name !='')
                    return $regsiter_user->first_name;
                else
                    return '-';
            })
            ->addColumn('last_name', function($regsiter_user) {
                if(isset($regsiter_user->last_name) && $regsiter_user->last_name!='')
                return $regsiter_user->last_name;
                else
                    return '-';
            })
            ->addColumn('email', function($regsiter_user) {
                if(isset($regsiter_user->user->email) && $regsiter_user->user->email !='')
                return $regsiter_user->user->email;
                else
                return '-';
            })
            ->addColumn('status', function($admin_users) {

                $html = '';

                if ($admin_users->user_status == 0) {
                    $html = '<div  id="active_div' . $admin_users->user->id . '"    style="display:none;text-align:center">
                                                <a class="label label-success" title="Click to Change UserStatus" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                    $html = $html . '<div id="inactive_div' . $admin_users->user->id . '"  style="display:inline-block;text-align:center">
                                                <a class="label label-warning" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Inactive </a> </div>';
                    $html = $html . '<div id="blocked_div' . $admin_users->user->id . '" style="display:none;text-align:center">
                                                <a class="label label-danger" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked </a> </div>';
                } else if ($admin_users->user_status == 2) {
                    $html = '<div  id="active_div' . $admin_users->user->id . '"  style="display:none;text-align:center" >
                                                <a class="label label-success" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                    $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"    style="display:inline-block;text-align:center">
                                                <a class="label label-danger" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                } else {//
                    $html = '<div  id="active_div' . $admin_users->user->id . '"   style="display:inline-block;text-align:center">
                                                <a class="label label-success" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 2);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Active</a> </div>';
                    $html = $html . '<div id="blocked_div' . $admin_users->user->id . '"  style="display:none;text-align:center">
                                                <a class="label label-danger" title="Click to Change Status" onClick="javascript:changeStatus(' . $admin_users->user->id . ', 1);" href="javascript:void(0);" id="status_' . $admin_users->user->id . '">Blocked</a> </div>';
                }
////                            return ($regsiter_user->user_status > 0) ? 'Active' : 'Inactive';
                return $html;
            })->make(true);
    }

    public function sendCouponToUser($coupon_id,$user_id) {
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');
        $arr_keyword_values = array();
        $coupon_details= Coupon::find($coupon_id);
        if(isset($coupon_details)&& count($coupon_details)>0){
            $user = MainUser::find($user_id);

            if (isset($user) && count($user)>0) {

                $arr_keyword_values['FIRST_NAME'] = $user->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $user->userInformation->last_name;
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['COUPON_CODE'] = $coupon_details->coupon_code;
                $arr_keyword_values['VALID_FROM'] = $coupon_details->coupon_valid_from;
                $arr_keyword_values['VALID_TO'] = $coupon_details->coupon_valid_to;

                //  $user->delete();
                $email_template = EmailTemplate::where("template_key", 'user-coupon')->first();
                Mail::send('emailtemplate::user-coupon', $arr_keyword_values, function ($message) use ($user,$coupon_details, $email_template, $site_email, $site_title) {
                    $message->to($user->email)->subject($email_template->subject)->from($site_email, $site_title);
                });
                    $coupon_user = new CouponUser();
                    $coupon_user->user_id =$user->id;
                    $coupon_user->coupon_id =$coupon_details->id;
                    $coupon_user->save();
                    return redirect('/admin/manage-coupon-users/'.$coupon_id.'/'.$coupon_details->user_type)->with('delete-user-status', 'Coupon has been sent Successfully!');


        } else {
            return redirect("/admin/manage-coupon-users/".$coupon_id.'/'.$coupon_details->user_type);
        }
    }
    }

    public function sendCouponToSelectedUser(Request $request,$coupon_id,$user_id) {
       $coupon_details= Coupon::find($coupon_id);
       if(isset($coupon_details)&& count($coupon_details)>0){
           $user = MainUser::find($user_id);
           $userInfo =$user->UserInformation;
           if (isset($user) && count($user)>0) {
                 if(isset($user->email) && $user->email!= "")
                 {
                     $status = $this->sendCouponUser($coupon_details, $user->email, $userInfo);
                     if($status == "1"){

                         $coupon_user = new CouponUser();
                         $coupon_user->user_id =$user->id;
                         $coupon_user->coupon_id =$coupon_details->id;
                         $coupon_user->save();
                         echo json_encode(array("success" => '1', 'msg' => 'Selected coupons has been sent successfully.'));
                     }
                     else{
                         echo json_encode(array("success" => '0', 'msg' => 'There is an issue in sending coupon to user.'));
                     }

                 }
                 else{
                     echo json_encode(array("success" => '0', 'msg' => 'Could not find Customer email id.'));
                 }

           } else {
               echo json_encode(array("success" => '0', 'msg' => "This user doesn't exist anymore"));
           }
       }
       else{
           echo json_encode(array("success" => '0', 'msg' => 'Coupon id does not found'));
       }

    }
    public function sendCouponUser($coupon,$email,$userInfo) {

        if (isset($coupon) && count($coupon)> 0) {
                if($email != "") {
                   // dd($coupon->id);
                    $queued_coupon = (new SendCouponEmail($coupon, $email,$userInfo));
                    $this->dispatch($queued_coupon);
                    if ($queued_coupon) {
                        return "1";
                    } else {
                        return "0";
                    }
                }
                 else{
                     return "0";
                 }
        } else {
            return "0";
        }
    }

}
