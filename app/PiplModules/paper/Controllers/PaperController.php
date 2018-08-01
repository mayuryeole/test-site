<?php

namespace App\PiplModules\paper\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\paper\Models\Paper;
use Mail;
use Datatables;
use Illuminate\Routing\UrlGenerator;

class PaperController extends Controller {

    public function listpapers() {

        $arr_papers = Paper::all();

        return view('paper::list-papers');
    }

    public function listPapersData() {

        $arr_papers = Paper::all();
        return Datatables::of($arr_papers)
                        ->addColumn('image', function($arr_papers) {
                            $image = $arr_papers->image;
                            return '<img src=' . url('/') . '/storage/app/public/paper_image/' . $image . ' class="paper-image" height="150px" width="200px">';
                        })
                        ->make(true);
    }

    public function createPaper(Request $request) {
        if ($request->method() == "GET") {
            return view("paper::create-paper");
        } else {
            $data = $request->all();
            $validate_response = Validator::make($data, array(
                        'image' => 'required'
            ));

            if ($validate_response->fails()) {
                return redirect($request->url())->withErrors($validate_response)->withInput();
            } else {
                $created_paper = new Paper;

                /* Upload Image */
                if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                    $image_name = time() . '.png';
                    move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/paper_image/" . $image_name);
                    $created_paper->image = $image_name;
                }
                if($request->status == "1"){
                    $created_paper->price = $request->price;
                }
                else{
                    $created_paper->price = 0;
                }
                $created_paper->name = $request->paper_name;
                $created_paper->description = $request->description;
                $created_paper->status  = $request->status;
//                $created_paper->order_quantity  = isset($request->order_quantity) ? $request->order_quantity : '';
                $created_paper->save();

                return redirect("admin/paper-list")->with('status', 'Paper created successfully!');
            }
        }
    }

    public function updatePaper(Request $request, $paper_id) {
        $paper_details = Paper::find($paper_id);

        if ($paper_details) {


            if ($request->method() == "GET") {
                return view("paper::update-paper", array('paper_details' => $paper_details));
            } else {
                $data = $request->all();
                $validate_response = Validator::make($data, array(
                            
                ));

                if ($validate_response->fails()) {
                    return redirect($request->url())->withErrors($validate_response)->withInput();
                } else {
                   //  dd($request->all());
                    
                    if ($request->image != '') {

                        if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != "") {
                            $image_name = time() . '.png';
                            move_uploaded_file($_FILES['image']['tmp_name'], storage_path() . "/app/public/paper_image/" . $image_name);
                            $paper_details->image = $image_name;
                        }
                        
                    }
                    if($request->status == "1"){
                        $paper_details->price  = $request->price;
                    }
                    else{
                        $paper_details->price  = 0;
                    }
                    $paper_details->name  = $request->paper_name;
                    $paper_details->description  = $request->description;
                    $paper_details->status  = $request->status;
                    $paper_details->order_quantity  = isset($request->order_quantity) ? $request->order_quantity : '';
                    $paper_details->save();

                    return redirect("admin/paper-list")->with('status', 'paper updated successfully!');
                }
            }
        } else {
            return redirect('admin/categories-list');
        }
    }

    public function deletePaper($paper_id) {
        $paper_data = Paper::find($paper_id);

        if ($paper_data) {
            $paper_data->delete();
            return redirect("admin/paper-list")->with('status', 'paper deleted successfully!');
        } else {
            return redirect('admin/categories-list');
        }
    }

    public function deleteSelectedPaper($paper_id) {
        $paper_data = Paper::find($paper_id);

        if ($paper_data) {
            $paper_data->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

}
