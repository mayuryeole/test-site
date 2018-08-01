<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once("../lib/easypost.php");
\EasyPost\EasyPost::setApiKey('aLmLoePe4FYBwC9WfoAmFg');

try {
    // create address
    $address_params = array("name" => "Sawyer Bateman",
        "street1" => "388 Townasend St",
        "street2" => "Apt 20",
        "city" => "San Francisco",
        "state" => "CA",
        "phone" => "3216549871",
        "zip" => "94107",
        "country" => "US");

    $ae_address_params = array(
        "name" => "Ian Caron",
        "comapny" => "Move One",
        "street1" => "40th Floor,U-Bora Towers",
        "city" => "DUBAI",
        "phone" => "+9714 438 5300",
        "zip" => "00000",
        "country" => "AE"
    );


    $nz_address_params = array(
        "name" => "Queen Elizabeth",
        "street1" => "50 Seddon Road",
        "street2" => "50 Seddon Road",
        "city" => "Hamilton",
        "zip" => "3204",
        "phone" => "3216549871",
        "country" => "NZ"
    );





    // create and verify at the same time
    $verified_on_to = \EasyPost\Address::create_and_verify($address_params);


    $verified_on_from = \EasyPost\Address::create_and_verify($nz_address_params);


    $parcel_params = array("length" => 20.2,
        "width" => 10.9,
        "height" => 5,
        "predefined_package" => null,
        "weight" => 14.8
    );

    $parcel = \EasyPost\Parcel::create($parcel_params);


// customs info form
    $customs_item_params = array(
        "description" => "Many, many EasyPost stickers.",
        "hs_tariff_number" => 123456,
        "origin_country" => "NZ",
        "quantity" => 1,
        "value" => 879.47,
        "weight" => 14
    );
    $customs_item = \EasyPost\CustomsItem::create($customs_item_params);

    $customs_info_params = array(
        "customs_certify" => true,
        "customs_signer" => "Borat Sagdiyev",
        "contents_type" => "gift",
        "contents_explanation" => "", // only necessary for contents_type=other
        "eel_pfc" => "NOEEI 30.37(a)",
        "non_delivery_option" => "abandon",
        "restriction_type" => "none",
        "restriction_comments" => "",
        "customs_items" => array($customs_item)
    );

    $customs_info = \EasyPost\CustomsInfo::create($customs_info_params);
    $shipment_params = array("from_address" => $verified_on_from,
        "to_address" => $verified_on_to,
        "parcel" => $parcel,
        "customs_info" => $customs_info,
        "mode" => "test",
        "carrier_accounts" => ["ca_cf43b7f220764b6998b0e3843d13f0b7"]
    );
    $shipment = \EasyPost\Shipment::create($shipment_params);


    $rate = \EasyPost\Rate::retrieve($shipment->lowest_rate());
    $rateData = $shipment->lowest_rate();

    echo "Lowest Rate";
    echo '<pre>';
    print_r($shipment->lowest_rate());
    $shipment->buy(array('rate' => array('id' => $rateData->id)));

    echo "Rates";
    echo '<pre>';
    print_r($shipment->rates);
} catch (Exception $e) {
    echo "Status: " . $e->getHttpStatus() . ":\n";
    echo $e->getMessage();
    if (!empty($e->param)) {
        echo "\nInvalid param: {$e->param}";
    }
    exit();
}

