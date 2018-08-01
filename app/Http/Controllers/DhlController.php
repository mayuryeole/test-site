<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use DHL\Express\Webservice\TrackingService;
use DHL\Express\Webservice\ShipmentRequestService;
use DHL\Express\Webservice\ContactInfoType;
use DHL\Entity\GB\ShipmentRequest;
use DHL\Express\Webservice\ShipmentInfoType;
use App\PiplModules\admin\Models\CountryTranslation;
use App\PiplModules\cart\Controllers\CartController;
use Auth;
use App\PiplModules\cart\Models\Cart;
use Illuminate\Support\Facades\Session;
use App\Helpers\Helper;

class DhlController extends Controller
{

//    const MAX_TRANSIT_TIME_DAYS = 3;
    public function __construct()
    {
        define('MAX_TRANSIT_TIME_DAYS', 3);       // Pipl :MXeyZIFdvQy4F1pl
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');


        $fromAddress = \Shippo_Address::create( array(
            "name" => "Shawn Ippotle",
            "company" => "Shippo",
            "street1" => "215 Clayton St.",
            "city" => "San Francisco",
            "state" => "CA",
            "zip" => "94117",
            "country" => "US",
            "email" => "shippotle@goshippo.com",
            "validate" => true
        ));
         $arr =json_decode($fromAddress,true);
         $object_id =$arr['object_id'];
        dd($object_id);
         $fromAddress = \Shippo_Address::validate($object_id);

//        print_r($fromAddress);
//        dd (json_decode($fromAddress,true));
        $validArr =json_decode($fromAddress,true);
//        dd($validArr['validation_results']['is_valid']);
        return $validArr['validation_results']['is_valid'];

    }
    public function valiadateAddress($country_cide,$zip)
    {
        $toAddress = \Shippo_Address::create( array(
            "zip" => $zip,
            "country" => $country_cide,
            "validate" => true
        ));
        $arr =json_decode($toAddress,true);
        $object_id =$arr['object_id'];
        $toAddress = \Shippo_Address::validate($object_id);
        $validArr =json_decode($toAddress,true);
        return $validArr['validation_results']['is_valid'];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function international()
    {
        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');
        //shippo_test_d36106395f5e193336d71737ac26208fef870f4e

        $from_address = array(
            'name' => 'Mr Hippo',
            'company' => 'Shippo',
            'street1' => '215 Clayton St.',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94117',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
            'email' => 'mr-hippo@goshipppo.com',
        );

        $to_address = array(
            'name' => 'Ms Hippo',
            'company' => 'Regents Park',
            'street1' => 'Outer Cir',
            'city' => 'London',
            'zip' => 'NW1 4RY',
            'country' => 'GB',
            'phone' => '+1 555 341 9393',
            'email' => 'ms-hippo@goshipppo.com',
            'metadata' =>  'For Order Number 123',
        );

        $parcel = array(
            'length'=> '5',
            'width'=> '5',
            'height'=> '5',
            'distance_unit'=> 'in',
            'weight'=> '2',
            'mass_unit'=> 'lb',

        );


        $customs_item = array(
            'description' => 'T-Shirt',
            'quantity' => '2',
            'net_weight' => '400',
            'mass_unit' => 'g',
            'value_amount' => '20',
            'value_currency' => 'USD',
            'origin_country' => 'US',
            'tariff_number' => '',
        );


        $customs_declaration = \Shippo_CustomsDeclaration::create(
            array(
                'contents_type'=> 'MERCHANDISE',
                'contents_explanation'=> 'T-Shirt purchase',
                'non_delivery_option'=> 'RETURN',
                'certify'=> 'true',
                'certify_signer'=> 'Mr Hippo',
                'items'=> array($customs_item),
            ));


        $shipment = \Shippo_Shipment::create(
            array(
                'address_from' => $from_address,
                'address_to' => $to_address,
                'parcels'=> array($parcel),
                'customs_declaration' => $customs_declaration -> object_id,
                'async' => false,
            )
        );

        $rate = $shipment['rates'][0];

        $transaction = \Shippo_Transaction::create(array(
            'rate'=> $rate['object_id'],
            'async'=> false,
        ));

        return json_decode($transaction,true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function createDhlShipment($data)
    {
        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');

        $length =0;
        $width =0;
        $height =0;
        $weight=0;
        $distance_unit='';
        $mass_unit='';

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


        if($data['order']['shipping_service_type'] == "national")
        {
            $distance_unit ='cm';
            $mass_unit ='kg';
            $weight *=0.001;
        }
        else if($data['order']['shipping_service_type'] == "international")
        {
            $distance_unit ='in';
            $mass_unit ='lb';
            $length =number_format($length *(1/2.54),2,'.','');
            $width =number_format($width*(1/2.54),2,'.','');
            $height =number_format($height*(1/2.54),2,'.','');
            $weight = number_format($weight *0.00220462262185,2,'.','');
        }

        $from_address = array(
            'name' => 'Shawn Ippotle',
            'company' => 'Shippo',
            'street1' => '215 Clayton St.',
            'city' => 'Mumbai',
            'state' => 'MH',
            'zip' => '400097',
            'country' => 'IN',
            'phone' => '+91 9657199892',
            'email' => 'mr-hippo@goshipppo.com',
        );

        $to_address = array(
            'name' => $data['order']['shipping_name'],
            'company' => 'San Diego Zoo',
            'street1' => $data['order']['shipping_address1'],
            'city' => $data['order']['shipping_city'],
            'state' => $data['order']['shipping_state'],
            'zip' => $data['order']['shipping_zip'],
            'country' => $data['order']['shipping_country'],
            'phone' => $data['order']['shipping_telephone'],
            'email' => $data['order']['shipping_email']
        );
        $parcel = array(
            'length'=> $length,
            'width'=> $width,
            'height'=> $height,
            'distance_unit'=> $distance_unit,
            'weight'=> $weight,
            'mass_unit'=> $mass_unit,
        );

//        $customs_item = array(
//            'COD'=> array('COD.amount'=>'12.23'));


        $shipment = \Shippo_Shipment::create(
            array(
                'address_from'=> $from_address,
                'address_to'=> $to_address,
                'parcels'=> array($parcel),
                'async'=> false
//                'extra'=>$customs_item,
            ));
        echo '<pre>';
        print_r($shipment);

        $eligible_rates = array_values(array_filter(
            $shipment['rates'],
            function($rate){
                return $rate['days'] <= MAX_TRANSIT_TIME_DAYS;
            }
        ));


        usort($eligible_rates, function($a, $b) {
            return $a['days'] - $b['days'];
        });


        $transaction = \Shippo_Transaction::create(array(
            'rate'=> $eligible_rates[0]['object_id'],
            'async'=> false,
        ));
        echo '<pre>';
        print_r($transaction);
        return json_decode($transaction,true);
    }

    public function createshipment(Request $request)
    {
        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');
//        \Shippo::setApiKey('shippo_test_625bdc79d9093dbc9c9c19f78fdb6c4de2d012be');

        $from_address = array(
            'name' => 'Chawlas International',
            'company' => 'Chawla’s International',
            'street1' => 'Unit No 20/21 , Eastern Plaza, Daftary Road , Malad (East), ',
            'city' => 'Mumbai',
            'state' => 'MH',
            'zip' => '400097',
            'country' => 'IN',
            'phone' => '+917743968747',
            'email' => 'mr-hippo@goshipppo.com',
        );

//        $from_address = array(
//            'name' => 'Shawn Ippotle',
//            'company' => 'Shippo',
//            'street1' => '215 Clayton St.',
//            'city' => 'San Francisco',
//            'state' => 'CA',
//            'zip' => '94117',
//            'country' => 'US',
//            'phone' => '+91 9657199892',
//            'email' => 'mr-hippo@goshipppo.com',
//        );

        $to_address = array(
            'name' => 'Ms ram sawake',
            'company' => 'San Diego Zoo',
            'street1' => '2920 Zoo Drive',
            'city' => 'San Diego',
            'state' => 'CA',
            'zip' => '92101',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
            'email' => 'ms-hippo@goshipppo.com'
        );

        $parcel = array(
            'length'=> '5',
            'width'=> '5',
            'height'=> '5',
            'distance_unit'=> 'in',
            'weight'=> '2',
            'mass_unit'=> 'lb',
        );

//        $customs_item = array(
//            'COD'=> array('COD.amount'=>'12.23'));


        $shipment = \Shippo_Shipment::create(
            array(
                'address_from'=> $from_address,
                'address_to'=> $to_address,
                'parcels'=> array($parcel),
                'async'=> false
//                'extra'=>$customs_item,
            ));
        $shiArr =\GuzzleHttp\json_decode($shipment,true);
        dd($shiArr);
        if($shiArr['status']=='SUCCESS')
        {
//            dd($shiArr);
            if(count($shiArr['rates'])>0)
            {
                $eligible_rates = array_values(array_filter(
                    $shipment['rates'],
                    function($rate){
                        return $rate['days'] <= MAX_TRANSIT_TIME_DAYS;
                    }
                ));
                usort($eligible_rates, function($a, $b) {
                    return $a['days'] - $b['days'];
                });

//                dd($eligible_rates);
                $transaction = \Shippo_Transaction::create(array(
                    'rate'=> $eligible_rates[0]['object_id'],
                    'async'=> false,
                ));
                return(json_decode($transaction,true)) ;

            }
            else{
                dd('Rates are not available');
            }
        }
        else{
            dd($shiArr['status']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function createshipment(Request $request)
//    {
//        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');
//        $from_address = array(
//            'name' => 'Chawlas International',
//            'company' => 'Chawla’s International',
//            'street1' => 'Unit No 20/21 , Eastern Plaza, Daftary Road , Malad (East), ',
//            'city' => 'Mumbai',
//            'state' => 'MH',
//            'zip' => '400097',
//            'country' => 'IND',
//            'phone' => '+917743968747',
//            'email' => 'mr-hippo@goshipppo.com',
//        );
//
//        $to_address = array(
//            'name' => 'Ms ram sawake',
//            'company' => 'San Diego Zoo',
//            'street1' => '2920 Zoo Drive',
//            'city' => 'San Diego',
//            'state' => 'CA',
//            'zip' => '92101',
//            'country' => 'US',
//            'phone' => '+1 555 341 9393',
//            'email' => 'ms-hippo@goshipppo.com',
//        );
//        $parcel = array(
//            'length'=> '5',
//            'width'=> '5',
//            'height'=> '5',
//            'distance_unit'=> 'in',
//            'weight'=> '2',
//            'mass_unit'=> 'lb',
//        );
//
//
//
//
//        $shipment = \Shippo_Shipment::create(
//            array(
//                'address_from'=> $from_address,
//                'address_to'=> $to_address,
//                'parcels'=> array($parcel),
//                'async'=> false,
//            ));
//        $eligible_rates = array_values(array_filter(
//            $shipment['rates'],
//            function($rate){
//                return $rate['days'] <= MAX_TRANSIT_TIME_DAYS;
//            }
//        ));
//
//
//        usort($eligible_rates, function($a, $b) {
//            return $a['days'] - $b['days'];
//        });
//
//
//        $transaction = \Shippo_Transaction::create(array(
//            'rate'=> $eligible_rates[0]['object_id'],
//            'async'=> false,
//        ));
//
//        return json_decode($transaction,true);
//
//
//    }
    public function trackshipment()
    {

        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');

        $status_params = array(
            'id' => '4349248002',  //0002275604// 4349248002
            'carrier' => 'shippo'
        );

//Get the tracking status of a shipment using Shippo_Track::get_status
//The response is stored in $status
//The complete reference for the returned Tracking object is available here: https://goshippo.com/docs/reference#tracks
        $status = \Shippo_Track::get_status($status_params);

//Example data for Track::create
//The complete reference for the tracks-create endpoint is available here: https://goshippo.com/docs/reference#tracks-create
        $create_params = array(
            'carrier' => 'shippo',
            'tracking_number' => '4349248002',// 4349248002
            'metadata' => 'This is an optional field'
        );

//The response is stored in $webhook response and is identical to the response of Track::get_status
        $webhook_response = \Shippo_Track::create($create_params);
        print_r($webhook_response);
    }
    public function rateshipping(Request $request)
    {

        $country_code = '';
        $pin_code = 0;
        $cart = null;
        $weight = 0;
        $totalAmt = 0;
        $length = 0;
        $width = 0;
        $height = 0;
        $distance_unit='';
        $mass_unit='';
        $arr = array();
        if ($request->country != '' && $request->pin_code != '') {
            $countryTrans = CountryTranslation::where('country_id', trim($request->country))->first();
            if (isset($countryTrans) && count($countryTrans) > 0) {
                $data = array();
                $country_code = $countryTrans->iso_code;
                $pin_code = trim($request->pin_code);
            }
        }
            if (Auth::check())
            {
                $cart = Auth::user()->cart;
            } else
            {
                $cart = Cart::where('ip_address', $request->ip())->first();
            }


            $cartObj = new CartController();
            $totalAmt = $cartObj->getCartTotalAmt($request);
            $grandTotal = $cartObj->calTotalCredit($cart, $totalAmt) - Session::get('all_cart_data.total_savings');
            $weight = floatval($cartObj->getCartTotalWeight($request));


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
            if($request->value == "0")
            {
                $distance_unit ='cm';
                $mass_unit ='kg';
                $weight *=0.001;
            }
            else if($request->value == "1"){
                $distance_unit ='in';
                $mass_unit ='lb';
                $length =number_format($length *(1/2.54),2,'.','');
                $width =number_format($width*(1/2.54),2,'.','');
                $height =number_format($height*(1/2.54),2,'.','');
                $weight = number_format($weight *0.00220462262185,2,'.','');
            }

            \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');
            $delivery_windows = array(7);
            $destination_zip_codes = array($pin_code);

//        $from_address = \Shippo_Address::create( array(
//            "name" => "Shawn Ippotle",
//            "company" => "Shippo",
//            "street1" => "215 Clayton St.",
//            "city" => "San Francisco",
//            "state" => "CA",
//            "zip" => "94117",
//            "country" => "US",
//            "email" => "shippotle@goshippo.com",
//            "validate" => true
//        ));
            // Example from_address array
            // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses

            $from_address = array(
                'name' => 'Shawn Ippotle',
                'company' => 'Shippo',
                'street1' => '215 Clayton St.',
                'city' => 'San Francisco',
                'state' => 'CA',
                'zip' => '94117',
                'country' => 'US',
                'phone' => '+91 9657199892',
                'email' => 'mr-hippo@goshipppo.com',
            );
            // Parcel information array
            // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
            $parcel = array(
                'length'=> $length,
                'width'=> $width,
                'height'=> $height,
                'distance_unit'=> $distance_unit,
                'weight'=> $weight,
                'mass_unit'=> $mass_unit,
            );
            // Collect the shipments to each address
            $shipments = array();
            foreach ($destination_zip_codes as $zip_code)
            {
                // Example to_address with the zip code
                // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
                $to_address = array(
                    'country' => $country_code,
                    'zip' => $zip_code,
                );

                // For each destination address we now create a Shipment object.
                // async=false indicates that the function will wait until all rates are generated before it returns.
                // The reference for the shipment object is here: https://goshippo.com/docs/reference#shipments
                // By default Shippo API operates on an async basis. You can read about our async flow here: https://goshippo.com/docs/async
                $shipments[] = \Shippo_Shipment::create(array(
                    'address_from'=> $from_address,
                    'address_to'=> $to_address,
                    'parcels'=> array($parcel),
                    'async'=> false
                ));
            }


//        // Collect all shipments rates
//        $all_rates = array();
//        foreach ($shipments as $shipment) {
//            $all_rates = array_merge($all_rates, $shipment['rates']);
//        }
//
//        // This function takes a list of $rates, filters only those rates in
//        // the $delivery_window, and returns the rates estimation
//
//        print_r($all_rates);
//        // Show estimations for each delivery window
//        foreach ($delivery_windows as $delivery_window) {
//            $estimations = $this->calculate_rates_estimation($all_rates, $delivery_window);
//            echo "For a delivery window of {$delivery_window} days:" . "\n";
//            echo "--> " . "Min. costs: " . $estimations['min'] . "\n";
//            echo "--> " . "Max. costs: " . $estimations['max'] . "\n";
//            echo "--> " . "Avg. costs: " . $estimations['average'] . "\n";
//        }
            if($shipments[0]->status == 'SUCCESS')
            {
                $all_rates = array();
                foreach ($shipments as $shipment) {
                    $all_rates = array_merge($all_rates, $shipment['rates']);
                }

                // This function takes a list of $rates, filters only those rates in
                // the $delivery_window, and returns the rates estimation

                $arrRates = array();
                $tempArr = array();
                $cnt=0;
                // Show estimations for each delivery window
                foreach ($delivery_windows as $delivery_window)
                {
                    $estimations = $this->calculate_rates_estimation($all_rates, $delivery_window);
//            $arrRates[$cnt] =$estimations;
                    $toCurrency = $estimations['currency'];
                    $fromCurrency = Helper::getCurrency();
                    $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
                    if($getRate !=-1)
                    {
                        if($estimations['max'] != 0)
                        {
                            $estimations['max'] = number_format($estimations['max'] * $getRate,2,'.','');
                        }
                    }
                    $estimations['min']=Helper::getCurrencySymbol().$estimations['min'];
                    $estimations['max']=Helper::getCurrencySymbol().$estimations['max'];
                    $estimations['average']=Helper::getCurrencySymbol().$estimations['average'];
                    $tempArr['delivery_window']=$estimations['delivery_window'];
                    $tempArr['max']=$estimations['max'];
                    $tempArr['service_provider']=$estimations['service_provider'];
                    $tempArr['estimated_days']=$estimations['estimated_days'];
//                dd($estimations);
                    $arrRates[$cnt] =$tempArr;
                    $cnt++;
                }
//                dd($arrRates);
                echo json_encode(array("success" => '1', 'msg' => $shipments[0]->status,'arr'=>$arrRates));
                exit();
            }
            else
            {
                echo json_encode(array("success" => '0', 'msg' => $shipments[0]->status));
                exit();
            }

    }
    public function testRateShipping(Request $request)
    {
//        dd($request->all());

        $country_code = 'IN';
        $pin_code = '411028';
        $length = 24;
        $width = 18;
        $height = 5.5;
        $weight = 10 + 150;

        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');
//        \Shippo::setApiKey('shippo_test_625bdc79d9093dbc9c9c19f78fdb6c4de2d012be');
        $delivery_windows = array(7);
        $destination_zip_codes = array($pin_code);

        // Example from_address array
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
//        $from_address = array(
//            'name' => 'Shiv Chawla',
//            'company' => 'Chawlas International',
//            'street1' => '215 Clayton St.',
//            'city' => 'Mumbai',
//            'state' => 'MH',
//            'zip' => '400097',
//            'country' => 'IN',
//            'phone' => '+91 9657199892',
//            'email' => 'mr-hippo@goshipppo.com',
//        );
        $from_address = array(
            'name' => 'Mr Hippo',
            'company' => 'Shippo',
            'street1' => '215 Clayton St.',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94117',
            'country' => 'US',
            'phone' => '+1 555 341 9393',
            'email' => 'mr-hippo@goshipppo.com',
        );
        // Parcel information array
        // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
        $parcel = array(
            'length'=> $length,
            'width'=> $width,
            'height'=> $height,
            'distance_unit'=> 'cm',
            'weight'=> $weight*0.001,
            'mass_unit'=> 'kg',
        );
        // Collect the shipments to each address
        $shipments = array();
        foreach ($destination_zip_codes as $zip_code)
        {
            // Example to_address with the zip code
            // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
            $to_address = array(
                'country' => $country_code,
                'zip' => $zip_code,
            );

            // For each destination address we now create a Shipment object.
            // async=false indicates that the function will wait until all rates are generated before it returns.
            // The reference for the shipment object is here: https://goshippo.com/docs/reference#shipments
            // By default Shippo API operates on an async basis. You can read about our async flow here: https://goshippo.com/docs/async
            $shipments[] = \Shippo_Shipment::create(array(
                'address_from'=> $from_address,
                'address_to'=> $to_address,
                'parcels'=> array($parcel),
                'async'=> false
            ));
        }

        // Collect all shipments rates
        if($shipments[0]->status == 'SUCCESS')
        {
//            dd($shipments[0]->status);
            $all_rates = array();
            foreach ($shipments as $shipment) {
                $all_rates = array_merge($all_rates, $shipment['rates']);
            }

            // This function takes a list of $rates, filters only those rates in
            // the $delivery_window, and returns the rates estimation



            $arrRates = array();
            $tempArr = array();
            $cnt=0;
            // Show estimations for each delivery window
            foreach ($delivery_windows as $delivery_window)
            {
                $estimations = $this->calculate_rates_estimation($all_rates, $delivery_window);
//            $arrRates[$cnt] =$estimations;
//                dd($estimations);
                $toCurrency = $estimations['currency'];
                $fromCurrency = Helper::getCurrency();
                $getRate = Helper::getInlineCurrency($toCurrency,$fromCurrency);
//                dd($getRate);
                if($getRate !=-1)
                {
                    if($estimations['min'] != 0)
                    {
                        $estimations['min'] = number_format($estimations['min'] * $getRate,2,'.','');
                    }
                    if($estimations['max'] != 0)
                    {
                        $estimations['max'] = number_format($estimations['max'] * $getRate,2,'.','');
                    }
                    if($estimations['average'] != 0)
                    {
                        $estimations['average'] = number_format($estimations['average'] * $getRate,2,'.','');
                    }
                }
                $tempArr['delivery_window']=$estimations['delivery_window'];
                $tempArr['price']=$estimations['max'];
                $tempArr['service_provider']=$estimations['service_provider'];
                $tempArr['estimated_days']=$estimations['estimated_days'];
//                dd($estimations);
                $arrRates[$cnt] =$tempArr;
                $cnt++;
            }
            dd($arrRates);
        }
        else
            {
                dd($shipments[0]->status);
            }


    }


    function calculate_rates_estimation($rates, $delivery_window)
    {
        // Filter rates by delivery window
        $eligible_rates = array_values(array_filter(
            $rates,
            function($rate) use($delivery_window){
                return $rate['days'] <= $delivery_window;
            }
        ));
        // Calculate estimations on the eligible_rates
        $min = $eligible_rates[0]['amount'];
        $max = 0.0;
        $sum = 0.0;
        foreach ($eligible_rates as $rate) {
            $amount = $rate['amount'];
            $min = min($min, $amount);
            $max = max($max, $amount);
            $sum += $amount;
        }
        return array(
            'delivery_window' => $delivery_window,
            'min' => $min,
            'max' => $max,
            'average' => $sum / count($eligible_rates),
            'currency' => $eligible_rates[0]['currency'],
            'estimated_days'=>$eligible_rates[0]['estimated_days'],
            'service_provider'=>$eligible_rates[0]['provider'],
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);
        Task::find($id)->update($request->all());
        return redirect()->route('tasks.index')->with('success','Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
        return redirect()->route('tasks.index')->with('success','Task removed successfully');
    }
    public function refundshipment(){
        \Shippo::setApiKey('shippo_test_d36106395f5e193336d71737ac26208fef870f4e');
        //feb38b3f0d3d4a4a8a33c1df67f9a93b
        $fdf = \Shippo_Refund::create(array('transaction'=>'feb38b3f0d3d4a4a8a33c1df67f9a93b'));

        dd($fdf);
    }

}