<?php

namespace App\Http\Controllers;

use App\PiplModules\cart\Models\Order;
use Auth;
use App\Http\Requests;
use FedEx\ShipService\ComplexType\CustomerReference;
use FedEx\ShipService\SimpleType\CustomerReferenceType;
use Illuminate\Http\Response;
use Illuminate\Http\Request as Res;
use Session;
use URL;
//address validation
use FedEx\OpenShipService\Request;
use FedEx\OpenShipService\ComplexType;
use FedEx\OpenShipService\SimpleType;
use GlobalValues;
use SoapClient;

class CreateShipController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        define('FEDEX_KEY', 'XdnjjVB7QdVCsj9j');       // Pipl :MXeyZIFdvQy4F1pl // n47oZv2H73eiuyZv
        define('FEDEX_PASSWORD', 'QlxfQ1YYmppQp0jWb6IuplnTS');  // Pipl:  Nkzsl7tTFOoqeH5wnKZqLWL6U  // quGOPGGe5Kx825gY8zfcYtpAl
        define('FEDEX_ACCOUNT_NUMBER', '543100382'); // Pipl : 510087380 //  
        define('FEDEX_METER_NUMBER', '112783102');  // pipl : 119003017 
        define('PRODUCTION_URL', 'https://ws.fedex.com:443/web-services/ship');
        define('TESTING_URL', 'https://wsbeta.fedex.com:443/web-services/ship'); // https://wsbeta.fedex.com:443/web-services/ship
    }

    public function CreateNationalShipOrder($data)
    {
        $length =0;
        $width =0;
        $height =0;
        $weight =floatval($data['order']['shipping_total_weight']);

        if($weight <= 350)
        {
            $length = 24;
            $width = 18;
            $height = 5.5;
            $weight = $weight + 150;
        }
        else if($weight <= 785)
        {
            $length = 28;
            $width = 11;
            $height = 8;
            $weight = $weight + 215;
        }
        if($weight <= 500)
        {
            $weight=500;
        }

        $customerRef = array('CustomerReferenceType'=>'P_O_NUMBER','Value'=>'B2C');
        $tin = array('TinType'=>'BUSINESS_NATIONAL','Number'=>'GST No:1234567890');
        /********************************************************
         * Create initial open shipment request with 1 package...
         ********************************************************/
        $shipDate = new \DateTime();
        $createOpenShipmentRequest = new ComplexType\CreateOpenShipmentRequest();
// web authentication detail
        $createOpenShipmentRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $createOpenShipmentRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
// client detail
        $createOpenShipmentRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;
        $createOpenShipmentRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
// version
        $createOpenShipmentRequest->Version->ServiceId = 'ship';
        $createOpenShipmentRequest->Version->Major = 11;
        $createOpenShipmentRequest->Version->Intermediate = 0;
        $createOpenShipmentRequest->Version->Minor = 0;

//$customClearence =ComplexType\CustomsClearanceDetail();

// package 1
        $requestedPackageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $requestedPackageLineItem1->SequenceNumber = 1;
        $requestedPackageLineItem1->ItemDescription = 'Product description 1';
//$requestedPackageLineItem1->GroupPackageCount = 1;
//$requestedPackageLineItem1->InsuredValue->Currency = 'INR';
//$requestedPackageLineItem1->InsuredValue->Amount = '600';
        $requestedPackageLineItem1->Dimensions->Width = $width;
        $requestedPackageLineItem1->Dimensions->Height = $height;
        $requestedPackageLineItem1->Dimensions->Length = $length;
        $requestedPackageLineItem1->Dimensions->Units = SimpleType\LinearUnits::_CM;
        $requestedPackageLineItem1->Weight->Value = number_format($weight * 0.001,1,'.','');
        $requestedPackageLineItem1->Weight->Units = SimpleType\WeightUnits::_KG;
        $requestedPackageLineItem1->CustomerReferences = $customerRef;

        $commodity = new ComplexType\Commodity();
        $commodity->Name = 'ABC';
        $commodity->NumberOfPieces = 1;
        $commodity->Description = 'ABC';
        $commodity->CountryOfManufacture = 'IN';
        $commodity->Weight->Units = 'KG';
        $commodity->Weight->Value = number_format($weight * 0.001,1,'.','');
        $commodity->Quantity = 1;
        $commodity->QuantityUnits = 'EA';
        $commodity->UnitPrice->Currency = 'INR';
        $commodity->UnitPrice->Amount = number_format($data['order']['order_total'],2,'.','');
        $commodity->CustomsValue->Currency = 'INR';
        $commodity->CustomsValue->Amount = number_format($data['order']['order_total'],2,'.','');
// requested shipment
        $createOpenShipmentRequest->RequestedShipment->DropoffType = SimpleType\DropoffType::_REGULAR_PICKUP;
        $createOpenShipmentRequest->RequestedShipment->ShipTimestamp = $shipDate->format('c');
        $createOpenShipmentRequest->RequestedShipment->ServiceType = $data['order']['shipping_service_name'];
        $createOpenShipmentRequest->RequestedShipment->PackagingType = SimpleType\PackagingType::_YOUR_PACKAGING;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->ImageType = SimpleType\ShippingDocumentImageType::_PDF;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->LabelFormatType = SimpleType\LabelFormatType::_COMMON2D;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->LabelStockType = SimpleType\LabelStockType::_PAPER_8POINT5X11_TOP_HALF_LABEL; //_PAPER_8.5X11_TOP_HALF_LABEL
        $createOpenShipmentRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED];
        $createOpenShipmentRequest->RequestedShipment->PackageCount = 1;
        $createOpenShipmentRequest->RequestedShipment->RequestedPackageLineItems = [$requestedPackageLineItem1];
// requested shipment shipper
        $createOpenShipmentRequest->RequestedShipment->Shipper->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->StreetLines = ['1234 Main Street','1234 Main Street'];
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->City = 'Mumbai';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'MH';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->PostalCode = '400079';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->CountryCode = 'IN';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->CompanyName = 'Company Name';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->PersonName = 'Person Name';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->EMailAddress = 'shipper@example.com';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->PhoneNumber = '1-123-123-1234';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Tins=$tin;
//        $createOpenShipmentRequest->RequestedShipment->Shipper;
// requested shipment recipient
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StreetLines = ['NIBM Road'];
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->City = 'Pune';
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'MH';
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->PostalCode = '411048';
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->CountryCode = 'IN';
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PersonName = 'Swapnil Daunde';
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->EMailAddress = 'recipient@example.com';
//        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PhoneNumber = '1-321-321-4321';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StreetLines = [$data['order']['shipping_address1'],$data['order']['billing_address1']];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->City = $data['order']['shipping_city'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $data['order']['shipping_state'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->PostalCode = $data['order']['shipping_zip'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->CountryCode = $data['order']['shipping_country'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PersonName = $data['order']['shipping_name'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->EMailAddress = $data['order']['shipping_email'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PhoneNumber = $data['order']['shipping_telephone'];

        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->DutiesPayment->PaymentType = 'RECIPIENT';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Currency = 'INR';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Amount = number_format($data['order']['order_total'],2,'.','');
        if(trim($data['order']['shipping_service_name']) == 'PRIORITY_OVERNIGHT')
        {
            $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CommercialInvoice->Purpose = 'GIFT';
        }
        else
        {
            $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CommercialInvoice->Purpose = 'SOLD';

        }
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->Commodities = $commodity->toArray();

// shipping charges payment
        $createOpenShipmentRequest->RequestedShipment->ShippingChargesPayment->Payor->ResponsibleParty = $createOpenShipmentRequest->RequestedShipment->Shipper;
        $createOpenShipmentRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
//dd(\GuzzleHttp\json_encode($createOpenShipmentRequest));
// send the create open shipment request
        $openShipServiceRequest = new Request();
        $createOpenShipmentReply = $openShipServiceRequest->getCreateOpenShipmentReply($createOpenShipmentRequest);


// shipment is created and we have an index number
        $index = $createOpenShipmentReply->Index;
        /********************************
         * Add a package to open shipment
         ********************************/
        $addPackagesToOpenShipmentRequest = new ComplexType\AddPackagesToOpenShipmentRequest();
// set index
        $addPackagesToOpenShipmentRequest->Index = $index;
// reuse web authentication detail from previous request
        $addPackagesToOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
// reuse client detail from previous request
        $addPackagesToOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
// reuse version from previous request
        $addPackagesToOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $addPackagesToOpenShipmentRequest->RequestedPackageLineItems = $requestedPackageLineItem1->toArray();


// send the add packages to open shipment request
        $addPackagesToOpenShipmentReply = $openShipServiceRequest->getAddPackagesToOpenShipmentReply($addPackagesToOpenShipmentRequest);
        /************************************
         * Retrieve the open shipment details
         ************************************/
        $retrieveOpenShipmentRequest = new ComplexType\RetrieveOpenShipmentRequest();
        $retrieveOpenShipmentRequest->Index = $index;
        $retrieveOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
        $retrieveOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
        $retrieveOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $retrieveOpenShipmentReply = $openShipServiceRequest->getRetrieveOpenShipmentReply($retrieveOpenShipmentRequest);
//dd($retrieveOpenShipmentReply);


        /***********************
         * Confirm open shipment
         ***********************/
        $confirmOpenShipmentRequest = new ComplexType\ConfirmOpenShipmentRequest();
        $confirmOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
        $confirmOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
        $confirmOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $confirmOpenShipmentRequest->Index = $index;
//dd($confirmOpenShipmentRequest);

        $confirmOpenShipmentReply = $openShipServiceRequest->getConfirmOpenShipmentReply($confirmOpenShipmentRequest);
//        dd($confirmOpenShipmentReply);
        if($confirmOpenShipmentReply->values['HighestSeverity'] != "FAILURE" && $confirmOpenShipmentReply->values['HighestSeverity'] != "ERROR")
        {
            $masterTrackArr = $confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['MasterTrackingId']->values;
            $orderObj =Order::find($data['order']['id']);
            if($orderObj)
            {
                $orderObj->master_tracking_id_type = $masterTrackArr['TrackingIdType'];
                $orderObj->master_form_Id =$masterTrackArr['FormId'];
                $orderObj->master_tracking_number =$masterTrackArr['TrackingNumber'];
                if(isset($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']) && count($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'])>0)
                {
                    for($i=0;$i<count($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']);$i++)
                    {
                        $filepath = "Online-Labels/product-".$i. time() . ".pdf";
                        $str = $confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][$i]->values['Label']->values['Parts'][0]->values['Image'];
                        file_put_contents($filepath, $str);
                        if($i==0)
                        {
                            $orderObj->ship_label_pdf =$filepath;
                        }
                        elseif ($i==1)
                        {
                            $orderObj->ship_label_pdf2 =$filepath;
                        }
                    }
                }
                $orderObj->save();
            }
            return 1;
        }
        else
        {
            return 0;
        }

//        $filepath = "Online-Labels/product-" . time() . ".pdf";
//        $str = $confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][0]->values['Label']->values['Parts'][0]->values['Image'];
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
    public function CreateInternationalShipOrder($data)
    {
//        dd($data['order']['order_total']);
        $length =0;
        $width =0;
        $height =0;
        $weight =floatval($data['order']['shipping_total_weight']);

        if($weight <= 350)
        {
            $length = 24;
            $width = 18;
            $height = 5.5;
            $weight = $weight + 150;
        }
        else if($weight <= 785)
        {
            $length = 28;
            $width = 11;
            $height = 8;
            $weight = $weight + 215;
        }

        if($weight <=500)
        {
        	$weight = 500;	
        }
//        dd($length."##".$width."##".$height);

//        dd(212);
        /********************************************************
         * Create initial open shipment request with 1 package...
         ********************************************************/
        $shipDate = new \DateTime();
        $createOpenShipmentRequest = new ComplexType\CreateOpenShipmentRequest();
// web authentication detail
        $createOpenShipmentRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $createOpenShipmentRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
// client detail
        $createOpenShipmentRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;
        $createOpenShipmentRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
// version
        $createOpenShipmentRequest->Version->ServiceId = 'ship';
        $createOpenShipmentRequest->Version->Major = 11;
        $createOpenShipmentRequest->Version->Intermediate = 0;
        $createOpenShipmentRequest->Version->Minor = 0;

//$customClearence =ComplexType\CustomsClearanceDetail();

// package 1
        $requestedPackageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $requestedPackageLineItem1->SequenceNumber = 1;
        $requestedPackageLineItem1->ItemDescription = 'Product description 1';
//$requestedPackageLineItem1->GroupPackageCount = 1;
//$requestedPackageLineItem1->InsuredValue->Currency = 'INR';
//$requestedPackageLineItem1->InsuredValue->Amount = '600';
        $requestedPackageLineItem1->Dimensions->Width = $width;
        $requestedPackageLineItem1->Dimensions->Height = $height;
        $requestedPackageLineItem1->Dimensions->Length = $length;
        $requestedPackageLineItem1->Dimensions->Units = SimpleType\LinearUnits::_CM;
        $requestedPackageLineItem1->Weight->Value = number_format($weight * 0.001,1,'.','');
        $requestedPackageLineItem1->Weight->Units = SimpleType\WeightUnits::_KG;

        $commodity = new ComplexType\Commodity();
        $commodity->Name = 'ABC';
        $commodity->NumberOfPieces = 1;
        $commodity->Description = 'ABC';
        $commodity->CountryOfManufacture = 'IN';
        $commodity->Weight->Units = 'KG';
        $commodity->Weight->Value = number_format($weight * 0.001,1,'.','');
        $commodity->Quantity = 1;
        $commodity->QuantityUnits = 'EA';
        $commodity->UnitPrice->Currency = 'INR';
        $commodity->UnitPrice->Amount = number_format($data['order']['order_total'],2,'.','');
        $commodity->CustomsValue->Currency = 'INR';
        $commodity->CustomsValue->Amount = number_format($data['order']['order_total'],2,'.','');

// requested shipment
        $createOpenShipmentRequest->RequestedShipment->DropoffType = SimpleType\DropoffType::_REGULAR_PICKUP;
        $createOpenShipmentRequest->RequestedShipment->ShipTimestamp = $shipDate->format('c');
        $createOpenShipmentRequest->RequestedShipment->ServiceType =$data['order']['shipping_service_name'];
        $createOpenShipmentRequest->RequestedShipment->PackagingType = SimpleType\PackagingType::_YOUR_PACKAGING;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->ImageType = SimpleType\ShippingDocumentImageType::_PDF;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->LabelFormatType = SimpleType\LabelFormatType::_COMMON2D;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->LabelStockType = SimpleType\LabelStockType::_PAPER_8POINT5X11_TOP_HALF_LABEL;
        $createOpenShipmentRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED];
        $createOpenShipmentRequest->RequestedShipment->PackageCount = 1;
        $createOpenShipmentRequest->RequestedShipment->RequestedPackageLineItems = [$requestedPackageLineItem1];
// requested shipment shipper
        $createOpenShipmentRequest->RequestedShipment->Shipper->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->StreetLines = ['1234 Main Street','1234 Main Street'];
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->City = 'Mumbai';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'MH';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->PostalCode = '400079';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->CountryCode = 'IN';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->CompanyName = 'Company Name';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->PersonName = 'Person Name';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->EMailAddress = 'shipper@example.com';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->PhoneNumber = '1-123-123-1234';
// requested shipment recipient
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StreetLines = [$data['order']['shipping_address1'],$data['order']['billing_address1']];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->City = $data['order']['shipping_city'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $data['order']['shipping_state'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->PostalCode = $data['order']['shipping_zip'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->CountryCode = $data['order']['shipping_country'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PersonName = $data['order']['shipping_name'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->EMailAddress = $data['order']['shipping_email'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PhoneNumber = $data['order']['shipping_telephone'];

        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->DutiesPayment->PaymentType = 'RECIPIENT';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Currency = 'INR';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Amount = number_format($data['order']['order_total'],2,'.','');
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CommercialInvoice->Purpose = 'SOLD';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->Commodities = $commodity->toArray();

// shipping charges payment
        $createOpenShipmentRequest->RequestedShipment->ShippingChargesPayment->Payor->ResponsibleParty = $createOpenShipmentRequest->RequestedShipment->Shipper;
        $createOpenShipmentRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
//dd(\GuzzleHttp\json_encode($createOpenShipmentRequest));
// send the create open shipment request
        $openShipServiceRequest = new Request();
        $createOpenShipmentReply = $openShipServiceRequest->getCreateOpenShipmentReply($createOpenShipmentRequest);


// shipment is created and we have an index number
        $index = $createOpenShipmentReply->Index;
        /********************************
         * Add a package to open shipment
         ********************************/
        $addPackagesToOpenShipmentRequest = new ComplexType\AddPackagesToOpenShipmentRequest();
// set index
        $addPackagesToOpenShipmentRequest->Index = $index;
// reuse web authentication detail from previous request
        $addPackagesToOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
// reuse client detail from previous request
        $addPackagesToOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
// reuse version from previous request
        $addPackagesToOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $addPackagesToOpenShipmentRequest->RequestedPackageLineItems = $requestedPackageLineItem1->toArray();


// send the add packages to open shipment request
        $addPackagesToOpenShipmentReply = $openShipServiceRequest->getAddPackagesToOpenShipmentReply($addPackagesToOpenShipmentRequest);


        ($addPackagesToOpenShipmentReply);
        /************************************
         * Retrieve the open shipment details
         ************************************/
        $retrieveOpenShipmentRequest = new ComplexType\RetrieveOpenShipmentRequest();
        $retrieveOpenShipmentRequest->Index = $index;
        $retrieveOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
        $retrieveOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
        $retrieveOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $retrieveOpenShipmentReply = $openShipServiceRequest->getRetrieveOpenShipmentReply($retrieveOpenShipmentRequest);
//dd($retrieveOpenShipmentReply);


        /***********************
         * Confirm open shipment
         ***********************/
        $confirmOpenShipmentRequest = new ComplexType\ConfirmOpenShipmentRequest();
        $confirmOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
        $confirmOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
        $confirmOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $confirmOpenShipmentRequest->Index = $index;
//dd($confirmOpenShipmentRequest);

        $confirmOpenShipmentReply = $openShipServiceRequest->getConfirmOpenShipmentReply($confirmOpenShipmentRequest);
//         dd($confirmOpenShipmentReply);
        if($confirmOpenShipmentReply->values['HighestSeverity'] != "FAILURE" && $confirmOpenShipmentReply->values['HighestSeverity'] != "ERROR")
        {
            $masterTrackArr = $confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['MasterTrackingId']->values;
            $orderObj =Order::find($data['order']['id']);
            if($orderObj)
            {
                $orderObj->master_tracking_id_type = $masterTrackArr['TrackingIdType'];
                $orderObj->master_form_Id =$masterTrackArr['FormId'];
                $orderObj->master_tracking_number =$masterTrackArr['TrackingNumber'];
                if(isset($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']) && count($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'])>0)
                {
                    for($i=0;$i<count($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']);$i++)
                    {
                        $filepath = "Online-Labels/product-".$i . time() . ".pdf";
                        $str = $confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][$i]->values['Label']->values['Parts'][0]->values['Image'];
                        file_put_contents($filepath, $str);
                        if($i==0)
                        {
                            $orderObj->ship_label_pdf =$filepath;
                        }
                        elseif ($i==1)
                        {
                            $orderObj->ship_label_pdf2 =$filepath;
                        }
                    }
                }
                $orderObj->save();
            }
            return 1;
        }
        else
            {
             return 0;
           }


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
    public function CreateShipOrder()
    {
        $customerRef = array('CustomerReferenceType'=>'CUSTOMER_REFERENCE','Value'=>'1234');  // CUSTOMER_REFERENCE //P_O_NUMBER B2C
        $tin = array('TinType'=>'BUSINESS_NATIONAL','Number'=>'GST No:1234567890');
       // dd(212);
        /********************************************************
         * Create initial open shipment request with 1 package...
         ********************************************************/
        $shipDate = new \DateTime();
        $createOpenShipmentRequest = new ComplexType\CreateOpenShipmentRequest();
// web authentication detail
        $createOpenShipmentRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $createOpenShipmentRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
// client detail
        $createOpenShipmentRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;
        $createOpenShipmentRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
// version
        $createOpenShipmentRequest->Version->ServiceId = 'ship';
        $createOpenShipmentRequest->Version->Major = 11;
        $createOpenShipmentRequest->Version->Intermediate = 0;
        $createOpenShipmentRequest->Version->Minor = 0;

//$customClearence =ComplexType\CustomsClearanceDetail();

// package 1
        $requestedPackageLineItem1 = new ComplexType\RequestedPackageLineItem();
        $requestedPackageLineItem1->SequenceNumber = 1;
        $requestedPackageLineItem1->ItemDescription = 'Product description 1';
//$requestedPackageLineItem1->GroupPackageCount = 1;
//$requestedPackageLineItem1->InsuredValue->Currency = 'INR';
//$requestedPackageLineItem1->InsuredValue->Amount = '600';
         $length = 24;
         $width = 18;
         $height = 5.5;
        //
        $requestedPackageLineItem1->Dimensions->Width =  $width;
        $requestedPackageLineItem1->Dimensions->Height = $height;
        $requestedPackageLineItem1->Dimensions->Length = $length;
        $requestedPackageLineItem1->Dimensions->Units = SimpleType\LinearUnits::_CM;
        $requestedPackageLineItem1->Weight->Value = 0.5;
        $requestedPackageLineItem1->Weight->Units = SimpleType\WeightUnits::_KG;
        $requestedPackageLineItem1->CustomerReferences = $customerRef;

        $commodity = new ComplexType\Commodity();
        $commodity->Name = 'ABC';
        $commodity->NumberOfPieces = 1;
        $commodity->Description = 'ABC';
        $commodity->CountryOfManufacture = 'IN';
        $commodity->Weight->Units = 'KG';
        $commodity->Weight->Value = 0.5;
        $commodity->Quantity = 1;
        $commodity->QuantityUnits = 'EA';
        $commodity->UnitPrice->Currency = 'INR';
        $commodity->UnitPrice->Amount = 1734.25;
        $commodity->CustomsValue->Currency = 'INR';
        $commodity->CustomsValue->Amount = 1734.25;

// requested shipment
        $createOpenShipmentRequest->RequestedShipment->DropoffType = SimpleType\DropoffType::_REGULAR_PICKUP;
        $createOpenShipmentRequest->RequestedShipment->ShipTimestamp = $shipDate->format('c');
        $createOpenShipmentRequest->RequestedShipment->ServiceType = SimpleType\ServiceType::_STANDARD_OVERNIGHT;
        $createOpenShipmentRequest->RequestedShipment->PackagingType = SimpleType\PackagingType::_YOUR_PACKAGING;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->ImageType = SimpleType\ShippingDocumentImageType::_PDF;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->LabelFormatType = SimpleType\LabelFormatType::_COMMON2D;
        $createOpenShipmentRequest->RequestedShipment->LabelSpecification->LabelStockType = SimpleType\LabelStockType::_PAPER_8POINT5X11_TOP_HALF_LABEL;
        $createOpenShipmentRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED];
        $createOpenShipmentRequest->RequestedShipment->PackageCount = 1;
        $createOpenShipmentRequest->RequestedShipment->RequestedPackageLineItems = [$requestedPackageLineItem1];
// requested shipment shipper
        $createOpenShipmentRequest->RequestedShipment->Shipper->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->StreetLines = ['1234 Main Street','54321 1st Ave'];
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->City = 'Mumbai';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'MH';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->PostalCode = '400079';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Address->CountryCode = 'IN';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->CompanyName = 'Company Name';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->PersonName = 'Person Name';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->EMailAddress = 'shipper@example.com';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Contact->PhoneNumber = '1-123-123-1234';
        $createOpenShipmentRequest->RequestedShipment->Shipper->Tins = $tin;
// requested shipment recipient
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StreetLines = ['304-8128 128st','Payal Business Center,Opp Maharaja Sweets'];
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->City = 'Mumbai';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'MH';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->PostalCode = '411028';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Address->CountryCode = 'IN';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PersonName = 'Shiv Chawla';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->EMailAddress = 'recipient@example.com';
        $createOpenShipmentRequest->RequestedShipment->Recipient->Contact->PhoneNumber = '1-321-321-4321';

        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->DutiesPayment->PaymentType = 'RECIPIENT';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Currency = 'INR';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Amount = 1734.25;
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->CommercialInvoice->Purpose = 'SOLD';
        $createOpenShipmentRequest->RequestedShipment->CustomsClearanceDetail->Commodities = $commodity->toArray();

// shipping charges payment
        $createOpenShipmentRequest->RequestedShipment->ShippingChargesPayment->Payor->ResponsibleParty = $createOpenShipmentRequest->RequestedShipment->Shipper;
        $createOpenShipmentRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
// dd($createOpenShipmentRequest);
// send the create open shipment request
        $openShipServiceRequest = new Request();
        $createOpenShipmentReply = $openShipServiceRequest->getCreateOpenShipmentReply($createOpenShipmentRequest);


// shipment is created and we have an index number
        $index = $createOpenShipmentReply->Index;
        /********************************
         * Add a package to open shipment
         ********************************/
        $addPackagesToOpenShipmentRequest = new ComplexType\AddPackagesToOpenShipmentRequest();
// set index
        $addPackagesToOpenShipmentRequest->Index = $index;
// reuse web authentication detail from previous request
        $addPackagesToOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
// reuse client detail from previous request
        $addPackagesToOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
// reuse version from previous request
        $addPackagesToOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $addPackagesToOpenShipmentRequest->RequestedPackageLineItems = $requestedPackageLineItem1->toArray();

// send the add packages to open shipment request
        $addPackagesToOpenShipmentReply = $openShipServiceRequest->getAddPackagesToOpenShipmentReply($addPackagesToOpenShipmentRequest);


//       dd ($addPackagesToOpenShipmentReply);
        /************************************
         * Retrieve the open shipment details
         ************************************/
        $retrieveOpenShipmentRequest = new ComplexType\RetrieveOpenShipmentRequest();
        $retrieveOpenShipmentRequest->Index = $index;
        $retrieveOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
        $retrieveOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
        $retrieveOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $retrieveOpenShipmentReply = $openShipServiceRequest->getRetrieveOpenShipmentReply($retrieveOpenShipmentRequest);


        /***********************
         * Confirm open shipment
         ***********************/
        $confirmOpenShipmentRequest = new ComplexType\ConfirmOpenShipmentRequest();
        $confirmOpenShipmentRequest->WebAuthenticationDetail = $createOpenShipmentRequest->WebAuthenticationDetail;
        $confirmOpenShipmentRequest->ClientDetail = $createOpenShipmentRequest->ClientDetail;
        $confirmOpenShipmentRequest->Version = $createOpenShipmentRequest->Version;
        $confirmOpenShipmentRequest->Index = $index;
        $confirmOpenShipmentReply = $openShipServiceRequest->getConfirmOpenShipmentReply($confirmOpenShipmentRequest);
        dd($confirmOpenShipmentReply);
       //  dd(\GuzzleHttp\json_encode($confirmOpenShipmentReply));


        if(isset($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']))
        {
//            dd(count($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']));
            for($i=0;$i<count($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails']);$i++)
            {
                $filepath = "Online-Labels/product-" .$i. time() . ".pdf";
                $str = $confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'][$i]->values['Label']->values['Parts'][0]->values['Image'];
                file_put_contents($filepath, $str);
            }
//            foreach ($confirmOpenShipmentReply->values['CompletedShipmentDetail']->values['CompletedPackageDetails'] as $label)
//            {
//
////                if (file_exists($filepath))
////                {
////                    header('Content-Description: File Transfer');
////                    header('Content-Type: application/octet-stream');
////                    header('Content-Disposition: attachment; filename="' . ($filepath) . '"');
////                    header('Expires: 0');
////                    header('Cache-Control: must-revalidate');
////                    header('Pragma: public');
////                    header('Content-Length: ' . filesize($filepath));
////                    flush(); // Flush system output buffer
////                    readfile($filepath);
////                    exit;
////                }
//            }
        }

    }
    function addShipper()
    {
        $shipper = array(
            'Contact' => array(
                'PersonName' => 'Sender Name',
                'CompanyName' => 'Sender Company Name',
                'PhoneNumber' => '1234567890'
            ),
            'Address' => array(
                'StreetLines' => ['1 SENDER STREET','1 SENDER STREET'],
                'City' => 'Mumbai',
                'StateOrProvinceCode' => 'MH',
                'PostalCode' => '400079',
                'CountryCode' => 'IN',
                'CountryName' => 'INDIA'
            ),
            'Tins' => array(
            'TinType'=>'BUSINESS_NATIONAL',
            'Number'=>'GST No:1234567890'
            )
        );
        return $shipper;
    }
    function addRecipient($data)
    {
        $recipient = array(
            'Contact' => array(
                'PersonName' => $data->shipping_name,
                'CompanyName' => 'Recipient Company Name',
                'PhoneNumber' => $data->shipping_telephone
            ),
            'Address' => array(
                'StreetLines' => [$data->shipping_address1,$data->shipping_address2],
                'City' => $data->shipping_city,
                'StateOrProvinceCode' => $data->shipping_state,
                'PostalCode' => $data->shipping_zip,
                'CountryCode' => $data->shipping_country,
                'CountryName' =>'India',
                'Residential' => false
            )
        );
        return $recipient;
    }
    function addShippingChargesPayment(){
        $shippingChargesPayment = array(
            'PaymentType' => 'SENDER',
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => '543100382',//getProperty('billaccount'),
                    'Contact' => null,
                    'Address' => array('CountryCode' => 'IN')
                )
            )
        );
        return $shippingChargesPayment;
    }
    function addLabelSpecification()
    {
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_8.5X11_TOP_HALF_LABEL'
        );
        return $labelSpecification;
    }
    function addSpecialServices1($data){
        $specialServices = array(
            'SpecialServiceTypes' => 'COD',
            'CodDetail' => array(
                'CodCollectionAmount' => array(
                    'Currency' => 'INR',
                    'Amount' => number_format($data->order_total,2,'.','')
                ),
                'CollectionType' => 'CASH'
//            ,// GUARANTEED_FUNDS,ANY, GUARANTEED_FUNDS
//                'FinancialInstitutionContactAndAddress' => array(
//                    'Contact' => array(
//                        'PersonName' => 'Shiv Chawla',
//                        'CompanyName' => "Chawla's International",
//                        'PhoneNumber' => '8888888888'
//                    ),
//                    'Address' => array(
//                        'StreetLines' => ['1234 Main Street','1234 Main Street'],
//                        'City' => 'Mumbai',
//                        'StateOrProvinceCode' => 'MH',
//                        'PostalCode' => '400079',
//                        'CountryCode' => 'IN',
//                        'CountryName' => 'INDIA'
//                    )
//                ),
//                'RemitToName' => 'Remitter'
            )
        );
        return $specialServices;
    }
    function addCustomClearanceDetail($data)
    {
        $customerClearanceDetail = array(
            'DutiesPayment' => array(
                'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
                'Payor' => array(
                    'ResponsibleParty' => array(
                        'AccountNumber' => '543100382',//getProperty('dutyaccount'),
                        'Contact' => null,
                        'Address' => array(
                            'CountryCode' => 'IN'
                        )
                    )
                )
            ),
            'DocumentContent' => 'NON_DOCUMENTS',
            'CustomsValue' => array(
                'Currency' => 'INR',
                'Amount' => number_format($data->order_total,2,'.','')
            ),
            'CommercialInvoice' => array(
                'Purpose' => 'SOLD',
                'CustomerReferences' => array(
                    'CustomerReferenceType' => 'CUSTOMER_REFERENCE',
                    'Value' => '1234'
                )
            ),
            'Commodities' => array(
                'NumberOfPieces' => 1,
                'Description' => 'Books',
                'CountryOfManufacture' => 'IN',
                'Weight' => array(
                    'Units' => 'KG',
                    'Value' => floatval($data->shipping_total_weight) *0.001
                ),
                'Quantity' => 1,
                'QuantityUnits' => 'EA',
                'UnitPrice' => array(
                    'Currency' => 'INR',
                    'Amount' => number_format($data->order_total,2,'.','')
                ),
                'CustomsValue' => array(
                    'Currency' => 'INR',
                    'Amount' => number_format($data->order_total,2,'.','')
                )
            )
        );
        return $customerClearanceDetail;
    }
    function addPackageLineItem1($data)
    {
        $length =0;
        $width =0;
        $height =0;
        $weight =0;
        $weight =floatval($data->shipping_total_weight);

        if($weight <= 350)
        {
            $length = 24;
            $width = 18;
            $height = 5.5;
            $weight = $weight + 150;
        }
        else if($weight <= 785)
        {
            $length = 28;
            $width = 11;
            $height = 8;
            $weight = $weight + 215;
        }
        if($weight <= 500)
        {
           $weight = 500;	
        }

        $packageLineItem = array(
            'SequenceNumber'=>1,
            'GroupPackageCount'=>1,
            'InsuredValue' => array(
                'Amount' => number_format($data->order_total,2,'.',''),
                'Currency' => 'INR'
            ),
            'Weight' => array(
                'Value' => number_format($weight * 0.001,1,'.',''),
                'Units' => 'KG'
            ),
            'Dimensions' => array(
                'Length' => $length,
                'Width' => $width,
                'Height' => $height,
                'Units' => 'CM'
            ),
            'CustomerReferences' => array(

//                'CustomerReferenceType' => 'P_O_NUMBER', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
//                'Value' => 'B2C'
                array(
                    'CustomerReferenceType' => 'P_O_NUMBER', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY P_O_NUMBER
                    'Value' => 'B2C'  // BILL D/T: SENDER GR4567892

                    // DEPARTMENT_NUMBER   BILL D/T: SENDER
                    // P_O_NUMBER             B2C
                ),
                array(
                    'CustomerReferenceType' => 'DEPARTMENT_NUMBER', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY P_O_NUMBER
                    'Value' => 'BILL D/T: SENDER'  // BILL D/T: SENDER GR4567892

                    // DEPARTMENT_NUMBER   BILL D/T: SENDER
                    // P_O_NUMBER             B2C
                )
            )
        );
        return $packageLineItem;
    }


    function addDomShipper(){
    $shipper = array(
        'Contact' => array(
            'PersonName' => 'Shiv Chawla',
            'CompanyName' => 'Chawlas international',
            'PhoneNumber' => '1234567890'
        ),
        'Address' => array(
            'StreetLines' => array("1 SENDER STREET","1 SENDER STREET"),
            'City' => 'MUMBAI',
            'StateOrProvinceCode' => 'MH',
            'PostalCode' => '400079',
            'CountryCode' => 'IN',
            'CountryName' => 'INDIA'
        ), 
        'Tins' => array(
            'TinType'=>'BUSINESS_NATIONAL',
            'Number'=>'GST No:1234567890'
            )
    );
    return $shipper;
}
function addDomRecipient(){
    $recipient = array(
        'Contact' => array(
            'PersonName' => 'Swapnil daunde',
            'CompanyName' => 'Company Name',
            'PhoneNumber' => '1234567890'
        ),
        'Address' => array(
            'StreetLines' => array("magarpatta","noble"),
            'City' => 'PUNE',
            'StateOrProvinceCode' => 'MH',
            'PostalCode' => '411028',
            'CountryCode' => 'IN',
            'CountryName' => 'INDIA',
            'Residential' => false
        )
    );
    return $recipient;                                      
}
function addDomShippingChargesPayment(){
    $shippingChargesPayment = array(
        'PaymentType' => 'SENDER',
        'Payor' => array(
            'ResponsibleParty' => array(
                'AccountNumber' => '543100382', //getProperty('billaccount'),
                'Contact' => null,
                'Address' => array('CountryCode' => 'IN')
            )
        )
    );
    return $shippingChargesPayment;
}
function addDomLabelSpecification(){
    $labelSpecification = array(
        'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
        'ImageType' => 'PDF',  // valid values DPL, EPL2, PDF, ZPLII and PNG
        'LabelStockType' => 'PAPER_8.5X11_TOP_HALF_LABEL'  //PAPER_7X4.75  PAPER_8.5X11_TOP_HALF_LABEL
    );
    return $labelSpecification;
}
function addDomSpecialServices1(){
    $specialServices = array(
        'SpecialServiceTypes' => 'COD',
        'CodDetail' => array(
            'CodCollectionAmount' => array(
                'Currency' => 'INR', 
                'Amount' => 100
            ),
            'CollectionType' => 'CASH'
            // ,// ANY, GUARANTEED_FUNDS
            // 'FinancialInstitutionContactAndAddress' => array(
            //  'Contact' => array(
            //      'PersonName' => 'Financial Contact',
            //      'CompanyName' => 'Financial Company',
            //      'PhoneNumber' => '8888888888'
            //  ),
            //  'Address' => array(
            //      'StreetLines' => '1 FINANCIAL STREET',
            //      'City' => 'NEWDELHI',
            //      'StateOrProvinceCode' => 'DL',
            //      'PostalCode' => '110010',
            //      'CountryCode' => 'IN',
            //      'CountryName' => 'INDIA'
            //  )
            // ),
            // 'RemitToName' => 'Remitter'
        )
    );
    return $specialServices; 
}
function addDomCustomClearanceDetail()
{
    $customerClearanceDetail = array(
        'DutiesPayment' => array(
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array(
                'ResponsibleParty' => array(
                    'AccountNumber' => '543100382',//getProperty('dutyaccount'),
                    'Contact' => null,
                    'Address' => array(
                        'CountryCode' => 'IN'
                    )
                )
            )
        ),
        'DocumentContent' => 'NON_DOCUMENTS',                                                                                            
        'CustomsValue' => array(
            'Currency' => 'INR', 
            'Amount' => 400.0
        ),
        'CommercialInvoice' => array(
            'Purpose' => 'SOLD',
            'CustomerReferences' => array(
                'CustomerReferenceType' => 'CUSTOMER_REFERENCE',
                'Value' => '1234'
            )
        ),
        'Commodities' => array(
            'NumberOfPieces' => 1,
            'Description' => 'Books',
            'CountryOfManufacture' => 'IN',
            'Weight' => array(
                'Units' => 'KG', 
                'Value' => 1.0
            ),
            'Quantity' => 4,
            'QuantityUnits' => 'EA',
            'UnitPrice' => array(
                'Currency' => 'INR', 
                'Amount' => 100.000000
            ),
            'CustomsValue' => array(
                'Currency' => 'INR', 
                'Amount' => 400.000000
            )
        )
    );
    return $customerClearanceDetail;
}
function addDomPackageLineItem1()
{
    $packageLineItem = array(
        'SequenceNumber'=>1,
        'GroupPackageCount'=>1,
        'InsuredValue' => array(
            'Amount' => 80.00, 
            'Currency' => 'INR'
        ),
        'Weight' => array(
            'Value' => 20.0,
            'Units' => 'KG'
        ),
        'Dimensions' => array(
            'Length' => 20,
            'Width' => 10,
            'Height' => 10,
            'Units' => 'CM'
        ),
        'CustomerReferences' => array(array(
            'CustomerReferenceType' => 'P_O_NUMBER', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY P_O_NUMBER
            'Value' => 'B2C'  // BILL D/T: SENDER GR4567892

            // DEPARTMENT_NUMBER   BILL D/T: SENDER
            // P_O_NUMBER             B2C
         ),
        array(
            'CustomerReferenceType' => 'DEPARTMENT_NUMBER', // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY P_O_NUMBER
            'Value' => 'BILL D/T: SENDER'  // BILL D/T: SENDER GR4567892

            // DEPARTMENT_NUMBER   BILL D/T: SENDER
            // P_O_NUMBER             B2C
         ))
    );
    return $packageLineItem;
}


    function shipCodOrder($data)
    {
// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 12.0.0

        require_once('fedex-common.php');

//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
        $path_to_wsdl = "ShipService_v21.wsdl";

// PDF label files. Change to file-extension .png for creating a PNG label (e.g. shiplabel.png)
        define('SHIP_LABEL', 'shiplabel.pdf');
        define('COD_LABEL', 'codlabel.pdf');

        ini_set("soap.wsdl_cache_enabled", "0");

        $client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

        $request['WebAuthenticationDetail'] = array(
            'ParentCredential' => array(
                'Key' => 'XdnjjVB7QdVCsj9j',//getProperty('n47oZv2H73eiuyZv'),
                'Password' => 'QlxfQ1YYmppQp0jWb6IuplnTS' //getProperty('parentpassword')
            ),
            'UserCredential' => array(
                'Key' => 'XdnjjVB7QdVCsj9j',//getProperty('key'),
                'Password' => 'QlxfQ1YYmppQp0jWb6IuplnTS'//getProperty('password')
            )
        );

        $request['ClientDetail'] = array(
            'AccountNumber' => '543100382', //getProperty('shipaccount'),
            'MeterNumber' => '112783102' //getProperty('meter')
        );
        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Intra India Shipping Request using PHP ***');
        $request['Version'] = array(
            'ServiceId' => 'ship',
            'Major' => '21',
            'Intermediate' => '0',
            'Minor' => '0'
        );
        $request['RequestedShipment'] = array(
            'ShipTimestamp' => date('c'),
            'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
            'ServiceType' => $data->shipping_service_name, // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_EXPRESS_SAVER
            'PackagingType' => 'STANDARD_OVERNIGHT', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
            'Shipper' => $this->addShipper(),
            'Recipient' => $this->addRecipient($data),
            'ShippingChargesPayment' => $this->addShippingChargesPayment(),
            'SpecialServicesRequested' => $this->addSpecialServices1($data), //Used for Intra-India shipping - cannot use with PRIORITY_OVERNIGHT
            'CustomsClearanceDetail' => $this->addCustomClearanceDetail($data),
            'LabelSpecification' => $this->addLabelSpecification(),
            'CustomerSpecifiedDetail' => array('MaskedData'=> '543100382'),
            'PackageCount' => 1,
            'RequestedPackageLineItems' => array(
                '0' => $this->addPackageLineItem1($data)
            )
        );


//        dd(\GuzzleHttp\json_encode($request));
        try{
            if(setEndpoint('changeEndpoint')){
                $newLocation = $client->__setLocation(setEndpoint('endpoint'));
            }

            $response = $client->processShipment($request); // FedEx web service invocation
            if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR')
            {
                $masterTrack = $response->CompletedShipmentDetail->MasterTrackingId;
                $orderObj =Order::find($data->id);
                if($orderObj)
                {
                    $orderObj->master_tracking_id_type = $masterTrack->TrackingIdType;
                    $orderObj->master_form_Id =$masterTrack->FormId;
                    $orderObj->master_tracking_number =$masterTrack->TrackingNumber;
                    $filepath1 = "COD-labels/shiplabel-" . time() . ".pdf";
                    $str = $response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image;
                    file_put_contents($filepath1, $str);
                    $filepath2 = "COD-labels/codlabel-" . time() . ".pdf";
                    $str = $response->CompletedShipmentDetail->AssociatedShipments->Label->Parts->Image;
                    file_put_contents($filepath2, $str);
                    $orderObj->ship_label_pdf =$filepath1;
                    $orderObj->cod_label_pdf =$filepath2;
                    $orderObj->save();
                }
                return '1';
            }
            else{
                printError($client, $response);
            }

            writeToLog($client);    // Write to log file
            return '0';
        } catch (SoapFault $exception) {
            printFault($exception, $client);
            return '0';
        }
    }

    function shipDomOrder()
    {
        // Copyright 2009, FedEx Corporation. All rights reserved.
// Version 12.0.0
error_reporting(E_ALL);
require_once('fedex-common.php5');

//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "ShipService_v21.wsdl";

// PDF label files. Change to file-extension .png for creating a PNG label (e.g. shiplabel.png)
define('SHIP_LABEL', 'shiplabel.pdf');  
define('COD_LABEL', 'codlabel.pdf'); 

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
    'ParentCredential' => array(
        'Key' => 'XdnjjVB7QdVCsj9j', //getProperty('parentkey'), //n47oZv2H73eiuyZv
        'Password' => 'QlxfQ1YYmppQp0jWb6IuplnTS' //getProperty('parentpassword')
    ), // XdnjjVB7QdVCsj9j   //QlxfQ1YYmppQp0jWb6IuplnTS
    'UserCredential' => array(
        'Key' => 'XdnjjVB7QdVCsj9j', //getProperty('parentkey'), 
        'Password' => 'QlxfQ1YYmppQp0jWb6IuplnTS' //getProperty('parentpassword')
        // quGOPGGe5Kx825gY8zfcYtpAl
    )
);

$request['ClientDetail'] = array(
    'AccountNumber' => '543100382', //getProperty('shipaccount'), 
    'MeterNumber' => '112783102'  //getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Intra India Shipping Request using PHP ***');
$request['Version'] = array(
    'ServiceId' => 'ship', 
    'Major' => '21', 
    'Intermediate' => '0', 
    'Minor' => '0'
);
$request['RequestedShipment'] = array(
    'ShipTimestamp' => date('c'),
    'DropoffType' => 'REGULAR_PICKUP', // valid values REGULAR_PICKUP, REQUEST_COURIER, DROP_BOX, BUSINESS_SERVICE_CENTER and STATION
    'ServiceType' => 'STANDARD_OVERNIGHT', // valid values STANDARD_OVERNIGHT, PRIORITY_OVERNIGHT, FEDEX_EXPRESS_SAVER
    'PackagingType' => 'YOUR_PACKAGING', // valid values FEDEX_BOX, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING, ...
    'Shipper' => $this->addDomShipper(),
    'Recipient' => $this->addDomRecipient(),
    'ShippingChargesPayment' => $this->addDomShippingChargesPayment(),
    'SpecialServicesRequested' => $this->addDomSpecialServices1(), //Used for Intra-India shipping - cannot use with PRIORITY_OVERNIGHT
    'CustomsClearanceDetail' => $this->addDomCustomClearanceDetail(),                                                                                                      
    'LabelSpecification' => $this->addDomLabelSpecification(),
    'CustomerSpecifiedDetail' => array('MaskedData'=> '543100382'), 
    'PackageCount' => 1,                                       
    'RequestedPackageLineItems' => array(
        '0' => $this->addDomPackageLineItem1()
    )
);

try{
    if(setEndpoint('changeEndpoint')){
        $newLocation = $client->__setLocation(setEndpoint('endpoint'));
    }
    
    $response = $client->processShipment($request); // FedEx web service invocation
    // dd(\GuzzleHttp\json_encode($response));
    if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR'){
        // printSuccess($client, $response);

       $filepath1 = "COD-labels/shiplabel-" . time() . ".pdf";
                    $str = $response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image;
                    file_put_contents($filepath1, $str);
                    $filepath2 = "COD-labels/codlabel-" . time() . ".pdf";
                    $str = $response->CompletedShipmentDetail->AssociatedShipments->Label->Parts->Image;
                    file_put_contents($filepath2, $str);
                    
        // Create PNG or PDF labels
        // Set LabelSpecification.ImageType to 'PNG' for generating a PNG labels
        // $fp = fopen(SHIP_LABEL, 'wb');   
        // fwrite($fp, ($response->CompletedShipmentDetail->CompletedPackageDetails->Label->Parts->Image));
        // fclose($fp);
        // echo 'Label <a href="./'.SHIP_LABEL.'">'.SHIP_LABEL.'</a> was generated.';           
        
        // $fp = fopen(COD_LABEL, 'wb');   
        // fwrite($fp, ($response->CompletedShipmentDetail->AssociatedShipments->Label->Parts->Image));
        // fclose($fp);
        echo 'Label <a href="./'.COD_LABEL.'">'.COD_LABEL.'</a> was generated.';   
        }else{
            printError($client, $response);
        }
    
        writeToLog($client);    // Write to log file
    }
    catch (SoapFault $exception)
    {
        printFault($exception, $client);
    }
    }

}
