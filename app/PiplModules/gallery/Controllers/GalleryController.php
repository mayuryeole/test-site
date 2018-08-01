<?php 
namespace App\PiplModules\gallery\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\gallery\Models\Gallery;
use App\PiplModules\gallery\Models\GalleryMedia;
use App\PiplModules\gallery\Models\GalleryRatings;
use App\PiplModules\gallery\Models\GalleryTranslation;
use Mail;
use Datatables;
use Image;
use App\UserInformation;
use App\PiplModules\category\Models\Category;
use App\PiplModules\admin\Models\Comment;

class GalleryController extends Controller {

    private $thumbnail_size = array("width" => 300, "height" => 200);

    public function listGallery() {

        $all_gallery = Gallery::translatedIn(\App::getLocale())->get();

        return view('gallery::list-gallery', array('categories' => $all_gallery));
    }

    public function listRooms() {

        $all_gallery = UserInformation::all();

        return view('gallery::list-rooms', array('categories' => $all_gallery));
    }

    public function listGalleryData() {

        $all_categories = Gallery::translatedIn(\App::getLocale())->where('parent_id', 0)->get();
        $all_categories = $all_categories->sortBy('id');

        return Datatables::of($all_categories)
                        ->addColumn('name', function($category) {
                            return (strlen($category->name) > 50) ? stripslashes(substr($category->name, 0, 50)) : stripslashes($category->name);
                        })
                        ->make(true);
    }

    public function listRoomsData() {

        $all_rooms = UserInformation::where('user_type', 2)->get();

        return Datatables::of($all_rooms)
                        ->addColumn('new_room_name', function($category) {
                            if ($category->room_name != "")
                                return (strlen($category->room_name) > 50) ? stripslashes(substr($category->room_name, 0, 50))."...." : stripslashes($category->room_name);
                            else {
                                return "<p style='color:red'>No Room details Added yet!!</p>";
                            }
                        })
                        ->addColumn('status', function($category) {
                           
                                if($category->room_open == -1)
                                {
                                    $status = "Rejected";
                                }elseif($category->room_open == 1)
                                {
                                    $status = "Open";
                                }else{
                                    $status = "Close";
                                }
                            return $status;
                            
                        })
                        ->make(true);
    }

    public function listSubGallery($gal_id) {
        $gallery = Gallery::where('id', $gal_id)->get();
        if (count($gallery) <= 0) {
            return redirect("admin/gallery-list")->with('status', 'Oops!! Your Parent category no more exist!');
        }
        return view('gallery::list-subgallery', array('gallery_id' => $gal_id, "gallery" => $gallery));
    }

    public function listSubGalleryData($cat_id) {
        $all_categories = Gallery::translatedIn(\App::getLocale())->where('parent_id', $cat_id)->get();
        if (isset($all_categories) && count($all_categories) > 0) {
            $all_categories = $all_categories->sortBy('id');
        }

        return Datatables::of($all_categories)
                        ->addColumn('name', function($category) {
                            return (strlen($category->name) > 50) ? stripslashes(substr($category->name, 0, 50)) : stripslashes($category->name);
                        })
                        ->make(true);
    }

    public function createGallery(Request $request) {
//        dd($request);
        if ($request->method() == "GET") {
            $all_category = Gallery::all();
            return view("gallery::create-gallery", array('all_category' => $all_category));
        } else {
//              dd($request);
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:gallery_translations',
                        'description' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                /* Create PArent GAllery */
                $created_category = new Gallery();
                $created_category->created_by = Auth::user()->id;
                $created_category->parent_id = $request->parent_id;
                $created_category->save();

//                $created_category = Category::create(array('created_by' =>'1','parent_id' =>'2'));

                /* Create Translated GAllery */
                $translated_category = $created_category->translateOrNew(\App::getLocale());
                $translated_category->name = ucfirst(strtolower($request->name));
                $translated_category->description = $request->description;
                $translated_category->seo_url = $this->seoUrl($translated_category->name);
                $translated_category->locale = \App:: getLocale();
                $translated_category->gallery_id = $created_category->id;
                $translated_category->save();


                return redirect("admin/gallery-list")->with('status', 'Gallery created successfully!');
            }
        }
    }

    public function createSubGallery(Request $request, $gallery_id) {
        if ($request->method() == "GET") {
            $gallery = GalleryTranslation::where('gallery_id',$gallery_id)->first();
            return view("gallery::create-subgallery", array('gallery_id' => $gallery_id, "gallery" => $gallery));
        } else {
//              dd($request);
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:gallery_translations',
                        'description' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                /* Create PArent GAllery */
                $created_category = new Gallery();
                $created_category->created_by = Auth::user()->id;
                $created_category->parent_id = $request->parent_id;
                $created_category->save();

//                $created_category = Category::create(array('created_by' =>'1','parent_id' =>'2'));

                /* Create Translated GAllery */
                $translated_category = $created_category->translateOrNew(\App::getLocale());
                $translated_category->name = ucfirst(strtolower($request->name));
                $translated_category->description = $request->description;
                $translated_category->seo_url = $this->seoUrl($translated_category->name);
                $translated_category->locale = \App:: getLocale();
                $translated_category->gallery_id = $created_category->id;
                $translated_category->save();


                return redirect("/admin/sub-gallery-list/" . $gallery_id)->with('status', 'Sub Gallery created successfully!');
            }
        }
    }

    public function manageImages(Request $request, $cat_id) {
        if ($request->method() == "GET") {
            $all_media = GalleryMedia::where('gallery_id', $cat_id)->where('content_type', 0)->orderBy('id','DESC')->paginate(5);
            return view("gallery::manage-images", array('all_media' => $all_media, "gallery_id" => $cat_id));
        } else {
            $request_data = $request->all();
//                file_ext=='jpg'||file_ext=='mp3'||file_ext=='m4v'||file_ext=='mpg'||file_ext=='avi'||file_ext=='fly'||file_ext=='wmv'
            $validate_response = Validator::make($request_data, [
                'images.*' => 'required|max:5120|mimes:jpg,jpeg,gif,png',
            ]);

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            }
            $this->uploadImages($request, $request->gallery_id);
            return redirect("admin/gallery-list")->with('status', 'Gallery Images altered successfully!');
        }
    }

    public function manageSubImages(Request $request, $cat_id) {
        $parent_cat = Gallery::where('id', $cat_id)->first();
        $parent_cat = GalleryTranslation::where('id', $parent_cat->parent_id)->first();
        $category = Gallery::findOrfail($cat_id);
//        dd($parent_cat->paret);
        if ($request->method() == "GET") {
            $all_media = GalleryMedia::where('gallery_id', $cat_id)->where('content_type', 0)->orderBy('id','DESC')->paginate(5);
            return view("gallery::manage-subimages", array('all_media' => $all_media, "category" => $category, "gallery_id" => $parent_cat->id, "parent_cat" => $parent_cat));
        } else {
            $request_data = $request->all();
//                file_ext=='jpg'||file_ext=='mp3'||file_ext=='m4v'||file_ext=='mpg'||file_ext=='avi'||file_ext=='fly'||file_ext=='wmv'
            $validate_response = Validator::make($request_data, [
                'images.*' => 'required|max:5120|mimes:jpg,jpeg,gif,png',
            ]);

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            }

            $this->uploadImages($request, $cat_id);
            return redirect("/admin/sub-gallery-list/" . $parent_cat->id)->with('status', 'Sub Gallery Images altered successfully!');
        }
    }

    public function manageVideos(Request $request, $cat_id) {
        if ($request->method() == "GET") {
            $all_media = GalleryMedia::where('gallery_id', $cat_id)->where('content_type', 1)->orderBy('id','DESC')->paginate(5);
//            dd($all_media);
            return view("gallery::manage-videos", array('all_media' => $all_media, "gallery_id" => $cat_id));
        } else {
            $this->uploadVideos($request, $cat_id);
            return redirect("admin/gallery-list")->with('status', 'Sub Gallery Videos altered successfully!');
        }
    }

    public function manageSubVideos(Request $request, $cat_id) {
        $parent_cat = Gallery::where('id', $cat_id)->first();
        $parent_cat = GalleryTranslation::where('id', $parent_cat->parent_id)->first();
        $category = Gallery::findOrfail($cat_id);
        if ($request->method() == "GET") {
            $all_media = GalleryMedia::where('gallery_id', $cat_id)->where('content_type', 1)->orderBy('id','DESC')->paginate(5);
            return view("gallery::manage-subvideos", array('all_media' => $all_media, "category" => $category, "gallery_id" => $cat_id, "parent_cat" => $parent_cat));
        } else {
            $request_data = $request->all();
//                file_ext=='mp4'||file_ext=='mp3'||file_ext=='m4v'||file_ext=='mpg'||file_ext=='avi'||file_ext=='fly'||file_ext=='wmv'
            $validate_response = Validator::make($request_data, [
                'videos.*' => 'required|max:25600|mimes:mp4,mp3,m4v,mpg,avi,fly,wmv',
            ]);

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            }
            $this->uploadVideos($request, $request->gallery_id);
            return redirect("/admin/sub-gallery-list/" . $parent_cat->id)->with('status', 'Gallery Videos altered successfully!');
        }
    }

    public function updateGallery(Request $request, $category_id, $locale = "") {
        $category = Gallery::find($category_id);
        if ($category) {
            $translated_category = $category->translateOrNew($locale);
            if ($request->method() == "GET") {
                if ($locale != '' && $locale != 'en') {
                    return view("gallery::update-language-category", array('category' => $translated_category, 'main_info' => $category));
                } else {
                    return view("gallery::update-gallery", array('category' => $translated_category, 'main_info' => $category));
                }
            } else {
                $data = $request->all();
                if ($request->old_name == $request->name) {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required',
                                'description' => 'required',
                    ));
                } else {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:gallery_translations',
                                'description' => 'required',
                    ));
                }
                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    /* Create Translated GAllery */
                    $translated_category = GalleryTranslation::where('gallery_id', $category_id)->where('locale', \App::getLocale())->first();
                    $translated_category->name = ucfirst(strtolower($request->name));
                    $translated_category->description = $request->description;
                    $translated_category->seo_url = $this->seoUrl($translated_category->name);
                    $translated_category->locale = \App:: getLocale();
                    $translated_category->gallery_id = $category->id;
                    $translated_category->save();
                    return redirect("admin/gallery-list")->with('status', 'Gallery Updated successfully!');
                }
            }
        } else {
            return redirect('admin/gallery-list');
        }
    }

    public function updateRooms(Request $request, $category_id, $locale = "") {
        $all_rooms = UserInformation::where('user_id', $category_id)->first();

        if (count($all_rooms) > 0) {

            if ($request->method() == "GET") {
                $all_categories = Category::translatedIn(\App::getLocale())->get();
                $all_categories = $all_categories->sortBy('id');
                if ($locale != '' && $locale != 'en') {
                    return view("gallery::update-language-category", array('category' => $translated_category, 'main_info' => $category, "parent_cat" => $parent_cat));
                } else {
                    return view("gallery::update-rooms", array('rooms' => $all_rooms, 'all_categories' => $all_categories));
                }
            } else {
                $data = $request->all();
                if ($request->room_name == $request->old_room_name && ($request->room_name!="")) {
                    $validate_response = Validator::make($data, array(
                                'room_name' => 'required',
                                'theme_type' => 'required',
                                'room_desc' => 'required|max:500',
                                'status' => 'required',
                    ));
                } else {
                    $validate_response = Validator::make($data, array(
                                'room_name' => 'required|unique:user_informations',
                                'theme_type' => 'required',
                                'room_desc' => 'required|max:500',
                                'status' => 'required',
                    ));
                }
                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    /* Create Translated GAllery */
                    $all_rooms->room_name = ucfirst(strtolower($request->room_name));
                    $all_rooms->room_type = $request->theme_type;
                    $all_rooms->room_desc = $request->room_desc;
                    $all_rooms->room_open = $request->status;
                    $all_rooms->save();
                    return redirect("admin/rooms-list")->with('status', 'Room details Updated successfully!');
                }
            }
        }
    }

    public function updateSubGallery(Request $request, $category_id, $locale = "") {
        $category = Gallery::findOrfail($category_id);
        $parent_cat = Gallery::where('id', $category->parent_id)->first();
        if ($category) {
            $translated_category = $category->translateOrNew($locale);

            if ($request->method() == "GET") {
                if ($locale != '' && $locale != 'en') {
                    return view("gallery::update-language-category", array('category' => $translated_category, 'main_info' => $category, "parent_cat" => $parent_cat));
                } else {
//                    dd($translated_category);
                    return view("gallery::update-subgallery", array('category' => $translated_category, 'main_info' => $category, "parent_cat" => $parent_cat, "gallery_id" => $category_id));
                }
            } else {
                $data = $request->all();
                if ($request->old_name == $request->name) {
//                    dd($parent_cat);
                    $validate_response = Validator::make($data, array(
                                'name' => 'required',
                                'description' => 'required',
                    ));
                } else {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:gallery_translations',
                                'description' => 'required',
                    ));
                }

                if ($validate_response->fails()) {

                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    /* Create Translated GAllery */
                    $translated_category = GalleryTranslation::where('gallery_id', $category_id)->where('locale', \App::getLocale())->first();
                    $translated_category->name = ucfirst(strtolower($request->name));
                    $translated_category->description = $request->description;
                    $translated_category->seo_url = $this->seoUrl($translated_category->name);
                    $translated_category->locale = \App:: getLocale();
                    $translated_category->gallery_id = $category->id;
                    $translated_category->save();
                    return redirect("/admin/sub-gallery-list/" . $parent_cat->id)->with('status', 'Gallery Updated successfully!');

//                    return redirect('admin/gallery-list'); 
                }
            }
        } else {
            return redirect("/admin/sub-gallery-list/" . $parent_cat->id);
        }
    }

    public function deleteGallery($category_id) {
        $category = Gallery::find($category_id);
        if ($category) {
            $category->delete();
            return redirect("admin/gallery-list")->with('status', 'Gallery deleted successfully!');
        } else {
            return redirect('admin/gallery-list');
        }
    }

    public function deleteSubGallery($category_id) {
        $category = Gallery::find($category_id);
        if ($category) {
            $category->delete();
            return redirect("/admin/sub-gallery-list/" . $category_id)->with('status', 'Sub Gallery deleted successfully!');
        } else {
            return redirect('/admin/sub-gallery-list/' . $category_id);
        }
    }

    public function deleteSelectedGallery($category_id) {
        $category = Gallery::find($category_id);
        if ($category) {
            $category->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function deleteImage($id) {
        $category = GalleryMedia::find($id);
        if ($category) {
            $category->delete();
            unlink(storage_path('app/public/gallery/images/').$category->path);
            unlink(storage_path('app/public/gallery/images/thumbnails/').$category->path);
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
            exit();
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
            exit();
            
        }
    }
    
    public function deleteVideo($id) {
        $category = GalleryMedia::find($id);
        if ($category) {
            $category->delete();
            unlink(storage_path('app/public/gallery/videos/').$category->path);
//            unlink(storage_path('app/public/gallery/videos/thumbnails/').$category->path);
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function deleteSelectedSubGallery($category_id) {
        $category = Gallery::find($category_id);
        if ($category) {
            $category->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function seoUrl($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function uploadImages($request, $gallery_id) {
        $mediaGalleryObj = new GalleryMedia();
        $images = array();
        if ($request->hasFile('images')) {
            $uploaded_images = $request->file('images');
            foreach ($uploaded_images as $uploaded_image) {
                $extension = $uploaded_image->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                dd(storage_path('app/public/gallery/images'));
                if (!is_dir(storage_path('app/public/gallery/images'))) {
                    Storage::makeDirectory('public/gallery/images', 0777, true);
                }
                if (!is_dir(storage_path('app/public/gallery/images/thumbnails'))) {

                    Storage::makeDirectory('app/public/gallery/images/thumbnails', 0777, true);
                }

                Storage::put('public/gallery/images/' . $new_file_name, file_get_contents($uploaded_image->getRealPath()));
//                        $images = array("original_name" => $new_file_name, "display_name" => $uploaded_image->getClientOriginalName());

                $thumbnail = Image::make(storage_path('app/public/gallery/images/' . $new_file_name));
                    
                            
                $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);

                $thumbnail->save(storage_path('app/public/gallery/images/thumbnails/' . $new_file_name));

                $images = $new_file_name;
                $content_type = 0;
                $gallery_user_id = Auth::user()->id;
                $gallery_ids = $gallery_id;
                $created_images = array("path" => $images, "content_type" => $content_type, "gallery_id" => $gallery_ids, "created_by" => $gallery_user_id);
                $success = $this->saveGalleryMedia($created_images);
                if ($success == -1) {
                    return redirect("admin/gallery-list")->with('status', 'Oops!! Something has really went wrong,File you looking isn\'t created!');
                }
            }
        }
        return 0;
    }

    public function uploadVideos($request, $gallery_id) {
        $mediaGalleryObj = new GalleryMedia();
        $videos = array();
        if ($request->hasFile('videos')) {
//            dd($request);
            $uploaded_videos = $request->file('videos');
            foreach ($uploaded_videos as $uploaded_video) {
                $extension = $uploaded_video->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                if (!is_dir(storage_path('app/public/gallery/videos'))) {
                    Storage::makeDirectory('public/gallery/videos', 0777, true);
                }
                Storage::put('public/gallery/videos/' . $new_file_name, file_get_contents($uploaded_video->getRealPath()));
//                        $videos = array("original_name" => $new_file_name, "display_name" => $uploaded_video->getClientOriginalName());
                $videos = $new_file_name;
                $content_type_video = 1;
                $gallery_user_id_video = Auth::user()->id;
                $gallery_ids_video = $gallery_id;
                $created_videos = array("path" => $videos, "content_type" => $content_type_video, "gallery_id" => $gallery_ids_video, "created_by" => $gallery_user_id_video);
                $success = $this->saveGalleryMedia($created_videos);
                if ($success == -1) {
                    return redirect("admin/gallery-list")->with('status', 'Oops!! Something has really went wrong,File you looking isn\'t created!');
                }
            }
        }
        return 0;
    }

    public function saveGalleryMedia($created_media) {
        $created_post = GalleryMedia::create($created_media);
        if ($created_post->id > 0) {
            return 0;
        } else {
            return -1;
        }
    }
    
    /*******   manage Gallery Ratings  **/
    public function addUserGalleryRatings(Request $request){
              
        
        
                $gal_Rat = GalleryRatings::where('created_by',$request->gal_usr_id)->where('gallery_id',$request->gal_id)->first();
                 
                if($gal_Rat==null){

                    $gal_ratings = new GalleryRatings();
                    $gal_ratings->created_by = $request->gal_usr_id;
                    $gal_ratings->rating = $request->gal_rating;
                    $gal_ratings->gallery_id = $request->gal_id;
                    $gal_ratings->save();

                    if($gal_ratings->id > 0){
                    echo json_encode(array("success" => '1','cnt' => '0', 'msg' => 'Rating Successfull'));
                    exit();
                    }
                    else{
                        echo json_encode(array("success" => '0','cnt' => '0', 'msg' => 'Rating could not Successful'));
                        exit();
                    }
                
                }
                else{
                    echo json_encode(array("success" => '0','cnt' => '1', 'msg' => 'You have already rated this gallery'));
                    exit();
                }
    }
    
    
    
   /**  Start     MAnage Gallery Ratings    **/
   
    
    public function listGalRatings(){
         return view('gallery::list-gallery-ratings');
    }
    public function listGalRatingData() {
        $gal_rtng = GalleryRatings::orderBy('id', 'DESC')->get();
        
        return Datatables::of($gal_rtng)
                 ->addColumn('name', function($work) {
                            return (isset($work->getGallery->trans->name))?$work->getGallery->trans->name:"";
                        })->addColumn('rated_by', function($work) {
                            return (isset($work->getUserRating->userInformation->first_name))?$work->getUserRating->userInformation->first_name:"User without name";
                        })->make(true);
                      
                        
    }
    public function deleteGalRating($id) {
        $gal_rtng = GalleryRatings::where('id', $id)->first();
        if ($gal_rtng ) {
                    $gal_rtng->delete();
            return redirect('/admin/list-gal-ratings')->with('delete-user-status', 'Entry has been deleted successfully!');
        } else {
            return redirect("/admin/list-gal-ratings");
        }
    }
    public function deleteGalRatingSelected($id) {
        $gal_rtng = GalleryRatings::where('id', $id)->first();
        if ($gal_rtng) {
            $gal_rtng->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }
    public function updateGalRating(Request $request, $id) {
        $gal_rtng_data = GalleryRatings::find($id);
         
        if ($gal_rtng_data) {
            if ($request->method() == "GET") {
                return view("gallery::edit-gallery-ratings", array('info' => $gal_rtng_data));
            } elseif ($request->method() == "POST") {
                //dd($gal_rtng_data);
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'rating' => 'required'
                ));

                if ($validate_response->fails()) {
                    return redirect('admin/update-gal-rating/' . $gal_rtng_data->id)
                                    ->withErrors($validate_response)
                                    ->withInput();
                } else {
                    if (isset($data["rating"])) {
                        $gal_rtng_data->rating = $data["rating"];
                    }
                         $gal_rtng_data->save();
                    $success_msg = "Entry has been updated successfully!";
                    return redirect("admin/list-gal-ratings")->with("profile-updated", $success_msg);
                }
            }
        } else {
            return redirect("/list-gal-ratings");
        }
    }
    
    /**  End     MAnage Gallery Ratings    **/
     
    

}
