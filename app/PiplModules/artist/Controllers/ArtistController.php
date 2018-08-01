<?php

namespace App\PiplModules\artist\Controllers;

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

class ArtistController extends Controller {

    /**
     * Show the login window for admin.
     *
     * @return Response
     * 
     */
    private $thumbnail_size = array("width" => 400, "height" => 400);

    protected function validator(Request $request) {
        //only common files if we have multiple registration
        return Validator::make($request, [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'gender' => 'required',
        ]);
    }

    private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

//functions for supplier    

    public function listRegisteredArtist() {
//dd(132);
        return view("artist::list-artist");
    }

    public function listArtist() {
        $artist = Artist::all();
        $artist = $artist->sortByDesc('id');

        return Datatables::of($artist)
                        ->make(true);
    }

    public function createRegisteredArtist(Request $request)
    {
        if ($request->method() == "GET") {

            return view("artist::create-registered-artist");
        } elseif ($request->method() == "POST") {

            $data = $request->all();
            //dd($data);
            $validate_response = Validator::make($data, array(
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'artist_email' => 'required|email|max:255',
                        'number' => 'required|numeric|digits_between:10,12',
                        'description' => 'required',
                        'youtube_link' => 'required',
                        'facebook_id' => 'required',
                        'instagram_id' => 'required',
                        'linkedin_id' => 'required',
                        'twitter_id' => 'required',
                        'profile_image' => 'required',
                        'country_flag' => 'required',
            ));
            if ($validate_response->fails()) {
                return redirect()->back()
                                ->withErrors($validate_response)
                                ->withInput();
            }
            else {
               // dd($request->all());
                foreach ($request->services as $key => $val) {
                    $val =trim($val);
                    $val = str_replace(' ','_', $val);
                    if (!empty($data['entered_' . $val])) {
                        $newVal = str_replace('_',' ', $val);
                        $array[$newVal] = $data['entered_' . $val];
                    }
                }
                $created_user = Artist::create(array(
                            'first_name' => isset($data['first_name'])?$data['first_name']:'',
                            'last_name' => isset($data['last_name'] )? $data['last_name']:'',
                            'email' => isset($data['artist_email'] )?$data['artist_email']:'',
                            'number' => isset($data['number'] )?$data['number']:'',
                            'description' => isset($data['description'] )?$data['description']:'',
                            'youtube_link' => isset($data['youtube_link'])?$data['youtube_link']:'',
                            'facebook_id' => isset($data['facebook_id'])?$data['facebook_id']:'',
                            'instagram_id' => isset($data['instagram_id'])?$data['instagram_id']:'',
                            'linkedin_id' => isset($data['linkedin_id'])?$data['linkedin_id']:'',
                            'twitter_id' => isset($data['twitter_id'])?$data['twitter_id']:'',
                            'services' => isset($array)?serialize($array):''
                ));

                if ($request->hasFile('profile_image'))
                {

                    $uploaded_file = $request->file('profile_image');


                    $extension = $uploaded_file->getClientOriginalExtension();

                    $new_file_name = time() . "." . $extension;
                    if (!is_dir(storage_path('public/artist/'))) {
                        Storage::makeDirectory('public/artist/', 0777, true);
                    }

                    Storage::put('public/artist/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                    $created_user->profile_image = $new_file_name;
                }

            if ($request->hasFile('country_flag'))
            {

                $uploaded_file = $request->file('country_flag');


                $extension = $uploaded_file->getClientOriginalExtension();

                $new_file_name = time() . "." . $extension;
                if (!is_dir(storage_path('public/artist/country/'))) {
                    Storage::makeDirectory('public/artist/country/', 0777, true);
                }

                Storage::put('public/artist/country/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                $created_user->country_flag = $new_file_name;
                }

            if ($request->file('video'))
            {
                $extension = $request->file('video')->getClientOriginalExtension();
                $file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                if (!is_dir(storage_path('public/artist/video/'))) {
                    Storage::makeDirectory('public/artist/video/', 0777, true);
                }
                Storage::put('public/artist/video/' . $file_name, file_get_contents($request->file('video')->getRealPath()));

                $created_user->video = $file_name;
            }
            $created_user->save();

//this code is to upload multiple images
                $artist_id = $created_user->id;


                if ($request->hasFile('images')) {


                    $uploaded_images = $request->file('images');
                    foreach ($request->file('images') as $uploaded_image) {

                        $extension = $uploaded_image->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                        // dd(storage_path('app/public/gallery/images'));
                        if (!is_dir(storage_path('public/artist/images'))) {
                            Storage::makeDirectory('public/artist/images', 0777, true);
                        }
                        if (!is_dir(storage_path('public/artist/images/thumbnails'))) {

                            Storage::makeDirectory('public/artist/images/thumbnails', 0777, true);
                        }

                        Storage::put('public/artist/images/' . $new_file_name, file_get_contents($uploaded_image->getRealPath()));

//                        $thumbnail = Image::make(storage_path('app/public/artist/images/' . $new_file_name));
//
//
//                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//
//                        $thumbnail->save(storage_path('app/public/artist/images/thumbnails/' . $new_file_name));
                        $created_videos = array("path" => $new_file_name, "artist_id" => $artist_id, "media_type" => 0);

                        $success = $this->saveIntoArtistMedia($created_videos);
                        if ($success == -1) {
                            return redirect("admin/manage-artist")->with('update-user-status', 'Oops!! Something has really went wrong,File you looking isn\'t created!');
                        }
                    }
                }
                return redirect('admin/manage-artist')
                                ->with("update-user-status", "artist has been created successfully");
            }
        }
    }

    public function saveIntoArtistMedia($created_media) {
        // dd($created_media);
        $created_post = ArtistImage::create($created_media);
        if ($created_post->id > 0) {
            return 0;
        } else {
            return -1;
        }
    }

//upload multiple images END    


    public function updateArtist(Request $request, $id) {


        $artist = Artist::find($id);
        $services = unserialize($artist->services);
        
        $img = ArtistImage::where('artist_id', $id)->orderBy('id', 'DESC')->paginate(5);


        if ($artist) {


            if ($request->method() == "GET") {
                return view("artist::edit", ["artist" => $artist, 'multi' => $img, "editServices" => $services]);
            } else {

                // validate request
                $data = $request->all();
//                dd($data);
                $validate_response = Validator::make($data, [
                            'first_name' => 'required',
                            'last_name' => 'required',
                            'email' => 'required',
                            'description' => 'required',
                            'youtube_link' => 'required',
                            'facebook_id' => 'required',
                            'instagram_id' => 'required',
                            'linkedin_id' => 'required',
                            'twitter_id' => 'required',
                            'services' => 'required',
                ]);

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
//                    dd($data);
                       foreach ($request->services as $key => $val) {
                           $val =trim($val);
                           $val = str_replace(' ','_', $val);
                    if (!empty($data['entered_' . $val])) {
                        $newVal = str_replace('_',' ', $val);
                        $array[$newVal] = $data['entered_' . $val];
//                        dd($array[$val]);
                    }
                }
//                dd($array);

                    $artist->first_name = isset($request->first_name)?$request->first_name:'';
                    $artist->last_name = isset($request->last_name)?$request->last_name:'';
                    $artist->description = isset($request->description)?$request->description:'';
                    $artist->youtube_link = isset($request->youtube_link)?$request->youtube_link:'';
                    $artist->facebook_id = isset($request->facebook_id)?$request->facebook_id:'';
                    $artist->instagram_id = isset($request->instagram_id)?$request->instagram_id:'';
                    $artist->linkedin_id = isset($request->linkedin_id)?$request->linkedin_id:'';
                    $artist->twitter_id = isset($request->twitter_id)?$request->twitter_id:'';
                    $artist->first_name = isset($request->first_name)?$request->first_name:'';
                    $artist->first_name = isset($request->first_name)?$request->first_name:'';
                    $artist->services = isset($array)?serialize($array):'';


                    if ($request->hasFile('profile_image'))
                    {

                        $uploaded_file = $request->file('profile_image');


                        $extension = $uploaded_file->getClientOriginalExtension();

                        $new_file_name = time() . "." . $extension;
                        if (!is_dir(storage_path('public/artist/'))) {
                            Storage::makeDirectory('public/artist/', 0777, true);
                        }

                        Storage::put('public/artist/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                        $artist->profile_image = $new_file_name;
                    }

                    if ($request->hasFile('country_flag'))
                    {

                        $uploaded_file = $request->file('country_flag');


                        $extension = $uploaded_file->getClientOriginalExtension();

                        $new_file_name = time() . "." . $extension;
                        if (!is_dir(storage_path('public/artist/country/'))) {
                            Storage::makeDirectory('public/artist/country/', 0777, true);
                        }

                        Storage::put('public/artist/country/' . $new_file_name, file_get_contents($uploaded_file->getRealPath()));

                        $artist->country_flag = $new_file_name;
                    }
                    if ($request->file('video'))
                    {
                        $extension = $request->file('video')->getClientOriginalExtension();
                        $file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                        if (!is_dir(storage_path('public/artist/video/'))) {
                            Storage::makeDirectory('public/artist/video/', 0777, true);
                        }
                        Storage::put('public/artist/video/' . $file_name, file_get_contents($request->file('video')->getRealPath()));

                        $artist->video = $file_name;
                    }
                    $artist->save();

                    $artist_id = $id;


                    if ($request->hasFile('images'))
                    {
//                    unlink('storage/app/public/artist/images/');
                        $uploaded_images = $request->file('images');
                        $data = ArtistImage::where('artist_id', $id)->where('media_type', 0)->get();

//                    foreach($data as $imgs){
//                      unlink(storage_path('app/public/artist/images/').$imgs->path);    
//                    }


                        foreach ($request->file('images') as $uploaded_image) {

                            $extension = $uploaded_image->getClientOriginalExtension();
                            $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                            // dd(storage_path('app/public/gallery/images'));
                            if (!is_dir(storage_path('public/artist/images'))) {
                                Storage::makeDirectory('public/artist/images', 0777, true);
                            }
                            if (!is_dir(storage_path('public/artist/images/thumbnails'))) {

                                Storage::makeDirectory('public/artist/images/thumbnails', 0777, true);
                            }

                            Storage::put('public/artist/images/' . $new_file_name, file_get_contents($uploaded_image->getRealPath()));

//                        $thumbnail = Image::make(storage_path('app/public/artist/images/' . $new_file_name));
//
//
//                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//
//                        $thumbnail->save(storage_path('app/public/artist/images/thumbnails/' . $new_file_name));
                            $created_videos = array("path" => $new_file_name, "artist_id" => $artist_id, "media_type" => 0);

                            $id = array('id' => $artist_id);



                            $success = $this->updateIntoArtistMedia($created_videos, $id);

                            if ($success == -1) {
                                return redirect("admin/manage-artist")->with('delete-user-status', 'Oops!! Something has really went wrong,File you looking isn\'t created!');
                            }
                        }
                    }

                    return redirect("admin/manage-artist")->with('update-user-status', 'artist updated successfully!');
                }
            }
        } else {
            return redirect("admin/manage-artist")->with('delete-user-status', 'Oops!! Something has really went wrong');
        }
    }

    public function updateIntoArtistMedia($created_media, $id) {
        $created_post = ArtistImage::create($created_media);
        if ($created_post->id > 0) {
            return 0;
        } else {
            return -1;
        }
    }

    protected function updateRegisteredSupplierEmailInfo(Request $data, $user_id) {
        $data_values = $data->all();
        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            $validate_response = Validator::make($data_values, array(
                        'email' => 'required|email|max:500|unique:users',
                        'confirm_email' => 'required|email|same:email',
            ));

            if ($validate_response->fails()) {
                return redirect('admin/update-registered-supplier/' . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user email
                $arr_user_data->email = $data->email;
                $arr_user_data->save();

                //updating user status to inactive
                $arr_user_data->userInformation->user_status = 0;
                $arr_user_data->userInformation->save();
                //sending email with verification link
                //sending an email to the user on successfull registration.
                $site_email = GlobalValues::get('site-email');
                $site_title = GlobalValues::get('site-title');
                $arr_keyword_values = array();
                $activation_code = $this->generateReferenceNumber();
                //Assign values to all macros
                $arr_keyword_values['FIRST_NAME'] = $arr_user_data->userInformation->first_name;
                $arr_keyword_values['LAST_NAME'] = $arr_user_data->userInformation->last_name;
                $arr_keyword_values['VERIFICATION_LINK'] = url('verify-user-email/' . $activation_code);
                $arr_keyword_values['SITE_TITLE'] = $site_title;
                // updating activation code                 
                $arr_user_data->userInformation->activation_code = $activation_code;
                $arr_user_data->userInformation->save();
                $email_template = EmailTemplate::where("template_key", 'email-change')->first();

                Mail::send('emailtemplate::email-change', $arr_keyword_values, function ($message) use ($arr_user_data, $site_email, $site_title, $email_template) {

                    $message->to($arr_user_data->email)->subject($email_template->subject)->from($site_email, $site_title);
                });

                $succes_msg = "supplier email has been updated successfully!";
                return redirect("admin/update-registered-supplier/" . $user_id)->with("profile-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("admin/login")->with("issue-profile", $errorMsg);
        }
    }

    protected function updateRegisteredSupplierPasswordInfo(Request $data, $user_id) {
        //$current_password = $data->current_password;
        $data_values = $data->all();

        if (Auth::user()) {
            $arr_user_data = User::find($user_id);
            // $user_password_chk = Hash::check($current_password, $arr_user_data->password);
            $validate_response = Validator::make($data_values, array(
                        'new_password' => 'required|min:6',
                        'confirm_password' => 'required|min:6|same:new_password',
            ));

            if ($validate_response->fails()) {
                return redirect("admin/update-registered-supplier/" . $user_id)
                                ->withErrors($validate_response)
                                ->withInput();
            } else {
                //updating user Password

                $arr_user_data->password = $data->new_password;
                $arr_user_data->save();
                $succes_msg = "Supplier password has been updated successfully!";
                return redirect("admin/update-registered-supplier/" . $user_id)->with("profile-updated", $succes_msg);
            }
        } else {
            $errorMsg = "Error! Something wrong is going on.";
            Auth::logout();
            return redirect("login")->with("issue-profile", $errorMsg);
        }
    }

    public function deleteArtist($id) {
        $Artist = Artist::find($id);

        if ($Artist) {
            $Artist->delete();

            return redirect('admin/manage-artist')->with('delete-user-status', 'artist has been deleted successfully!');
        } else {
            return redirect("admin/manage-artist");
        }
    }

    public function deleteSelectedArtist($id) {


        $Artist = Artist::find($id);

        if ($Artist) {
            $Artist->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function deleteImage($id) {
        $category = ArtistImage::find($id);

        if ($category) {
            $category->delete();
            unlink(storage_path('app/public/artist/images/') . $category->path);
//            unlink(storage_path('app/public/artist/images/thumbnails/').$category->path);
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
            exit();
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
            exit();
        }
    }

    public function chkArtistDuplicateEmail(Request $request){

        $countryDets = Country::find($request->email);

//        if(isset($countryDets) && count($countryDets)>0){
//            $state = State::where('id',$request->state)->where('country_id',$request->country)->first();
//            if(isset($state) && count($state)>0){
//                $cities = City::where('state_id',$request->state)->where('country_id',$request->country)->get();
//                foreach ($cities as $city){
//                    if($city->name == $request->city_name){
//                        return "false";
//                    }
//                }
//            }
//        }
        return "true";
    }

    //supplier function end
//dd(123);
}
