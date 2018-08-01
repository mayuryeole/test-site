<?php

namespace App\PiplModules\display\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\display\Models\Display;
use Mail;
use Datatables;
use Illuminate\Routing\UrlGenerator;

class DisplayController extends Controller {

    public function listDisplays() {
        return view('display::list-displays');
    }

    public function listDisplaysData() {

        $arr_displays = Display::all();
        return Datatables::of($arr_displays)
                        ->addColumn('image', function($arr_displays) {
                            $image = $arr_displays->image;
                            return '<img src=' . url('/') . '/storage/app/public/display_image/' . $image . ' class="ribbon-image" height="150px" width="200px">';
                        })
                        ->make(true);
    }

    public function createDisplay(Request $request)
    {
        if ($request->method() == "GET") {
            return view("display::create-display");
        } else {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'display_name'=>'required',
                        'display_weight'=>'required',
                        'image' => 'required',
                        'status' => 'required'
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
//                dd($request->all());
                $created_display = new Display();
                /* Upload Image */
                if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                    $image_name = time() . '.png';
                    move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/display_image/" . $image_name);
                    $created_display->image = $image_name;
                }
                if($request->status == "1"){
                    $created_display->price = $request->price;
                }
                else{
                    $created_display->price = 0;
                }
                $created_display->name  = isset($request->display_name)?$request->display_name:'';
                $created_display->status  = isset($request->status)?$request->status:'0';
                $created_display->display_weight  = isset($request->display_weight)?$request->display_weight:0;
                $created_display->description  = isset($request->description)?$request->description:'';
//                $created_box->order_quantity  = isset($request->order_quantity) ? $request->order_quantity : '';
                $created_display->save();

                return redirect("admin/display-list")->with('status', 'Display created successfully!');
            }
        }
    }

    public function updateDisplay(Request $request, $display_id) {
        $display_details = Display::find($display_id);

        if (isset($display_details) && count($display_details)>0) {
            if ($request->method() == "GET") {
                return view("display::update-display", array('display_details' => $display_details));
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {

                    if ($request->image != '') {

                        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                            $image_name = time() . '.png';
                            move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/display_image/" . $image_name);
                            $display_details->image = $image_name;
                        }
                        
                    }

                    $display_details->name  = $request->display_name;
                    $display_details->status  = $request->status;
                    $display_details->display_weight  = $request->display_weight;
                    if($request->status == "1"){
                        $display_details->price  = $request->price;
                    }
                    else{
                        $display_details->price  = 0;
                    }
                    $display_details->description  = $request->description;
//                    $box_details->order_quantity  = isset($request->order_quantity) ? $request->order_quantity : '';
                    $display_details->save();

                    return redirect("admin/display-list")->with('status', 'Display updated successfully!');
                }
            }
        } else {
            return redirect('admin/display-list');
        }
    }

    public function deleteDisplay($display_id) {
        $display_details = Display::find($display_id);

        if ($display_details) {
            $display_details->delete();
            return redirect("admin/display-list")->with('status', 'Display deleted successfully!');
        } else {
            return redirect('admin/display-list');
        }
    }

    public function deleteSelectedBox($display_id) {

        $display_details = Display::find($display_id);

        if ($display_details) {
            $display_details->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

}
