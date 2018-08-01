<?php

namespace App\PiplModules\artist\Controllers;

use App\PiplModules\artist\Models\ArtistAppointment;
use Session;
use App\User;
use App\UserInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Hash;
use Datatables;
use App\PiplModules\roles\Models\Role;
use App\PiplModules\roles\Models\RoleUser;
use App\PiplModules\roles\Models\Permission;
use App\PiplModules\admin\Models\GlobalSetting;
use App\PiplModules\admin\Models\Country;
use App\PiplModules\admin\Models\State;
use App\PiplModules\admin\Models\City;
use App\PiplModules\emailtemplate\Models\EmailTemplate;
use Storage;
use Cache;
use GlobalValues;
use App\PiplModules\artist\Models\Artist;
use App\PiplModules\artist\Models\ArtistImage;
use Image;

class ArtistAppointmentController extends Controller {


    protected function getArtistAppointment(Request $request,$id){
       // dd($id);
        $artist_info = Artist::find($id);
        if(count($artist_info) >0){
          //  $services = unserialize($artist_info->services);
           // dd($services);
            $img_gallery = ArtistImage::where('artist_id',$artist_info->id)->where('media_type',0)->inRandomOrder()->get();
            //$vdo = ArtistImage::where('artist_id',$artist_info->id)->where('media_type',1)->inRandomOrder()->first();
//            $video = ArtistImage::where('media_type',1)->rand
//            dd($artist_info);
            return view('artist::artist-appointment',compact('artist_info','img_gallery'));
        }
        return redirect('/');
    }

    protected function setArtistAppointment(Request $request){
//        dd($request->all());

        if($request->artist_id !='')
        $ckArtist =Artist::find($request->artist_id);

        $service_name =isset($request->service_nm)?trim($request->service_nm):'';
        $service_price =isset($request->service_price)?trim($request->service_price):'';
        $service_name = explode(',',$service_name);
        $service_price = explode(',',$service_price);
        $arrSrNm = [];
        $arrSrPrice = [];
//         dd($service_name);
        $cnt=0;
        foreach ($service_name as $key=>$nm)
        {

            if($nm !='')
            {
                $arrSrNm[$cnt] = trim($nm);
                $cnt++;
            }
        }
        $cnt1=0;
        foreach ($service_price as $key=>$nm)
        {

            if($nm !='')
            {
                $arrSrPrice[$cnt1] = trim($nm);
                $cnt1++;
            }
        }
//        dd($arrSrPrice);

     //   dd($ckArtist);
        if(isset($ckArtist) && count($ckArtist)>0){
            $artistAppointment =new ArtistAppointment();
            $artistAppointment->artist_id = $ckArtist->id;
            $artistAppointment->service_name = isset($arrSrNm)?implode(',',$arrSrNm):'';
            $artistAppointment->service_price = isset($arrSrPrice)?implode(',',$arrSrPrice):'';
            $artistAppointment->first_name =isset($request->first_name)?$request->first_name:'';
            $artistAppointment->last_name =isset($request->last_name)?$request->last_name:'';
            $artistAppointment->email =isset($request->email)?$request->email:'';
            $artistAppointment->mobile =isset($request->mobile)?$request->mobile:'';
            $artistAppointment->country =isset($request->country)?$request->country:'';
            $artistAppointment->date =isset($request->valid_from)?$request->valid_from:'';
            $artistAppointment->description =isset($request->description)?$request->description:'';
            $artistAppointment->save();

            $site_email = GlobalValues::get('site-email');
            $site_title = GlobalValues::get('site-title');
            $contact_email = GlobalValues::get('contact-email');
            $arr_keyword_values = array();
            $arr_artist_values = array();
            $arr_admin_value = array();

            $arr_artist_values['FIRST_NAME'] =$ckArtist->first_name;
            $arr_artist_values['LAST_NAME'] =$ckArtist->last_name;
            $arr_artist_values['CUSTOMER_FIRST_NAME'] =$artistAppointment->first_name;
            $arr_artist_values['CUSTOMER_LAST_NAME'] =$artistAppointment->last_name;
            $arr_artist_values['SERVICE_NAME'] =$artistAppointment->service_name;
            $arr_artist_values['SERVICE_PRICE'] =$artistAppointment->service_price;
            $arr_artist_values['CUSTOMER_EMAIL'] =$artistAppointment->email;
            $arr_artist_values['CUSTOMER_MOBILE'] =$artistAppointment->mobile;
            $arr_artist_values['CUSTOMER_COUNTRY'] =$artistAppointment->country;
            $arr_artist_values['DATE'] =$artistAppointment->date;
            $arr_artist_values['CUSTOMER_DESCRIPTION'] =$artistAppointment->description;
            $arr_artist_values['SITE_TITLE'] = $site_title;

            $email_template = EmailTemplate::where("template_key", 'appointment-request-to-artist')->first();

             $status = Mail::send('emailtemplate::appointment-request-to-artist', $arr_artist_values, function ($message) use ($ckArtist,$site_email, $site_title, $email_template) {

                $message->to($ckArtist->email)->subject($email_template->subject)->from($site_email, $site_title);
            });

            if($status){
                $arr_keyword_values['FIRST_NAME'] = $artistAppointment->first_name;
                $arr_keyword_values['LAST_NAME'] = $artistAppointment->last_name;
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                $arr_keyword_values['ARTIST_FIRST_NAME'] = $ckArtist->first_name;
                $arr_keyword_values['ARTIST_LAST_NAME'] = $ckArtist->last_name;
                $arr_keyword_values['DATE'] = $artistAppointment->date;

                $email_template = EmailTemplate::where("template_key", 'artist-appointment-request')->first();

                $status1 = Mail::send('emailtemplate::artist-appointment-request', $arr_keyword_values, function ($message) use ($artistAppointment, $site_email, $site_title, $email_template) {

                    $message->to($artistAppointment->email)->subject($email_template->subject)->from($site_email, $site_title);
//                    $message->to("swapnil.d@panaceatek.com")->subject($email_template->subject)->from($site_email, $site_title);
                });
                if($status1){
                    $arr_admin_value['CUSTOMER_FIRST_NAME']=$artistAppointment->first_name;
                    $arr_admin_value['CUSTOMER_LAST_NAME']=$artistAppointment->last_name;
                    $arr_admin_value['ARTIST_FIRST_NAME']=$ckArtist->first_name;
                    $arr_admin_value['ARTIST_LAST_NAME']=$ckArtist->last_name;
                    $arr_admin_value['DATE']=$artistAppointment->date;
                    $arr_admin_value['SITE_TITLE'] = $site_title;

                    $email_template = EmailTemplate::where("template_key", 'customer-artist-appointment-request')->first();

                    $status2 = Mail::send('emailtemplate::customer-artist-appointment-request', $arr_admin_value, function ($message) use ($contact_email, $site_email, $site_title, $email_template) {

                        $message->to($contact_email)->subject($email_template->subject)->from($site_email, $site_title);
                    });
                }
            }

            return redirect('artist/appointment/'. $ckArtist->id)->with('appointment-status','Appointment request has been sent successfully');
        }
       return redirect('/');
    }

    public function listArtistAppointments(Request $request){
//          dd(2423);
//        $artistAppointments = ArtistAppointment::all();
//        dd($artistAppointments);
        return view('artist::list-artist-appointments');
    }

    public function listArtistAppointmentData(Request $request){
        $artistAppointments = ArtistAppointment::all();
        $artistAppointments = $artistAppointments->sortByDesc('id');
        return Datatables::of($artistAppointments)
            ->addColumn('customer_name', function($artistAppointments) {
                if(!empty($artistAppointments->first_name) || !empty($artistAppointments->last_name))
                {
                    $fName =!empty($artistAppointments->first_name)?$artistAppointments->first_name:'';
                    $lName =!empty($artistAppointments->last_name)?$artistAppointments->last_name:'';
                    return $fName.' '.$lName;
                }
                else
                    {
                        return '-';
                    }
            })
            ->addColumn('artist_name', function($artistAppointments) {
                $artist = Artist::find($artistAppointments->artist_id);
                if($artist){
                    $fName =!empty($artist->first_name)?$artist->first_name:'';
                    $lName =!empty($artist->last_name)?$artist->last_name:'';
                    return $fName.' '.$lName;
                }
                return '-';
            })
            ->make(true);
    }

    public function deleteArtistAppointment($id) {

        $ArtistAppointment = ArtistAppointment::find($id);

        if ($ArtistAppointment) {
            $ArtistAppointment->delete();

            return redirect('admin/manage-artist-appointments')->with('delete-user-status', 'artist appointment has been deleted successfully!');
        } else {
            return redirect("admin/manage-artist-appointments");
        }
    }

    public function deleteSelectedArtistAppointment($id) {
        $ArtistAppointment = ArtistAppointment::find($id);

        if ($ArtistAppointment) {
            $ArtistAppointment->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function viewArtistAppointment(Request $request,$id){
        $ArtistAppointment = ArtistAppointment::find($id);
        if($ArtistAppointment){
            return view('artist::view-artist-appointment',compact('ArtistAppointment'));
        }

    }
}