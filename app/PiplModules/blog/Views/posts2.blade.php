<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function resolveIP($ip) {
  $string = file_get_contents("https://ipsidekick.com/{$ip}");
  $json = json_decode($string);
  return $json;
}

$ip = request()->ip();
$json = resolveIP($ip);


if(isset($json->country)) {
    echo "Country name: {$json->country->name}\n";
}