<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Jwt\AccessToken;
//use Twilio\Jwt\Grants\IpMessagingGrant;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

use App\Models\Appointment;

class TokenController extends Controller
{
    public function generate(Request $request, AccessToken $accessToken, ChatGrant $ipmGrant)
    {
//        dd($request);
        $appName = "TwilioChat";
        $deviceId = $request->input("device");
        $identity = $request->input("identity");

        $TWILIO_IPM_SERVICE_SID = config('services.twilio')['ipmServiceSid'];
//        dd($TWILIO_IPM_SERVICE_SID);

        $endpointId = $appName . ":" . $identity . ":" . $deviceId;

        $accessToken->setIdentity($identity);

        $ipmGrant->setServiceSid($TWILIO_IPM_SERVICE_SID);
        $ipmGrant->setEndpointId($endpointId);

        $accessToken->addGrant($ipmGrant);

//        dd($accessToken->toJWT());
        $response = array(
            'identity' => $identity,
            'token' => $accessToken->toJWT()
        );

        return response()->json($response);
    }

    public function startSession(Request $request,$apt_id, AccessToken $accessToken, ChatGrant $ipmGrant){
        $current_appointment = Appointment::where(['id'=>$apt_id])->first();
        $appName = "AppointmentChat";
//        dd(str_replace(" ","-",date_create($current_appointment->appointment_datetime)->format('Y-m-d h:i A')));
//        $deviceId = $request->input("device");
        $deviceId = 'web';
//        $identity = $request->input("identity");
        $providerData = User::where(['id'=> $current_appointment->expert_id])->first();
        $customerData = User::where(['id'=> $current_appointment->customer_id])->first();
        $user_id = $providerData->id;
        $user_email = $providerData->email;
        $userName = explode('@',$user_email);
        $customer_email = $customerData->email;
        $customerName = explode('@',$customer_email);
//        $userName = $userName[0];
        $identity = $userName[0];
        $TWILIO_IPM_SERVICE_SID = config('services.twilio')['ipmServiceSid'];

        $endpointId = $appName . ":" . $identity . ":" . $deviceId;

        $accessToken->setIdentity($identity);

        $ipmGrant->setServiceSid($TWILIO_IPM_SERVICE_SID);
        $ipmGrant->setEndpointId($endpointId);

        $accessToken->addGrant($ipmGrant);

//        dd($accessToken->toJWT());
        $response = array(
            'identity' => $identity,
            'token' => $accessToken->toJWT()
        );
//        return response()->json($response);
        if($response['token'] !=""){
            // Find your Account Sid and Token at twilio.com/user/account
            $sid = config('services.twilio')['accountSid'];
            $token = 'f176e7a15456de632a9b1279ae6423d5';//"your_auth_token";

// Initialize the client
            $client = new Client($sid, $token);
            //check if channel exist
            // Retrieve the service
            $flagChannel = "1";
            try {
                $channel = $client->chat
                    ->services(config('services.twilio')['ipmServiceSid'])
                    ->channels($current_appointment->channel_id)
                    ->fetch();
            } catch (TwilioException $e) {
                $flagChannel = "2";
            }
            if($flagChannel =="2") {
                // Create a private channel if not exist for this appointment
                $channel = $client->chat
                    ->services(config('services.twilio')['ipmServiceSid'])
                    ->channels
                    ->create(
                        array(
//                        'friendlyName' => 'MyChannel',
//                        'uniqueName' => 'my-channel',
                            'friendlyName' => 'Appointment-' . date_create($current_appointment->appointment_datetime)->format('Y-m-d h:i A'),
                            'uniqueName' => 'Appointment-' . str_replace(" ", "-", date_create($current_appointment->appointment_datetime)->format('Y-m-d h:i A')),
                            'Type' => 'private',
                            'CreatedBy' => $identity
                        )
                    );
                $current_appointment->channel_id = $channel->sid;
                $current_appointment->save();
            }
//            echo $channel->friendlyName;

            $flagUser = "1";
            try {
                // Retrieve the user
                $user = $client->chat
                    ->services(config('services.twilio')['ipmServiceSid'])
                    ->users($current_appointment->channel_user)
                    ->fetch();
            } catch (TwilioException $e) {
                $flagUser = "2";
            }
            if($flagUser =="2") {
                // Create the user
                $user = $client->chat
                    ->services(config('services.twilio')['ipmServiceSid']/*"ISXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"*/)
                    ->users
                    ->create($customerName[0]);

//            echo $user->identity;
                $current_appointment->channel_user = $user->sid;
                $current_appointment->save();
            }
            // Delete the member
//            $client->chat
//                ->services(config('services.twilio')['ipmServiceSid'])
//                ->channels("CHf2261783809549178f9d61eaba3872da")
//                ->members("MB65cdfeb839f549e3875a11cbd94b90ef")
//                ->delete();
            $flagMember = "1";
            try {
                // Retrieve the member
                $member = $client->chat
                    ->services(config('services.twilio')['ipmServiceSid'])
                    ->channels($current_appointment->channel_id)
                    ->members($current_appointment->channel_member)
                    ->fetch();
            } catch (TwilioException $e) {
                $flagMember = "2";
            }
            if($flagMember =="2") {
                // Retrieve the channel and Add the member
                $member = $client->chat
//                ->services("ISXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
//                ->channels("CHXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                    ->services(config('services.twilio')['ipmServiceSid'])
                    ->channels($channel->sid)
                    ->members
//                ->create("IDENTITY");
                    ->create($customerName[0]);
                $current_appointment->channel_member = $member->sid;
                $current_appointment->save();
//            echo $member->identity;
            }
        }
        return view('appointments.chat');
//        return response()->json($response);

    }

}
