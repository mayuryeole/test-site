<?php

namespace App\PiplModules\inventory\Controllers;

use App\PiplModules\product\Models\ProductColor;
use App\PiplModules\product\Models\ProductColorImage;
use App\PiplModules\product\Models\ProductCountry;
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
use App\PiplModules\product\Models\ProductImage;
use App\PiplModules\product\Models\ProductDescription;
use App\PiplModules\product\Models\ProductTag;
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
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class InventoryController extends Controller {

    private $thumbnail_size = array("width" => 240, "height" => 240);

    public function listInventory() {
        return view('inventory::list-inventory-product');
    }

    public function listInventoryData() {

        $all_products = Product::all();
        $all_products = $all_products->sortBy('id');

        return Datatables::of($all_products)
                        ->addColumn('name', function($product) {
                            return stripslashes($product->name);
                        })
                        ->addColumn('category_name', function($product) {

                            if (isset($product->productDescription->category->name) && $product->productDescription->category->name != "") {
//                                dd($product->productDescription);
                                return $product->productDescription->category->name;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('quantity', function($product) {

                            if (isset($product->productDescription->quantity) && $product->productDescription->quantity != "") {
//                                dd($product->productDescription);
                                return $product->productDescription->quantity;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('short_description', function($product) {

                            if (isset($product->productDescription->short_description) && $product->productDescription->short_description != "") {
//                                dd($product->productDescription);
                                return $product->productDescription->short_description;
                            } else {
                                return "-";
                            }
                        })
                        ->addColumn('description', function($product) {

                            if (isset($product->productDescription->description) && $product->productDescription->description != "") {
//                                dd($product->productDescription);
                                return $product->productDescription->description;
                            } else {
                                return "-";
                            }
                        })
                        ->make(true);
    }

    public function updateInventory(Request $request, $product_id) 
    {
        $product = Product::find($product_id);
        if (isset($product) && count($product)>0)
        {
            if ($request->method() == "GET") {
                return view("inventory::update-inventory-product", array('product' => $product));
            } else if ($request->method() == "POST")
            {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'quantity' => 'required'
                ));
                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                }
                else
                    {
                        $product_description = ProductDescription::where('product_id',$product->id)->first();

                        if(isset($product_description) && count($product_description)>0)
                        {
                            if(isset($request->quantity) && $request->quantity !='')
                            {
                                if($request->quantity >= 1)
                                {
                                    $product_description->quantity =$request->quantity;
                                    $product_description->availability =0;
                                    $product_description->save();
                                }
                            }
                        }
                        return redirect("/admin/inventory-list")->with('status', 'Product Inventory updated successfully!');
                }

            }
        } else {
            return redirect('/admin/inventory-list');
        }
    }
    public function is_url_exist($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public function createInventoryExcel()
    {
        $product = Product::all();
        Excel::create('Inventory CSV File', function($product) {
            $product->sheet('Excel sheet', function($sheet) {
                $product_description = ProductDescription::get();

                foreach ($product_description as $key => $value) {
                    if (isset($value->product->name) && $value->product->name != "") {
                        $name = $value->product->name;
                    } else {
                        $name = "";
                    }
                    if (isset($value->category->name) && $value->category->name != "") {
                        $category_name = $value->category->name;
                    } else {
                        $category_name = "";
                    }
                    if (isset($value->color) && $value->color != "") {
                        $color = $value->color;
                    } else {
                        $color = "";
                    }

                    if (isset($value->price) && $value->price != "") {
                        $price = $value->price;
                    } else {
                        $price = "";
                    }if (isset($value->quantity) && $value->quantity != "") {
                        $quantity = $value->quantity;
                    } else {
                        $quantity = "";
                    }
                    if (isset($value->productStyle->style->name) && $value->productStyle->style->name != "") {
                        $style = $value->productStyle->style->name;
                    } else {
                        $style = "";
                    }
                    if (isset($value->collectionStyle->productCollectionStyle->name) && $value->collectionStyle->productCollectionStyle->name != "") {
                        $collection_style = $value->collectionStyle->productCollectionStyle->name;
                    } else {
                        $collection_style = "";
                    }
                    if (isset($value->productOccasion->occasion->name) && $value->productOccasion->occasion->name != "") {
                        $occasion = $value->productOccasion->occasion->name;
                    } else {
                        $occasion = "";
                    }
                    if (isset($value->is_featured) && $value->is_featured == "0") {
                        $featured = "Not Featured";
                    } else {
                        $featured = "Featured";
                    }
                    if (isset($value->availability) && $value->availability == "0") {
                        $availability = "In Stock";
                    } else {
                        $availability = "Out Of Stock";
                    }
                    if (isset($value->status) && $value->status == "0") {
                        $status = "Disabled";
                    } else {
                        $status = "Enabled";
                    }
                    if (isset($value->pre_order) && $value->pre_order == "0") {
                        $pre_order = "Not Pre-Order";
                    } else {
                        $pre_order = "Pre-Order";
                    }
                    if (isset($value->launched_date) && $value->launched_date != "") {
                        $launched_date = $value->launched_date;
                    } else {
                        $launched_date = "";
                    }
                    if (isset($value->short_description) && $value->short_description != "") {
                        $short_desc = $value->short_description;
                    } else {
                        $short_desc = "";
                    }
                    if (isset($value->description) && $value->description != "") {
                        $desc = $value->description;
                    } else {
                        $desc = "";
                    }

                    $rows = array($key + 2 => array($key + 1, $name, $category_name, $color, $price, $quantity, $style, $collection_style, $occasion, $featured, $availability, $status, $pre_order, $launched_date, $short_desc, $desc));
                    $sheet->row(1, function($rows) {
                        $rows->setBackground('#F9E79F');
                    });
                    $sheet->row(1, array(
                        'Sr no.', 'Name', 'Category Name', 'Color', 'Price', 'Quantity of product', 'Style', 'Collection Style', 'Occasion', 'Is Featured', 'Availability', 'Status', 'Pre-Order', 'Launched Date', 'Short Description', 'Description'
                    ));
                    foreach ($rows as $key => $r) {
                        $sheet->row($key, $r);
                    }
                }
            });
        })->export('xls');
    }

    public function ImportInventoryExcel(Request $request)
    {

//        dd($request->all());
        if ($request->method() == "POST")
        {
            //dd($request->all());
            if (Input::hasFile('import_file')) {

                $path = Input::file('import_file')->getRealPath();
                $extension = Input::file('import_file')->getClientOriginalExtension();
                $data = Excel::load($path, function($reader) {
                            
                        })->get();

                if (!empty($data) && $data->count())
                {
                    $arr1=[];
                    $arr2=[];
                    $arr3=[];
                    $arr4=[];
                    $arr5=[];
                    $arr6=[];
                    foreach ($data as $key => $value) {
                        $category = Category::where('id', intval(trim($value->category_id)))->first();

                        if(isset($category) && $category!="")
                        {

                        $product_detail = Product::where('name', trim($value->name))->first();
//                        dd($product_detail);
                        if (isset($product_detail) && count($product_detail) > 0) {
                            $desc = ProductDescription::where('product_id', $product_detail->id)->first();
//                            dd($desc);
                            if(!$desc){
                                $desc = ProductDescription::create(['product_id' => $product_detail->id]);
                            }
                            if (isset($value->category_id) && $value->category_id != "") {
                                $category = Category::where('id', $value->category_id)->first();

                                if (isset($category) && $category != "") {
                                    $product_detail->category_id = $category->id;
                                    $desc->category_id = $category->id;
                                    $product_detail->save();

                                } else if ($category == "") {

                                    $arr4[] = (['name' => trim($value->name), 'category' => intval(trim($value->category_id)), 'quantity' => intval(trim($value->quantity))]);
//                                               
                                    continue;
                                }
                            }
                            if (isset($value->product_sku) && $value->product_sku != "") {
                                $desc->sku = trim($value->product_sku);
                            }
                            if (isset($value->price) && $value->price != "") {
                                $desc->price = floatval(trim($value->price));
                            }
                            if (isset($value->quantity) && $value->quantity != "") {
                                $desc->quantity = intval(trim($value->quantity));
                            }
                            if (isset($value->style_id) && $value->style_id != "")
                            {
                                $desc->style = intval(trim($value->style_id));
                                $prodStyle = ProductStyle::where('product_id',$product_detail->id)->first();
                                if($prodStyle)
                                {
                                    $prodStyle->style_id = intval(trim($value->style_id));
                                    $prodStyle->save();
                                }
                                else
                                {
                                    $prodStyle =new ProductStyle();
                                    $prodStyle->product_id = $product_detail->id;
                                    $prodStyle->style_id = intval(trim($value->style_id));
                                    $prodStyle->save();
                                }
                            }
                            if (isset($value->collection_style) && $value->collection_style != "")
                            {
                                $desc->collection_style = intval(trim($value->collection_style));
                                $prodStyle = ProductCollectionStyle::where('product_id',$product_detail->id)->first();
                               if($prodStyle)
                               {
                                   $prodStyle->collection_style_id =intval(trim($value->collection_style));
                                   $prodStyle->save();
                               }
                                else
                                {
                                    $prodStyle =new ProductCollectionStyle();
                                    $prodStyle->product_id = $product_detail->id;
                                    $prodStyle->collection_style_id = intval(trim($value->collection_style));
                                    $prodStyle->save();
                                }
                            }
                            if (isset($value->occasion) && $value->occasion != "")
                            {
                                $desc->occasion = intval(trim($value->occasion));
                                $prodOcc = ProductOccasion::where('product_id',$product_detail->id)->first();
                                if($prodOcc)
                                {
                                    $prodOcc->occasion_id =intval(trim($value->occasion));
                                    $prodOcc->save();
                                }
                                else
                                {
                                    $prodOcc =new ProductOccasion();
                                    $prodOcc->product_id = $product_detail->id;
                                    $prodOcc->occasion_id = intval(trim($value->occasion));
                                    $prodOcc->save();
                                }
                            }

                            if (isset($value->is_featured) && $value->is_featured != "")
                            {
                                $desc->is_featured = intval(trim($value->is_featured));
                            }
                            if (isset($value->availability) && $value->availability != "") {
                                $desc->availability = intval(trim($value->availability));
                            }
                            if (isset($value->status) && $value->status != "") {
                                $desc->status = intval(trim($value->status));
                            }
                            if (isset($value->pre_order) && $value->pre_order != "") {
                                $desc->pre_order = intval(trim($value->pre_order));
                            }
                            if (isset($value->launched_date) && $value->launched_date != "") {
                                $desc->launched_date = trim($value->launched_date);
                            }

                            if (isset($value->maximum_order_quantity) && $value->maximum_order_quantity != "") {
                                $desc->max_order_qty = intval(trim($value->maximum_order_quantity));
                            }
                            if (isset($value->description) && $value->description != "") {
                                $desc->description = trim($value->description);
                            }
                            if (isset($value->single_color) && $value->single_color != "") {
                                $desc->color = trim($value->single_color);
                            }
                            $desc->save();

                            if(isset($value->color) && $value->color !='')
                            {
                                $chkprodColors = ProductColor::where('product_id',$product_detail->id)->delete();
                                if (strpos($value->color, ',') !== false) {
                                    $arrColors = explode(',',trim($value->color));
                                    foreach ($arrColors as $key=>$val){
                                        $prodColors =new ProductColor();
                                        $prodColors->product_id =$product_detail->id;
                                        $prodColors->color =$val;
                                        $prodColors->save();
                                    }
                                }
                                else{
                                    $prodColors =new ProductColor();
                                    $prodColors->product_id =$product_detail->id;
                                    $prodColors->color =trim($value->color);
                                    $prodColors->save();
                                }
                            }
                            if(isset($value->weight) && $value->weight!='')
                            {
                                $attr = AttributeTranslation::where('name',"Gross Weight")->first();
                                if($attr)
                                {
                                    $prodAttr = ProductAttribute::where('product_id',$product_detail->id)->where('attribute_id',$attr->attribute_id)->first();
                                    if($prodAttr){
                                        $prodAttr->value =trim($value->weight);
                                        $prodAttr->save();
                                    }
                                    else{
                                        $prodAttr = new ProductAttribute();
                                        $prodAttr->attribute_id =$attr->attribute_id;
                                        $prodAttr->product_id =$product_detail->id;
                                        $prodAttr->value =trim($value->weight);
                                        $prodAttr->save();
                                    }

                                }
                            }
                            if(isset($value->country) && $value->country!='')
                            {   $strArr = [];
                               $country = intval(trim($value->country));
                                $attr = AttributeTranslation::where('name',"Country")->first();
                                if($attr)
                                {
                                    $prodAttr = ProductAttribute::where('product_id',$product_detail->id)->where('attribute_id',$attr->attribute_id)->first();
                                    if($prodAttr){
                                        $prodAttr->value =$country;
                                        $prodAttr->save();
                                    }
                                    else{
                                        $prodAttr = new ProductAttribute();
                                        $prodAttr->attribute_id =$attr->attribute_id;
                                        $prodAttr->product_id =$product_detail->id;
                                        $prodAttr->value =$country;
                                        $prodAttr->save();
                                    }
                                    $prodCountry =ProductCountry::where('product_id',$product_detail->id)->where('country_id',$country)->first();
                                    if(!$prodCountry)
                                    {
                                         $cntryObj = new ProductCountry();
                                        $cntryObj->product_id = $product_detail->id;
                                        $cntryObj->country_id = $country;
                                        $cntryObj->save();
                                    }
                                }
                            }
                            if(isset($value->size) && $value->size!='')
                            {   $size = trim($value->size);
                                $strArr = [];
                                $attr = AttributeTranslation::where('name',"Size")->first();
                                if($attr)
                                {
                                    $prodAttr = ProductAttribute::where('product_id',$product_detail->id)->where('attribute_id',$attr->attribute_id)->delete();

                                    if( strpos($size, ',') !== false ) {
                                        $strArr = explode(',',$size);
                                        foreach ($strArr as $key=>$val)
                                        {
                                            $prodAttr = new ProductAttribute();
                                            $prodAttr->attribute_id =$attr->attribute_id;
                                            $prodAttr->product_id =$product_detail->id;
                                            $prodAttr->value =$val;
                                            $prodAttr->save();
                                        }
                                    }
                                    else{
                                        $prodAttr = new ProductAttribute();
                                        $prodAttr->attribute_id =$attr->attribute_id;
                                        $prodAttr->product_id =$product_detail->id;
                                        $prodAttr->value =$size;
                                        $prodAttr->save();
                                    }

                                }
                            }
                                $mandotary_attribute = array(151, 150, 117, 76, 34, 32, 31, 30, 24, 20, 19);
                                /** New Changes as per requested ** */
                                if (isset($mandotary_attribute) && count($mandotary_attribute) > 0)
                                {
                                    $arr_attr = AttributeTranslation::whereIn('attribute_id',$mandotary_attribute)->get();
                                    foreach ($arr_attr as $attrkey => $attr) {
                                        $prodAttr = ProductAttribute::where('product_id', $product_detail->id)->where('attribute_id', $attr->attribute_id)->first();
                                        if ($prodAttr) {
                                            $prodAttr->value = $value{$attr->attribute_id};
                                            $prodAttr->save();
                                        } else {
                                            $prodAttr = new ProductAttribute();
                                            $prodAttr->attribute_id = $attr->attribute_id;
                                            $prodAttr->product_id = $product_detail->id;
                                            $prodAttr->value = $value{$attr->attribute_id};
                                            $prodAttr->save();
                                        }
                                    }
                                }
                                /***/
                            if(isset($value->length) && $value->length!='')
                            {
                                $attr = AttributeTranslation::where('name',"Length")->first();
                                if($attr){

                                    $prodAttr = ProductAttribute::where('product_id',$product_detail->id)->where('attribute_id',$attr->attribute_id)->first();
                                    if($prodAttr){
                                        $prodAttr->value =$value->length;
                                        $prodAttr->save();
                                    }
                                    else{
                                        $prodAttr =new ProductAttribute();
                                        $prodAttr->attribute_id =$attr->attribute_id;
                                        $prodAttr->product_id =$product_detail->id;
                                        $prodAttr->value =trim($value->length);
                                        $prodAttr->save();
                                    }
                                }
                            }
                            if(isset($value->width) && $value->width!='')
                            {
                                $attr = AttributeTranslation::where('name',"Width")->first();
                                if($attr){
                                    $prodAttr = ProductAttribute::where('product_id',$product_detail->id)->where('attribute_id',$attr->attribute_id)->first();
                                    if($prodAttr){
                                        $prodAttr->value =$value->width;
                                        $prodAttr->save();
                                    }
                                    else{
                                        $prodAttr =new ProductAttribute();
                                        $prodAttr->attribute_id =$attr->attribute_id;
                                        $prodAttr->product_id =$product_detail->id;
                                        $prodAttr->value =trim($value->width);
                                        $prodAttr->save();
                                    }
                                }
                            }

                            if(isset($value->height) && $value->height!='')
                            {
                                $attr = AttributeTranslation::where('name',"Height")->first();
                                if($attr){
                                    $prodAttr = ProductAttribute::where('product_id',$product_detail->id)->where('attribute_id',$attr->attribute_id)->first();
                                    if($prodAttr){
                                        $prodAttr->value =$value->width;
                                        $prodAttr->save();
                                    }
                                    else{
                                        $prodAttr =new ProductAttribute();
                                        $prodAttr->attribute_id =$attr->attribute_id;
                                        $prodAttr->product_id =$product_detail->id;
                                        $prodAttr->value =trim($value->height);
                                        $prodAttr->save();
                                    }
                                }
                            }

                            if (isset($value->product_image) && $value->product_image != "")
                            {
                                $dir =  base_path().'/storage/app/public/product/image';
                                $dir1 =  base_path().'/storage/app/public/product/product_images';
                                $image =trim($value->product_image);
                                $arr = explode('/',$image);
                                $fileName =end($arr);
                                $file=null;
                                $status = $this->is_url_exist($image);
                                if($status){
                                    $file =file_get_contents($image);
                                }
                                if (!is_dir(base_path().'/storage/app/public/product/image'))
                                {
//                                    Storage::makeDirectory('app/public/product/image');
                                    mkdir(base_path().'/storage/app/public/product/image', 0777, true);
                                }
                                if (!is_dir(base_path().'/storage/app/public/product/image/thumbnail'))
                                {
                                    mkdir(base_path().'/storage/app/public/product/image/thumbnail', 0777, true);
                                }
                                if (!is_dir(base_path().'/storage/app/public/product/product_images'))
                                {
//                                    Storage::makeDirectory('app/public/product/image');
                                    mkdir(base_path().'/storage/app/public/product/product_images', 0777, true);
                                }
                                if (!is_dir(base_path().'/storage/app/public/product/product_images/thumbnails'))
                                {
                                    mkdir(base_path().'/storage/app/public/product/product_images/thumbnails', 0777, true);
                                }

                                 if($file){
                                        $chkprodImgs = ProductImage::where('product_id',$product_detail->id)->where('color',trim($desc->color))->first();
                                        if(!$chkprodImgs)
                                        {
                                            $chkprodImgs = new ProductImage();
                                            $chkprodImgs->product_id = $product_detail->id;
                                            $chkprodImgs->color = isset($desc->color)?trim($desc->color):'';
                                            $chkprodImgs->save();
                                        }
                                        $objProdClrImg = new ProductColorImage();
                                        $objProdClrImg->product_image_id = $chkprodImgs->id;
                                        $objProdClrImg->product_id = $product_detail->id;
                                        $extension = explode('.',$fileName);
                                        $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
//                                        Storage::put('app/public/product/image/' . $file_name,$file);
                                           $status= file_put_contents($dir.'/'.$file_name, $file);
                                        if($status)
                                        {
                                            $status1 =file_put_contents($dir1.'/'.$file_name,$file);
                                            if($status1)
                                            {
                                                if(file_exists(base_path().'/storage/app/public/product/product_images/' . $file_name))
                                                {
                                                    $thumbnail = Image::make(base_path().'/storage/app/public/product/product_images/' . $file_name);
                                                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                    $thumbnail->save(base_path().'/storage/app/public/product/product_images/thumbnails/' . $file_name);
                                                }
                                                $objProdClrImg->image = $file_name;
                                                $objProdClrImg->save();
                                            }
                                                // $dir1
                                            if(file_exists(base_path().'/storage/app/public/product/image/' . $file_name))
                                            {
                                                $thumbnail = Image::make(base_path().'/storage/app/public/product/image/' . $file_name);
                                                $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                $thumbnail->save(base_path().'/storage/app/public/product/image/thumbnail/' . $file_name);
                                            }
                                            $desc->image = $file_name;

                                        }
                                }
                            }
                            if(isset($value->product_multiple_image) && $value->product_multiple_image !='')
                            {
                                $dir =base_path().'/storage/app/public/product/product_images';
                                if (!is_dir(base_path().'/storage/app/public/product/product_images'))
                                {
//                                    Storage::makeDirectory('app/public/product/product_images');
                                    mkdir(base_path().'/storage/app/public/product/product_images', 0777, true);
                                }
                                if (!is_dir(base_path().'/storage/app/public/product/product_images/thumbnails'))
                                {
//                                    Storage::makeDirectory('app/public/product/product_images/thumbnail');
                                    mkdir(base_path().'/storage/app/public/product/product_images/thumbnails', 0777, true);
                                }

                                $allImgs = trim($value->product_multiple_image);
                                $arrImgs = '';
                                $objImgs =ProductImage::where('product_id',$product_detail->id)->where('color',trim($desc->color))->first();
                                if(!$objImgs)
                                {
                                    $objImgs->product_id = $product_detail->id;
                                    $objImgs->color = isset($desc->color)?trim($desc->color):'';
                                    $objImgs->save();
                                }

                                  if( strpos($allImgs, ',') !== false )
                                  {
                                      $arrImgs = explode(',',$allImgs);

                                      foreach ($arrImgs as $img){

                                          $objProdColrImg = new ProductColorImage();
                                          $objProdColrImg->product_image_id = $objImgs->id;
                                          $objProdColrImg->product_id = $product_detail->id;
                                          $image =$img;
                                          $file=null;
                                          $status = $this->is_url_exist($image);
                                          if($status){
                                              $file =file_get_contents($image);
                                          }
                                          $arr = explode('/',$image);
                                          $fileName =end($arr);
                                          if($file){
                                              $extension = explode('.',$fileName);
                                              $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
//                                              Storage::put('app/public/product/product_images/' . $file_name,$file);
                                              $status = file_put_contents($dir.'/'.$file_name, $file);
                                              if($status)
                                              {
                                                  if (file_exists(base_path().'/storage/app/public/product/product_images/' . $file_name))
                                                  {
                                                      $thumbnail = Image::make(base_path().'/storage/app/public/product/product_images/' . $file_name);
                                                      $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                      $thumbnail->save(base_path().'/storage/app/public/product/product_images/thumbnails/' . $file_name);
                                                  }
                                                  $objProdColrImg->image = $file_name;
                                                  $objProdColrImg->save();

                                              }

                                          }
                                      }
                                  }
                                  else{
                                      $objProdColrImg = new ProductColorImage();
                                      $objProdColrImg->product_image_id = $objImgs->id;
                                      $objProdColrImg->product_id = $product_detail->id;
                                      $image =$allImgs;
                                      $file=null;
                                      $status = $this->is_url_exist($image);
                                      if($status){
                                          $file =file_get_contents($image);
                                      }
                                      if($file) {
                                          $extension = explode('.', $fileName);
                                          $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
//                                          Storage::put('app/public/product/product_images/' . $file_name, $file);
//                                          $file->move(base_path() . '/storage/app/public/product/image/', $file_name);
                                          $status = file_put_contents($dir . '/' . $file_name, $file);
                                          // make thumbnail
                                          if ($status) {
                                              if (file_exists(base_path() . '/storage/app/public/product/product_images/' . $file_name)) {
                                                  $thumbnail = Image::make(base_path() . '/storage/app/public/product/product_images/' . $file_name);
                                                  $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                  $thumbnail->save(base_path() . '/storage/app/public/product/product_images/thumbnails/' . $file_name);
                                                  $objProdColrImg->image = $file_name;
                                                  $objProdColrImg->save();
                                              }
                                          }
                                      }
                                  }
                            }


                            if (isset($value->product_video) && count($value->product_video)>0)
                            {
                                $dir = base_path().'/storage/app/public/product/video';
                                if (!is_dir(base_path().'/storage/app/public/product/video'))
                                {
                                    mkdir(base_path().'/storage/app/public/product/video', 0777, true);
                                }
                                $image =trim($value->product_video);
                                $arr = explode('/',$image);
                                $fileName =end($arr);
                                $file =null;
                                $status = $this->is_url_exist($image);
                                if($status){
                                    $file =file_get_contents($image);
                                }
                                $extension = explode('.',$fileName);
                                if($file){
                                    $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
                                    $status = file_put_contents($dir.'/'.$file_name, $file);
                                    if($status)
                                    {
                                        $desc->video = $file_name;
                                    }
                                }
                            }
                                  $arr5[] = (['name' => $value->name, 'category' => $value->category_id, 'quantity' => $value->quantity]);

                            $desc->save();
                        } else if (count($product_detail) == 0) {
                            if (isset($value->name) && $value->name !='') {
                                $category = Category::where('id', $value->category_id)->first();
                                if ($category == "") {

                                    $arr2[] = (['name' => $value->name, 'category' => $value->category_id, 'quantity' => $value->quantity]);

                                    continue;
                                } else {
                                    $product = Product::create(['name' => $value->name,'category_id'=>$value->category_id]);
                                    if (isset($category) && $category != "") {
                                        $product_description = new ProductDescription();
                                        $product_description->product_id = $product->id;
                                        $product_description->category_id = intval($category->id);
                                        $product_description->quantity = intval($value->quantity);
                                        $product_description->price = $value->price;
                                        $product_description->short_description = $value->short_description;
                                        $product_description->description = $value->description;
                                        $product_description->sku = $value->product_sku;
//                                        $product_description->style = intval($value->style_id);
//                                        $product_description->collection_style = intval($value->collection_style);
//                                        $product_description->occasion = intval($value->occasion);
                                        if (isset($value->style_id) && $value->style_id != "")
                                        {
                                            $product_description->style = intval(trim($value->style_id));
                                            $prodStyle = ProductStyle::where('product_id',$product->id)->first();
                                            if($prodStyle)
                                            {
                                                $prodStyle->style_id = intval(trim($value->style_id));
                                                $prodStyle->save();
                                            }
                                            else
                                            {
                                                $prodStyle =new ProductStyle();
                                                $prodStyle->product_id = $product->id;
                                                $prodStyle->style_id = intval(trim($value->style_id));
                                                $prodStyle->save();
                                            }
                                        }
                                        if (isset($value->collection_style) && $value->collection_style != "")
                                        {
                                            $product_description->collection_style = intval(trim($value->collection_style));
                                            $prodStyle = ProductCollectionStyle::where('product_id',$product->id)->first();
                                            if($prodStyle)
                                            {
                                                $prodStyle->collection_style_id =intval(trim($value->collection_style));
                                                $prodStyle->save();
                                            }
                                            else
                                            {
                                                $prodStyle =new ProductCollectionStyle();
                                                $prodStyle->product_id = $product->id;
                                                $prodStyle->collection_style_id = intval(trim($value->collection_style));
                                                $prodStyle->save();
                                            }
                                        }
                                        if (isset($value->occasion) && $value->occasion != "")
                                        {
                                            $product_description->occasion = intval(trim($value->occasion));
                                            $prodOcc = ProductOccasion::where('product_id',$product->id)->first();
                                            if($prodOcc)
                                            {
                                                $prodOcc->occasion_id =intval(trim($value->occasion));
                                                $prodOcc->save();
                                            }
                                            else
                                            {
                                                $prodOcc =new ProductOccasion();
                                                $prodOcc->product_id = $product->id;
                                                $prodOcc->occasion_id = intval(trim($value->occasion));
                                                $prodOcc->save();
                                            }
                                        }
                                        $product_description->is_featured = intval($value->is_featured);
                                        $product_description->availability = intval($value->availability);
                                        $product_description->status = intval($value->status);
                                        $product_description->pre_order = intval($value->pre_order);
                                        $product_description->launched_date = $value->launched_date;
                                        $product_description->max_order_qty = intval($value->maximum_order_quantity);
                                        if (isset($value->single_color) && $value->single_color != "")
                                        {
                                            $product_description->color = $value->single_color;
                                        }
                                        $product_description->save();

                                        if(isset($value->color) && $value->color !='')
                                        {
                                            if (strpos($value->color, ',') !== false) {
                                                $arrColors = explode(',',$value->color);
                                                foreach ($arrColors as $key=>$val){
                                                   $prodColors =new ProductColor();
                                                    $prodColors->product_id =$product->id;
                                                    $prodColors->color =$val;
                                                    $prodColors->save();
                                                }
                                            }
                                            else{
                                                $prodColors =new ProductColor();
                                                $prodColors->product_id =$product->id;
                                                $prodColors->color =$value->color;
                                                $prodColors->save();
                                            }
                                        }
                                        if(isset($value->weight) && $value->weight!='')
                                        {
                                            $attr = AttributeTranslation::where('name',"Gross Weight")->first();
                                            if($attr){
                                                $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attr->attribute_id)->first();
                                                if($prodAttr){
                                                    $prodAttr->value =$value->weight;
                                                    $prodAttr->save();
                                                }
                                                else{
                                                    $prodAttr = new ProductAttribute();
                                                    $prodAttr->attribute_id =$attr->attribute_id;
                                                    $prodAttr->product_id =$product->id;
                                                    $prodAttr->value =$value->weight;
                                                    $prodAttr->save();
                                                }

                                            }
                                        }
                                        if(isset($value->length) && $value->length!='')
                                        {
                                            $attr = AttributeTranslation::where('name',"Length")->first();
                                            if($attr){
                                                $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attr->attribute_id)->first();
                                                if($prodAttr){
                                                    $prodAttr->value =$value->length;
                                                    $prodAttr->save();
                                                }
                                                else{
                                                    $prodAttr = new ProductAttribute();
                                                    $prodAttr->attribute_id =$attr->attribute_id;
                                                    $prodAttr->product_id =$product->id;
                                                    $prodAttr->value =$value->length;
                                                    $prodAttr->save();
                                                }
                                            }
                                        }
                                        if(isset($value->height) && $value->height!='')
                                        {
                                            $attr = AttributeTranslation::where('name',"Height")->first();
                                            if($attr){
                                                $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attr->attribute_id)->first();
                                                if($prodAttr){
                                                    $prodAttr->value =$value->length;
                                                    $prodAttr->save();
                                                }
                                                else{
                                                    $prodAttr = new ProductAttribute();
                                                    $prodAttr->attribute_id =$attr->attribute_id;
                                                    $prodAttr->product_id =$product->id;
                                                    $prodAttr->value =$value->length;
                                                    $prodAttr->save();
                                                }
                                            }
                                        }
                                        if(isset($value->country) && $value->country!='')
                                        {   $strArr = [];
                                            $country = intval(trim($value->country));
                                            $attr = AttributeTranslation::where('name',"Country")->first();
                                            if($attr)
                                            {
                                                $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attr->attribute_id)->first();
                                                if($prodAttr){
                                                    $prodAttr->value =$country;
                                                    $prodAttr->save();
                                                }
                                                else{
                                                    $prodAttr = new ProductAttribute();
                                                    $prodAttr->attribute_id =$attr->attribute_id;
                                                    $prodAttr->product_id =$product->id;
                                                    $prodAttr->value =$country;
                                                    $prodAttr->save();
                                                }
                                                $prodCountry =ProductCountry::where('product_id',$product->id)->where('country_id',$country)->first();
                                                if(!$prodCountry)
                                                {
                                                    $cntryObj = new ProductCountry();
                                                    $cntryObj->product_id = $product->id;
                                                    $cntryObj->country_id = $country;
                                                    $cntryObj->save();
                                                }
                                            }
                                        }
                                        if(isset($value->size) && $value->size!='')
                                        {   $strArr = [];
                                            $size =trim($value->size);
                                            $attr = AttributeTranslation::where('name',"Size")->first();
                                            if($attr)
                                            {
                                                $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attr->attribute_id)->delete();

                                                if( strpos($size, ',') !== false )
                                                {
                                                    $strArr = explode(',',$size);
                                                    foreach ($strArr as $key=>$val)
                                                    {
                                                        $prodAttr = new ProductAttribute();
                                                        $prodAttr->attribute_id =$attr->attribute_id;
                                                        $prodAttr->product_id =$product->id;
                                                        $prodAttr->value =$val;
                                                        $prodAttr->save();
                                                    }
                                                }
                                                else{
                                                    $prodAttr = new ProductAttribute();
                                                    $prodAttr->attribute_id =$attr->attribute_id;
                                                    $prodAttr->product_id =$product->id;
                                                    $prodAttr->value =$size;
                                                    $prodAttr->save();
                                                }

                                            }
                                        }
                                        
                                $mandotary_attribute = array(151, 150, 117, 76, 34, 32, 31, 30, 24, 20, 19);
                                /** New Changes as per requested ** */
                                if (isset($mandotary_attribute) && count($mandotary_attribute) > 0)
                                {
                                    $arr_attr = AttributeTranslation::whereIn('attribute_id', $mandotary_attribute)->get();
                                    foreach ($arr_attr as $attrkey => $attr) {
                                        $prodAttr = ProductAttribute::where('product_id', $product->id)->where('attribute_id', $attr->attribute_id)->first();
                                        if ($prodAttr) {
                                            $prodAttr->value = $value{$attr->attribute_id};
                                            $prodAttr->save();
                                        } else {
                                            $prodAttr = new ProductAttribute();
                                            $prodAttr->attribute_id = $attr->attribute_id;
                                            $prodAttr->product_id = $product->id;
                                            $prodAttr->value = $value{$attr->attribute_id};
                                            $prodAttr->save();
                                        }
                                    }
                                }
                                /***/
                                        if(isset($value->width) && $value->width!='')
                                        {
                                            $attr = AttributeTranslation::where('name',"Width")->first();
                                            if($attr){
                                                $prodAttr = ProductAttribute::where('product_id',$product->id)->where('attribute_id',$attr->attribute_id)->first();
                                                if($prodAttr){
                                                    $prodAttr->value =$value->width;
                                                    $prodAttr->save();
                                                }
                                                else{
                                                    $prodAttr = new ProductAttribute();
                                                    $prodAttr->attribute_id =$attr->attribute_id;
                                                    $prodAttr->product_id =$product->id;
                                                    $prodAttr->value =$value->width;
                                                    $prodAttr->save();
                                                }
                                            }
                                        }
                                        if (isset($value->product_image) && $value->product_image != "")
                                        {
                                            $dir =  base_path().'/storage/app/public/product/image';
                                            $dir1 =  base_path().'/storage/app/public/product/product_images';
                                            $image =trim($value->product_image);
                                            $arr = explode('/',$image);
                                            $fileName =end($arr);
                                            $file=null;
                                            $status = $this->is_url_exist($image);
                                            if($status){
                                                $file =file_get_contents($image);
                                            }
                                            if (!is_dir(base_path().'/storage/app/public/product/image'))
                                            {
//                                    Storage::makeDirectory('app/public/product/image');
                                                mkdir(base_path().'/storage/app/public/product/image', 0777, true);
                                            }
                                            if (!is_dir(base_path().'/storage/app/public/product/image/thumbnail'))
                                            {
                                                mkdir(base_path().'/storage/app/public/product/image/thumbnail', 0777, true);
                                            }
                                            if (!is_dir(base_path().'/storage/app/public/product/product_images'))
                                            {
//                                    Storage::makeDirectory('app/public/product/image');
                                                mkdir(base_path().'/storage/app/public/product/product_images', 0777, true);
                                            }
                                            if (!is_dir(base_path().'/storage/app/public/product/product_images/thumbnails'))
                                            {
                                                mkdir(base_path().'/storage/app/public/product/product_images/thumbnails', 0777, true);
                                            }

                                            if($file){
                                                $chkprodImgs = ProductImage::where('product_id',$product->id)->where('color',trim($product_description->color))->first();
                                                if(!$chkprodImgs)
                                                {
                                                    $chkprodImgs = new ProductImage();
                                                    $chkprodImgs->product_id = $product->id;
                                                    $chkprodImgs->color = isset($product_description->color)?trim($product_description->color):'';
                                                    $chkprodImgs->save();
                                                }
                                                $objProdClrImg = new ProductColorImage();
                                                $objProdClrImg->product_image_id = $chkprodImgs->id;
                                                $objProdClrImg->product_id = $product->id;
                                                $extension = explode('.',$fileName);
                                                $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
//                                        Storage::put('app/public/product/image/' . $file_name,$file);
                                                $status= file_put_contents($dir.'/'.$file_name, $file);
                                                if($status)
                                                {
                                                    $status1 =file_put_contents($dir1.'/'.$file_name,$file);
                                                    if($status1)
                                                    {
                                                        if(file_exists(base_path().'/storage/app/public/product/product_images/' . $file_name))
                                                        {
                                                            $thumbnail = Image::make(base_path().'/storage/app/public/product/product_images/' . $file_name);
                                                            $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                            $thumbnail->save(base_path().'/storage/app/public/product/product_images/thumbnails/' . $file_name);
                                                        }
                                                        $objProdClrImg->image = $file_name;
                                                        $objProdClrImg->save();
                                                    }
                                                    // $dir1
                                                    if(file_exists(base_path().'/storage/app/public/product/image/' . $file_name))
                                                    {
                                                        $thumbnail = Image::make(base_path().'/storage/app/public/product/image/' . $file_name);
                                                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                        $thumbnail->save(base_path().'/storage/app/public/product/image/thumbnail/' . $file_name);
                                                    }
                                                    $product_description->image = $file_name;

                                                }
                                            }
                                        }

//                                        if (isset($value->product_image) && $value->product_image != "")
//                                        {
//                                            $dir = base_path().'/storage/app/public/product/image';
//                                            if (!is_dir(base_path().'/storage/app/public/product/image'))
//                                            {
////                                                Storage::makeDirectory('app/public/product/image');
//                                                mkdir(base_path().'/storage/app/public/product/image', 0777, true);
//                                            }
//                                            if (!is_dir(base_path().'/storage/app/public/product/image/thumbnail'))
//                                            {
////                                                Storage::makeDirectory('app/public/product/image/thumbnail');
//                                                mkdir(base_path('/storage/app/public/product/image/thumbnail'), 0777, true);
//                                            }
//                                            $image =trim($value->product_image);
//                                            $arr = explode('/',$image);
//                                            $fileName =end($arr);
//                                            $status = $this->is_url_exist($image);
//                                            $file =null;
//                                            if($status){
//                                                $file =file_get_contents($image);
//                                            }
//                                            if($file){
//                                                $obj = new ProductImage();
//                                                $obj->product_id = $product->id;
//                                                $obj->color = $product_description->color;
//                                                $obj->save();
//                                                $objProdClrImgs = new ProductColorImage();
//                                                $objProdClrImgs->product_id = $product->id;
//                                                $objProdClrImgs->product_image_id = $obj->id;
//                                                $extension = explode('.',$fileName);
//                                                $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
////                                                Storage::put(base_path().'/storage/app/public/product/image/' . $file_name,$file);
////                                                $file->move(base_path() . '/storage/app/public/product/image/', $file_name);
//                                                $status = file_put_contents($dir.'/'.$file_name, $file);
//                                                if($status)
//                                                {
//                                                    if(file_exists(base_path().'/storage/app/public/product/image/' . $file_name))
//                                                    {
//                                                        $thumbnail = Image::make(base_path().'/storage/app/public/product/image/' . $file_name);
//                                                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//                                                        $thumbnail->save(base_path().'/storage/app/public/product/image/thumbnail/' . $file_name);
//                                                    }
//                                                    $product_description->image = $file_name;
//                                                    $objProdClrImgs->image = $file_name;
//                                                    $objProdClrImgs->save();
//                                                }
//
//                                            }
//                                        }

                                        if(isset($value->product_multiple_image) && $value->product_multiple_image !='')
                                        {
                                            $dir = base_path().'/storage/app/public/product/product_images';
                                            $thumbdir = base_path().'/storage/app/public/product/product_images/thumbnails';
                                            if (!is_dir(base_path().'/storage/app/public/product/product_images')) {
//                                                Storage::makeDirectory('app/public/product/product_images');
                                                mkdir(base_path().'/storage/app/public/product/product_images', 0777, true);
                                            }
                                            if (!is_dir(base_path().'/storage/app/public/product/product_images/thumbnails')) {
//                                                Storage::makeDirectory('app/public/product/product_images/thumbnails');
                                                mkdir(base_path().'/storage/app/public/product/product_images//thumbnails', 0777, true);
                                            }
                                            $productImgs = ProductImage::where('product_id',$product->id)->where('color',trim($product_description->color))->first();
                                            if(!$productImgs)
                                            {
                                                $productImgs = new ProductImage();
                                                $productImgs->product_id = $product->id;
                                                $productImgs->color=isset($product_description->color)?trim($product_description->color):'';
                                                $productImgs->save();
                                            }
                                            $allImgs = trim($value->product_multiple_image);
                                            if( strpos($allImgs, ',') !== false )
                                            {
                                                $arrImgs = explode(',',$allImgs);
                                                foreach ($arrImgs as $img){
                                                    $prodClrImgs = new ProductColorImage();
                                                    $prodClrImgs->product_id = $product->id;
                                                    $prodClrImgs->product_image_id = $productImgs->id;
                                                    $image =$img;
                                                    $arr = explode('/',$image);
                                                    $fileName =end($arr);
                                                    $status = $this->is_url_exist($image);
                                                    $file =null;
                                                    if($status){
                                                        $file =file_get_contents($image);
                                                    }
                                                    if($file){
                                                        $extension = explode('.',$fileName);
                                                        $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
//                                                        Storage::put(base_path().'/storage/app/public/product/product_images/' . $file_name,$file);
                                                        $status = file_put_contents($dir.'/'.$file_name, $file);
                                                        if($status)
                                                        {
                                                            if(file_exists(base_path().'/storage/app/public/product/product_images/' . $file_name))
                                                            {
                                                                $thumbnail = Image::make(base_path().'/storage/app/public/product/product_images/' . $file_name);
                                                                $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                                $thumbnail->save(base_path().'/storage/app/public/product/product_images/thumbnails/' . $file_name);

                                                            }
                                                            $prodClrImgs->image = $file_name;
                                                            $prodClrImgs->save();
                                                        }
                                                    }
                                                }
                                            }
                                            else{
                                                $prodClrImgs = new ProductColorImage();
                                                $prodClrImgs->product_id = $product->id;
                                                $prodClrImgs->product_image_id = $productImgs->id;
                                                $image =$allImgs;
                                                $arr = explode('/',$image);
                                                $fileName =end($arr);
                                                $status = $this->is_url_exist($image);
                                                $file =null;
                                                if($status){
                                                    $file =file_get_contents($image);
                                                }
                                                if($file){
                                                    $extension = explode('.',$fileName);
                                                    $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
//                                                    Storage::put(base_path().'/storage/app/public/product/product_images/' . $file_name,$file);
                                                  $status = file_put_contents($dir.'/'.$file_name, $file);
//
                                                    if($status)
                                                    {
                                                        if(file_exists(base_path().'/storage/app/public/product/product_images/' . $file_name))
                                                        {
                                                            $thumbnail = Image::make(base_path().'/storage/app/public/product/product_images/' . $file_name);
                                                            $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                                            $thumbnail->save(base_path().'/storage/app/public/product/product_images/thumbnails/' . $file_name);

                                                        }
                                                        $prodClrImgs->image = $file_name;
                                                        $prodClrImgs->save();
                                                    }

                                                }
                                            }
                                        }


                                        if (isset($value->product_video) && count($value->product_video)>0)
                                        {
                                            $dir = base_path().'/storage/app/public/product/video';

                                            if (!is_dir(base_path().'/storage/app/public/product/video')) {
//                                                Storage::makeDirectory('app/public/product/video');
                                                mkdir(base_path().'/storage/app/public/product/video', 0777, true);
                                            }
                                            $image =trim($value->product_video);
                                            $arr = explode('/',$image);
                                            $fileName =end($arr);
                                            $file=null;
                                            $extension = explode('.',$fileName);
                                            $status = $this->is_url_exist($image);
                                            if($status){
                                                $file =file_get_contents($value->product_video);
                                            }
                                            if($file){
                                                $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
                                               $status = file_put_contents($dir.'/'.$file_name, $file);
                                                if($status)
                                                {
                                                    $product_description->video = $file_name;
                                                }
                                            }
                                        }
    
                                        $arr6[] = (['name' => $value->name, 'category' => $value->category_id, 'quantity' => $value->quantity]);

                                            $product_description->save();
                                    } else if ($category == "") {

                                        $arr3[] = (['name' => $value->name, 'category' => $value->category_id, 'quantity' => $value->quantity]);
//                                               
//                                               continue;
                                    }

                                }
                            }
                        }
                    }
                    else if($category==""){
                        $arr1[] = (['name' => $value->name, 'category' => $value->category_id, 'quantity' => $value->quantity]);
                        continue;
                    }
                    }
//                    dd($arr1[]);
                    $msg="";
                    $msg1="";
                    $msg2="";
                    $msg3="";
                    
//                    $space="<br>";
                    if(isset($arr1) && $arr1!=""){
                        
//                        $msg="Sorry! Failed to add product to inventory.";
//                        foreach($arr as $key=>$val){
//                    $msg.=$space."Category:' ".$val['category']." ' does not exist.";
//                    $msg.=$space."Failed to add product ' ".$val['name']." ' to inventory.";
//                    }
//                        dd($arr1);
                        foreach($arr1 as $key=>$val){
                            if($val['category']!="" && $val['name']!=""){
//                    $msg.="Sorry! The category you have entered ' ".$val['category']." ' does not exist.Failed to add product ' ".$val['name']." ' to inventory.";
                    $msg1.="<br>"."Category : ' ".$val['category']." ' does not exist. so failed to add Product : ' ".$val['name']."' to inventory. ".'\r\n';
                            }
                    
                        }
//                    dd($msg);
                    }
                    else{
                        $msg.="Product imported successfully";
                    }
                    if(isset($arr5) && $arr5!=""){
                        foreach($arr5 as $key=>$val){
                            if($val['category']!="" && $val['name']!=""){
//                    $msg.="The product ' ".$val['name']. " ' with category' ".$val['category']." ' updated to inventory successfully!";
                       $msg2.="\n Product : ' ".$val['name']. " ' of Category : ' ".$val['category']." ' updated successfully ! ";
                 
                    }
                    }
                    }
                    if(isset($arr6) && $arr6!=""){
                        foreach($arr6 as $key=>$val){
                            if($val['category']!="" && $val['name']!=""){
//                    $msg.="The product ' ".$val['name']. " ' with category' ".$val['category']." ' added to inventory successfully!";
                    $msg3.="\n Product: ' ".$val['name']. " 'of Category' ".$val['category']." ' added to inventory successfully ! ";
                            }
                    
                        }
                    }
                    \Session::flash('status1',$msg1);
                    \Session::flash('alert-class', 'alert-danger');
                
                    \Session::flash('status2',$msg2);
                    \Session::flash('alert-class', 'alert-success');
            
                    \Session::flash('status3',$msg3);
                    \Session::flash('alert-class', 'alert-success');
            
                    return redirect(url('/admin/inventory-list'))->with('status',$msg)->with('status1',$msg1)->with('status2',$msg2)->with('status3',$msg3);
                }
            }

            return back();
        }
    }

   private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    public function uploadMediaImages($request, $mediaName)
    {
        $images = array();
        $dir = base_path().'/storage/app/public/bulk-upload/media-upload/videos';
        if (!is_dir(base_path().'/storage/app/public/bulk-upload/media-upload/images'))
        {
            mkdir(base_path().'/storage/app/public/bulk-upload/media-upload/images', 0777, true);
        }
        if ($request->hasFile($mediaName)) {
            $uploaded_images = $request->file($mediaName);
            foreach ($uploaded_images as $uploaded_image) {
                $extension = $uploaded_image->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
               $file =file_get_contents($uploaded_image->getRealPath());
               if($file)
               {
                   file_put_contents($dir.'/'.$new_file_name, $file);
               }
//                Storage::put('public/bulk-upload/media-upload/images/' . $new_file_name, file_get_contents($uploaded_image->getRealPath()));
            }
        }
        return 0;
    }
    public function uploadMediaVideos($request, $mediaName) {
        $images = array();
        $dir = base_path().'/storage/app/public/bulk-upload/media-upload/videos';
        if (!is_dir(base_path().'/storage/app/public/bulk-upload/media-upload/videos'))
        {
            mkdir(base_path().'/storage/app/public/bulk-upload/media-upload/videos', 0777, true);
        }
        /***
        if (isset($value->product_video) && count($value->product_video)>0)
        {
        $dir = base_path().'/storage/app/public/product/video';
        if (!is_dir(base_path().'/storage/app/public/product/video'))
        {
        mkdir(base_path().'/storage/app/public/product/video', 0777, true);
        }
        $image =trim($value->product_video);
        $arr = explode('/',$image);
        $fileName =end($arr);
        $file =null;
        $status = $this->is_url_exist($image);
        if($status){
        $file =file_get_contents($image);
        }
        $extension = explode('.',$fileName);
        if($file){
        $file_name = str_replace(".", "-", microtime(true)) . "." . $extension[1];
        $status = file_put_contents($dir.'/'.$file_name, $file);
        if($status)
        {
        $desc->video = $file_name;
        }
        }

        }
         */
        if ($request->hasFile($mediaName)) {
            $uploaded_images = $request->file($mediaName);
            foreach ($uploaded_images as $uploaded_image) {
                $extension = $uploaded_image->getClientOriginalExtension();
                $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//                if (!is_dir(storage_path('app/public/bulk-upload/media-upload/videos'))) {
//                    Storage::makeDirectory('public/bulk-upload/media-upload/videos', 0777, true);
//                }
                $file = file_get_contents($uploaded_image->getRealPath());
                if($file)
                {
                    file_put_contents($dir.'/'.$new_file_name, $file);
                }
//                Storage::put('public/bulk-upload/media-upload/videos/' . $new_file_name, );
            }
        }
        return 0;
    }

    public function uploadBulkProduct(Request $request)
    {
        $imageStatus = "";
        $videoStatus = "";
        if ($request->allFiles()) {
            if ($request->hasFile('bulk_images')) {
                $this->uploadMediaImages($request, 'bulk_images');
                $imageStatus = "Your Images are successfully uploaded.";
            }

            if ($request->hasFile('bulk_videos')) {
                $this->uploadMediaVideos($request, 'bulk_videos');
                $videoStatus = "Your Videos are successfully uploaded.";
            }
        }
        return redirect('/admin/inventory-list')->with('status', $imageStatus)->with('status1', $videoStatus);
    }

    public function goToBulkProductListData(Request $request, $type)
    {
        $dir ='';
        $fileArr = array();
        if(isset($type) && $type == 0){
            $dir = storage_path('app/public/bulk-upload/media-upload/images/');
        }
        elseif (isset($type) && $type ==1)
        {
            $dir = storage_path('app/public/bulk-upload/media-upload/videos/');
        }

        $files = scandir($dir);
        if (isset($files) && count($files) > 0) {
          foreach ($files as $file){
                  if($file != '.' && $file !='..')
                    $fileArr[] = $file;
          }

        }
        $object = json_decode(json_encode($fileArr), FALSE);
        return Datatables::of($object)
            ->addColumn('name', function($object) {
                return stripslashes($object);
            })
            ->make(true);
    }

    public function goToBulkProductList(Request $request, $type)
    {
        $dir ='';
        $fileArr = array();
        if(isset($type) && $type == 0){
            $dir = storage_path('app/public/bulk-upload/media-upload/images/');
        }
        elseif (isset($type) && $type ==1)
        {
            $dir = storage_path('app/public/bulk-upload/media-upload/videos/');
        }

        $files = scandir($dir);
        if (isset($files) && count($files) > 0) {
            foreach ($files as $file){
                if($file != '.' && $file !='..')
                    $fileArr[] = $file;
            }
        }
        $object = json_decode(json_encode($fileArr), FALSE);
//        $cnt = count($object);
//        if($cnt % 10 !=0)
//        {
//            $cnt =intval($cnt/10)+1;
//        }
//        else{
//            $cnt =intval($cnt/10);
//        }
//        $object = collect($object)->paginate(10);

        return view('inventory::list-inventory-product-media',compact('object','cnt'));
    }

    public function listInventoryProductMedia() {
        $all_products = Product::all();
        $all_products = $all_products->sortBy('id');

        return Datatables::of($all_products)
            ->addColumn('name', function($product) {
                return stripslashes($product->name);
            })
            ->make(true);
    }
    public function removeBulkProductMedia(Request $request,$type,$img)
    {
        if(isset($type) && $type == 0){
            $fileDestinationPath = storage_path('app/public/bulk-upload/media-upload/images/') . $img;
            if(file_exists($fileDestinationPath)){
                unlink($fileDestinationPath);
             }
        }
        else if(isset($type) && $type == 1){
            $fileDestinationPath = storage_path('app/public/bulk-upload/media-upload/videos/') . $img;
            if(file_exists($fileDestinationPath)){
                unlink($fileDestinationPath);
            }
        }
       return redirect('/admin/inventory/show-product-media/'.$type)->with('status','File Deleted successfully');
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
