<?php

namespace App\Http\Controllers;

use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request as Res;
use Session;
use URL;
//address validation
use FedEx\ShipService;
use FedEx\ShipService\ComplexType;
use FedEx\ShipService\SimpleType;
use FedEx\ShipService\ComplexType\CustomsClearanceDetail;
use FedEx\ShipService\ComplexType\Money;
use FedEx\ShipService\ComplexType\Commodity;
use FedEx\ShipService\ComplexType\FreightShipmentDetail;
use FedEx\ShipService\ComplexType\ContactAndAddress;
use FedEx\ShipService\ComplexType\Contact;
use FedEx\ShipService\ComplexType\Address;
 

class ShipOrderController extends Controller {

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

    public function shipInternationalOrder() {
		
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
    ->setMajor(12)
    ->setIntermediate(1)
    ->setMinor(0)
    ->setServiceId('ship');
$shipperAddress = new ComplexType\Address();
$shipperAddress
    ->setStreetLines(['Address Line 1'])
    ->setCity('Austin')
    ->setStateOrProvinceCode('TX')
    ->setPostalCode('73301')
    ->setCountryCode('US');
$shipperContact = new ComplexType\Contact();
$shipperContact
    ->setCompanyName('Company Name')
    ->setEMailAddress('test@example.com')
    ->setPersonName('Person Name')
    ->setPhoneNumber(('123-123-1234'));
$shipper = new ComplexType\Party();
$shipper
    ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
    ->setAddress($shipperAddress)
    ->setContact($shipperContact);
$recipientAddress = new ComplexType\Address();
$recipientAddress
    ->setStreetLines(['Unit # 102, Pentagon Tower P-4, Magarpatta City, Hadapsar, Pune – 411 013 Maharashtra, India'])
    ->setCity('Herndon')
    ->setStateOrProvinceCode('VA')
    ->setPostalCode('20171')
    ->setCountryCode('US');
$recipientContact = new ComplexType\Contact();
$recipientContact
    ->setPersonName('Nitin Nimbalkar')
    ->setPhoneNumber('9822817746');
$recipient = new ComplexType\Party();
$recipient
    ->setAddress($recipientAddress)
    ->setContact($recipientContact);
$labelSpecification = new ComplexType\LabelSpecification();
$labelSpecification
    ->setLabelStockType(new SimpleType\LabelStockType(SimpleType\LabelStockType::_PAPER_7X4POINT75))
    ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
    ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));
$packageLineItem1 = new ComplexType\RequestedPackageLineItem();

$packageLineItem1
    ->setSequenceNumber(1)
   ->setItemDescription('Product description')
   // ->setDimensions(new ComplexType\Dimensions(array(
     //   'Width' => 10,
      //  'Height' => 10,
      //  'Length' => 25,
     //   'Units' => SimpleType\LinearUnits::_IN
    //)))
    ->setWeight(new ComplexType\Weight(array(
        'Value' => 2,
        'Units' => SimpleType\WeightUnits::_LB
    )));
$shippingChargesPayor = new ComplexType\Payor();
$shippingChargesPayor->setResponsibleParty($shipper);
$shippingChargesPayment = new ComplexType\Payment();
$shippingChargesPayment
    ->setPaymentType(SimpleType\PaymentType::_SENDER)
    ->setPayor($shippingChargesPayor);
$requestedShipment = new ComplexType\RequestedShipment();
$requestedShipment->setShipTimestamp(date('c'));
$requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
$requestedShipment->setServiceType(new SimpleType\ServiceType(SimpleType\ServiceType::_FEDEX_GROUND)); // Pass service Type here
$requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));
$requestedShipment->setShipper($shipper);
$requestedShipment->setRecipient($recipient);
$requestedShipment->setLabelSpecification($labelSpecification);
$requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_ACCOUNT)));
$requestedShipment->setPackageCount(1);
$requestedShipment->setRequestedPackageLineItems([
    $packageLineItem1
]);
$requestedShipment->setShippingChargesPayment($shippingChargesPayment);
$processShipmentRequest = new ComplexType\ProcessShipmentRequest();
$processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
$processShipmentRequest->setClientDetail($clientDetail);
$processShipmentRequest->setVersion($version);
$processShipmentRequest->setRequestedShipment($requestedShipment);
$shipService = new ShipService\Request();
$shipService->getSoapClient()->__setLocation('https://wsbeta.fedex.com:443/web-services/ship'); //https://ws.fedex.com:443/web-services/ship -- production url
$result = $shipService->getProcessShipmentReply($processShipmentRequest);

/*$filepath = "Online-Labels/product-" . time() . ".pdf";
        $str = $result->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][0]->values['Label']->values['Parts'][0]->values['Image'];

        file_put_contents($filepath, $str);
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . ($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        }*/
//echo '<pre>';
//print_r($result);
		echo json_encode(["response"=>$result]);
		
       // $userCredential = new ComplexType\WebAuthenticationCredential();
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
//                ->setStreetLines(['Unit No 20 & 21,Ground Floor,Eastern Plaza,Shivaji Chowk Daftary Road , Malad (East)'])
//                ->setCity('Mumbai')
//                ->setStateOrProvinceCode('MH')
//                ->setPostalCode('400097')
//                ->setCountryCode('IN');
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
//                    'Height' => 3,
//                    'Length' => 10,
//                    'Units' => SimpleType\LinearUnits::_CM
//                )))
//                ->setWeight(new ComplexType\Weight(array(
//                    'Value' => 1,
//                    'Units' => SimpleType\WeightUnits::_KG
//        )));
//
//        $shippingChargesPayor = new ComplexType\Payor();
//        $shippingChargesPayor->setResponsibleParty($shipper);
//        $shippingChargesPayment = new ComplexType\Payment();
//        $shippingChargesPayment
//                ->setPaymentType(SimpleType\PaymentType::_SENDER)
//                ->setPayor($shippingChargesPayor);
//        $requestedShipment = new ComplexType\RequestedShipment();
//
//
//
//        /*         * ***************** Set Custom Clearance  @author Abhishek More **************************** */
//        //$setCustomClearanceReport = new CustomsClearanceDetail();
////        $shipperDetails = new ComplexType\Party();
////        $money = new Money();
////        $money->setAmount('100');
////        $money->setCurrency('USD');
////        $shipperDetails->setAccountNumber(FEDEX_ACCOUNT_NUMBER);
////        $setCustomClearanceReport->setCustomsValue($money);
////        $wieght = new ComplexType\Weight();
////        $wieght->setUnits(SimpleType\WeightUnits::_KG);
////        $wieght->setValue('1');
////        $setCustomClearanceReport->setCommodities(array("Name" => "Jewellry", "NumberOfPieces" => 1, "CountryOfManufacture" => "IN", 'Weight' => $wieght, 'Description' => 'All the details will be provided at the time of shipment', "Quantity" => "1", "QuantityUnits" => 'KG'));
////        $paymentType = new ComplexType\Payment();
////        $paymentType->setPaymentType(SimpleType\PaymentType::_RECIPIENT);
////        $setCustomClearanceReport->setDutiesPayment($paymentType);
////        $requestedShipment->setManualCustomsClearanceDetail($setCustomClearanceReport);
//        /*         * ***************** End Custom Clearance  **************************** */
//
//
//        $requestedShipment->setShipTimestamp(date('c'));
//        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
//        $requestedShipment->setServiceType(new SimpleType\ServiceType(SimpleType\ServiceType::_INTERNATIONAL_PRIORITY));
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
//        //$shipService->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services/ship');
//        $result = $shipService->getProcessShipmentReply($processShipmentRequest);
//        dd($result);
//        $filepath = "Online-Labels/product-" . time() . ".pdf";
//        $str = $result->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][0]->values['Label']->values['Parts'][0]->values['Image'];
//
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
    }

    public function shipNationalOrder($data)
    {
//        dd($data);
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
                ->setMajor(12)
                ->setIntermediate(1)
                ->setMinor(0)
                ->setServiceId('ship');
        $shipperAddress = new ComplexType\Address();
        $shipperAddress
                ->setStreetLines(['Unit No 20 & 21,Ground Floor,Eastern Plaza,Shivaji Chowk Daftary Road , Malad (East)'])
                ->setCity('Mumbai')
                ->setStateOrProvinceCode('MH')
                ->setPostalCode('400097')
                ->setCountryCode('IN');
        $shipperContact = new ComplexType\Contact();
        $shipperContact
                ->setCompanyName('Company Name')
                ->setEMailAddress('test@example.com')
                ->setPersonName('Person Name')
                ->setPhoneNumber(('123-123-1234'));
        $shipper = new ComplexType\Party();
        $shipper
                ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
                ->setAddress($shipperAddress)
                ->setContact($shipperContact);
        $recipientAddress = new ComplexType\Address();
        $recipientAddress
                ->setStreetLines([$data['order']->shipping_address1])
                ->setCity($data['order']->shipping_city)
                ->setStateOrProvinceCode('MH')
                ->setPostalCode('411013')
                ->setCountryCode('IN');
        $recipientContact = new ComplexType\Contact();
        $recipientContact
                ->setPersonName($data['order']->shipping_name)
                ->setPhoneNumber($data['order']->shipping_telephone);
        $recipient = new ComplexType\Party();
        $recipient
                ->setAddress($recipientAddress)
                ->setContact($recipientContact);
        $labelSpecification = new ComplexType\LabelSpecification();
        $labelSpecification
                ->setLabelStockType(new SimpleType\LabelStockType(SimpleType\LabelStockType::_PAPER_7X4POINT75))
                ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
                ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));

        $packageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $packageLineItem1
                ->setSequenceNumber(1)
                ->setItemDescription('Product description')
                ->setDimensions(new ComplexType\Dimensions(array(
                    'Width' => 10,
                    'Height' => 10,
                    'Length' => 25,
                    'Units' => SimpleType\LinearUnits::_IN
                )))
                ->setWeight(new ComplexType\Weight(array(
                    'Value' => 0.01,
                    'Units' => SimpleType\WeightUnits::_KG
        )));

        $shippingChargesPayor = new ComplexType\Payor();
        $shippingChargesPayor->setResponsibleParty($shipper);
        $shippingChargesPayment = new ComplexType\Payment();
        $shippingChargesPayment
                ->setPaymentType(SimpleType\PaymentType::_SENDER)
                ->setPayor($shippingChargesPayor);



        $requestedShipment = new ComplexType\RequestedShipment();
        $requestedShipment->setShipTimestamp(date('c'));
        $requestedShipment->setShipper($shipper);
        $requestedShipment->setRecipient($recipient);
        $requestedShipment->setLabelSpecification($labelSpecification);
        $requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_ACCOUNT)));
        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
        $requestedShipment->setServiceType(new SimpleType\ServiceType($data['service']['service_name']));
        $requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));
		
		$requestedShipment->setPackageCount(1);
        
		/*$requestedShipment->setRequestedPackageLineItems([
          $packageLineItem1
          ]);*/
        
        $requestedShipment->setShippingChargesPayment($shippingChargesPayment);

//        dd($requestedShipment);
        /// author : @abhishekmore  This is mandotory to apply when using fedex frieght economy within shippment in india ///
        $freightDetail = new FreightShipmentDetail();   // // Acc No. for  826552727 Below 6kg
        $freightDetail->setComment("All details will be provided at the time of dispatch");
        $freightDetail->setFedExFreightAccountNumber(FEDEX_ACCOUNT_NUMBER);
        $freightDetail->setLineItems(array("Weight" => array("Units" => 'KG', 'Value' => '1'), "Pieces" => '1', 'Description' => 'All the details will be provided at the time of shipment', 'Packaging' => 'BAG'));
        $freightDetail->setTotalHandlingUnits("1");
        $contactAddress = new ContactAndAddress();
        $contact = new Contact();
        $contact->setEMailAddress("abhishek.m@panaceatek.com");
        $address = new Address();
        $address->setStreetLines('Unit No 20 & 21,Ground Floor,Eastern Plaza,Shivaji Chowk Daftary Road , Malad (East)');
        $address->setStateOrProvinceCode('MH');
        $address->setPostalCode('400097');
        $address->setCity('Mumbai');
        $address->setCountryCode('IN');
        $contactAddress->setContact($contact);
        $contactAddress->setAddress($address);

        //CONSIGNEE
        $freightDetail->setRole('SHIPPER');
        $freightDetail->setFedExFreightBillingContactAndAddress($contactAddress);
        $requestedShipment->setManualFreightShipmentDetail($freightDetail);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */



        $processShipmentRequest = new ComplexType\ProcessShipmentRequest();
        $processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
        $processShipmentRequest->setClientDetail($clientDetail);
        $processShipmentRequest->setVersion($version);
        $processShipmentRequest->setRequestedShipment($requestedShipment);
        $shipService = new ShipService\Request();
//$shipService->getSoapClient()->__setLocation('https://wsbeta.fedex.com:443/web-services/ship'); //https://ws.fedex.com:443/web-services/ship -- production url
        $result = $shipService->getProcessShipmentReply($processShipmentRequest);
		echo '<pre>';
        print_r($result);
        $filepath = "Online-Labels/product-" . time() . ".pdf";
        $str = $result->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][0]->values['Label']->values['Parts'][0]->values['Image'];

        file_put_contents($filepath, $str);
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . ($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        }
    }

    public function shipCodOrder() {
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
                ->setMajor(12)
                ->setIntermediate(1)
                ->setMinor(0)
                ->setServiceId('ship');
        $shipperAddress = new ComplexType\Address();
        $shipperAddress
                ->setStreetLines(['Unit No 20 & 21,Ground Floor,Eastern Plaza,Shivaji Chowk Daftary Road , Malad (East)'])
                ->setCity('Mumbai')
                ->setStateOrProvinceCode('MH')
                ->setPostalCode('400097')
                ->setCountryCode('IN');
        $shipperContact = new ComplexType\Contact();
        $shipperContact
                ->setCompanyName('Company Name')
                ->setEMailAddress('test@example.com')
                ->setPersonName('Person Name')
                ->setPhoneNumber(('123-123-1234'));
        $shipper = new ComplexType\Party();
        $shipper
                ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
                ->setAddress($shipperAddress)
                ->setContact($shipperContact);
        $recipientAddress = new ComplexType\Address();
        $recipientAddress
                ->setStreetLines(['Unit # 102, Pentagon Tower P-4, Slip Road to Tower-3/4, Magarpatta City, Hadapsar'])
                ->setCity('Pune')
                ->setStateOrProvinceCode('MH')
                ->setPostalCode('411013')
                ->setCountryCode('IN');
        $recipientContact = new ComplexType\Contact();
        $recipientContact
                ->setPersonName('Contact Name')
                ->setPhoneNumber('1234567890');
        $recipient = new ComplexType\Party();
        $recipient
                ->setAddress($recipientAddress)
                ->setContact($recipientContact);
        $labelSpecification = new ComplexType\LabelSpecification();
        $labelSpecification
                ->setLabelStockType(new SimpleType\LabelStockType(SimpleType\LabelStockType::_PAPER_7X4POINT75))
                ->setImageType(new SimpleType\ShippingDocumentImageType(SimpleType\ShippingDocumentImageType::_PDF))
                ->setLabelFormatType(new SimpleType\LabelFormatType(SimpleType\LabelFormatType::_COMMON2D));
        $packageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $packageLineItem1
                ->setSequenceNumber(1)
                ->setItemDescription('Product description')
                ->setDimensions(new ComplexType\Dimensions(array(
                    'Width' => 10,
                    'Height' => 10,
                    'Length' => 25,
                    'Units' => SimpleType\LinearUnits::_IN
                )))
                ->setWeight(new ComplexType\Weight(array(
                    'Value' => 2,
                    'Units' => SimpleType\WeightUnits::_LB
        )));
        $shippingChargesPayor = new ComplexType\Payor();
        $shippingChargesPayor->setResponsibleParty($shipper);
        $shippingChargesPayment = new ComplexType\Payment();
        $shippingChargesPayment
                ->setPaymentType(SimpleType\PaymentType::_SENDER)
                ->setPayor($shippingChargesPayor);
        $requestedShipment = new ComplexType\RequestedShipment();
        $requestedShipment->setShipTimestamp(date('c'));
        $requestedShipment->setDropoffType(new SimpleType\DropoffType(SimpleType\DropoffType::_REGULAR_PICKUP));
        $requestedShipment->setServiceType(new SimpleType\ServiceType(SimpleType\ServiceType::_FEDEX_FREIGHT_ECONOMY));
        $requestedShipment->setPackagingType(new SimpleType\PackagingType(SimpleType\PackagingType::_YOUR_PACKAGING));

        /////////// Author: @abhishekMore (This is mandotory when request is for COD)/////////////////////////////
        $obj = new ComplexType\ShipmentSpecialServicesRequested();
        $requestedShipment->dispatchCOD($obj);
        ///////////////////////////////////////////////////////////////
        
        $cod= new ComplexType\CodDetail();
		 
		  
        $requestedShipment->setShipper($shipper);
        $requestedShipment->setRecipient($recipient);
        $requestedShipment->setLabelSpecification($labelSpecification);
        $requestedShipment->setRateRequestTypes(array(new SimpleType\RateRequestType(SimpleType\RateRequestType::_ACCOUNT)));
        $requestedShipment->setPackageCount(1);
        $requestedShipment->setRequestedPackageLineItems([
            $packageLineItem1
        ]);
    
        $requestedShipment->setShippingChargesPayment($shippingChargesPayment);    // Doubt
        
        
        
       /// author : @abhishekmore  This is mandotory to apply when using fedex frieght economy within shippment in india ///
        $freightDetail = new FreightShipmentDetail();   // // Acc No. for  826552727 Below 6kg
        $freightDetail->setComment("All details will be provided at the time of dispatch");
        $freightDetail->setFedExFreightAccountNumber(FEDEX_ACCOUNT_NUMBER);
        $freightDetail->setLineItems(array("Weight" => array("Units" => 'KG', 'Value' => '1'), "Pieces" => '1', 'Description' => 'All the details will be provided at the time of shipment', 'Packaging' => 'BAG'));
        $freightDetail->setTotalHandlingUnits("1");
        $contactAddress = new ContactAndAddress();
        $contact = new Contact();
        $contact->setEMailAddress("abhishek.m@panaceatek.com");
        $address = new Address();
        $address->setStreetLines('Unit No 20 & 21,Ground Floor,Eastern Plaza,Shivaji Chowk Daftary Road , Malad (East)');
        $address->setStateOrProvinceCode('MH');
        $address->setPostalCode('400097');
        $address->setCity('Mumbai');
        $address->setCountryCode('IN');
        $contactAddress->setContact($contact);
        $contactAddress->setAddress($address);

        //CONSIGNEE
        $freightDetail->setRole('SHIPPER');
        $freightDetail->setFedExFreightBillingContactAndAddress($contactAddress);
        $requestedShipment->setManualFreightShipmentDetail($freightDetail);
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// */


        $processShipmentRequest = new ComplexType\ProcessShipmentRequest();
        $processShipmentRequest->setWebAuthenticationDetail($webAuthenticationDetail);
        $processShipmentRequest->setClientDetail($clientDetail);
        $processShipmentRequest->setVersion($version);
        $processShipmentRequest->setRequestedShipment($requestedShipment);
        $shipService = new ShipService\Request();
//$shipService->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services/ship');
        $result = $shipService->getProcessShipmentReply($processShipmentRequest);
        dd($result);
        $filepath = "COD-labels/product-" . time() . ".pdf";
        $str = $result->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][0]->values['Label']->values['Parts'][0]->values['Image'];
        file_put_contents($filepath, $str);
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . ($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        }
//        dd($result);
    }
}

class ABC {

    const _EUROPE_FIRST_INTERNATIONAL_PRIORITY = 'EUROPE_FIRST_INTERNATIONAL_PRIORITY';
    const _FEDEX_1_DAY_FREIGHT = 'FEDEX_1_DAY_FREIGHT';
    const _FEDEX_2_DAY = 'FEDEX_2_DAY';
    const _FEDEX_2_DAY_AM = 'FEDEX_2_DAY_AM';
    const _FEDEX_2_DAY_FREIGHT = 'FEDEX_2_DAY_FREIGHT';
    const _FEDEX_3_DAY_FREIGHT = 'FEDEX_3_DAY_FREIGHT';
    const _FEDEX_EXPRESS_SAVER = 'FEDEX_EXPRESS_SAVER';
    const _FEDEX_FIRST_FREIGHT = 'FEDEX_FIRST_FREIGHT';
    const _FEDEX_FREIGHT_ECONOMY = 'FEDEX_FREIGHT_ECONOMY';
    const _FEDEX_FREIGHT_PRIORITY = 'FEDEX_FREIGHT_PRIORITY';
    const _FEDEX_GROUND = 'FEDEX_GROUND';
    const _FIRST_OVERNIGHT = 'FIRST_OVERNIGHT';
    const _GROUND_HOME_DELIVERY = 'GROUND_HOME_DELIVERY';
    const _INTERNATIONAL_ECONOMY = 'INTERNATIONAL_ECONOMY';
    const _INTERNATIONAL_ECONOMY_FREIGHT = 'INTERNATIONAL_ECONOMY_FREIGHT';
    const _INTERNATIONAL_FIRST = 'INTERNATIONAL_FIRST';
    const _INTERNATIONAL_PRIORITY = 'INTERNATIONAL_PRIORITY';
    const _INTERNATIONAL_PRIORITY_FREIGHT = 'INTERNATIONAL_PRIORITY_FREIGHT';
    const _PRIORITY_OVERNIGHT = 'PRIORITY_OVERNIGHT';
    const _SMART_POST = 'SMART_POST';
    const _STANDARD_OVERNIGHT = 'STANDARD_OVERNIGHT';
    /// Added by @abhishekmore not sure working just checking ///
    const _FEDEX_ECONOMY = 'FEDEX_ECONOMY';

    ///////////////////////////////////////////////////////////
}
