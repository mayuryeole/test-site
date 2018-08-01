<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\PiplModules\cart\Controllers\CartController;
use Auth;
use Auth\User;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Http\Request as Res;
use Illuminate\Support\Facades\Session;;
use URL;
//address validation
use FedEx\RateService\Request;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;
use App\PiplModules\admin\Models\CountryTranslation;
use App\PiplModules\cart\Models\Cart;

class RateRequestController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        define('FEDEX_KEY', 'n47oZv2H73eiuyZv');       // Pipl :MXeyZIFdvQy4F1pl
        define('FEDEX_PASSWORD', 'quGOPGGe5Kx825gY8zfcYtpAl');  // Pipl: Nkzsl7tTFOoqeH5wnKZqLWL6U 
        define('FEDEX_ACCOUNT_NUMBER', '510087160'); // Pipl : 510087380  
        define('FEDEX_METER_NUMBER', '119005049');  // pipl : 119003017 
        define('PRODUCTION_URL', 'https://ws.fedex.com:443/web-services/track');
        define('TESTING_URL', 'https://wsbeta.fedex.com:443/web-services/track');

    }

    public function getHelperFunction()
    {
        $price = \App\Helpers\Helper::setCurrency('CAN');
    }


    public function rateNationalRequest(Res $request)
    { 
        $country_code = '';
        $country_id = '';
        $pin_code = 0;
        $cart = null;
        $weight = 0;
        $totalAmt = 0;
        $length = 0;
        $width = 0;
        $height = 0;
        $arr = array();
        if ($request->country != '' && $request->pin_code != '') {
            $country_id =trim($request->country);
            $countryTrans = CountryTranslation::where('country_id', $country_id)->first();
            if (isset($countryTrans) && count($countryTrans) > 0) {
                $data = array();
                $country_code = $countryTrans->iso_code;
                $pin_code = trim($request->pin_code);
            }
        }
        if (Auth::check()) {
            $cart = Auth::user()->cart;
        } else {
            $cart = Cart::where('ip_address', $request->ip())->first();
        }


        $cartObj = new CartController();
        $totalAmt = $cartObj->getCartTotalAmt($request);
        $grandTotal = $cartObj->calTotalCredit($cart, $totalAmt) - Session::get('all_cart_data.total_savings');
        $weight = floatval($cartObj->getCartTotalWeight($request));

//        if ($cart)
//        {
//            $arr = $cartObj->calCartTotalLBH($cart);
//            $length = $arr['length'];
//            $width = $arr['width'];
//            $height = $arr['height'];
//        }
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
//        dd($arr);
        //RateRequest
        $rateRequest = new ComplexType\RateRequest();
//UserCredential
        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential
            ->setKey(FEDEX_KEY)
            ->setPassword(FEDEX_PASSWORD);
//WebAuthenticationDetail
        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);
        $rateRequest->setWebAuthenticationDetail($webAuthenticationDetail);
//ClientDetail
        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail
            ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setMeterNumber(FEDEX_METER_NUMBER);
        $rateRequest->setClientDetail($clientDetail);
//TransactionDetail
        $transactionDetail = new ComplexType\TransactionDetail();
        $transactionDetail->setCustomerTransactionId('Testing Rate Service request');

        //version
        $rateRequest->Version->ServiceId = 'crs';
        $rateRequest->Version->Major = 10;
        $rateRequest->Version->Minor = 0;
        $rateRequest->Version->Intermediate = 0;

        $rateRequest->ReturnTransitAndCommit = true;
//$rateRequest->PurposeOfShipmentType = 'GIFT';


//shipper
//$rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['Brahampuri'];
//$rateRequest->RequestedShipment->Shipper->Address->City = 'Delhi';

//$rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'DL';
        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = 400097;
        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'IN';

//recipient
//$rateRequest->RequestedShipment->Recipient->Address->StreetLines = ['NIBM Road'];
//$rateRequest->RequestedShipment->Recipient->Address->City = 'Pune';
//$rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'MH';
        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $pin_code;
        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $country_code;

//Purpose Of Shipment Type 
        $rateRequest->RequestedShipment->CustomsClearanceDetail->DutiesPayment->PaymentType = 'SENDER';  //'RECIPIENT' ;
        $rateRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Currency = 'INR';
        $rateRequest->RequestedShipment->CustomsClearanceDetail->CustomsValue->Amount = isset($grandTotal) ? $grandTotal : 0.00; // Grand Total
        $rateRequest->RequestedShipment->CustomsClearanceDetail->CommercialInvoice->Purpose = 'SOLD'; //'GIFT';

//shipping charges payment
        $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
        $rateRequest->RequestedShipment->ShippingChargesPayment->Payor->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $rateRequest->RequestedShipment->ShippingChargesPayment->Payor->CountryCode = 'IN';

//rate request types
        $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_ACCOUNT, SimpleType\RateRequestType::_LIST];

        $rateRequest->RequestedShipment->PackageCount = 1;

//create package line items for group package

//$rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];

//create package line items for single package
        $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem()];
//package 1
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $weight * 0.001;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_KG;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = $length;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = $width;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = $height;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = SimpleType\LinearUnits::_CM;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;
//        dd(\GuzzleHttp\json_encode($rateRequest));
//package 2
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 0.001;
//        $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = SimpleType\WeightUnits::_KG;
//////$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
//////$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
//////$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
//////$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = SimpleType\LinearUnits::_IN;
//       $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;
//          dd(\GuzzleHttp\json_encode($rateRequest));
        $rateServiceRequest = new Request();
        $rateServiceRequest->getSoapClient()->__setLocation(Request::TESTING_URL); //use production URL

        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.
//        dd($rateReply);
        if($rateReply->values['HighestSeverity'] != "FAILURE" || $rateReply->values['HighestSeverity'] != "ERROR")
        {
        $cnt = 0;
        $res = [];
        $finalAmt = array();
        if (!empty($rateReply->RateReplyDetails)) {
            foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
                $res[$cnt]["service-type"] = ($rateReplyDetail->ServiceType);
                $res[$cnt]["delivery"] = ($rateReplyDetail->DeliveryTimestamp);
                if (!empty($rateReplyDetail->RatedShipmentDetails)) {
                    foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
//                        $res[$cnt][$ratedShipmentDetail->ShipmentRateDetail->RateType][]   = ($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
                        $getArray[] = $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount;
                        $getCurrency[] = $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Currency;

                    }
                }
//                var_dump($getArray);
//                var_dump($getCurrency);
//                dd(234);
                $len = count($getArray);
                for ($i = 0; $i < $len; $i++)
                {
                    $toCurrency = $getCurrency[$i];
                    $fromCurrency = 'INR';
                    $getRate = Helper::getInlineCurrency($toCurrency, $fromCurrency);
                    if ($getRate != -1)
                    {
                        $finalAmt[$i] = $getArray[$i] * $getRate;
                    }
                    else
                    {
                        $finalAmt[$i] = $getArray[$i];
                    }
                }
                $min_val =  min($finalAmt);
                $res[$cnt][0] = Helper::getCurrencySymbol().number_format(Helper::getRealPrice($min_val),2,'.','');
                $cnt++;
            }
        }
        if(Session::has('usr_details')== false)
        {
            Session::put('usr_details.country_id',$country_id);
            Session::put('usr_details.pin_code',$pin_code);
            Session::save();
        }
        else{
            Session::put('usr_details.country_id',$country_id);
            Session::put('usr_details.pin_code',$pin_code);
            Session::save();
        }
        echo json_encode(array("success" => '1', 'msg' => "Success", 'arr' => $res));
        exit();
    }
    else{
        // Notifications
        $error = $rateReply->values['Notifications'][0]->values['Message'];
        echo json_encode(array("success" => '0', 'msg' => $rateReply->values['HighestSeverity'],'err'=>$error));
        exit();
    }

    }
    public function rateInternationalRequest(Res $request)
    {
        $country_code ='';
        $country_id ='';
        $pin_code =0;
        $cart =null;
        $weight =0;
        $totalAmt=0;
        $length = 0;
        $width = 0;
        $height = 0;
        $arr =array();
        if($request->country !='' && $request->pin_code !='')
        {
            $country_id = trim($request->country);
            $countryTrans = CountryTranslation::where('country_id',$country_id)->first();
            if(isset($countryTrans) && count($countryTrans)>0)
            {
                $data = array();
                $country_code=$countryTrans->iso_code;
                $pin_code=trim($request->pin_code);
            }
        }
        if(Auth::check())
        {
            $cart = Auth::user()->cart;
        }
        else
        {
            $cart=  Cart::where('ip_address',$request->ip())->first();
        }


        $cartObj = new CartController();
        $totalAmt = $cartObj->getCartTotalAmt($request);
        $grandTotal =$cartObj->calTotalCredit($cart,$totalAmt)-Session::get('all_cart_data.total_savings');
        $weight = floatval($cartObj->getCartTotalWeight($request));

//        if($cart)
//        {
//            $arr = $cartObj->calCartTotalLBH($cart);
//            $length = $arr['length'];
//            $width = $arr['width'];
//            $height = $arr['height'];
//        }
        if($weight <= 350)
        {
            $length = 24;
            $width  = 18;
            $height = 5.5;
            $weight = $weight + 150;
        }
        else if($weight <= 785)
        {
            $length = 28;
            $width  = 11;
            $height = 8;
            $weight = $weight + 215;
        }

        //RateRequest
        //dd(FEDEX_METER_NUMBER);
        $rateRequest = new ComplexType\RateRequest();

//UserCredential
        $userCredential = new ComplexType\WebAuthenticationCredential();
        $userCredential
            ->setKey(FEDEX_KEY)
            ->setPassword(FEDEX_PASSWORD);
//WebAuthenticationDetail
        $webAuthenticationDetail = new ComplexType\WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($userCredential);
        $rateRequest->setWebAuthenticationDetail($webAuthenticationDetail);
//ClientDetail
        $clientDetail = new ComplexType\ClientDetail();
        $clientDetail
            ->setAccountNumber(FEDEX_ACCOUNT_NUMBER)
            ->setMeterNumber(FEDEX_METER_NUMBER);
        $rateRequest->setClientDetail($clientDetail);
//TransactionDetail
        $transactionDetail = new ComplexType\TransactionDetail();
        $transactionDetail->setCustomerTransactionId('Testing Rate Service request');



//version
        $rateRequest->Version->ServiceId = 'crs';
        $rateRequest->Version->Major = 10;
        $rateRequest->Version->Minor = 0;
        $rateRequest->Version->Intermediate = 0;

        $rateRequest->ReturnTransitAndCommit = true;

//shipper
//$rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['10 Fed Ex Pkwy'];
//$rateRequest->RequestedShipment->Shipper->Address->City = 'Memphis';
//$rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'TN';
        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = '400097';
        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'IN';

//recipient
//$rateRequest->RequestedShipment->Recipient->Address->StreetLines = ['13450 Farmcrest Ct'];
//$rateRequest->RequestedShipment->Recipient->Address->City = 'Herndon';
//$rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'VA';
        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $pin_code;
        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $country_code;

//shipping charges payment
        $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
        $rateRequest->RequestedShipment->ShippingChargesPayment->Payor->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $rateRequest->RequestedShipment->ShippingChargesPayment->Payor->CountryCode = 'IN';

//rate request types
        $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_ACCOUNT, SimpleType\RateRequestType::_LIST];

        $rateRequest->RequestedShipment->PackageCount = 1;

//create package line items for group package

//$rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];

//create package line items for single package
        $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem()];
//package 1
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = $weight * 0.001;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_KG;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = $length *(1/2.54);
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = $width*(1/2.54);
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = $height*(1/2.54);
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = SimpleType\LinearUnits::_IN;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;
//        dd(\GuzzleHttp\json_encode($rateRequest));
//package 2
        //$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 5;
        //$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = SimpleType\WeightUnits::_LB;
//$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
//$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
//$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
//$rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = SimpleType\LinearUnits::_IN;
       // $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;

        $rateServiceRequest = new Request();
        $rateServiceRequest->getSoapClient()->__setLocation(Request::TESTING_URL); //use production URL

        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); // send true as the 2nd argument to return the SoapClient's stdClass response.
        $cnt = 0;
        $res =[];
        $finalAmt = array();
        if($rateReply->values['HighestSeverity'] != "FAILURE" || $rateReply->values['HighestSeverity'] != "ERROR")
        {
            if (!empty($rateReply->RateReplyDetails))
            {
                foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
                    $res[$cnt]["service-type"] = ($rateReplyDetail->ServiceType);
                    $res[$cnt]["delivery"] =($rateReplyDetail->DeliveryTimestamp);
                    if (!empty($rateReplyDetail->RatedShipmentDetails)) {
                        foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                            //  dd($ratedShipmentDetail);
//                        $res[$cnt][$ratedShipmentDetail->ShipmentRateDetail->RateType][]   = ($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
                            $getArray[] = $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount;
                            $getcurrency[] = $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Currency;

                        }
                    }
//                dd($getcurrency);
//                dd($getArray);
                    $len = count($getArray);
                    for($i=0;$i<$len;$i++)
                    {
                        $toCurrency = $getcurrency[$i];
                        $fromCurrency = Helper::getCurrency();
                        $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
                        if($getRate !=-1)
                        {
                            $finalAmt[$i] = $getArray[$i] * $getRate;
                        }
                        else
                        {
                          $finalAmt[$i] = $getArray[$i];
                        }
                    }
                    $min_val = min($finalAmt);
                    $res[$cnt][0] = Helper::getCurrencySymbol(). number_format(Helper::getRealPrice($min_val),2,'.','');
                    $cnt++;
                }
            }
            if(Session::has('usr_details')== false)
            {
                Session::put('usr_details.country_id',$country_id);
                Session::put('usr_details.pin_code',$pin_code);
                Session::save();
            }
            else{
                Session::put('usr_details.country_id',$country_id);
                Session::put('usr_details.pin_code',$pin_code);
                Session::save();
            }
            echo json_encode(array("success" => '1', 'msg' => $rateReply->values['HighestSeverity'],'arr'=>$res));
            exit();
        }
        else{
            // Notifications
            $error = $rateReply->values['Notifications'][0]->values['Message'];
            echo json_encode(array("success" => '0', 'msg' => $rateReply->values['HighestSeverity'],'err'=>$error));
            exit();
        }
    }

}
