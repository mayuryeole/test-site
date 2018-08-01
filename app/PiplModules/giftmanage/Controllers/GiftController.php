<?php

namespace App\PiplModules\giftmanage\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use App\PiplModules\giftmanage\Models\GiftManage;
use Mail;
use Datatables;
use Illuminate\Routing\UrlGenerator;

class GiftController extends Controller {

    public function listGifts() {
        
        return view('giftmanage::list-giftmanage');
    }

    public function listGiftsData() {

        $arr_gift = GiftManage::groupBy('order_number')->orderBy('id');
      
        return Datatables::of($arr_gift)
                        ->addColumn('surprise_status', function($arr_gift) {
                            if ($arr_gift->surprise_status == '0') {
                                return 'No';
                            }
                            if ($arr_gift->surprise_status == '1') {
                                return 'Yes';
                            }
                        })
//                        ->addColumn('product_name',function($arr_gift){
//                            return isset($arr_gift->Product->name) ? $arr_gift->Product->name : '';
//                        })
                        ->addColumn('gift_video',function($arr_gift){
                            return ($arr_gift->gift_video != '') ? '<a href='.url('/').'/storage/app/public/video/'.$arr_gift->gift_video.' target="_black">Click here</a>' : '-';
                        })
                        ->addColumn('gift_audio',function($arr_gift){
                            return ($arr_gift->gift_audio != '') ? '<a href='.url('/').'/storage/app/public/audio/'.$arr_gift->gift_audio.' target="_black">Click here</a>' : '-';
                                
                        })
                        ->make(true);
    }

    public function deleteGift($gift_id) {
        
        $gift_details = GiftManage::where('order_number',$gift_id);
        $order_details = \App\PiplModules\ordermanagement\Models\OrderManagement::where('order_number',$gift_id);

        if ($gift_details) {
            $gift_details->delete();
            if(count($order_details) > 0)
                $order_details->delete();
            return redirect("admin/gift-list")->with('status', 'Gift deleted successfully!');
        } else {
            return redirect('admin/gift-list');
        }
    }

    public function deleteSelectedGift($gift_id) {
        $gift_details = GiftManage::where('order_number',$gift_id);
        $order_details = \App\PiplModules\ordermanagement\Models\OrderManagement::where('order_number',$gift_id);
        if ($gift_details) {
            $gift_details->delete();
            if(count($order_details) > 0)
                $order_details->delete();
            echo json_encode(array("success" => '1', 'msg' => 'Selected records has been deleted successfully.'));
        } else {
            echo json_encode(array("success" => '0', 'msg' => 'There is an issue in deleting records.'));
        }
    }

}
