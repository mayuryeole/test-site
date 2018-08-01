<?php

namespace App\PiplModules\rivaah\Controllers;

use App\PiplModules\rivaah\Models\RivaahGallery;
use App\PiplModules\rivaah\Models\RivaahGalleryImage;
use App\PiplModules\rivaah\Models\RivaahProduct;
use Auth;
use App\UserInformation;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Pagination\Paginator;
use Storage;
use App\PiplModules\product\Models\Product;
use App\PiplModules\category\Models\Category;
use App\User;
use Mail;
use Illuminate\Filesystem\Filesystem;
use Datatables;
use Image;
use App\PiplModules\attribute\Models\Attribute;
use App\PiplModules\project\Models\Project;
use App\PiplModules\category\Models\CategoryAttributes;
use App\PiplModules\product\Models\ProductAttribute;
use App\PiplModules\attribute\Models\AttributeTranslation;
use App\PiplModules\category\Models\CategoryTranslation;
use App\PiplModules\product\Models\Style;
use App\PiplModules\product\Models\CollectionStyle;
use App\PiplModules\product\Models\ProductCollectionStyle;
use App\PiplModules\product\Models\ProductStyle;
use App\PiplModules\product\Models\Occasion;
use App\PiplModules\product\Models\ProductOccasion;
use App\PiplModules\product\Models\ProductColor;


class RivaahController extends Controller {

    private $thumbnail_size = array("width" => 400, "height" => 400);

    public function listRivaahGalleries() {
        $all_galleries = RivaahGallery::all();
        return view('rivaah::list-rivaah-galleries', array('images' => $all_galleries));
    }

    public function listRivaahGalleriesData() {

        $all_galleries = RivaahGallery::all();
        $all_galleries = $all_galleries->sortBy('id');

        return Datatables::of($all_galleries)
                        ->addColumn('name', function($gallery) {
                            return stripslashes($gallery->name);
//                        })
//                        ->addColumn('category_name', function($gallery) {
//
//                            if(isset($gallery->categoryTans->name) && $gallery->categoryTans->name!=""){
////                                dd($product->productDescription);
//                            return $gallery->categoryTans->name;
//                            }
//                            else{
//                                return "-";
//                            }
//
                        })->make(true);
    }   
    
    private function getCategoryTree($nodes, $prefix = "-") {
        $arr_cats = array();
        $traverse = function ($categories, $prefix) use (&$traverse, &$arr_cats ) {

            foreach ($categories as $category) {


                $arr_cats[] = new categoryTreeHolder($prefix . ' ' . $category->name, $category->id);

                $traverse($category->children, $prefix . $prefix);
            }
        };

        $traverse($nodes, $prefix);

        return $arr_cats;
    }

    public function createRivaahGallery(Request $request)
    {

        if ($request->method() == "GET") {
            $all_category = Category::all();
            return view("rivaah::create-rivaah-gallery", array('all_category' => $all_category));
        }
        else if($request->method()=="POST") {
           // dd($request->all());
                $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:rivaah_galleries',
                        'photo' => 'max:5120|mimes:jpg,jpeg,gif,png',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                //dd($request->all());
//                $category = '';
//                if(isset($request->category) && $request->category !=''){
//                    $category = Category::find($request->category);
//                    $category = Category::find($request->category);
                    $created_rivaah_gallery = new RivaahGallery();
                    $created_rivaah_gallery->name = $request->name;
                    $created_rivaah_gallery->description = $request->description;
//                    $created_rivaah_gallery->category_id = $category->id;
                    $created_rivaah_gallery->save();
                    $created_rivaah_gallery_image=new RivaahGalleryImage();
                    $created_rivaah_gallery_image->rivaah_gallery_id=$created_rivaah_gallery->id;
                    $created_rivaah_gallery_image->save();
                    return redirect("/admin/rivaah-galleries-list")->with('status', 'Rivaah Gallery created successfully!');
//                    }
//                else{
//                    return redirect("/admin/rivaah-galleries-list")->with('status', 'Category Id not Found!');
//                }

            }
        }
    }

    public function updateRivaahGallery(Request $request, $gallery_id)
    {
        $gallery = RivaahGallery::find($gallery_id);
        $all_category= CategoryTranslation::all();
        if (isset($gallery) && count($gallery)>0) {
            if ($request->method() == "GET") {
                $all_category= CategoryTranslation::all();

                return view("rivaah::update-rivaah-gallery", array('all_category'=>$all_category,'gallery' => $gallery));
            }
            else if ($request->method()=="POST") {
               
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                        'name' => 'required|unique:products,name,'.$gallery->id,
                        'description' => 'required'
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
//                    dd($request->color);
                    if(isset($request->name) && $request->name!=""){
                        $gallery->name = $request->name;
                    }
//                    if(isset($request->category) && $request->category!=""){
//                        $gallery->category_id = $request->category;
//                    }
                if(isset($request->description) && $request->description!=""){
                    $gallery->description = $request->description;
                }
                $gallery->save();
                    return redirect("admin/rivaah-galleries-list")->with('status', 'Rivaah Gallery updated successfully!');
                }
            }
        } else {
            return redirect('admin/rivaah-galleries-list');
        }
    }
    public function saveGalleryMedia($created_media) {
       // dd($created_media);
        $created_post = RivaahGalleryImage::create($created_media);
        if ($created_post->id > 0) {
            return 0;
        } else {
            return -1;
        }
    }


    public function uploadImages($request, $gallery_id)
    {
        if ($request->hasFile('images')) {
            $uploaded_images = $request->file('images');
            foreach ($uploaded_images as $uploaded_image)
            {
                $extension = $uploaded_image->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

               // dd(storage_path('app/public/gallery/images'));
                if (!is_dir(storage_path('app/public/rivaah/images'))) {
                    Storage::makeDirectory('public/rivaah/images', 0777, true);
                }
                if (!is_dir(storage_path('app/public/rivaah/images/thumbnails'))) {

                    Storage::makeDirectory('app/public/rivaah/images/thumbnails', 0777, true);
                }

                Storage::put('public/rivaah/images/' . $new_file_name, file_get_contents($uploaded_image->getRealPath()));

                $thumbnail = Image::make(storage_path('app/public/rivaah/images/' . $new_file_name));


                $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);

                $thumbnail->save(storage_path('app/public/rivaah/images/thumbnails/' . $new_file_name));
                $created_videos = array("image" => $new_file_name,"rivaah_gallery_id" => $gallery_id);
                //dd($created_videos);
                $success = $this->saveGalleryMedia($created_videos);
                if ($success == -1) {
                    return redirect("admin/gallery-list")->with('status', 'Oops!! Something has really went wrong,File you looking isn\'t created!');
                }
            }
        }
        return 0;
    }



    public function manageImages(Request $request, $cat_id) {
        //dd(123);
        if ($request->method() == "GET") {

            $all_media = RivaahGalleryImage::where('rivaah_gallery_id', $cat_id)->orderBy('id','DESC')->paginate(5);
            return view("rivaah::manage-images", array('all_media' => $all_media, "gallery_id" => $cat_id));
        } else {

            $request_data = $request->all();
           // dd($request_data);
            $validate_response = Validator::make($request_data, [
                'images.*' => 'required|max:5120|mimes:jpg,jpeg,gif,png',
            ]);

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            }
            $this->uploadImages($request, $request->gallery_id);
            return redirect("admin/rivaah-galleries-list")->with('status', 'Gallery Images altered successfully!');
        }
    }
    public function deleteImage($id) {
        $category = RivaahGalleryImage::find($id);
        if ($category) {
            $category->delete();
            unlink(storage_path('app/public/rivaah/images/').$category->image);
            unlink(storage_path('app/public/rivaah/images/thumbnails/').$category->image);
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
            exit();
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
            exit();

        }
    }
    
    public function chkDuplicateRivaahGallery(Request $request)
    {
        $name=$request->name;
        $gallery= RivaahGallery::where('name',$name)->first();
        if(count($gallery)>0)
        {
              return "false"; 
           } else{
             return "true";
           } 
    }
    public function chkUpDuplicateRivaahGallery(Request $request)
    {
       // dd($request->old_name);
        if($request->old_name == $request->name){
            return "true";
        }
        else{
        $name=$request->name;
        $gallery= RivaahGallery::where('name',$name)->first();
        if(count($gallery)>0)
        {
            return "false";
        } else{
            return "true";
        }
    }

    }
    public function rivaahStory(Request $request,$image_id)
    {
//         dd($image_id);
        $rivaah_gal_img = RivaahGalleryImage::find($image_id);
        if(isset($rivaah_gal_img) && count($rivaah_gal_img)>0){
            $rivaah_gal = RivaahGallery::where('id',$rivaah_gal_img->rivaah_gallery_id)->first();
            if(isset($rivaah_gal) && count($rivaah_gal)>0){
                $all_rivaah_gal_img = RivaahGalleryImage::where('rivaah_gallery_id','<>',$rivaah_gal->id)->groupBy('rivaah_gallery_id')->paginate('4');
                if(isset($rivaah_gal_img) && count ($rivaah_gal_img)>0){

                    return view('rivaah_our_stories')->with(array('rivaah_gal'=>$rivaah_gal,'rivaah_gal_img' => $rivaah_gal_img, 'all_rivaah_gal_img' => $all_rivaah_gal_img));
                }
            }
        }
    }
    public function rivaahStorySemiDetails(Request $request,$image_id)
    {
        $gal_img_details = RivaahGalleryImage::find($image_id);
        if(isset($gal_img_details) && count($gal_img_details)>0)
        {
            $gal_details = RivaahGallery::where('id',$gal_img_details->rivaah_gallery_id)->first();
            if(isset($gal_details) && count($gal_details)>0)
            {
                return view('our_story_sub_details',compact('gal_img_details','gal_details'));
            }
        }
        else{
            return redirect('/');
        }
    }
    public function rivaahStoryDetails(Request $request,$image_id)
    {
        $gal_img_details = RivaahGalleryImage::find($image_id);
        $user_pro = array();
        $arrProd = array();
        if(isset($gal_img_details) && count($gal_img_details)>0)
        {
            $gal_details = RivaahGallery::where('id',$gal_img_details->rivaah_gallery_id)->first();
              if(isset($gal_details) && count($gal_details)>0)
              {
               $all_riv_products = RivaahProduct::where('rivaah_id',$gal_details->id)->get();
               if(isset($all_riv_products) && count($all_riv_products)>0)
               {
                   foreach ($all_riv_products as $key=>$value){

                       if(!empty($value->userProduct))
                       {
                           $prod =Product::FilterHideProduct()->FilterProductStatus()->where('id',$value->userProduct->id)->first();
                           if(isset($prod) && count($prod)>0)
                           {
                               $user_pro[$key] = $prod;
                           }
                       }

                   }
               }
                  return view('rivaah_story_details',array('gal_img_details'=>$gal_img_details,'gal_details'=>$gal_details,'all_product'=>$user_pro));
              }
//            dd($gal_img_details);
         //  $all_product = Product::FilterGetRivaah()->FilterHideProduct()->paginate(1);

//           dd($all_product);

//           foreach($all_product as $pro)
//           {
//               dd($pro);
//           }

//           dd($all_product->first()->getRivaah);
//           foreach($all_product->first()->getRivaah as $riv)     // r , p
//           {
//                        dd($riv->userProduct->productDescription);
//           }
//
//            $rivaah_product = RivaahProduct::where('id','<>',$gal_details->id)->where('rivaah_id',$gal_img_details->rivaah_gallery_id)->get();
//
//            dd($rivaah_product);
//
//            if(isset($rivaah_product) && count($rivaah_product)>0)
//            {
//
//
//                foreach($rivaah_product as $riv)
//                {
//                    $user_pro[]  = $riv->rivaahProduct->FilterHideProduct()->get();
//                }
//            }
//            dd($user_pro);

            //dd($rivaah_product);
//            $rivaah_product = array_values($rivaah_product->toArray());
//            $rivaah_product = array_column($rivaah_product, 'product_id');
           // dd($rivaah_product);
        }
        return redirect('/');
    }

    public function deleteRivaahGallery($gallery_id) {
        $gallery = RivaahGallery::find($gallery_id);
        if ($gallery) {
            RivaahGalleryImage::where('rivaah_gallery_id',$gallery->id)->delete();
            $gallery->delete();
            return redirect("admin/rivaah-galleries-list")->with('status', 'Rivaah deleted successfully!');
        } else {
            return redirect('admin/rivaah-galleries-list');
        }
    }

    public function deleteSelectedRivaahGallery($gallery_id)
            {
        $gallery = RivaahGallery::find($gallery_id);

        if ($gallery) {
            RivaahGalleryImage::where('rivaah_gallery_id',$gallery->id)->delete();

            $gallery->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

 private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

}
class categoryTreeHolder {

    public $display = '';
    public $id = '';
    public $slug = '';

    public function __construct($display, $id, $slug = '') {
        $this->id = $id;
        $this->display = $display;
        $this->slug = $slug;
    }

}
