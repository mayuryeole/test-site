<?php

namespace App\PiplModules\box\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\box\Models\Box;
use Mail;
use Datatables;
use Illuminate\Routing\UrlGenerator;

class BoxController extends Controller {

    public function listBoxes() {

        return view('box::list-boxes');
    }

    public function listBoxesData() {

        $arr_boxes = Box::all();
        return Datatables::of($arr_boxes)
                        ->addColumn('image', function($arr_boxes) {
                            $image = $arr_boxes->image;
                            return '<img src=' . url('/') . '/storage/app/public/box_image/' . $image . ' class="ribbon-image" height="150px" width="200px">';
                        })
                        ->make(true);
    }

    public function createBox(Request $request) {
        if ($request->method() == "GET") {  
            return view("box::create-box");
        } else {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'image' => 'required'

            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                //dd($request->all());
                $created_box = new Box;
                /* Upload Image */
                if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                    $image_name = time() . '.png';
                    move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/box_image/" . $image_name);
                    $created_box->image = $image_name;
                }
                if($request->status == "1"){
                    $created_box->price = $request->price;
                }
                else{
                    $created_box->price = 0;
                }
                $created_box->name  = $request->box_name;
                $created_box->box_weight  = $request->box_weight;
                $created_box->status  = $request->status;
                $created_box->description  = $request->description;
//                $created_box->order_quantity  = isset($request->order_quantity) ? $request->order_quantity : '';
                $created_box->save();

                return redirect("admin/box-list")->with('status', 'Box created successfully!');
            }
        }
    }

    public function updateBox(Request $request, $box_id) {
        $box_details = Box::find($box_id);

        if (isset($box_details) && count($box_details)>0) {
            if ($request->method() == "GET") {
                return view("box::update-box", array('box_details' => $box_details));
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                       //dd($request->all());

                    if ($request->image != '') {

                        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                            $image_name = time() . '.png';
                            move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/box_image/" . $image_name);
                            $box_details->image = $image_name;
                        }
                        
                    }
                    $box_details->name  = $request->box_name;
                    $box_details->box_weight  = $request->box_weight;
                    $box_details->status  = $request->status;
                    if($request->status == "1"){
                        $box_details->price  = $request->price;
                    }
                    else{
                        $box_details->price  = 0;
                    }
                    $box_details->description  = $request->description;
//                    $box_details->order_quantity  = isset($request->order_quantity) ? $request->order_quantity : '';
                    $box_details->save();

                    return redirect("admin/box-list")->with('status', 'Box updated successfully!');
                }
            }
        } else {
            return redirect('admin/box-list');
        }
    }

    public function deleteBox($box_id) {
        $box_details = Box::find($box_id);

        if ($box_details) {
            $box_details->delete();
            return redirect("admin/box-list")->with('status', 'Box deleted successfully!');
        } else {
            return redirect('admin/box-list');
        }
    }

    public function deleteSelectedBox($box_id) {
        $box_details = Box::find($box_id);

        if ($box_details) {
            $box_details->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

}
