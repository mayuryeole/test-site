<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// require_once("../vendor/autoload.php");

require_once("../lib/easypost.php");
\EasyPost\EasyPost::setApiKey('ylZuNhCxX9ECm9dbXQ6Rrw');
define("ECHO_ALL_CA", true);
// retrieve all of your CarrierAccounts
if (ECHO_ALL_CA) {
  $my_carrier_accounts = \EasyPost\CarrierAccount::all();
//  print_r($my_carrier_accounts);
}




$to_address = \EasyPost\Address::create(array(
    'name' => 'Dr. Steve Brule',
    'street1' => '179 N Harbor Dr',
    'city' => 'Redondo Beach',
    'state' => 'CA',
    'zip' => '90277',
    'country' => 'US',
    'phone' => '3331114444',
    'email' => 'dr_steve_brule@gmail.com'
  ));


$from_address = \EasyPost\Address::create(array(
    'name' => 'EasyPost',
    'street1' => '417 Montgomery Street',
    'street2' => '5th Floor',
    'city' => 'San Francisco',
    'state' => 'CA',
    'zip' => '94104',
    'country' => 'US',
    'phone' => '3331114444',
    'email' => 'support@easypost.com'
  ));
$parcel = \EasyPost\Parcel::create(
    array(
        "predefined_package" => "Parcel",
        "weight" => 76.9
    )
);

$customs_item = \EasyPost\CustomsItem::create(array(
  "description" => 'T-shirt',
  "quantity" => 1,
  "weight" => 5,
  "value" => 10,
  "hs_tariff_number" => '123456',
  "origin_country" => 'US'
));
$shipment = \EasyPost\Shipment::create(
    array(
        "to_address"   => $to_address,
        "from_address" => $from_address,
        "parcel"       => $parcel,
        "customs_info"=>$customs_item
    )
);





print_r($shipment->get_rates());
die;
//print_r($shipment->lowest_rate());
$shipment->buy($shipment->lowest_rate());

$shipment->insure(array('amount' => 100));

echo $shipment->postage_label->label_url;