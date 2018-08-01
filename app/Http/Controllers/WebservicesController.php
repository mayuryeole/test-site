<?php

namespace App\Http\Controllers;

use App;
use App\User;
use App\UserInformation;
use Auth;
use Mail;
use Hash;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use App\PiplModules\admin\Models\GlobalSetting;
use Illuminate\Pagination\Paginator;
use Storage;
use DB;
use Illuminate\Support\Facades\Session;
use App\PiplModules\admin\Models\Country;
use App\PiplModules\category\Models\Category;

class WebServicesController extends Controller {

    public function getAllCountries() {
        $arr_to_return = array("error_code" => 2, "msg" => 'Value cant be empty.');
        return response()->json($arr_to_return);
       /* $all_countries = Country::translatedIn(\App::getLocale())->get();
        if (count($all_countries) > 0) {
            $arr_to_return = array("error_code" => 0, "msg" => 'Success', "countries" => $all_countries);
        } else {
            $arr_to_return = array("error_code" => 2, "msg" => 'Value cant be empty.');
        }
        return response()->json($arr_to_return);
        */
    }

    public function getMenuCategory() {
        $existing_categories = Category::withTranslation()->get();
        $tree = $this->getCategoryTree($existing_categories->toTree(), '--');
        $catObj = new \stdClass();
        $catObj->parent = array();
        $arr_temp = array();

//        dd($tree);
        foreach ($tree as $category) {
//            dd($category);
//            dd($category->display[2]);
            $arr_temp['data']['key'][] = $category->id;
            $arr_temp['data']['parent'][] = $category->parent_id;
            $arr_temp['data']['display'][] = $category->display;



            if (isset($category->display[2]) && isset($category->display[3]) && ($category->display[2] != '-' && $category->display[3] != '-')) {
                $std = new \stdClass();
                $child = new \stdClass();
                $sub_child = new \stdClass();

                /*  $sub_child->sub_child = array(6,7,8,9,10);  // No. of Sub Children                
                  $sub_child->name = "Children name";      //
                  $sub_child->id = "Children Id";

                  $child->child = array("0"=>$sub_child,"1"=>$sub_child,"2"=>$sub_child);

                  $sub_child->child_name = "Child Name";
                  $sub_child->id = 5;
                  array_push($child->child,$sub_child);
                 */

                $std->parent = $child;
                $sub_category = $existing_categories->filter(function ($value, $key) {
                    return $value > 2;
                });

                $filtered->all();

                $std->parent->parent_real_name = trim($category->display, '-');
                $std->parent->id = $category->id;
                $catObj->parent[$category->id] = $std;
            } else if (isset($category->display[4]) && isset($category->display[5]) && ($category->display[4] != '-' && $category->display[5] != '-')) {

//                $catObj->parent[$category->parent_id] = $category->id;
                //$catObj->sub[$category->id] = $category->display;
            } else if (isset($category->display[9]) && isset($category->display[10]) && ($category->display[9] != '-' && $category->display[10] != '-')) {
                //$catObj->child[$category->id] = $category->display;
            }
        }
        dd($catObj);

        /*   $tree = $this->getCategoryTree($existing_categories->toTree(), '--');
          dd($tree);
          if (count($tree) > 0) {
          $cnt = 0;
          $catObj = new \stdClass();
          $catObj->parent = array();
          $catObj->sub = array();
          $catObj->child = array();
          foreach ($tree as $category) {

          if (($category->display[2] != '-' && $category->display[3] != '-')) {
          $catObj->parent[$category->display][] = $category->display;
          $catObj->parent[$category->parent_id][] = $category->parent_id;
          }

          else if (($category->display[4] != '-' && $category->display[5] != '-')) {

          $catObj->sub[$category->display][] = $category->display;


          }

          else if(($category->display[9] != '-' && $category->display[10] != '-')) {
          $catObj->child[$category->display][] = $category->display;
          }


          }
          } else {
          $arr_to_return = array("error_code" => 2, "msg" => 'Value cant be empty.');
          }
          dd($catObj);
         */
    }

    public function getMenuCategoryBk() {
        $existing_categories = Category::withTranslation()->get();
        $tree = $this->getCategoryTree($existing_categories->toTree(), '--');
        $catObj = new \stdClass();
        $catObj->parent = array();
        //$catObj->sub = array();
        //$catObj->child = array();
        $arr_temp = array();

//        dd($tree);
        foreach ($tree as $category) {
//            dd($category);
//            dd($category->display[2]);
            $arr_temp['data']['key'][] = $category->id;
            $arr_temp['data']['parent'][] = $category->parent_id;
            $arr_temp['data']['display'][] = $category->display;



            if (isset($category->display[2]) && isset($category->display[3]) && ($category->display[2] != '-' && $category->display[3] != '-')) {
                $std = new \stdClass();
                $child = new \stdClass();
                $sub_child = new \stdClass();
                $sub_child->sub_child = array(6, 7, 8, 9, 10);
                $sub_child->name = "Children name";
                $sub_child->id = "Children Id";
                $child->child = array("0" => $sub_child, "1" => $sub_child, "2" => $sub_child);
//                $child->child->real_name = new \stdClass();
//                $child->child->id = 17;
                $std->parent = $child;
                $std->parent->parent_real_name = trim($category->display, '-');
                $std->parent->id = 12;
                $catObj->parent[$category->id] = $std;
            } else if (isset($category->display[4]) && isset($category->display[5]) && ($category->display[4] != '-' && $category->display[5] != '-')) {

                //$catObj->sub[$category->id] = $category->display;
            } else if (isset($category->display[9]) && isset($category->display[10]) && ($category->display[9] != '-' && $category->display[10] != '-')) {

                //$catObj->child[$category->id] = $category->display;
            }
        }
        dd($catObj);

        /*   $tree = $this->getCategoryTree($existing_categories->toTree(), '--');
          dd($tree);
          if (count($tree) > 0) {
          $cnt = 0;
          $catObj = new \stdClass();
          $catObj->parent = array();
          $catObj->sub = array();
          $catObj->child = array();
          foreach ($tree as $category) {

          if (($category->display[2] != '-' && $category->display[3] != '-')) {
          $catObj->parent[$category->display][] = $category->display;
          $catObj->parent[$category->parent_id][] = $category->parent_id;
          }

          else if (($category->display[4] != '-' && $category->display[5] != '-')) {

          $catObj->sub[$category->display][] = $category->display;


          }

          else if(($category->display[9] != '-' && $category->display[10] != '-')) {
          $catObj->child[$category->display][] = $category->display;
          }


          }
          } else {
          $arr_to_return = array("error_code" => 2, "msg" => 'Value cant be empty.');
          }
          dd($catObj);
         */
    }

    private function getCategoryTree($nodes, $prefix = "-") {
        $arr_cats = array();
        $traverse = function ($categories, $prefix) use (&$traverse, &$arr_cats ) {
            foreach ($categories as $category) {
                $arr_cats[] = new categoryTreeHolder($prefix . '' . $category->name, $category->id, '', $category->parent_id);
                $traverse($category->children, $prefix . $prefix);
            }
        };
        $traverse($nodes, $prefix);
        return $arr_cats;
    }

}

class categoryTreeHolder {

    public $display = '';
    public $id = '';
    public $slug = '';
    public $parent_id = '';

    public function __construct($display, $id, $slug = '', $parent_id) {
        $this->id = $id;
        $this->display = $display;
        $this->slug = $slug;
        $this->parent_id = $parent_id;
    }

}

?>