<?php

namespace App\Http\Controllers;

use Validator;
use Auth;
use Mail;
use Illuminate\Http\Request;
use GlobalValues;
use App\Http\Controllers\Auth\AuthController;

use App\Models\BookingDateTime;
use App\Models\Configuration;
use App\Models\TimeInterval;
use Illuminate\Support\Facades\Input;

class AvailabilityController extends Controller {


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //  $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        //$this->authApi = new AuthController;
       // echo "Hiiiiiiiiiiiiiii";
    }

    public function index(Request $request) {
       // return view('availabilities::set-availability');
    }

    public function getAllAvailability()
    {
	$user_id=Auth::user()->id;
        $times = BookingDateTime::where('user_id',$user_id)->get();
        $availability = array();
        $configs = Configuration::with('timeInterval')->first();
        foreach($times as $t) {
            $startDate = date_create($t['booking_datetime']);
            $endDate = date_create($t['booking_datetime']);

            // Get configuration variable
            // @todo default metric is minutes and only one supported
            // change to whichever metrics we support in the future
//            $timeToAdd = $configs->timeInterval->interval; //minutes
            $timeToAdd = 60; //minutes
//            $endDate = $endDate->add(new \DateInterval('PT'.$timeToAdd.'M'));
            $endDate = $endDate->add(new \DateInterval('PT'.$timeToAdd.'M'));
            if($t['status'] == "0") { //available
                $event = [
                    'id' => $t['id'],
                    'title' => 'Available',
                    'start' => $startDate->format('Y-m-d\TH:i:s'),
                    'end' => $endDate->format('Y-m-d\TH:i:s'),
                    'overlap' => false,
                    'backgroundColor' => 'green',
                    'editable' => true,
                    'rendering' => 'background',
                ];
            }
            /*elseif($startDate->format('Y-m-d H:i:s') <= date("Y-m-d H:i:s")){
                $event = [
                    'id' => $t['id'],
                    'title' => 'Expired',
                    'start' => $startDate->format('Y-m-d\TH:i:s'),
                    'end' => $endDate->format('Y-m-d\TH:i:s'),
                    'backgroundColor' => 'yellow',
                    'editable' => false,
//                    'rendering' => 'background',
                ];
//                dd($event);
            }*/
            else{ //un-available
                $event = [
                    'id' => $t['id'],
                    'title' => 'Booked',
                    'start' => $startDate->format('Y-m-d\TH:i:s'),
                    'end' => $endDate->format('Y-m-d\TH:i:s'),
                    'backgroundColor' => 'red',
                    'editable' => false,
//                    'rendering' => 'background',
                ];
            }
            array_push($availability, $event);
        }
        return response()->json($availability);
    }

    /**
     * Sets availability based on POST data
     * @param $start [Start datetime of selection]
     * @param $end   [End datetime of selection]
     *
     * @return  response()->json() - description of events
     */
    public function setAvailability(Request $request)
    {
        
        
        $user_id = Auth::user()->id;
       
        $begin = new \DateTime($request->start);
        $end = new \DateTime($request->end);

        $interval = \DateInterval::createFromDateString('1 hour');
        $period = new \DatePeriod($begin, $interval, $end);

        foreach($period as $dt) {
//            echo $dt->format("l Y-m-d H:i:s\n");
            $cur_dt = $dt->format("Y-m-d H:i:s");
            $existing_time = BookingDateTime::where([
                'booking_datetime' => $cur_dt//,
//                'status' => "0"
            ])->first();
            if(isset($existing_time)){
                BookingDateTime::deleteAvailability($cur_dt);
            }else{
                $setTime = new BookingDateTime();
                $setTime->user_id = $user_id;
                $setTime->booking_datetime = $cur_dt;
                $setTime->status = "0";
                $setTime->save();

            }
        }
        return response()->json('success', 200);
    }

}
