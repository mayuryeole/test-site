<?php

namespace App\Http\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Session;
use URL;
//address validation
use FedEx\ShipService;
use FedEx\ShipService\ComplexType;
use FedEx\ShipService\SimpleType;

class CancelOrderController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
      public function __construct() {
		
		 define('FEDEX_KEY', 'n47oZv2H73eiuyZv');       // Pipl :MXeyZIFdvQy4F1pl
        define('FEDEX_PASSWORD', 'quGOPGGe5Kx825gY8zfcYtpAl');  // Pipl: Nkzsl7tTFOoqeH5wnKZqLWL6U 
        define('FEDEX_ACCOUNT_NUMBER', '510087160'); // Pipl : 510087380  
        define('FEDEX_METER_NUMBER', '119005049');  // pipl : 119003017 
		define('PRODUCTION_URL', 'https://ws.fedex.com:443/web-services/ship');
		define('TESTING_URL', 'https://wsbeta.fedex.com:443/web-services/ship');
    }

    public function cancelOrder() {
        //$trackingNumber = '123456789012';
		//dd(FEDEX_METER_NUMBER);
      $trackingNumber = '794682726421';
$userCredential = new ComplexType\WebAuthenticationCredential();
$userCredential
    ->setKey(FEDEX_KEY)
    ->setPassword(FEDEX_PASSWORD);
$webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
$webAuthenticationDetail->setUserCredential($userCredential);
$clientDetail = new ComplexType\ClientDetail();
$clientDetail
    ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
    ->setMeterNumber(FEDEX_METER_NUMBER);
$version = new ComplexType\VersionId();
$version
    ->setServiceId('ship')
    ->setMajor(12)
    ->setIntermediate(1)
    ->setMinor(0);
$trackingId = new ComplexType\TrackingId();
$trackingId
    ->setTrackingNumber($trackingNumber)
    ->setTrackingIdType(SimpleType\TrackingIdType::_FEDEX);
$deleteShipmentRequest = new ComplexType\DeleteShipmentRequest();
$deleteShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
$deleteShipmentRequest->setClientDetail($clientDetail);
$deleteShipmentRequest->setVersion($version);
$deleteShipmentRequest->setTrackingId($trackingId);
$deleteShipmentRequest->setDeletionControl(SimpleType\DeletionControlType::_DELETE_ALL_PACKAGES);
$validateShipmentRequest = new ShipService\Request();
$validateShipmentRequest->getSoapClient()->__setLocation('https://wsbeta.fedex.com:443/web-services/ship');
$response = $validateShipmentRequest->getDeleteShipmentReply($deleteShipmentRequest);
echo '<pre>';
print_r($response);
    }
    

}
