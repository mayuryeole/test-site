<?php

namespace App\Http\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request as Res;
use Session;
use URL;
//ordr track validation
//use FedEx\ShipService;
use FedEx\TrackService;
use FedEx\TrackService\ComplexType;
use FedEx\TrackService\SimpleType;

class TrackOrderController extends Controller {

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
    }

    public function trackOrder(Res $request)
    {
//        dd($request->all());
       //

//        $userCredential = new ComplexType\WebAuthenticationCredential();
//        $userCredential
//                ->setKey(FEDEX_KEY)
//                ->setPassword(FEDEX_PASSWORD);
//        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
//        $webAuthenticationDetail->setUserCredential($userCredential);
//        $clientDetail = new ComplexType\ClientDetail();
//        $clientDetail
//                ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
//                ->setMeterNumber(FEDEX_METER_NUMBER);
//        $version = new ComplexType\VersionId();
//        $version
//                ->setMajor(12)
//                ->setIntermediate(1)
//                ->setMinor(0)
//                ->setServiceId('ship');
//        $shipperAddress = new ComplexType\Address();
//        $shipperAddress
//                ->setStreetLines(['Address Line 1'])
//                ->setCity('Austin')
//                ->setStateOrProvinceCode('TX')
//                ->setPostalCode('73301')
//                ->setCountryCode('US');
//        $shipperContact = new ComplexType\Contact();
//        $shipperContact
//                ->setCompanyName('Company Name')
//                ->setEMailAddress('test@example.com')
//                ->setPersonName('Person Name')
//                ->setPhoneNumber(('123-123-1234'));
//        $shipper = new ComplexType\Party();
//        $shipper
//                ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
//                ->setAddress($shipperAddress)
//                ->setContact($shipperContact);
//        $recipientAddress = new ComplexType\Address();
//        $recipientAddress
//                ->setStreetLines(['Address Line 1'])
//                ->setCity('Herndon')
//                ->setStateOrProvinceCode('VA')
//                ->setPostalCode('20171')
//                ->setCountryCode('US');
//        $recipientContact = new ComplexType\Contact();
//        $recipientContact
//                ->setPersonName('Contact Name')
//                ->setPhoneNumber('1234567890');
//        $recipient = new ComplexType\Party();
//        $recipient
//                ->setAddress($recipientAddress)
//                ->setContact($recipientContact);
//        $labelSpecification = new ComplexType\LabelSpecification();
//        $labelSpecification
//                ->setLabelStockType(new SimpleType\LabelStockType(SimpleType\LabelStockType::_PAPER_7X4POINT75))
//                ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
//                ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));
//        $packageLineItem1 = new ComplexType\RequestedPackageLineItem();
//        $packageLineItem1
//                ->setSequenceNumber(1)
//                ->setItemDescription('Product description')
//                ->setDimensions(new ComplexType\Dimensions(array(
//                    'Width' => 10,
//                    'Height' => 10,
//                    'Length' => 25,
//                    'Units' => SimpleType\LinearUnits::_IN
//                )))
//                ->setWeight(new ComplexType\Weight(array(
//                    'Value' => 2,
//                    'Units' => SimpleType\WeightUnits::_LB
//        )));
//        $shippingChargesPayor = new ComplexType\Payor();
//        $shippingChargesPayor->setResponsibleParty($shipper);
//        $shippingChargesPayment = new ComplexType\Payment();
//        $shippingChargesPayment
//                ->setPaymentType(SimpleType\PaymentType::_SENDER)
//                ->setPayor($shippingChargesPayor);
//        $requestedShipment = new ComplexType\RequestedShipment();
//        $requestedShipment->setShipTimestamp(date('c'));
//        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
//        $requestedShipment->setServiceType(new SimpleType\ServiceType(SimpleType\ServiceType::_FEDEX_GROUND));
//        $requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));
//        $requestedShipment->setShipper($shipper);
//        $requestedShipment->setRecipient($recipient);
//        $requestedShipment->setLabelSpecification($labelSpecification);
//        $requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_ACCOUNT)));
//        $requestedShipment->setPackageCount(1);
//        $requestedShipment->setRequestedPackageLineItems([
//            $packageLineItem1
//        ]);
//        $requestedShipment->setShippingChargesPayment($shippingChargesPayment);
//        $processShipmentRequest = new ComplexType\ProcessShipmentRequest();
//        $processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
//        $processShipmentRequest->setClientDetail($clientDetail);
//        $processShipmentRequest->setVersion($version);
//        $processShipmentRequest->setRequestedShipment($requestedShipment);
//        $shipService = new ShipService\Request();
////$shipService->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services/ship');
//        $result = $shipService->getProcessShipmentReply($processShipmentRequest);
//         $filepath = "Track-Labels/product-" . time() . ".pdf";
//        $str = $result->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][0]->values['Label']->values['Parts'][0]->values['Image'];
//        file_put_contents($filepath, $str);
//        if (file_exists($filepath)) {
//            header('Content-Description: File Transfer');
//            header('Content-Type: application/octet-stream');
//            header('Content-Disposition: attachment; filename="' . ($filepath) . '"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
//            header('Content-Length: ' . filesize($filepath));
//            flush(); // Flush system output buffer
//            readfile($filepath);
//            exit;
//        }
//    

$trackingId = trim($request->tracking_id);  // old 123456789012  new 2147483647
$userCredential = new ComplexType\WebAuthenticationCredential();
$userCredential->setKey(FEDEX_KEY)
               ->setPassword(FEDEX_PASSWORD);
$webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
$webAuthenticationDetail->setUserCredential($userCredential);
$clientDetail = new ComplexType\ClientDetail();
$clientDetail->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
    		 ->setMeterNumber(FEDEX_METER_NUMBER);
$version = new ComplexType\VersionId();
$version->setMajor(5)
        ->setIntermediate(0)
        ->setMinor(0)
        ->setServiceId('trck');
$identifier = new ComplexType\TrackPackageIdentifier();
$identifier->setType(SimpleType\TrackIdentifierType::_TRACKING_NUMBER_OR_DOORTAG)
           ->setValue($trackingId);
$request = new ComplexType\TrackRequest();
$request->setWebAuthenticationDetail($webAuthenticationDetail)
        ->setClientDetail($clientDetail)
        ->setVersion($version)
        ->setPackageIdentifier($identifier);
$response = (new TrackService\Request())->getTrackReply($request);
echo '<pre>';
print_r($response);
	
	}
    public function getTrackOrder()
    {
        $trackingId = 123456789012;  // old 123456789012  new 2147483647
        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential->setKey(FEDEX_KEY)
            ->setPassword(FEDEX_PASSWORD);
        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);
        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setMeterNumber(FEDEX_METER_NUMBER);
        $version = new ComplexType\VersionId();
        $version->setMajor(5)
            ->setIntermediate(0)
            ->setMinor(0)
            ->setServiceId('trck');
        $identifier = new ComplexType\TrackPackageIdentifier();
        $identifier->setType(SimpleType\TrackIdentifierType::_TRACKING_NUMBER_OR_DOORTAG)
            ->setValue($trackingId);
        $request = new ComplexType\TrackRequest();
        $request->setWebAuthenticationDetail($webAuthenticationDetail)
            ->setClientDetail($clientDetail)
            ->setVersion($version)
            ->setPackageIdentifier($identifier);
        $response = (new TrackService\Request())->getTrackReply($request);
        echo '<pre>';
        print_r($response);
    }

}
