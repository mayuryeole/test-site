<?php

namespace App\PiplModules\newsletter\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PiplModules\newsletter\Models\Subscriber;
use App\PiplModules\newsletter\Models\Newsletter;
use App\PiplModules\newsletter\SendNewsletterEmail;
use Validator;
use Datatables;
use Session;

class NewsletterController extends Controller {

    public function index() {
        return view("newsletter::index");
    }

    public function subscribeToNewsletter(Request $req) {
        $validation = Validator::make($req->all(), array(
                    'email' => 'required|email|unique:subscribers,email'
                        )
        );
        if ($validation->fails()) {
            echo json_encode(array("success" => "0", "msg" => $validation->errors()->first()));
            exit();
        } else {

            $create = Subscriber::create(array(
                        'email' => $req->email
                            )
            );
            echo json_encode(array("success" => "1", "msg" => "You have succesfully subscribed to our newsletter."));
            exit();
        }
    }

    public function createNewsletter(Request $request) {
        if ($request->method() == "GET") {
            return view("newsletter::create");
        } elseif ($request->method() == "POST") {

            $validation = Validator::make($request->all(), array(
                        'subject' => 'required',
                        'nl_content' => 'required',
                        'status' => 'required'
                            )
            );
            if ($validation->fails()) {
                return redirect($request->url())->withErrors($validation)->withInput();
            } else {
                $data="";
                $data=$request->nl_content;
//                dd($data);
                $data.='<a href="{{url("/admin/unsubscribe-user/replace-user")}}">Unsubscribe</a>';
//                dd($data);
                $arr_newsletter_data = array();
                $arr_newsletter_data['subject'] = $request->subject;
                $arr_newsletter_data['content'] = $data;
                
                $arr_newsletter_data['status'] = $request->status;

                $created_newsletter = Newsletter::create($arr_newsletter_data);

                if ($created_newsletter) {

                    // create view
                    $view_location = __DIR__ . "/../Views/" . $created_newsletter->id . ".blade.php";
                   // dd($view_location);
                    $view_resource = fopen($view_location, "w+");
                    fwrite($view_resource, $created_newsletter->content);
                    fclose($view_resource);

                    return redirect(url('admin/newsletters'))->with("status", "Newsletter created successfully");
                } else {
                    return redirect($request->url())->with("error", "Something goes wrong!!! Please try again")->withInput();
                }
            }
        }
    }

    public function listNewsletters() {
        $all_news_letters = Newsletter::all();

        return view("newsletter::list", array("newsletters" => $all_news_letters));
    }

    public function listNewslettersData() {
        $all_news_letters = Newsletter::all();
        return Datatables::of($all_news_letters)
                        ->make(true);


        //return view("newsletter::list",array("newsletters"=>$all_news_letters));
    }

    public function updateNewsletter(Request $request, $newsletter_id) {
        $newsletter = Newsletter::find($newsletter_id);
        if ($request->method() == "GET") {
            if ($newsletter) {
                return view("newsletter::update", array("newsletter" => $newsletter));
            } else {
                return redirect('admin/newsletters');
            }
        } elseif ($request->method() == "POST") {
            if ($newsletter) {
                $validation = Validator::make($request->all(), array(
                            'subject' => 'required',
                            'nl_content' => 'required',
                            'status' => 'required'
                                )
                );
                if ($validation->fails()) {
                    return redirect($request->url())->withErrors($validation)->withInput();
                } else {
                    $newsletter->subject = $request->subject;
                    $newsletter->content = $request->nl_content;
                    $newsletter->status = $request->status;
                    $newsletter->save();

                    // create view
                    $view_location = __DIR__ . "/../Views/" . $newsletter->id . ".blade.php";

                    $view_resource = fopen($view_location, "w+");
                    fwrite($view_resource, $newsletter->content);
                    fclose($view_resource);
                    return redirect(url('admin/newsletters'))->with("status", "Newsletter Updated successfully");
                }
            } else {
                return redirect('admin/newsletters');
            }
        }
    }

    public function selectUsersNewsletter(Request $request, $newsletter_id) {
        $newsletter = Newsletter::find($newsletter_id);
        if ($request->method() == "GET") {
            if ($newsletter) {
                $subscirber = Subscriber::all();


                foreach ($subscirber as $sub) {
                    $subs[] = $sub->email; //->explode(',');
                }
                if (isset($subs) && count($subs) > 0)
                    $users = implode(",", $subs);
                else
                    $users = "";

                return view("newsletter::select-users", array("newsletter" => $newsletter, "users" => $users));
            }
        }else {

            $this->distributeNewsletters($newsletter_id, $request);
            return redirect(url("/admin/newsletters"));
        }
    }

    public function deleteNewsletter(Request $request, $newsletter_id) {
        if ($request->method() == 'DELETE') {
            $newsletter = Newsletter::find($newsletter_id);

            if ($newsletter) {
                $view_location = __DIR__ . "/../Views/" . $newsletter->id . ".blade.php";
                @unlink($view_location);
                $newsletter->delete();
                return redirect('admin/newsletters')->with("status", "Newsletter deleted successfully!");
            }
        }
    }

    public function distributeNewsletters($newsletter_id, $request) {
        $newsletter = Newsletter::find($newsletter_id);

        if (isset($newsletter) && $newsletter->id) {
            
            $queued_newsletter = (new SendNewsletterEmail($newsletter,$request->email))->delay(60);
            $this->dispatch($queued_newsletter);
//            dd($this->dispatch($queued_newsletter));
            if ($queued_newsletter) {
                return redirect('admin/newsletters')->with("status", "Newsletter queued successfully!");
            } else {
                return redirect('admin/newsletters')->with("status", "Something went wrong, please try again.");
            }
        } else {
            return redirect('admin/newsletters')->with("status", "Something went wrong, please try again.");
        }
    }
    
    public function unsubscribeNewsletter(Request $request,$user) 
    {
//        dd(base64_decode($user));
        $user=base64_decode($user);
        $list = Subscriber::where('email',$user)->first();
        if(!isset($list) && count($list)<=0)
        {
            return redirect("/")->with("subscription_message", "You have already unsubscribed newsletter.");
            
           // echo "<script>alert('Newsletter unsubscribed successfully');</script>";
        }else{
            Subscriber::where('email',$user)->delete();
            Session::flash("subscription_message", "Newsletter unsubscribed successfully.");
            return redirect("/")->with("subscription_message", "Newsletter unsubscribed successfully.");
            //echo "<script>alert('Newsletter unsubscribed successfully');</script>";
        }
        
        
    }

}
