<?php

namespace App\PiplModules\attribute\Controllers;

use Auth;
use Auth\User;
use Validator;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\PiplModules\attribute\Models\Attribute;
use Datatables;
use App\PiplModules\attribute\Models\AttributeTranslation;

class AttributeController extends Controller {

    public function listAttributes() {
        $all_attributes = Attribute::translatedIn(\App::getLocale())->get();
        return view('attribute::list-attributes', array('attributes' => $all_attributes));
    }

    public function listAttributesData() {
        $all_attributes = Attribute::translatedIn(\App::getLocale())->orderBy('id',"DESC")->get();
        return Datatables::of($all_attributes)
                        ->addColumn('name', function($attribute) {
                            return stripslashes($attribute->name);
                        })
                        ->make(true);
    }

    public function createAttributes(Request $request) {
        if ($request->method() == "GET") {
            return view("attribute::create-attribute");
        } else {
//            dd($request->all());
            $data = $request->all();
//            $validate_response = Validator::make($data, array(
//                        'attribute_name' => 'required|unique:attribute_translations',
//            ));
//            dd();
//            if ($validate_response->fails()) {
//                
////                dd(1);
//                return redirect($request->url())->withErrors($validate_response)->withInput();
//            } else {
//                dd(1);
                $created_attribute = Attribute::create();

                $translated_attribute = $created_attribute->translateOrNew(\App::getLocale());
                $translated_attribute->name = $request->attribute_name;
                $translated_attribute->locale = \App:: getLocale();
                $translated_attribute->attribute_id = $created_attribute->id;
                $translated_attribute->save();

                return redirect("admin/attributes-list")->with('status', 'Attribute created successfully!');
//            }
        }
    }

    public function updateAttribute(Request $request, $attribute_id, $locale = "") {
        $attribute = Attribute::find($attribute_id);
         if ($attribute) {

            $translated_attribute= $attribute->translateOrNew($locale);

            if ($request->method() == "GET") {

                if ($locale != '' && $locale != 'en') {
                    return view("attribute::update-language-attribute", array('attribute' => $translated_attribute, 'main_info' => $attribute));
                } else {
                    return view("attribute::update-attribute", array('attribute' => $translated_attribute, 'main_info' => $attribute));
                }
            } else {
                $data = $request->all();
                if ($locale != 'en') {
                    if ($attribute->name == $request->name) {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required',
                        ));
                    } else {
                        $validate_response = Validator::make($data, array(
                                    'name' => 'required|unique:attribute_translations',
                        ));
                    }
                } else {
                    $validate_response = Validator::make($data, array(
                                'name' => 'required|unique:attribute_translations',
                    ));
                }

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {                  
                    $translated_attribute->name = $request->name;
                    if ($locale != '') {
                        $translated_attribute->attribute_id = $attribute->id;
                        $translated_attribute->locale = $locale;
                    }

                    $translated_attribute->save();

                    return redirect("admin/attributes-list")->with('status', 'Attribute updated successfully!');
                }
            }
        } else {
            return redirect('admin/attributes-list');
        }
    }
    
     public function chkDuplicateAttribute(Request $request) 
     {
//         dd($request->attribute_name);
//        $parent_id=$request->occasion_name;
        $name=$request->attribute_name;
//        $cat_data=CategoryTranslation::where('name',$name)->first();
        $collection= AttributeTranslation::where('name',$name)->first();

        if(count($collection)>0)
        {
              return "false"; 
           } else{
             return "true";
           } 
    }

    public function chkUpDuplicateAttribute(Request $request)
    {

        $name=$request->name;
        $old_name = $request->old_name;
        if(strcmp($name,$old_name) == 0){
            return "true";
        }
        else{
            $collection= AttributeTranslation::where('name',$name)->first();

            if(count($collection)>0)
            {
                return "false";
            } else{
                return "true";
            }
            }


    }


    public function deleteAttribute($attribute_id) {
        $attribute = Attribute::find($attribute_id);
        if ($attribute) {
            AttributeTranslation::where('attribute_id',$attribute->id)->delete();
            $attribute->delete();
            return redirect("admin/attributes-list")->with('status', 'Attribute deleted successfully!');
        } else {
            return redirect('admin/attributes-list');
        }
    }

    public function deleteSelectedAttribute($attribute_id) {
        $attribute = Attribute::find($attribute_id);
        if ($attribute) {
            AttributeTranslation::where('attribute_id',$attribute->id)->delete();
            
            $attribute->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

}
