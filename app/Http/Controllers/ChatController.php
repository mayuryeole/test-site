<?php
namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Twilio\Jwt\AccessToken;
//use Twilio\Jwt\Grants\IpMessagingGrant;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Accounts;
use Twilio\Rest\Client;
use App\Models\Appointment;

use Twilio\Jwt\Grants\VideoGrant;//TwilioJwtGrantsVideoGrant;
//voice
//use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\Jwt\ClientToken;
//use Twilio\Twiml;

class ChatController extends Controller
{
    protected $sid;
    protected $token;
    protected $key;
    protected $secret;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sid = config('services.twilio.accountSid');
        $this->token = config('services.twilio.token');
        $this->key = config('services.twilio.apiKey');
        $this->secret = config('services.twilio.apiSecret');
    }
    /*
     * chat page
     */
    public function startTextChat(Request $request,$appointment_id) {
//        dd(Auth::user()->userInformation()->first_name);
        if(Auth::user())
        {
            $appointment = Appointment::where('id',$appointment_id)->first();
            if($appointment->status=='1')
            {
                 $customer = User::find($appointment->customer_id);

//            dd($appointment);
                if($appointment->expert_id == Auth::user()->id){
                    $email = Auth::user()->email;
                    $name = explode('@',$email);
                    $username = $name[0];

                    $customerEmail = $customer->email;
                    $customerName = explode('@',$customerEmail);
                    $customerUsername = $customerName[0];
                }else{
                    $customerEmail = Auth::user()->email;
                    $customerName = explode('@',$customerEmail);
                    $customerUsername = $customerName[0];

                    $email = $customer->email;
                    $name = explode('@',$email);
                    $username = $name[0];
                }
                $currentAppointment = 'Appointment-'.$appointment->expert_id.'-'. date_create($appointment->appointment_datetime)->format('Y-m-d-h:i-A');
                $appointment_day='';
                $appointment_day=date('y-m-d h:i:s A',  strtotime($appointment->appointment_datetime));
        //         
                $datetime1 = new \DateTime();
                $datetime2 = new \DateTime($appointment_day);
        //            dd($datetime2);
                $interval = $datetime1->diff($datetime2);
                if($datetime2 > $datetime1)
                {
                    if($interval->d==0 && $interval->h==0 && $interval->i==0 && $interval->s<=60)
                    {
                        return view("chats.text-chat", compact('username','appointment','customerUsername','currentAppointment'));
                    }else{
                        if(Auth::user()->userInformation->user_type=='2') 
                        return redirect('my-appointments')->with('msg-error','Whoops!!! This appointment is not available right now.') ;
                        elseif(Auth::user()->userInformation->user_type=='4')
                        return redirect('service-provider/appointments-list')->with('msg-error','Whoops!!! This appointment is not available right now.') ;    
                    }
                } else {
                    if($interval->d==0 && $interval->h==0 && $interval->i<=60 && $interval->s<=60)
                    {
                        return view("chats.text-chat", compact('username','appointment','customerUsername','currentAppointment'));
                    }else{
                        if(Auth::user()->userInformation->user_type=='2') 
                        return redirect('my-appointments')->with('msg-error','Whoops!!! This appointment is not available right now.') ;
                        elseif(Auth::user()->userInformation->user_type=='4')
                        return redirect('service-provider/appointments-list')->with('msg-error','Whoops!!! This appointment is not available right now.') ;    
                    }
                }
            }elseif($appointment->status=='2')
            {
               if(Auth::user()->userInformation->user_type=='2') 
               return redirect('my-appointments')->with('msg-error','Whoops!!! This appointment has already been cancelled.') ;
               elseif(Auth::user()->userInformation->user_type=='4')
               return redirect('service-provider/appointments-list')->with('msg-error','Whoops!!! This appointment has already been cancelled.') ;    
            }elseif($appointment->status=='3')
            {
               if(Auth::user()->userInformation->user_type=='2') 
               return redirect('my-appointments')->with('msg-error','Whoops!!! This appointment has already been Completed.') ;
               elseif(Auth::user()->userInformation->user_type=='4')
               return redirect('service-provider/appointments-list')->with('msg-error','Whoops!!! This appointment has already been Completed.') ;    
            }elseif($appointment->status=='0'|| $appointment->status=='4')
            {
               if(Auth::user()->userInformation->user_type=='2') 
               return redirect('my-appointments')->with('msg-error','Whoops!!! This appointment has not been scheduled yet.') ;
               elseif(Auth::user()->userInformation->user_type=='4')
               return redirect('service-provider/appointments-list')->with('msg-error','Whoops!!! This appointment has not been scheduled yet.') ;    
            }

        }else {
            $errorMsg = "Error! Something is wrong going on.";
            Auth::logout();
            return redirect("")->with("issue-profile", $errorMsg);
        }
    }
    /*
     * generate token
     */
//    public function generateToken(Request $request, AccessToken $accessToken, IpMessagingGrant $ipmGrant)
    public function generateToken(Request $request, ChatGrant $ipmGrant)
    {
        // Initialize the client
        /*$client = new Client(config('services.twilio')['accountSid'], 'f176e7a15456de632a9b1279ae6423d5');
// Delete the channel
        $client->chat
            ->services(config('services.twilio')['ipmServiceSid'])
            ->channels("CH5b89f7e4ab284d9b8f9c22dfe53d3b19")
            ->delete();*/

        $appName = "TwilioChat";
//        $deviceId = $request->input("device");
        $endpointId = $request->input("endpointId");
        $identity = $request->input("identity");
        $TWILIO_IPM_SERVICE_SID = config('services.twilio')['ipmServiceSid'];

//        $endpointId = $appName . ":" . $identity . ":" . $deviceId;
        $endpointId = $TWILIO_IPM_SERVICE_SID . $identity . ":" . $endpointId;
        $accessToken = new AccessToken($this->sid, $this->key, $this->secret);
        $accessToken->setIdentity($identity);

        $ipmGrant->setServiceSid($TWILIO_IPM_SERVICE_SID);
        $ipmGrant->setEndpointId($endpointId);

        $accessToken->addGrant($ipmGrant);

//        $response = array(
//            'identity' => $identity,
//            'token' => $accessToken->toJWT()
//        );
//        return response()->json($response);
        $token = $accessToken->toJWT();
//        return response()->json($token);
        return $token;
    }

    public function startVideoChat(Request $request, $appointment_id){
        $appointment = Appointment::where('id',$appointment_id)->first();
//dd($appointment->expert_id);
        $email = Auth::user()->email;
        $name = explode('@',$email);
        $username = $name[0];
        $identity = $username;
//        $roomName = 'Appointment-'.Auth::user()->id.'-'. date_create($appointment->appointment_datetime)->format('Y-m-d-h:i-A');
        $roomName = 'Appointment-'.$appointment->expert_id.'-'. date_create($appointment->appointment_datetime)->format('Y-m-d-h:i-A');

        \Log::debug("joined with identity: $identity");
        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        $token->addGrant($videoGrant);
        return view('chats.video-chat', [ 'accessToken' => $token->toJWT(), 'roomName' => $roomName ]);

    }

    public function voiceToken(Request $request)
    {
        $clientToken = new ClientToken($this->sid, $this->token);
        $outgoingApplicationSid = 'APc35b293e34b24cbb91303ea08bd161bb';
        $forPage = $request->input('forPage');
//        $applicationSid = config('services.twilio')['applicationSid'];
        $applicationSid = $outgoingApplicationSid;
        $clientToken->allowClientOutgoing($applicationSid);

//        if ($forPage === route('dashboard', [], false)) {
//            $clientToken->allowClientIncoming('support_agent');
//        } else {
//            $clientToken->allowClientIncoming('customer');
            $clientToken->allowClientIncoming('ramesh');
//        }

        $token = $clientToken->generateToken();
        return response()->json(['token' => $token]);
    }

    public function startVoiceChat(Request $request){
        $appointment_id = $request->input("aptId");
//        dd($appointment_id);
        $appointment = Appointment::where('id',$appointment_id)->first();
        $email = Auth::user()->email;
        $name = explode('@',$email);
        $username = $name[0];
        $identity = str_replace(".","",$username);
//dd(Auth::user()->userInformation->user_mobile);
        // Required for all Twilio access tokens
        $twilioAccountSid = $this->sid;
        $twilioApiKey = $this->key;
        $twilioApiSecret = $this->secret;

// Required for Voice grant
        $outgoingApplicationSid = 'APc35b293e34b24cbb91303ea08bd161bb';
// An identifier for your app - can be anything you'd like

        // get the Twilio Client name from the page request parameters, if given
        $customer = User::find($appointment->customer_id);
        $customerEmail = $customer->email;
        $customerName = explode('@',$customerEmail);
        $customerUsername = $customerName[0];

        $clientName = $identity;

        $capability = new ClientToken($twilioAccountSid, $this->token);
        $capability->allowClientOutgoing($outgoingApplicationSid);
        $capability->allowClientIncoming($clientName);
        $token = $capability->generateToken();

        return view('chats.voice-chat', compact('token' , 'clientName'));

    }

}
