<?php

namespace App\PiplModules\category\Controllers;

use App\PiplModules\category\Models\CategoryAttributeValue;
use App\PiplModules\product\Models\ProductAttribute;
use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\category\Models\Category;
use App\PiplModules\attribute\Models\Attribute;
use App\PiplModules\category\Models\CategoryAttributes;
use Mail;
use Datatables;
use App\PiplModules\category\Models\CategoryTranslation;
use App\PiplModules\attribute\Models\AttributeTranslation;
use Image;

class CategoryController extends Controller {
    
   private $thumbnail_size = array("width" => 300, "height" => 200);
 
    public function listCategories() {
        $all_categories = Category::translatedIn(\App::getLocale())->get();
        return view('category::list-categories', array('categories' => $all_categories));
    }

    public function listCategoriesData() {

        $all_categories = Category::translatedIn(\App::getLocale())->where('parent_id', 0)->orWhere("parent_id",NULL)->get();
        $all_categories = $all_categories->sortBy('id');

        return Datatables::of($all_categories)
                        ->addColumn('name', function($category) {
                            return stripslashes($category->name);
                        })
                        ->make(true);
    }
    
//        public function giveCategoryDiscount(Request $request,$product_id){
////        dd($request->all());
//        $product= CategoryTranslation::where('category_id',$product_id)->first();
//        if($request->method()=="GET"){
//        return view('category::give-category-discount',compact('product_id','product'));
//        }
//        else if($request->method()=="POST"){
//           // dd($request->all());
//            
//            $product=  CategoryTranslation::where('category_id',$product_id)->first();
////            if($request->radioChange=='Amount'){
////            $product->discount_type=0;
////            }
////            else if($request->radioChange=='Percentage'){
////            $product->discount_type=1;
////            }
////            if($request->radioChange=='Amount')
////            {
////            $product->discount_price=$request->amount;
////            }
////            else if($request->radioChange=='Percentage'){
////            $product->discount_percent=$request->percentage;
////            }
//            if(isset($request->percentage) && $request->percentage != '')
//            {
//                $product->discount_type=1;
//                $product->discount_percent=$request->percentage;
//            }
//
//            $product->max_quantity=$request->max_quantity;
//            $product->discount_valid_from=$request->discount_valid_from;
//            $product->discount_valid_to=$request->discount_valid_to;
//            $product->save();
//            
//            return redirect(url('/admin/categories-list'))->with('status',"Discount on category applied successfully!");
//            
//        }
//    }
      public  function removeCatDiscount(Request $request){
          $category= CategoryTranslation::where('category_id',$request->cat_id)->first();
         if(count($category)>0){
             if($category->discount_type == 0){
                 $category->discount_price =0;
             }
             else{
                 $category->discount_percent = 0;
             }
             $category->discount_valid_from = 0;
             $category->discount_valid_to = 0;
             $category->max_quantity = 0;
             $category->save();
             echo json_encode(array("success" => '1', 'msg' => "Category discount has deleted successfully"));
             exit();
         }
          echo json_encode(array("success" => '0', 'msg' => "Wrong category id"));
          exit();
      }

public function giveCategoryDiscount(Request $request,$product_id){
        
        $product= CategoryTranslation::where('category_id',$product_id)->first();
        if($request->method()=="GET"){
        return view('category::give-category-discount',compact('product_id','product'));
        }
        else if($request->method()=="POST"){
//            dd($request->all());
           
            
            $product=  CategoryTranslation::where('category_id',$product_id)->first();
            
//            if($request->radioChange=='Amount'){
//            $product->discount_type=0;
//            }
//            else if($request->radioChange=='Percentage'){
//            $product->discount_type=1;
//            }
//            if($request->radioChange=='Amount')
//            {
//            $product->discount_price=$request->amount;
//            }
//            else if($request->radioChange=='Percentage'){
//            $product->discount_percent=$request->percentage;
//            }
            if($product->parent_id=="" ||$product->parent_id=="0"){
            if(isset($request->percentage) && $request->percentage != '')
            {
                $product->discount_type=1;
                $product->discount_percent=$request->percentage;
            }

            $product->max_quantity=$request->max_quantity;
            $product->discount_valid_from=$request->discount_valid_from;
            $product->discount_valid_to=$request->discount_valid_to;
            $product->save();
            
            return redirect(url('/admin/categories-list'))->with('status',"Discount on category applied successfully!");
            }
            else if($product->parent_id!="" ||$product->parent_id!="0"){
                $category=  CategoryTranslation::where('category_id',$product_id)->first();
                $parent_id=$category->parent_id;
                if(isset($request->percentage) && $request->percentage != '')
            {
                $product->discount_type=1;
                $product->discount_percent=$request->percentage;
            }

            $product->max_quantity=$request->max_quantity;
            $product->discount_valid_from=$request->discount_valid_from;
            $product->discount_valid_to=$request->discount_valid_to;
            $product->save();
            
            return redirect(url('/admin/subcategories-list/'.$parent_id))->with('status',"Discount on category applied successfully!");
                
            }
        }
    }
    
    public function listSubCategories($cat_id) {

        return view('category::list-subcategories', array('cat_id' => $cat_id));
    }

    public function listSubCategoriesData($cat_id) {
        $all_categories = Category::translatedIn(\App::getLocale())->where('parent_id', $cat_id)->get();
        $all_categories = $all_categories->sortBy('id');
        return Datatables::of($all_categories)
                        ->addColumn('name', function($category) {
                            return stripslashes($category->name);
                        })
                        ->make(true);
    }
    
    public function listSubSubCategories($cat_id) {

        return view('category::list-subsubcategories', array('cat_id' => $cat_id));
    }

    public function listSubSubCategoriesData($cat_id) {

        $all_categories = Category::translatedIn(\App::getLocale())->where('parent_id', $cat_id)->get();
        $all_categories = $all_categories->sortBy('id');
        return Datatables::of($all_categories)
                        ->addColumn('name', function($category) {
                            return stripslashes($category->name);
                        })
                        ->make(true);
    }

    public function createCategories(Request $request) {
        $all_attributes = Attribute::translatedIn(\App::getLocale())->get();
        if ($request->method() == "GET") {
            $all_category = Category::translatedIn(\App::getLocale())->get();
             $arr = ['Length','Width','Size','Height','Gross Weight'];
//             dd($arr);
            return view("category::create-category", array('all_category' => $all_category, 'all_attributes' => $all_attributes,'arr'=>$arr));
        } else {
//            $parent_id=  CategoryTranslation::where('parent_id',0)->first();
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'name' => 'required|regex:/[a-zA-Z]/',
                        'attribute' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                
                if ($request->hasFile('image')) {

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                        Storage::put('public/cat/' . $new_file_name, file_get_contents($request->file('image')->getRealPath()));

                        if (!is_dir(storage_path('public/blog/thumbnails/'))) {
                            Storage::makeDirectory('public/blog/thumbnails/');
                        }

                        // make thumbnail

                        $thumbnail = Image::make(storage_path('app/public/blog/' . $new_file_name));
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(storage_path('app/public/blog/thumbnails/' . $new_file_name));
                    }
                
                $created_category = Category::create();

                $translated_category = $created_category->translateOrNew(\App::getLocale());
                $translated_category->name = $request->name;
                $translated_category->category_id = $created_category->id;
                $translated_category->created_by = Auth::user()->id;
                $translated_category->description = $request->description;
                $translated_category->locale = \App::getLocale();
                $translated_category->save();

                foreach ($data['attribute'] as $key => $value) {
                    $category_attri = new CategoryAttributes();
                    $category_attri->category_id = $created_category->id;
                    $category_attri->attribute_id = $value;
                    $category_attri->save();
                }

                return redirect("admin/categories-list")->with('status', 'Category created successfully!');
            }
        }
    }

    public function createSubCategories(Request $request, $cat_id) {
        if ($request->method() == "GET") {
            $all_category = Category::translatedIn(\App::getLocale())->where('id', $cat_id)->first();

            return view("category::create-subcategories", array('all_category' => $all_category));
        } else {

            $data = $request->all();
            //dd($data);
            $validate_response = Validator::make($data, array(
                              'category'=>'required',
                              'name' => 'required|regex:/[a-zA-Z]/',
//                        'name' => 'required|regex:/[a-zA-Z]/|unique:category_translations',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            }
            else {
                $cat = Category::find($request->parent_id);
                //dd($cat->categoryAttribute->first()->attributeValue);
                if(isset($cat) && count($cat)>0){
                    $created_category = new Category();
                    $created_category->parent_id = $request->parent_id;
                    $created_category->save();
                    $translated_category = $created_category->translateOrNew(\App::getLocale());
                    $translated_category->name = $request->name;
                    $translated_category->parent_id = $request->parent_id;

                    $translated_category->category_id = $created_category->id;
                    $translated_category->created_by = Auth::user()->id;
                    $translated_category->description = $request->description;
                    $translated_category->locale = \App::getLocale();
                    $translated_category->save();

                    if(count($cat->categoryAttribute)>0){
                        foreach ($cat->categoryAttribute as $attr){
                            $catAttr =new CategoryAttributes();
                            $catAttr->category_id =$created_category->id;
                            $catAttr->attribute_id =$attr->attribute_id;
                            $catAttr->save();
                            if($catAttr){
                              $catAttrVal = CategoryAttributeValue::where('category_attribute_id',$attr->id)->get();
                              if(count($catAttrVal)>0){
                                   foreach ($catAttrVal as $val){
                                       $catVal =new  CategoryAttributeValue();
                                       $catVal->category_attribute_id = $catAttr->id;
                                       $catVal->value = $val->value;
                                       $catVal->save();
                                   }
                              }
                            }
                        }
                    }
                }


                return redirect("admin/subcategories-list/".$cat_id)->with('status', 'Category created successfully!');
            }
        }
    }
    
    public function createSubSubCategories(Request $request, $cat_id) {
        if ($request->method() == "GET") {
            $all_category = Category::translatedIn(\App::getLocale())->where('id', $cat_id)->first();
            
            return view("category::create-subsubcategories", array('all_category' => $all_category, 'cat_id' => $cat_id));
        } else {
//            dd($request->all());
            $data = $request->all();
//             $all_category = Category::translatedIn(\App::getLocale())->where('id', $cat_id)->first();
           
            $category=CategoryTranslation::where('category_id',$request->parent_id)->where('name',$request->name)->first();
//            dd($category);          
//            if($category!="")
//                       {
//                       dd(1);
//                        Session::put('status', 'The name already taken');
//                        return view("category::create-subsubcategories", array('all_category' => $all_category, 'cat_id' => $cat_id));

//                       }
//                        
//            else{            
            
            $validate_response = Validator::make($data, array(
                        'category'=>'required',
                        'name' => 'required|regex:/[a-zA-Z]/',
//                          'name' => 'required|regex:/[a-zA-Z]/',
        
                ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                $cat = Category::find($request->parent_id);
                if(count($cat) >0){
                    $created_category = new Category();
                    $created_category->parent_id = $request->parent_id;
                    $created_category->save();

                    $translated_category = $created_category->translateOrNew(\App::getLocale());
                    $translated_category->name = $request->name;
                    $translated_category->parent_id = $request->parent_id;

                    $translated_category->category_id = $created_category->id;
                    $translated_category->created_by = Auth::user()->id;
                    $translated_category->description = $request->description;
                    $translated_category->locale = \App::getLocale();
                    $translated_category->save();

                    if(count($cat->categoryAttribute)>0){
                        foreach ($cat->categoryAttribute as $attr){
                            $catAttr =new CategoryAttributes();
                            $catAttr->category_id =$created_category->id;
                            $catAttr->attribute_id =$attr->attribute_id;
                            $catAttr->save();
                            if($catAttr){
                                $catAttrVal = CategoryAttributeValue::where('category_attribute_id',$attr->id)->get();
                                if(count($catAttrVal)>0){
                                    foreach ($catAttrVal as $val){
                                        $catVal =new  CategoryAttributeValue();
                                        $catVal->category_attribute_id = $catAttr->id;
                                        $catVal->value = $val->value;
                                        $catVal->save();
                                    }
                                }
                            }
                        }
                    }
                    return redirect("admin/categories-list/")->with('status', 'Category created successfully!');
                }
            }
            }
    }

    public function updateCategory(Request $request, $category_id, $locale = "")
    {
        $all_attributes = Attribute::translatedIn(\App::getLocale())->get();
        $category_attribute = CategoryAttributes::where('category_id',$category_id)->get();
        $category = Category::find($category_id);
        $arr = ['Length','Width','Size','Height','Gross Weight'];

        if ($category) {

            $translated_category = $category->translateOrNew($locale);

            if ($request->method() == "GET") {

                if ($locale != '' && $locale != 'en') {
                    return view("category::update-language-category", array('category' => $translated_category, 'main_info' => $category,'arr'=>$arr));
                } else {
                    return view("category::update-category", array('category' => $translated_category, 'category_attribute' => $category_attribute, 'all_attributes' => $all_attributes,'arr'=>$arr));
                }
            } else {
                $data = $request->all();
                //dd($data);
                if ($locale != 'en') {
                    if ($category->name == $request->name) {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|regex:/[a-zA-Z]/',
                                    'attribute' => 'required',
                        ));
                    } else {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|unique:category_translations|regex:/[a-zA-Z]/',
                            'attribute' => 'required',
                        ));
                    }
                } else {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:category_translations|regex:/[a-zA-Z]/',
                                'attribute' => 'required',
                        
                    ));
                }

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                       // dd($data);
                    $new_file_name = '';
                    if ($request->hasFile('image')) {

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
                        Storage::put('public/category/' . $new_file_name, file_get_contents($request->file('image')->getRealPath()));

                        if (!is_dir(storage_path('public/category/thumbnails/'))) {
                            Storage::makeDirectory('public/category/thumbnails/');
                        }

                        // make thumbnail

                        $thumbnail = Image::make(storage_path('app/public/category/' . $new_file_name));
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(storage_path('app/public/category/thumbnails/' . $new_file_name));
                    }

                    $translated_category->category_id = $category->id;
                    $translated_category->created_by = Auth::user()->id;
                    $translated_category->name = $request->name;
                    $translated_category->description = $request->description;
                    $translated_category->about_category = $request->about_category;
                    $translated_category->image = $new_file_name;
                    $translated_category->locale = \App::getLocale();
                    //dd($category->id);
                    if(isset($data['attribute']) && count($data['attribute'])>0)
                    {
                        $cat_attr = CategoryAttributes::where('category_id',$category->id)->get();
                       // dd($cat_attr);
                        if(isset($cat_attr) && count($cat_attr)>0){
                            foreach ($cat_attr as $key) {
                                $key->delete();
                            }
                        }
                        foreach ($data['attribute'] as $key => $value) {
                            $category_attri = new CategoryAttributes();
                            $category_attri->category_id = $category->id;
                            $category_attri->attribute_id = $value;
                            $category_attri->save();
                        }

                    }
                    $translated_category->save();

                    return redirect("admin/categories-list")->with('status', 'Category updated successfully!');
                }
            }
        } else {
            return redirect('admin/categories-list');
        }
    }

    public function updateSubCategory(Request $request, $category_id, $locale = "") {
        $category = Category::find($category_id);

        if ($category) {

            $translated_category = $category->translateOrNew($locale);

            if ($request->method() == "GET") {

                if ($locale != '' && $locale != 'en') {
                    return view("category::update-language-category", array('category' => $translated_category, 'main_info' => $category));
                } else {
                    return view("category::update-subcategory", array('category' => $translated_category, 'main_info' => $category));
                }
            } else {
                $data = $request->all();
                if ($locale != 'en') {
                    if ($category->name == $request->name) {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|regex:/[a-zA-Z]/',
                        ));
                    } else {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|unique:category_translations|regex:/[a-zA-Z]/',
                        ));
                    }
                } else {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:category_translations|regex:/[a-zA-Z]/',
                                'category_type' => 'required',
                    ));
                }

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    $translated_category->category_id = $category->id;
                    $translated_category->created_by = Auth::user()->id;
                    $translated_category->name = $request->name;
                    $translated_category->description = $request->description;
                    $translated_category->about_category = $request->about_category;
                    $translated_category->locale = \App::getLocale();
                    $translated_category->save();

                    return redirect("admin/subcategories-list/".$category_id)->with('status', 'Category updated successfully!');
                }
            }
        } else {
            return redirect('admin/categories-list');
        }
    }
    
    public function updateSubSubCategory(Request $request, $category_id, $locale = "") {
        $category = Category::find($category_id);

        if ($category) {

            $translated_category = $category->translateOrNew($locale);

            if ($request->method() == "GET") {

                if ($locale != '' && $locale != 'en') {
                    return view("category::update-language-category", array('category' => $translated_category, 'main_info' => $category));
                } else {
                    return view("category::update-subsubcategory", array('category' => $translated_category, 'main_info' => $category));
                }
            } else {
                $data = $request->all();
                if ($locale != 'en') {
                    if ($category->name == $request->name) {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|regex:/[a-zA-Z]/',
                        ));
                    } else {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|unique:category_translations|regex:/[a-zA-Z]/',
                        ));
                    }
                } else {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:category_translations|regex:/[a-zA-Z]/',
                                'category_type' => 'required',
                    ));
                }

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    $translated_category->category_id = $category->id;
                    $translated_category->created_by = Auth::user()->id;
                    $translated_category->name = $request->name;
                    $translated_category->description = $request->description;
                    $translated_category->about_category = $request->about_category;
                    $translated_category->locale = \App::getLocale();
                    $translated_category->save();

                    return redirect("admin/categories-list")->with('status', 'Category updated successfully!');
                }
            }
        } else {
            return redirect('admin/categories-list');
        }
    }

    public function removePhoto($image_id) {
        $product_image = ProductImage::find($image_id);

        if ($product_image) {
            $image = $product_image->images;

            if ($image) {
                if ($this->removeProductFileFromStrorage($image)) {
                    ProductImage::where('id', $image_id)->delete();
                }
            }
        }

        echo '<script>window.opener.alert("File deleted successfully!");window.opener.location.reload();window.opener = window.self;window.close();</script>';
    }

    private function removeProductFileFromStrorage($file_name) {
        if (Storage::exists('public/product/' . $file_name)) {
            Storage::delete('public/product/' . $file_name);

            if (Storage::exists('public/product/thumbnails/' . $file_name)) {
                Storage::delete('public/product/thumbnails/' . $file_name);
            }

            return true;
        }

        return false;
    }

    public function deleteCategory($category_id) {
        $category = Category::find($category_id);
        if ($category) {
             $category_data=  Category::where('parent_id',$category_id)->delete();
        $cat=  CategoryTranslation::where('category_id',$category_id)->delete();
        $cat_data=  CategoryTranslation::where('parent_id',$category_id)->delete();
       
            $category->delete();
            return redirect("admin/categories-list")->with('status', 'Category deleted successfully!');
        } else {
            return redirect('admin/categories-list');
        }
    }

    public function deleteSelectedCategory($category_id) {
        $category = Category::find($category_id);
        if ($category) {
            $category_data=  Category::where('parent_id',$category_id)->delete();
        $cat=  CategoryTranslation::where('category_id',$category_id)->delete();
        $cat_data=  CategoryTranslation::where('parent_id',$category_id)->delete();
        
            $category->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }
    
    public function checkDupicateCategory(Request $request) 
    {
//     dd($request->all());  
        $parent_id=$request->parent_id;
        $name=$request->name;
//        $cat_data=CategoryTranslation::where('name',$name)->first();
        $cat_data=CategoryTranslation::where('name',$name)->where('parent_id',$parent_id)->first();
        if(count($cat_data)>0) {
            $parent_data = $cat_data->categoryName;
            if ($parent_data->parent_id == $parent_id) {
                return "false";
            } else {
                return "true";
            }
        }
        else{
            return "true";
        }
        
        
        
    }
    
    public function checkDupicateMainCategory(Request $request) 
    {
        $parent_id=$request->parent_id;
        $name=$request->name;
        $cat_data=CategoryTranslation::where('name',$name)->where('parent_id',null)->first();
        $cat1_data=CategoryTranslation::where('name',$name)->where('parent_id',"0")->first();
        
        if((count($cat_data)>0) || count($cat1_data)>0)
        {

              return "false";
           } else{
             return "true";
           }   
        
        
        
    }
   // manage category attribures
    //
    public function listCategoryAttributes($category_id)
    {
         $catAttr = CategoryAttributes::where('category_id',$category_id)->get();
        // dd($catAttr);
        return view("category::list_category_attributes",compact('category_id'));
    }

    public function listCategoryAttributesData($category_id)

    {

        $category=Category::where('id',$category_id)->first();

        if(isset($category) && count($category)>0){
            $categoryTrans=  CategoryTranslation::where('category_id',$category->id)->first();
            if($categoryTrans->parent_id==0){
            $all_attributes= CategoryAttributes::where('category_id',$category->id)->get();
        }
        else if($categoryTrans->parent_id!=""){
            $all_attributes= CategoryAttributes::where('category_id',$categoryTrans->parent_id)->get();

        }

        $all_attributes = $all_attributes->sortBy('id');
        //dd($all_attributes);
        return Datatables::of($all_attributes)
            ->addColumn('name', function($all_attributes) {
                if(isset($all_attributes->attribute->trans->name) && $all_attributes->attribute->trans->name!="" ){

                    return stripslashes($all_attributes->attribute->trans->name);
                }
                else{
                    return "-";
                }
            })
            ->make(true);
    }
    }
    public function updateCategoryAttributesValue(Request $request,$category_id,$attribute_id)
    {
        if($request->method()=="GET"){
            $attribute=  CategoryAttributes::where('attribute_id',$attribute_id)->where('category_id',$category_id)->first();
            $attr_values = CategoryAttributeValue::where('category_attribute_id',$attribute->id)->get();
            $attr_name=  AttributeTranslation::where('attribute_id',$attribute_id)->first();
            return view('category::update-category-attributes',compact("attribute","attribute_id","attr_name","category_id","attr_values"));
        }
        if($request->method()=="POST"){
           // dd($request->all());
            $category_id=$request->category_id;
            $cat_attribute = null;
            $attribute_id=$request->attribute_id;
            $cat_attribute_id=$request->category_attr_id;

            $attribute=  CategoryAttributeValue::where('category_attribute_id',$cat_attribute_id)->get();
           // dd($attribute);
            if(isset($attribute) && count($attribute)>0){
                foreach ($attribute as $attr){
                    $attr->delete();
                }
            }
            if(isset($request->value)){
                $valueArr = $request->value;
                foreach ($valueArr as $key=>$value){
                    $cat_attribute=new CategoryAttributeValue();
                    $cat_attribute->category_attribute_id=$cat_attribute_id;
                    $cat_attribute->value=$value;
                    $cat_attribute->save();
                }

            }
            return redirect(url('/admin/manage-category-attributes/'.$category_id))->with('status',"Category attribute values updated successfully");
        }
    }

    public function deleteCategoryAttributesValue($attribute_id) {
        $category = CategoryAttributes::find($attribute_id);
        if (isset($category) && count($category)>0) {
            $category->delete();
            return redirect("admin/categories-list")->with('status', 'Category Attribute deleted successfully!');
        } else {
            return redirect('admin/categories-list');
        }
    }


    public function deleteSelectedCategoryAttributesValue($attribute_id) {
        $category = CategoryAttributes::find($attribute_id);

        if ($category) {
//            ProductDescription::where('product_id',$product->id)->delete();

            $category->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }
}
