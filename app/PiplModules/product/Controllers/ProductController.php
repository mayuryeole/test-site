<?php

namespace App\PiplModules\product\Controllers;

use App\PiplModules\admin\Models\Country;
use App\PiplModules\category\Models\CategoryAttributeValue;
use App\PiplModules\product\Models\Color;
use App\PiplModules\product\Models\ProductColorImage;
use App\PiplModules\product\Models\ProductCountry;
use App\PiplModules\rivaah\Models\RivaahGallery;
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
use App\PiplModules\product\Models\ProductColor;
use Intervention\Image\Exception\NotReadableException;

class ProductController extends Controller
{
    private $thumbnail_size = array("width" => 240, "height" => 240);

    public function listProducts(Request $request) {
        if ($request->ajax()) {
            $all_products = Product::FilterProductByInStock()->FilterByCategory()->get();
            $all_products = $all_products->sortBy('id');

            return Datatables::of($all_products)
                            ->addColumn('name', function($product) {
                                if(isset($product->name) && $product->name!='')
                                {
                                    return stripslashes($product->name);
                                }
                                else{
                                    return '-';
                                }

                            })
                            ->addColumn('sku', function($product) {
                                if(!empty($product->productDescription->sku))
                                return stripslashes($product->productDescription->sku);
                            })
                            ->addColumn('category_name', function($product) {

                                if (isset($product->productDescription->category->name) && $product->productDescription->category->name != "") {
//                                dd($product->productDescription);
                                    return $product->productDescription->category->name;
                                } else {
                                    return "-";
                                }
                            })
                            ->addColumn('availability', function($product) {

                                if (isset($product->productDescription->availability)) {
//                                dd($product->productDescription);
                                    if ($product->productDescription->availability == 0) {
                                        return "<button class='btn btn-sm btn-success'>In Stock</button>";
                                    } else if ($product->productDescription->availability == 1) {
                                        return "<button class='btn btn-sm btn-danger'>Out of Stock</button>";
                                    }
                                } else {
                                    return "-";
                                }
                            })
                            ->make(true);
        } else {
            $all_products = Product::all();
            $category=  CategoryTranslation::all();
            $full = $request->fullUrl();
            //dd($full);
            return view('product::list-products', array('category'=>$category,'products' => $all_products, 'full' => $full));
        }
    }

    public function listProductsData()
    {
//        dd($avail);
        $all_products = Product::FilterProductByInStock()->get();
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
                        ->addColumn('availability', function($product) {

                            if (isset($product->productDescription->availability)) {
//                                dd($product->productDescription);
                                if ($product->productDescription->availability == 0) {
                                    return "<button class='btn btn-sm btn-success'>In Stock</button>";
                                } else if ($product->productDescription->availability == 1) {
                                    return "<button class='btn btn-sm btn-danger'>Out of Stock</button>";
                                }
                            } else {
                                return "-";
                            }
                        })
                        ->make(true);
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

    public function createProducts(Request $request)
    {
        if ($request->method() == "GET") {
            $all_users = UserInformation::where('user_type', '!=', 1)->get();
            $all_category = Category::all();
            $all_countries = Country::translatedIn(\App::getLocale())->get();
            $all_styles = Style::get();
            $all_collection_style = CollectionStyle::get();
            $all_occasion = Occasion::get();
            $rivaah_gal = RivaahGallery::all();
            $colors = Color::all();
//            dd($all_category);
            //12jan18
            $existing_categories = Category::withTranslation()->get();
//            dd($existing_categories);
//            $cat=$existing_categories->toTree();
//            dd($cat);
            $tree = $this->getCategoryTree($existing_categories->toTree(), '&nbsp;&nbsp;');
//            dd($tree);
//            $tree = $this->getCategoryTree($cat, '&nbsp;&nbsp;');
//            dd($tree);
            //
            
            return view("product::create-product", array('tree'=>$tree,'occasion' => $all_occasion, 'all_category' => $all_category, 'all_users' => $all_users, 'style' => $all_styles, 'collection_style' => $all_collection_style, 'rivaah_gal' => $rivaah_gal, 'colors' => $colors,'countries'=>$all_countries));
        }
        else if ($request->method() == "POST")
        {
            $data = $request->all();
            $data['product_name']=strtolower(trim($data['product_name']));
            $validate_response = Validator::make($data, array(
                        'product_name' => 'required|unique:products,name',
                        'photo' => 'max:5120|mimes:jpg,jpeg,gif,png'
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                // dd(2343);
                // dd($request->all());

//                dd($category);
                $created_product = new Product();
                $created_product->name = trim($request->product_name);
                if (isset($request->category) && $request->category != '') {
                    $category = Category::find($request->category);
                    if (isset($category) && count($category) > 0) {
                        $created_product->category_id = trim($request->category);
                        $created_product->save();
                        if (count($category->categoryAttribute) > 0) {

                            foreach ($category->categoryAttribute as $attr) {
                                $catAttrVal = CategoryAttributeValue::where('category_attribute_id', $attr->id)->get();
                                if (count($catAttrVal) > 0) {
                                    foreach ($catAttrVal as $val) {
                                        $proAttr = new ProductAttribute();
                                        $proAttr->product_id = $created_product->id;
                                        $proAttr->attribute_id = $attr->attribute_id;
                                        $proAttr->value = $val->value;
                                        $proAttr->save();
                                    }
                                } else {
                                    $proAttr = new ProductAttribute();
                                    $proAttr->product_id = $created_product->id;
                                    $proAttr->attribute_id = $attr->attribute_id;
                                    $proAttr->save();
                                }
                            }
                        }
                    }
                }

                $translated_product = new ProductDescription();
                $translated_product->product_id = isset($created_product->id) ? $created_product->id : '';
                $translated_product->category_id = isset($request->category) ? $request->category : "";
                $translated_product->created_by = Auth::user()->id;
//                $translated_product->sku = $this->generateReferenceNumber();
                $translated_product->sku = isset($request->product_sku) ? $request->product_sku : '';

                $translated_product->price = isset($request->price) ? $request->price : 0;
                $translated_product->quantity = isset($request->quantity) ? $request->quantity : 0;
                $translated_product->max_order_qty = isset($request->order_quantity) ? $request->order_quantity : 0;
                $translated_product->style = isset($request->style) ? $request->style : '';
                $translated_product->collection_style = isset($request->collection_style) ? $request->collection_style : '';
                $translated_product->occasion = isset($request->occasion) ? $request->occasion : '';
                $translated_product->is_featured = isset($request->is_featured) ? $request->is_featured : '0';
                $translated_product->status = isset($request->status) ? $request->status : '0';
                $translated_product->availability = isset($request->is_available) ? $request->is_available : '0';
                $translated_product->pre_order = isset($request->pre_order) ? $request->pre_order : '0';
                $translated_product->launched_date = isset($request->launched_date) ? $request->launched_date : '';
//                $translated_product->short_description=$request->short_description;
                $translated_product->description = isset($request->description) ? $request->description : '';
                if ($request->hide_product != "") {
                    $translated_product->hide_product = $request->hide_product;
                }
                if ($request->hide_product_price != "") {
                    $translated_product->hide_product_price = $request->hide_product_price;
                }

                if (isset($request->productCountry) && $request->productCountry != '') {
                    $productCountry = $request->productCountry;
                    foreach ($productCountry as $key => $c) {
                        //dd()
                        $product_contry = new ProductCountry();
                        $product_contry->product_id = $created_product->id;
                        $product_contry->country_id = $c;
                        $product_contry->save();
                    }
                }


                if (isset($request->rivaah) && $request->rivaah != "") {
                    $rivaah = $request->rivaah;
                    foreach ($rivaah as $key => $c) {
                        $rivaah_product = new RivaahProduct();
                        $riv_gal = RivaahGallery::where('name', $c)->first();
                        if (isset($riv_gal) && count($riv_gal) > 0) {
                            $rivaah_product->product_id = $created_product->id;
                            $rivaah_product->rivaah_id = $riv_gal->id;
                            $rivaah_product->save();
                        }
                    }
                }
                if (isset($request->productColor) && $request->productColor != '') {
                    $translated_product->color = $request->productColor[0];
                }


                if (isset($request->color) && count($request->color) > 0) {
                    $color = $request->color;
                    foreach ($color as $key => $c) {
                        $product_color = new ProductColor();
                        $product_color->product_id = $created_product->id;
                        $product_color->color = $c;
                        $product_color->save();
                    }
                }

                if (isset($request->style) && $request->style != "") {
                    $product_style = new ProductStyle();
                    $product_style->product_id = $created_product->id;
                    $product_style->style_id = $request->style;
                    $product_style->save();
                }

                if (isset($request->collection_style) && $request->collection_style != "") {
                    $product_collection_style = new ProductCollectionStyle();
                    $product_collection_style->product_id = $created_product->id;
                    $product_collection_style->collection_style_id = $request->collection_style;
                    $product_collection_style->save();
                }

                $translated_product->save();

//                if ($request->hasFile('photo'))
//                {
//                    $extension = $request->file('photo')->getClientOriginalExtension();
//                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//
//                    Storage::put('app/public/product/image/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));
//
//                    if (!is_dir(storage_path('app/public/product/image/thumbnail/'))) {
//                        Storage::makeDirectory('app/public/product/image/thumbnail/');
//                    }
//
//                    $thumbnail = Image::make(storage_path('app/public/product/image/' . $new_file_name));
//                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//                    $thumbnail->save(storage_path('app/public/product/image/thumbnail/' . $new_file_name));
//
//                    $translated_product->image = $new_file_name;
//                }
//                if ($request->file('product_clip'))
//                {
//                    $extension = $request->file('product_clip')->getClientOriginalExtension();
//                    $file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//
//                    Storage::put('app/public/product/video/' . $file_name, file_get_contents($request->file('product_clip')->getRealPath()));
//
//                    $translated_product->video = $file_name;
//                }

                if ($request->hasFile('photo'))
                {    $color = '';
                    $dir = base_path()."/storage/app/public/product/image";
                    $dir1 = base_path()."/storage/app/public/product/product_images";


                    if (isset($request->productColor) && $request->productColor != '') {
                        $color = trim($request->productColor[0]);
                    }
                    if (!is_dir(storage_path('app/public/product/image'))) {
                        mkdir(storage_path('app/public/product/image'), 0777, true);
                    }
                    if (!is_dir(storage_path('app/public/product/image/thumbnail'))) {
                    mkdir(storage_path('app/public/product/image/thumbnail'), 0777, true);
                    }

                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                    $file = Storage::put(base_path() .'/storage/app/public/product/product_images/'. $new_file_name, file_get_contents($uploaded_image->getRealPath()));
                    $status = file_put_contents($dir.'/'.$new_file_name,file_get_contents($request->file('photo')->getRealPath())) ;
//                    $status =$request->file('photo')->move(base_path() . '/storage/app/public/product/image/', $new_file_name);

                    if($status)
                    {
                        if (file_exists(base_path() . '/storage/app/public/product/image/' . $new_file_name)) {
                            $thumbnail = Image::make(base_path() . '/storage/app/public/product/image/' . $new_file_name);
                            $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                            $thumbnail->save(base_path() . '/storage/app/public/product/image/thumbnail/' . $new_file_name);
                        }
                        $translated_product->image = $new_file_name;
                    }
                    if($color != '')
                    {
                        $prodImgs = ProductImage::where('product_id',$created_product->id)->where('color',$color)->first();
                        if(!$prodImgs)
                        {
                            $prodImgs =new ProductImage();
                            $prodImgs->product_id =$created_product->id;
                            $prodImgs->color =$color;
                            $prodImgs->save();
                        }
                        $prodColrImgs = ProductColorImage::where('product_id',$created_product->id)->where('product_image_id',$prodImgs)->first();

                        if (!is_dir(storage_path('app/public/product/product_images'))) {
                            mkdir(storage_path('app/public/product/product_images'), 0777, true);
                        }
                        if (!is_dir(storage_path('app/public/product/product_images/thumbnails'))) {
                            mkdir(storage_path('app/public/product/product_images/thumbnails'), 0777, true);
                        }
//                        $status1 =$request->file('photo')->move(base_path() . '/storage/app/public/product/product_images/', $new_file_name);
                        $status1 = file_put_contents($dir1.'/'.$new_file_name,file_get_contents($request->file('photo')->getRealPath())) ;
                        if($status1)
                        {
                            if (file_exists(base_path() . '/storage/app/public/product/product_images/' . $new_file_name)) {
                                $thumbnail = Image::make(base_path() . '/storage/app/public/product/product_images/' . $new_file_name);
                                $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                $thumbnail->save(base_path() . '/storage/app/public/product/product_images/thumbnails/' . $new_file_name);
                            }
                            if(!$prodColrImgs)
                            {
                                $prodColrImgs =new ProductColorImage();
                                $prodColrImgs->product_id =$created_product->id;
                                $prodColrImgs->product_image_id =$prodImgs->id;
                            }
                            $prodColrImgs->image=$new_file_name;
                            $prodColrImgs->save();
                        }
                    }
                }

                if ($request->hasFile('product_clip'))
                {
                    $dir = base_path().'/'.'storage/app/public/product/video';
                    if (!is_dir(storage_path('app/public/product/video')))
                    {
                        mkdir(storage_path('app/public/product/video'), 0777, true);
                    }
                    $extension = $request->file('product_clip')->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                    $file = Storage::put(base_path() .'/storage/app/public/product/product_images/'. $new_file_name, file_get_contents($uploaded_image->getRealPath()));

//                    $request->file('product_clip')->move(base_path() . '/storage/app/public/product/video/', $new_file_name);
                    $status = file_put_contents($dir.'/'.$new_file_name,file_get_contents($request->file('photo')->getRealPath())) ;
                    if($status)
                    {
                        $translated_product->video = $new_file_name;
                    }

                }




//                if ($request->hasFile('photo'))
//                {
//                    $extension = $request->file('photo')->getClientOriginalExtension();
//                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//
//                    Storage::put('app/public/product/image/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));
//
//                    if (!is_dir(storage_path('app/public/product/image/thumbnail'))) {
//                        Storage::makeDirectory('public/product/image/thumbnail');
//                    }
//                    $thumbnail = Image::make(storage_path('app/public/product/image/' . $new_file_name));
//                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//                    $thumbnail->save(storage_path('app/public/product/image/thumbnail/' . $new_file_name));
//
//                    $translated_product->image = $new_file_name;
//                }
//                if ($request->file('product_clip'))
//                {
//                    $extension = $request->file('product_clip')->getClientOriginalExtension();
//                    $file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//
//                    if (!is_dir(storage_path('app/public/product/video'))) {
//                        Storage::makeDirectory('public/product/video');
//                    }
//                    Storage::put('public/product/video/' . $file_name, file_get_contents($request->file('product_clip')->getRealPath()));
//                    $translated_product->video = $file_name;
//                }
                $translated_product->save();
                return redirect("admin/products-list/?stock=&category=")->with('status', 'Product created successfully!');
            }
        }
    }

    public function updateProduct(Request $request, $product_id) {

        $product = Product::find($product_id);
        if (isset($product) && count($product)>0)
        {
            $product_description = $product->productDescription;

            $product_image = $product->productImages()->get();

            $product_style = ProductStyle::where('product_id', $product_id)->first();

            $style = Style::all();

            $collection_style = CollectionStyle::all();
            $product_collection_style = ProductCollectionStyle::where('product_id', $product_id)->first();

            $occasion = Occasion::get();
            $colors = Color::all();
            $existing_categories = Category::withTranslation()->get();
//            dd($existing_categories);
//            $cat=$existing_categories->toTree();
//            dd($cat);
            $tree = $this->getCategoryTree($existing_categories->toTree(), '&nbsp;&nbsp;');
            $product_occasion = ProductOccasion::where('product_id', $product_id)->first();

            $all_category = CategoryTranslation::all();
            $rivaah_gal = RivaahGallery::all();
            $rivaah_product = RivaahProduct::where('product_id', $product->id)->get();
            $rivaah_product = array_values($rivaah_product->toArray());
            $rivaah_product = array_column($rivaah_product, 'rivaah_id');

            $product_color = ProductColor::where('product_id', $product->id)->get();
            $product_color = array_values($product_color->toArray());
            $product_color = array_column($product_color, 'color');
            $all_countries = Country::translatedIn(\App::getLocale())->get();
            $productCountry = ProductCountry::where('product_id',$product->id)->get();
            $productArr = [];
            if(isset($productCountry) && count($productCountry)>0){
                foreach ($productCountry as $key=>$val){
                     array_push($productArr,$val->country_id);
                }
            }
            if ($request->method() == "GET") {
                return view("product::update-product", array('tree'=>$tree,'colors' => $colors, 'occasion' => $occasion, 'product_occasion' => $product_occasion, 'style' => $style, 'collection_style' => $collection_style, 'product_style' => $product_style, 'product_collection_style' => $product_collection_style, 'category' => $all_category, 'product' => $product, 'product_image' => $product_image, 'product_description' => $product_description, 'rivaah_gal' => $rivaah_gal, 'rivaah_product' => $rivaah_product, 'product_color' => $product_color,'countries'=>$all_countries,'product_country'=>$productArr));
            } else if ($request->method() == "POST")
            {

                $data = $request->all();
                $data['product_name']=strtolower(trim($data['product_name']));
                $validate_response = Validator::make($data, array(
                            'product_name' => 'required|unique:products,name,' . $product->id,
                            'photo' => 'max:5120|mimes:jpg,jpeg,gif,png'
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    if (isset($request->product_name) && $request->product_name != "") {
                        $product->name = $request->product_name;
                    }
                    if (isset($request->category) && $request->category != "") {
                        $product->category_id = $request->category;
                    }
                    $product->save();
                    $product_description = ProductDescription::where('product_id', $product->id)->first();

                    if (isset($request->category) && $request->category != "") {
                        $product_description->category_id = $request->category;
                    }
                    if (isset($request->rivaah) && $request->rivaah != "") {
                        $rivaah = $request->rivaah;
                        $product_color = RivaahProduct::where('product_id', $product->id)->delete();
                        foreach ($rivaah as $key => $c) {
                            $rivaah_product = new RivaahProduct();
                            $riv_gal = RivaahGallery::where('name', $c)->first();
                            if (isset($riv_gal) && count($riv_gal) > 0) {
                                $rivaah_product->product_id = $product->id;
                                $rivaah_product->rivaah_id = $riv_gal->id;
                                $rivaah_product->save();
                            }
                        }
                    }
                    if(isset($request->product_sku) && $request->product_sku !=''){
                        $product_description->sku = trim($request->product_sku);
                    }

                    if(isset($request->productColor) && $request->productColor !='')
                    {
                        $product_description->color =trim($request->productColor[0]);
                    }

                    if (isset($request->color) && $request->color != "") {
                        $color = $request->color;
                        $product_color = ProductColor::where('product_id', $product->id)->delete();

                        foreach ($color as $key => $c) {
                            $product_color = new ProductColor();
                            $product_color->product_id = $product->id;
                            $product_color->color = $c;
                            $product_color->save();
                        }
                    }
                    if(isset($request->productCountry) && $request->productCountry!='')
                    {
                        $productCountry = $request->productCountry;
                        $product_cntry = ProductCountry::where('product_id', $product->id)->delete();
                        foreach ($productCountry as $key => $c) {
                            //dd()
                            $product_contry = new ProductCountry();
                            $product_contry->product_id = $product->id;
                            $product_contry->country_id = $c;
                            $product_contry->save();
                        }
                    }
                    if (isset($request->price) && $request->price != "") {
                        $product_description->price = $request->price;
                    }
                    if (isset($request->quantity) && $request->quantity != "") {
                        $product_description->quantity = $request->quantity;
                    }
                    if (isset($request->quantity) && $request->quantity != "") {
                        $product_description->max_order_qty = $request->order_quantity;
                    }

                    if (isset($request->style) && $request->style != "") {
                        $product_description->style = $request->style;
                    }
                    if (isset($request->collection_style) && $request->collection_style != "") {
                        $product_description->collection_style = $request->collection_style;
                    }
                    if (isset($request->occasion) && $request->occasion != "") {
                        $product_description->occasion = $request->occasion;
                    }
                    if (isset($request->is_featured) && $request->is_featured != "") {
                        $product_description->is_featured = $request->is_featured;
                    }
                    if (isset($request->status) && $request->status != "") {
                        $product_description->status = $request->status;
                    }
                    if (isset($request->is_available) && $request->is_available != "") {
                        $product_description->availability = $request->is_available;
                    }
                    if (isset($request->pre_order) && $request->pre_order != "") {
                        $product_description->pre_order = $request->pre_order;
                    }
                    if (isset($request->short_description) && $request->short_description != "") {
                        $product_description->short_description = $request->short_description;
                    }
                    if (isset($request->description) && $request->description != "") {
                        $product_description->description = $request->description;
                    }

                    if ($request->hide_product != "") {
                        $product_description->hide_product = $request->hide_product;
                    }
                    if ($request->hide_product_price != "") {
                        $product_description->hide_product_price = $request->hide_product_price;
                    }

                    if (isset($request->occasion) && $request->occasion != "") {
                        $product_occasion = ProductOccasion::where('product_id', $product_id)->first();
                        if ($product_occasion != "") {
                            $product_occasion->occasion_id = $request->occasion;
                            $product_occasion->save();
                        } else if ($product_occasion == "") {
                            $product_occasion = new ProductOccasion();
                            $product_occasion->product_id = $product_id;
                            $product_occasion->occasion_id = $request->occasion;
                            $product_occasion->save();
                        }
                    }

                    if (isset($request->style) && $request->style != "") {
                        $prostyle = ProductStyle::where('product_id', $product_id)->first();
                        if ($prostyle != "") {
                            $prostyle->style_id = $request->style;
                            $prostyle->save();
                        } else if ($prostyle == "") {
                            $prostyle = new ProductStyle();
                            $prostyle->product_id = $product_id;
                            $prostyle->style_id = $request->style;
                            $prostyle->save();
                        }
                    }

                    if (isset($request->collection_style) && $request->collection_style != "") {
                        $procollection_style = ProductCollectionStyle::where('product_id', $product_id)->first();
                        if ($procollection_style != "") {
                            $procollection_style->collection_style_id = $request->collection_style;
                            $procollection_style->save();
                        } else if ($procollection_style == "") {
                            $procollection_style = new ProductCollectionStyle();
                            $procollection_style->product_id = $product_id;
                            $procollection_style->collection_style_id = $request->collection_style;
                            $procollection_style->save();
                        }
                    }
                    if ($request->hasFile('photo'))
                    {
                        $dir = base_path().'/'.'storage/app/public/product/image';
                        $dir1 = base_path().'/'.'storage/app/public/product/product_images';
                        $color = '';
                        if (isset($request->productColor) && $request->productColor != '') {
                            $color = trim($request->productColor[0]);
                        }
                        if (!is_dir(storage_path('app/public/product/image'))) {
                            mkdir(storage_path('app/public/product/image'), 0777, true);
                        }
                        if (!is_dir(storage_path('app/public/product/image/thumbnail'))) {
                            mkdir(storage_path('app/public/product/image/thumbnail'), 0777, true);
                        }

                        $extension = $request->file('photo')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                    $file = Storage::put(base_path() .'/storage/app/public/product/product_images/'. $new_file_name, file_get_contents($uploaded_image->getRealPath()));
                        $status = file_put_contents($dir.'/'.$new_file_name,file_get_contents($request->file('photo')->getRealPath()));
//                        $status =$request->file('photo')->move(base_path() . '/storage/app/public/product/image/', $new_file_name);

                        if($status)
                        {
                            if (file_exists(base_path() . '/storage/app/public/product/image/' . $new_file_name)) {
                                $thumbnail = Image::make(base_path() . '/storage/app/public/product/image/' . $new_file_name);
                                $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                $thumbnail->save(base_path() . '/storage/app/public/product/image/thumbnail/' . $new_file_name);
                            }
                            $product_description->image = $new_file_name;
                        }
                        if(isset($color) && $color != '')
                        {
                            $prodImgs = ProductImage::where('product_id',$product->id)->where('color',$color)->first();
                            if(!$prodImgs)
                            {
                                $prodImgs =new ProductImage();
                                $prodImgs->product_id =$product->id;
                                $prodImgs->color =$color;
                                $prodImgs->save();
                            }
                            $prodColrImgs = ProductColorImage::where('product_id',$product->id)->where('product_image_id',$prodImgs)->first();

                            if (!is_dir(storage_path('app/public/product/product_images'))) {
                                mkdir(storage_path('app/public/product/product_images'), 0777, true);
                            }
                            if (!is_dir(storage_path('app/public/product/product_images/thumbnails'))) {
                                mkdir(storage_path('app/public/product/product_images/thumbnails'), 0777, true);
                            }
                            $status1 = file_put_contents($dir1.'/'.$new_file_name,file_get_contents($request->file('photo')->getRealPath()));
//                            $status1 =$request->file('photo')->move(base_path() . '/storage/app/public/product/product_images/', $new_file_name);
                            if($status1)
                            {
                                if (file_exists(base_path() . '/storage/app/public/product/product_images/' . $new_file_name)) {
                                    $thumbnail = Image::make(base_path() . '/storage/app/public/product/product_images/' . $new_file_name);
                                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                                    $thumbnail->save(base_path() . '/storage/app/public/product/product_images/thumbnails/' . $new_file_name);
                                }
                                if(!$prodColrImgs)
                                {
                                    $prodColrImgs =new ProductColorImage();
                                    $prodColrImgs->product_id =$product->id;
                                    $prodColrImgs->product_image_id =$prodImgs->id;
                                }
                                $prodColrImgs->image=$new_file_name;
                                $prodColrImgs->save();
                            }
                        }
                    }



                    /***
                    if ($request->hasFile('photo'))
                    {
                        if (!is_dir(storage_path('app/public/product/image'))) {
                            mkdir(storage_path('app/public/product/image'), 0777, true);
                        }
                        if (!is_dir(storage_path('app/public/product/image/thumbnail'))) {
                            mkdir(storage_path('app/public/product/image/thumbnail'), 0777, true);
                        }
                        $extension = $request->file('photo')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                    $file = Storage::put(base_path() .'/storage/app/public/product/product_images/'. $new_file_name, file_get_contents($uploaded_image->getRealPath()));

                        $request->file('photo')->move(base_path() . '/storage/app/public/product/image/', $new_file_name);

                        // make thumbnail
                        if (file_exists(base_path() . '/storage/app/public/product/image/' . $new_file_name)) {
                            $thumbnail = Image::make(base_path() . '/storage/app/public/product/image/' . $new_file_name);
                            $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                            $thumbnail->save(base_path() . '/storage/app/public/product/image/thumbnail/' . $new_file_name);
                        }
                        $product_description->image = $new_file_name;
                    }
                     * ***/

                    if ($request->hasFile('product_clip'))
                    {
                        $dir = base_path().'/'.'storage/app/public/product/video';
                        if (!is_dir(storage_path('app/public/product/video'))) {
                            mkdir(storage_path('app/public/product/video'), 0777, true);
                        }
                        $extension = $request->file('product_clip')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                    $file = Storage::put(base_path() .'/storage/app/public/product/product_images/'. $new_file_name, file_get_contents($uploaded_image->getRealPath()));

//                        $request->file('product_clip')->move(base_path() . '/storage/app/public/product/video/', $new_file_name);
                        $status1 = file_put_contents($dir.'/'.$new_file_name,file_get_contents($request->file('product_clip')->getRealPath()));
                        if($status1)
                        {
                            $product_description->video = $new_file_name;
                        }

                    }

                    $product_description->save();
                    return redirect("admin/products-list/?stock=&category=")->with('status', 'Product updated successfully!');
                }
            }
        } else {
            return redirect('admin/products-list/?stock=&category=');
        }
    }

    public function chkDuplicateProduct(Request $request) {
        $name = strtolower(trim($request->product_name));
        $product = Product::where('name', $name)->first();
        if (count($product) > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function chkUpDuplicateProduct(Request $request) {
        $name = strtolower(trim($request->product_name));
        $old_name = $request->product_old_name;
        if (strcasecmp($name, $old_name) == 0) {
            return "true";
        }
        $product = Product::where('name', $name)->first();
        if (count($product) > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function manageProductImages($product_id) {
        $all_products = ProductImage::all();
        return view('product::list-product-images', array('product_id' => $product_id));
    }

    public function manageProductImagesData($product_id) {
        $all_products = ProductImage::where('product_id', $product_id)->get();
        $all_products = $all_products->sortBy('id');
//        $all_products = $all_products->sortBy('id');
        return Datatables::of($all_products)->make(true);
    }
    public function deleteColorImage($id) {
        $colImg = ProductColorImage::find($id);
        if ($colImg) {
            $colImg->delete();
            if(file_exists(base_path().'/storage/app/public/product/product_images/'.$colImg->image))
            {
                unlink(base_path().'/storage/app/public/product/product_images/'.$colImg->image);
            }
            if(file_exists(base_path().'/storage/app/public/product/product_images/thumbnails/'.$colImg->image))
            {
                unlink(base_path().'/storage/app/public/product/product_images/thumbnails/'.$colImg->image);
            }
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
            exit();
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
            exit();

        }
    }

    public function updateProductImages(Request $request, $product_id, $color)
    {
        $product_image = ProductImage::where('id', $product_id)->where('color', $color)->first();
        if(isset($product_image) && count($product_image) > 0)
        {
//            $multi = ProductColorImage::
            $all_imgs_cnt =ProductColorImage::where('product_id',$product_image->product_id)->where('product_image_id',$product_image->id)->get()->count();
            $multi = ProductColorImage::where('product_id',$product_image->product_id)->where('product_image_id',$product_image->id)->paginate(4);
//            $multi = $multi->
//            $img = ArtistImage::where('artist_id', $id)->orderBy('id', 'DESC')->paginate(5);
            if ($request->method() == "GET")
            {

                return view('product::update-product-images', compact('product_image','multi','all_imgs_cnt'));
            }
            else if ($request->method() == "POST")
            {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                    'photo' => 'required'
                ));
                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                }
                $this->uploadProductColorImages($request,$product_image->product_id,$product_id);
                return redirect(url("/admin/manage-product-image/" . $request->product_id))->with('status', "Product Image updated successfully");
            }
        }
        else
            {
                return redirect()->back();
            }
    }
    public function uploadProductColorImages($request,$pro_id,$prod_img_id)
    {
        if ($request->hasFile('photo')) {
            $uploaded_images = $request->file('photo');
            if(isset($uploaded_images) && count($uploaded_images)>0)
            {

                if (!is_dir(storage_path('app/public/product/product_images'))) {
                    mkdir(storage_path('app/public/product/product_images'), 0777, true);
                }
                if (!is_dir(storage_path('app/public/product/product_images/thumbnails'))) {
                    mkdir(storage_path('app/public/product/product_images/thumbnails'), 0777, true);
                }
                foreach ($uploaded_images as $uploaded_image)
                {
                    $objProductImages = new ProductColorImage();
                    $objProductImages->product_image_id =$prod_img_id;
                    $objProductImages->product_id =$pro_id;
                    $extension = $uploaded_image->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

//                    $file = Storage::put(base_path() .'/storage/app/public/product/product_images/'. $new_file_name, file_get_contents($uploaded_image->getRealPath()));

                    $uploaded_image->move(base_path() .'/storage/app/public/product/product_images/', $new_file_name);

                    // make thumbnail
                    if(file_exists(base_path().'/storage/app/public/product/product_images/' . $new_file_name))
                    {
                        $thumbnail = Image::make(base_path().'/storage/app/public/product/product_images/' . $new_file_name);
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(base_path().'/storage/app/public/product/product_images/thumbnails/' . $new_file_name);
                    }
                    $objProductImages->image = $new_file_name;
                    $objProductImages->save();
                }
            }
        }
    }

    public function createProductImages(Request $request, $product_id) {

        $product = Product::find($product_id);
        if(isset($product) && count($product)>0)
        {
            if ($request->method() == "GET") {
                $colorArr = array();
                $filterArr = array();
                $colors = ProductColor::where('product_id',$product_id)->get();

                if(!empty($product->productDescription->color))
                {
                    if(!in_array(trim($product->productDescription->color), $colorArr)){
                        $colorArr[]=trim($product->productDescription->color);
                    }

                }
                foreach ($colors as $colr)
                {
                    if(!in_array(trim($colr->color), $colorArr))
                    {
                        $colorArr[] = trim($colr->color);
                    }
                }
                $prodImgs = ProductImage::where('product_id',$product_id)->get();
//            dd($prodImgs);
                if(isset($prodImgs) && count($prodImgs)>0)
                {
                    $filterArr = $colorArr;
                    foreach ($prodImgs as $key=>$val)
                    {
                        // dd($img->color);
                        if(!empty($val->color))
                        {
                            $value =$val->color;
                            $arrKey = array_search($value, $colorArr);
                            if($arrKey > -1)
                            {
                                unset($filterArr[$key]);
                            }
                        }
                    }
                }
                else
                {
                    $filterArr = $colorArr;
                }
                return view('product::create-product-images', compact('product_id','filterArr'));
            } else if ($request->method() == "POST") {
                $productImg =new ProductImage();
                $productImg->product_id = $product_id;
                $productImg->color = $request->color;
                $productImg->save();
                 $this->uploadProductColorImages($request,$product_id,$productImg->id);
                return redirect(url("/admin/manage-product-image/" . $product_id))->with("status", "Product Image added successfully");
            }
        }
        else{
           return redirect()->back();
        }

    }

    public function deleteProductImages($product_id) {
        $productImg = ProductImage::find($product_id);
        if ($productImg) {
            $objProdColrImgs = ProductColorImage::where('product_image_id',$productImg->id)->get();
            if(isset($objProdColrImgs) && count($objProdColrImgs)>0)
            {
                foreach ($objProdColrImgs as $colrImg)
                {
                    if(!empty($colrImg) && !empty($colrImg->image))
                    if(file_exists(base_path().'/storage/app/public/product/product_images'.'/'.$colrImg->image))
                    {
                        unlink(base_path().'/storage/app/public/product/product_images'.'/'.$colrImg->image);
                    }
                    if(file_exists(base_path().'/storage/app/public/product/product_images/thumbnails'.'/'.$colrImg->image))
                    {
                        unlink(base_path().'/storage/app/public/product/product_images/thumbnails'.'/'.$colrImg->image);
                    }
                    $colrImg->delete();
                }
            }
            $productImg->delete();
            return redirect("/admin/manage-product-image/")->with('status', 'Product Image deleted successfully!');
        } else {
            return redirect('/admin/manage-product-image/');
        }
    }

    public function deleteSelectedProductImages($product_id) {
        $product = ProductImage::find($product_id);

        if ($product) {
            $product->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function listProductAttributes($product_id) {
//        $product=Product::where('id',$product_id)->first();
//        $cat_id=$product->category_id;
//        $category=  CategoryTranslation::where('category_id',$cat_id)->first();
//        dd($category->parent_id);
        return view("product::product_attributes", compact('product_id'));
    }

//    public function listProductAttributesData($product_id)
//
//            {
//
//                $product=Product::where('id',$product_id)->first();
//                $cat_id=$product->category_id;
//                $all_attributes= CategoryAttributes::where('category_id',$cat_id)->get();
//
//        $all_attributes = $all_attributes->sortBy('id');
//
//        return Datatables::of($all_attributes)
//                        ->addColumn('name', function($product) {
//                            if(isset($product->attribute->trans->name) && $product->attribute->trans->name!="" ){
//                            return stripslashes($product->attribute->trans->name);
//                            }
//                            else{
//                                return "-";
//                            }
//                        })
////                        ->addColumn('product_id', function($product) {
////                            if(isset($product->product_id)){
////                            return stripslashes($product->product_id);
////                            }
////                        })
//                        ->make(true);
//    }
    public function listProductAttributesData($product_id) {
//        dd($product_id);
        $product = Product::where('id', $product_id)->first();
//        dd($product);
        $cat_id = $product->category_id;
        $category = CategoryTranslation::where('category_id', $cat_id)->first();
        if ($category->parent_id == "0" || $category->parent_id == "" || $category->parent_id == "null") {

            $all_attributes = CategoryAttributes::where('category_id', $cat_id)->get();
        } else if ($category->parent_id != "" || $category != "0") {
            $sub_category = CategoryTranslation::where('category_id', $category->parent_id)->first();
            if ($sub_category->parent_id == "0" || $sub_category->parent_id == "" || $sub_category->parent_id == "null") {
//                     $all_attributes= CategoryAttributes::where('category_id',$cat_id)->get();
                $all_attributes = CategoryAttributes::where('category_id', $category->parent_id)->get();
            } else if ($sub_category != "" || $sub_category != "0") {
                $all_attributes = CategoryAttributes::where('category_id', $sub_category->parent_id)->get();
            }
        }

        $all_attributes = $all_attributes->sortBy('id');

        return Datatables::of($all_attributes)
                        ->addColumn('name', function($product) {
//                    dd($product);
                            if (isset($product->attribute->trans->name) && $product->attribute->trans->name != "") {

                                return stripslashes($product->attribute->trans->name);
                            } else {
                                return "-";
                            }
                        })
//                        ->addColumn('product_id', function($product) {
//                            if(isset($product->product_id)){
//                            return stripslashes($product->product_id);
//                            }
//                        })
                        ->make(true);
    }

    public function updateProductAttributesValue(Request $request, $product_id, $attribute_id)
    {
        if ($request->method() == "GET") {
            $attribute = ProductAttribute::where('attribute_id', $attribute_id)->where('product_id', $product_id)->get();
//            dd($attribute);
            $attr_name = AttributeTranslation::where('attribute_id', $attribute_id)->first();
            $product_id = $product_id;
            $exclude_arr = [37,57,26,25,62];
           // dd($attr_name);
            return view('product::update-product-attributes', compact("attribute", "attribute_id", "attr_name", "product_id",'exclude_arr'));
        }
        if ($request->method() == "POST") {
//            dd($request->all());
            $product_id = $request->product_id;
            $attribute_id = $request->attribute_id;
            $proAttribute = ProductAttribute::where('attribute_id', $attribute_id)->where('product_id', $product_id)->get();

            if(isset($proAttribute) && count($proAttribute)>0){
                foreach ($proAttribute as $attr){
                    $attr->delete();
                }
            }
            if(isset($request->value)){
                $valueArr = $request->value;
                foreach ($valueArr as $key=>$value){
                    $attVal ='';
                    if(is_string($value))
                    {
                        $attVal =strtolower(trim($value));
                    }
                    else
                        {
                            $attVal = trim($value);
                        }
                    $pro_attribute=new ProductAttribute();
                    $pro_attribute->product_id = $product_id;
                    $pro_attribute->attribute_id = $attribute_id;
                    $pro_attribute->value= $attVal;
                    $pro_attribute->save();
                }
            }
            return redirect(url('/admin/manage-product-attributes/' . $pro_attribute->product_id))->with('status', "Product attribute updated successfully");
        }
    }

    public function deleteProductAttributesValue($attribute_id) {
        $product = ProductAttribute::find($attribute_id);
        if ($product) {
//            ProductDescription::where('product_id',$product->id)->delete();
            $product->delete();
            return redirect("admin/products-list/?stock=&category=")->with('status', 'Product Attribute deleted successfully!');
        } else {
            return redirect('admin/products-list/?stock=&category=');
        }
    }

    public function deleteSelectedProductAttributesValue($attribute_id) {
        $product = ProductAttribute::find($attribute_id);

        if ($product) {
//            ProductDescription::where('product_id',$product->id)->delete();

            $product->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function removePhoto($image_id) {
        $product_image = ProductImage::find($image_id);

        if ($product_image) {
            if ($this->removeProductFileFromStrorage($product_image)) {
//                    $post->post_image = "";
                $product_image->save();
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

    public function viewProduct(Request $request, $product_id) {
        $product = Product::find($product_id);
        $user = $product->user->userInformation;
        $product_description = $product->productDescription()->first();
        $product_image = $product->productImages()->get();

        if ($product) {
            if ($request->method() == "GET") {
                return view("product::view-product", array('product' => $product, 'product_image' => $product_image, 'pd' => $product_description, 'user' => $user));
            }
        } else {
            return redirect('admin/products-list/?stock=&category=');
        }
    }

    public function deleteProduct($product_id) {
        $product = Product::find($product_id);
        if ($product) {
            ProductDescription::where('product_id', $product->id)->delete();
            $product->delete();
            return redirect("admin/products-list/?stock=&category=")->with('status', 'Product deleted successfully!');
        } else {
            return redirect('admin/products-list/?stock=&category=');
        }
    }

    public function deleteSelectedProduct($product_id) {
        $product = Product::find($product_id);

        if ($product) {
            ProductDescription::where('product_id', $product->id)->delete();

            $product->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function showDashboard() {
        return view('product::dashboard');
    }

//    public function viewProductCategories() {
//        $product = Product::all();
//        $existing_categories = Category::all();
//        $tree = $this->getCategoryTreeList($existing_categories->toTree(), '<li>', true);
//
//        return view('product::posts', array('posts' => $posts, 'posts_latest' => $posts_latest, 'category_tree' => $tree));
//    }

    public function viewCategories() {
        $parent_category = Category::where('parent_id', 0)->get();
        return view('product::view-categories', array('parent_category' => $parent_category));
    }

    public function lists(Request $request, $category_id) {
        $product = Product::where('category_id', $category_id)->first();
        if ($product) {
            $product_image = $product->productImages()->first();
            $product_desciption = $product->productDescription()->first();
            if ($request->method() == "GET") {
                return view("product::lists", array('product' => $product, 'product_image' => $product_image, 'product_desciption' => $product_desciption));
            }
        } else {
            return redirect('/product/categories');
        }
    }

    public function listProductFront(Request $request, $product_id) {

        $product = Product::find($product_id);
        $product_desciption = $product->productDescription()->first();
        $product_image = $product->productImages()->get();

        if ($product) {
            if ($request->method() == "GET") {
                return view("product::view-product", array('product' => $product, 'product_image' => $product_image, 'pd' => $product_desciption));
            }
        } else {
            return redirect('admin/products-list/?stock=&category=');
        }

        $all_products = Product::all();
        $all_products = $all_products->sortBy('id');

        return Datatables::of($all_products)
                        ->addColumn('name', function($product) {
                            return stripslashes($product->name);
                        })
                        ->make(true);
    }

    public function viewAllProducts() {
        $products = Product::orderBy('priority', 'desc')->paginate(5);
        return view('product::view-all-products', array('products' => $products));
    }

    public function viewProductsDetails($product_id) {
        $product = Product::find($product_id);
        $productImages = $product->productImages;
//        foreach($product as $product){
//            echo $product;
//        } exit();
//        dd($productImages);
        return view('product::view-product-details', array('$product' => $product, 'productImages' => $productImages));
    }

    public function viewProductsForTag(Request $request) {

        $products = ProductDescription::with('product', 'productImages')->filterByTags()->filterByPrice()->orderBy('id')->paginate(5);
        return view('product::search-by-tag', array('products' => $products, 'keyword' => $request->searchText));
    }

    public function viewProductForPrice(Request $request) {
        $max = $request->maxPrice;
        $matching_products = ProductDescription::where('price', '<=', $max)->get();
        dd($matching_products);
    }

//    public function viewProductsForColor(Requests $request) {
//       // dd($request->color);
//        $products = ProductDescription::with('product', 'productImages')->where('tags', 'LIKE', '%' . $request->color . '%')->get();
//        return view('product::search-by-color', array('products' => $products, 'keyword' => $keyword));
//    }

    public function listAllProducts() {
        return view('product::product_listing');
//        return view('product::view-products');
    }

    public function productDetails() {
        return view('product::product_details');
    }

    private function getCategoryTreeList($nodes, $prefix = "</li><li>", $include_anchor = false) {
        $arr_cats = array();
        $traverse = function ($categories, $prefix) use (&$traverse, &$arr_cats, $include_anchor) {

            foreach ($categories as $category) {

                $disp_name = $prefix . ' ' . $category->name . " (" . count($category->products) . ")</li>";

                if ($include_anchor) {
                    $disp_name = $prefix . '<a href="' . url('/product/categories/' . $category->name) . '" title="Click to view posts">' . $category->name . " (" . count($category->products) . ")</a></li>";
                }

                $arr_cats[] = new categoryTreeHolder($disp_name, $category->id, $category->name);

                $traverse($category->children, "<ul class='subtree'><li>");
            }
        };

        $traverse($nodes, $prefix);

        return $arr_cats;
    }

    public function searchProduct(Request $request) {
//        dd($request->all());
        $data = Product::where('name', $request->name)->get();
//    dd($data);
        return view('product::search-product', compact('data'));
    }

    public function listStyles() {
        return view("product::list-styles");
    }

    public function listStylesData() {
        $styles = Style::all();
        return Datatables::of($styles)
                        ->addColumn('name', function($product) {
                            if (isset($product->name) && $product->name != "") {
                                return stripslashes($product->name);
                            } else {
                                return "-";
                            }
                        })
//                        ->addColumn('product_id', function($product) {
//                            if(isset($product->product_id)){
//                            return stripslashes($product->product_id);
//                            }
//                        })
                        ->make(true);
    }

    public function createStyles(Request $request) {

        if ($request->method() == "GET") {

            return view("product::create-style");
        } else if ($request->method() == "POST") {

            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'style_name' => 'required|unique:styles,name',
//                        'attribute' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
//            $data = $request->all();
//            dd($request->all());
                $style = new Style();
                $style->name = $request->style_name;



//                  dd($translated_product);
                if ($request->hasFile('photo')) {
                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                    Storage::put('public/style/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));

                    if (!is_dir(storage_path('app/public/style/'))) {
                        Storage::makeDirectory('public/style/');
                    }

                    // make thumbnail

                    $thumbnail = Image::make(storage_path('app/public/style/' . $new_file_name));
                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                    $thumbnail->save(storage_path('app/public/style/thumbnails/' . $new_file_name));

                    $style->image = $new_file_name;
                }
                $style->save();

                return redirect("/admin/product-styles")->with('status', 'Style created successfully!');
            }
        }
    }

    public function updateStyles(Request $request, $style_id) {
        $style = Style::find($style_id);
        if ($style) {
            if ($request->method() == "GET") {
                return view("product::update-style", array('style' => $style));
            } else if ($request->method() == "POST") {

                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'style_name' => 'required|unique:styles,name,' . $style->id,
//                        'attribute' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    if (isset($request->style_name) && $request->style_name != "") {
                        $style->name = $request->style_name;
                    }



                    if ($request->hasFile('photo')) {

                        $extension = $request->file('photo')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                        Storage::put('public/style/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));

                        if (!is_dir(storage_path('app/public/style/'))) {
                            Storage::makeDirectory('public/style/');
                        }

                        // make thumbnail

                        $thumbnail = Image::make(storage_path('app/public/style/' . $new_file_name));
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(storage_path('app/public/style/thumbnails/' . $new_file_name));

                        $style->image = $new_file_name;
                    }


                    $style->save();

                    return redirect("/admin/product-styles")->with('status', 'Style updated successfully!');
                }
            }
        } else {
            return redirect('/admin/product-styles');
        }
    }

    public function deleteStyles($product_id) {
        $product = Style::find($product_id);
        if ($product) {
            $product->delete();
            return redirect("/admin/product-styles")->with('status', 'Style deleted successfully!');
        } else {
            return redirect('/admin/product-styles');
        }
    }

    public function deleteSelectedStyles($product_id) {
        $product = Style::find($product_id);

        if ($product) {
            $product->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function chkDuplicateStyle(Request $request) {
//        $parent_id=$request->occasion_name;
        $name = $request->style_name;
//        $cat_data=CategoryTranslation::where('name',$name)->first();
        $style = Style::where('name', $name)->first();
//            dd($cat_data);
        if (count($style) > 0) {
//           $parent_data=$cat_data->categoryName; 
//           if($parent_data->parent_id==$parent_id)
//           {
            return "false";
        } else {
            return "true";
        }
    }

    public function listCollectionStyles() {
        return view("product::list-collection-style");
    }

    public function listCollectionStylesData() {
        $styles = CollectionStyle::all();
        return Datatables::of($styles)
                        ->addColumn('name', function($product) {
                            if (isset($product->name) && $product->name != "") {
                                return stripslashes($product->name);
                            } else {
                                return "-";
                            }
                        })
//                        ->addColumn('product_id', function($product) {
//                            if(isset($product->product_id)){
//                            return stripslashes($product->product_id);
//                            }
//                        })
                        ->make(true);
    }

    public function createCollectionStyles(Request $request) {

        if ($request->method() == "GET") {

            return view("product::create-collection-style");
        } else if ($request->method() == "POST") {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'collection_style_name' => 'required|unique:collection_styles,name',
//                        'attribute' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
//            $data = $request->all();
//            dd($request->all());
                $style = new CollectionStyle();
                $style->name = $request->collection_style_name;



//                  dd($translated_product);
                if ($request->hasFile('photo')) {
                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                    Storage::put('public/collection-style/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));

                    if (!is_dir(storage_path('app/public/collection-style/'))) {
                        Storage::makeDirectory('public/collection-style/');
                    }

                    // make thumbnail

                    $thumbnail = Image::make(storage_path('app/public/collection-style/' . $new_file_name));
                    $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                    $thumbnail->save(storage_path('app/public/collection-style/thumbnails/' . $new_file_name));

                    $style->image = $new_file_name;
                }
                $style->save();

                return redirect("/admin/product-collection-styles")->with('status', 'Collection Style created successfully!');
            }
        }
    }

    public function updateCollectionStyles(Request $request, $style_id) {
        $style = CollectionStyle::find($style_id);
        if ($style) {
            if ($request->method() == "GET") {
                return view("product::update-collection-style", array('collection_style' => $style));
            } else if ($request->method() == "POST") {

                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'collection_style_name' => 'required|unique:collection_styles,name,' . $style->id,
//                        'attribute' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    if (isset($request->collection_style_name) && $request->collection_style_name != "") {
                        $style->name = $request->collection_style_name;
                    }



                    if ($request->hasFile('photo')) {

                        $extension = $request->file('photo')->getClientOriginalExtension();
                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;

                        Storage::put('public/collection-style/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));

                        if (!is_dir(storage_path('app/public/collection-style/'))) {
                            Storage::makeDirectory('public/collection-style/');
                        }

                        // make thumbnail

                        $thumbnail = Image::make(storage_path('app/public/collection-style/' . $new_file_name));
                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
                        $thumbnail->save(storage_path('app/public/collection-style/thumbnails/' . $new_file_name));

                        $style->image = $new_file_name;
                    }


                    $style->save();

                    return redirect("/admin/product-collection-styles")->with('status', 'Collection Style updated successfully!');
                }
            }
        } else {
            return redirect('/admin/product-collection-styles');
        }
    }

    public function deleteCollectionStyles($product_id) {
        $product = CollectionStyle::find($product_id);
        if ($product) {
            $product->delete();
            return redirect("/admin/product-collection-styles")->with('status', 'Collection Style deleted successfully!');
        } else {
            return redirect('/admin/product-collection-styles');
        }
    }

    public function deleteSelectedCollectionStyles($product_id) {
        $product = CollectionStyle::find($product_id);

        if ($product) {
            $product->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function chkDuplicateCollectionStyle(Request $request) {
//        $parent_id=$request->occasion_name;
        $name = $request->collection_style_name;
//        $cat_data=CategoryTranslation::where('name',$name)->first();
        $collection = CollectionStyle::where('name', $name)->first();
//            dd($cat_data);
        if (count($collection) > 0) {
//           $parent_data=$cat_data->categoryName; 
//           if($parent_data->parent_id==$parent_id)
//           {
            return "false";
        } else {
            return "true";
        }
    }

    public function chkUpDuplicateCollectionStyle(Request $request) {
        $name = $request->collection_style_name;
        $old_name = $request->old_name;
        if (strcmp($name, $old_name) == 0) {
            return "true";
        } else {
            $collection = CollectionStyle::where('name', $name)->first();
            if (count($collection) > 0) {
                return "false";
            } else {
                return "true";
            }
        }
    }

    public function listOccasion() {
        return view("product::list-occasion");
    }

    public function listOccasionData() {
        $styles = Occasion::all();
        return Datatables::of($styles)
                        ->addColumn('name', function($product) {
                            if (isset($product->name) && $product->name != "") {
                                return stripslashes($product->name);
                            } else {
                                return "-";
                            }
                        })
//                        ->addColumn('product_id', function($product) {
//                            if(isset($product->product_id)){
//                            return stripslashes($product->product_id);
//                            }
//                        })
                        ->make(true);
    }

    public function createOccasion(Request $request) {

        if ($request->method() == "GET") {

            return view("product::create-occasion");
        } else if ($request->method() == "POST") {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'occasion_name' => 'required|unique:occasions,name',
//                        'attribute' => 'required',
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
//            $data = $request->all();
//            dd($request->all());
                $style = new Occasion();
                $style->name = $request->occasion_name;



//                  dd($translated_product);
//                if ($request->hasFile('photo')) {
//                        $extension= $request->file('photo')->getClientOriginalExtension();
//                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//
//                        Storage::put('public/collection-style/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));
//
//                        if (!is_dir(storage_path('app/public/collection-style/'))) {
//                            Storage::makeDirectory('public/collection-style/');
//                        }
//
//                        // make thumbnail
//
//                        $thumbnail = Image::make(storage_path('app/public/collection-style/' . $new_file_name));
//                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//                        $thumbnail->save(storage_path('app/public/collection-style/thumbnails/' . $new_file_name));
//
//                        $style->image =$new_file_name;
//                        
//                }
                $style->save();

                return redirect("/admin/product-occasion")->with('status', 'Occasion created successfully!');
            }
        }
    }

    public function updateOccasion(Request $request, $style_id) {
        $style = Occasion::find($style_id);
        if ($style) {
            if ($request->method() == "GET") {
                return view("product::update-occasion", array('occasion' => $style));
            } else if ($request->method() == "POST") {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            'occasion_name' => 'required|unique:occasions,name,' . $style->id,
//                        'attribute' => 'required',
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                    if (isset($request->occasion_name) && $request->occasion_name != "") {
                        $style->name = $request->occasion_name;
                    }



//                    if ($request->hasFile('photo')) {
//                        
//                        $extension= $request->file('photo')->getClientOriginalExtension();
//                        $new_file_name = str_replace(".", "-", microtime(true)) . "." . $extension;
//
//                        Storage::put('public/collection-style/' . $new_file_name, file_get_contents($request->file('photo')->getRealPath()));
//
//                        if (!is_dir(storage_path('app/public/collection-style/'))) {
//                            Storage::makeDirectory('public/collection-style/');
//                        }
//
//                        // make thumbnail
//
//                        $thumbnail = Image::make(storage_path('app/public/collection-style/' . $new_file_name));
//                        $thumbnail->resize($this->thumbnail_size["width"], $this->thumbnail_size["height"]);
//                        $thumbnail->save(storage_path('app/public/collection-style/thumbnails/' . $new_file_name));
//
//                        $style->image=$new_file_name;
//                }


                    $style->save();

                    return redirect("/admin/product-occasion")->with('status', 'Occasion updated successfully!');
                }
            }
        } else {
            return redirect('/admin/product-occasion');
        }
    }

    public function deleteOccasion($product_id) {
        $product = Occasion::find($product_id);
        if ($product) {
            $product->delete();
            return redirect("/admin/product-occasion")->with('status', 'Occasion deleted successfully!');
        } else {
            return redirect('/admin/product-occasion');
        }
    }

    public function deleteSelectedOccasion($product_id) {
        $product = Occasion::find($product_id);

        if ($product) {
            $product->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

    public function chkDuplicateOccasion(Request $request) {
//        $parent_id=$request->occasion_name;
        $name = $request->occasion_name;
//        $cat_data=CategoryTranslation::where('name',$name)->first();
        $occasion = Occasion::where('name', $name)->first();
//            dd($cat_data);
        if (count($occasion) > 0) {
//           $parent_data=$cat_data->categoryName; 
//           if($parent_data->parent_id==$parent_id)
//           {
            return "false";
        } else {
            return "true";
        }
    }

    public  function removeDiscount(Request $request){
        $product = Product::find($request->product_id);

        if(count($product)> 0){
            $proDesc = ProductDescription::where('product_id',$product->id)->first();
            if(isset($proDesc) && count($proDesc)>0){
                if($proDesc->discount_type == 0){
                    $proDesc->discount_price = 0;
                }
                else{
                    $proDesc->discount_percent = 0;
                }
                $proDesc->discount_valid_from = 0;
                $proDesc->discount_valid_to = 0;
                $proDesc->max_quantity = 0;
                $proDesc->save();
                echo json_encode(array("success" => '1', 'msg' => "Product discount has deleted successfully"));
                exit();
            }
        }
        echo json_encode(array("success" => '1', 'msg' => "Wrong product id"));
        exit();
    }

    public function giveDiscount(Request $request, $product_id) {
//        dd($request->all());
        $product = ProductDescription::where('product_id', $product_id)->first();
        if ($request->method() == "GET") {
            return view('product::give-discount', compact('product_id', 'product'));
        } else if ($request->method() == "POST") {
            //dd($request->all());

            $product = ProductDescription::where('product_id', $product_id)->first();
//            if($request->radioChange=='Amount'){
//            $product->discount_type=0;
//            }
//            else if($request->radioChange=='Percentage'){
//            $product->discount_type=1;
//
//            }
//            if($request->radioChange=='Amount')
//            {
//            $product->discount_price=$request->amount;
//            }
//            else if($request->radioChange=='Percentage'){
//            $product->discount_percent=$request->percentage;
//
//            }
            $product->discount_type = 1;
            if (isset($request->percentage) && $request->percentage != '') {
                $product->discount_percent = $request->percentage;
            }
            $product->max_quantity = $request->max_quantity;
            $product->discount_valid_from = $request->discount_valid_from;
            $product->discount_valid_to = $request->discount_valid_to;
            $product->save();

            return redirect(url('/admin/products-list/?stock=&category='))->with('status', "Discount on product applied successfully!");
        }
    }

    private function generateReferenceNumber() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    public function getCatSizeValue(Request $request){

       $category = Category::find($request->category_id);
        $attrVal = array();
       if(isset($category) && count($category)>0)
       {
           if(count($category->categoryAttribute)>0){
               foreach ($category->categoryAttribute as $catAttr)
               {
                  if($catAttr->attribute->name == "Size"){
                      $catAttrVal = CategoryAttributeValue::where('category_attribute_id',$catAttr->id)->get();
                      if(isset($catAttrVal) && count($catAttrVal)>0){
                           foreach ($catAttrVal as $val){
                               $attrVal[] = $val->value;
                           }
                      }
                  }
               }
           }
       }
       return $attrVal;
    }
    public function getProductVideoView(Request $request,$prodId){
        $product = Product::find($prodId);
        $video = '';
        if(isset($product) && count($product)>0){
            $video = $product->productDescription->video;
//            dd($video);
            return view('product-video',compact('video'));
        }
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
