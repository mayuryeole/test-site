<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use App\CurrencyExchangeRate;

class Helper {

    protected static $getPrice;
    protected static $currentPrice;
    protected static $setPrice;
    protected static $currentExchangeRate;
    protected static $currency;
    protected static $price;
    protected static $errorException;
    protected static $getExchangeRate;
    protected static $realPrice;
    protected static $currencySymbol;

    public static function setCurrency($currencyCode = '')
    {
        if (Session::has('universal_currency') && $currencyCode != '') {
            Session::put('universal_currency', $currencyCode);
            Session::save();
            return Helper::setSessionCurrency($currencyCode);
        } else {
            return Helper::setSessionDefaultCurrency();
        }
    }

    public static function setFallBackCurrency()
    {
        Session::put('universal_currency', 'INR');
        Session::save();
        Helper::$currency = Session::get('universal_currency');
        return Helper::$currency;
    }
      public static function setExchangeRates($to = '')
      {
          $currencyExRate = CurrencyExchangeRate::orderBy('id','DESC')->first()->toArray();
//          $currencyExRate = (array)$currencyExRate;
//          dd($currencyExRate);
          if(isset($currencyExRate) && count($currencyExRate)>0)
          {
              Helper::$currentExchangeRate = $currencyExRate[strtolower($to)];
              Session::set('exchange_rate', Helper::$currentExchangeRate);
              Session::save();
              return Helper::$currentExchangeRate;
          }
      }
//    public static function setExchangeRates($to = '') {
//        //dd($to);
//        $from = 'INR';
//        $conv_id = "{$from}_{$to}";
//        $url = "https://api.fixer.io/latest?base=$to&symbols=INR";
//
//        try {
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $contents = curl_exec($ch);
//            $json_a = json_decode($contents, true);
//            if (isset($json_a) && array_key_exists('rates', $json_a) && count($json_a['rates']) > 0)
//            {
//                Helper::$currentExchangeRate = $json_a['rates']['INR'];
//                Session::set('exchange_rate', Helper::$currentExchangeRate);
//                Session::save();
//                return Helper::$currentExchangeRate;
//            } else {
//               // Helper::setSessionDefaultCurrency();
//                Helper::setFallBackCurrency();
//                Helper::$currentExchangeRate = 1;
//                Session::set('exchange_rate', Helper::$currentExchangeRate);
//                Session::save();
//                Helper::$errorException = 1;
//                Helper::$currentExchangeRate = Helper::$errorException;
//                return Helper::$currentExchangeRate;
//            }
//        } catch (Exception $e) {
//            //Helper::setSessionDefaultCurrency();
//            Helper::setFallBackCurrency();
//            Helper::$currentExchangeRate = 1;
//            Session::set('exchange_rate', Helper::$currentExchangeRate);
//            Session::save();
//            Helper::$errorException = 1;
//            Helper::$currentExchangeRate = Helper::$errorException;
//            return Helper::$currentExchangeRate;
//        }
//    }

    public static function getInlineCurrency($to='',$from='')
    {
        $url = 'http://free.currencyconverterapi.com/api/v5/convert?q='.$to.'_'.$from.'&compact=y';
//        dd($url);
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $contents = curl_exec($ch);
//            dd($contents);

            $json_a = json_decode($contents, true);
            if (isset($json_a) && array_key_exists($to.'_'.$from, $json_a) && count($json_a[$to.'_'.$from]) > 0)
            {
                Helper::$currentExchangeRate =$json_a[$to.'_'.$from]['val'];
                return Helper::$currentExchangeRate;
            }
            else{
                return -1;
            }
        }
        catch (Exception $e)
        {
            return -1;
        }
    }

//    public static function getInlineCurrency($to='',$from='')
//    {
//       // dd($to.'++'.$from);
//        $conv_id = "{$from}_{$to}";
//        $url = "https://api.fixer.io/latest?base=$to&symbols=$from";
//
//        try {
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $contents = curl_exec($ch);
//            $json_a = json_decode($contents, true);
//            if (isset($json_a) && array_key_exists('rates', $json_a) && count($json_a['rates']) > 0)
//            {
//                Helper::$currentExchangeRate = $json_a['rates'][$from];
//                return Helper::$currentExchangeRate;
//            } else {
//                return -1;
//            }
//        } catch (Exception $e) {
//           return -1;
//        }
//    }


    public static function setSessionDefaultCurrency()
    {
        Session::put('universal_currency', 'INR');
        Session::save();
        Helper::$currency = Session::get('universal_currency');
        Helper::setExchangeRates(Helper::$currency);
        return Helper::$currency;
    }

    public static function setSessionCurrency($currencyCode = '')
    {
        Session::put('universal_currency', $currencyCode);
        Session::save();
        Helper::$currency = Session::get('universal_currency');
//        dd(Helper::$currency);
        Helper::setExchangeRates(Session::get('universal_currency'));

        return Helper::$currency;
    }

    public static function setCurrencySymbol()
    {
            switch(Session::get('universal_currency'))
            {
                case 'INR' : Helper::$currencySymbol = '₹';
                             break;
                case 'EUR' : Helper::$currencySymbol = '€';
                             break;
                case 'USD' : Helper::$currencySymbol = '$';
                             break;
                case 'CAD' : Helper::$currencySymbol = 'C$';
                             break;
                case 'GBP' : Helper::$currencySymbol = '£';
                             break;   
            }
        return  Helper::$currencySymbol;
    }

    public static function getCurrencySymbol() {
        if (Session::has('universal_currency') && Session::has('exchange_rate')) {
            Helper::setCurrencySymbol();
            return Helper::$currencySymbol;
        } else {
            Helper::setSessionDefaultCurrency();
            Helper::getCurrencySymbol();
        }
    }

    public static function getExchangeRate() {
        Helper::$currentExchangeRate = Session::get('exchange_rate');
        return Helper::$currentExchangeRate;
    }

    public static function getCurrency() {
        Helper::$currency = Session::get('universal_currency');
        return Helper::$currency;
    }

    public static function getRealPrice($price = '') {
        if (Session::has('universal_currency') && Session::has('exchange_rate'))
        {
            Helper::$currentExchangeRate = Session::get('exchange_rate');
            $realval = $price / Helper::$currentExchangeRate;
            Helper::$realPrice = $realval;
            return Helper::$realPrice;
        } else {
            Helper::setSessionDefaultCurrency();
            Helper::getRealPrice();
        }
    }

}

?>
