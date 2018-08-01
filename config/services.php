<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
//723713547839606, 297991344020948
//213c34715a29a4ef472304dd6122899f, 4c6191762a01f98b7f98f9dc05df7b15
        'client_id' => '364223400723318',
        'client_secret' => '8c744520185784cab2f2d025871a0337',
        'redirect' => 'http://www.parasfashions.com/auth/facebook/callback',
    ],
    'twitter' => [
        'client_id' => 'HcT4RYlWBxM0CdbnHFfvn9auK',
        'client_secret' => '5WiGDPuYCFFeTiTYpPYtbhBhovh1wR7yqG4b9xghvmCh9x6RAI',
        'redirect' => 'http://www.parasfashions.com/auth/twitter/callback',
//             'redirect' => 'http://192.168.2.22:8079/GITLARAVELLIB/auth/twitter/callback',
    ],
    'google' => [
        'client_id' => '348677826514-blag56apv754ff8557avfbaa1fl0i8c1.apps.googleusercontent.com',
        'client_secret' => 'X65NRm5v36g3qrRufU-BaeAE',  //pallavi.deokate18@gmail.com
        'redirect' => 'http://www.parasfashions.com/auth/google/callback',
    //'redirect' => 'http://localhostGITLARAVELLIB/auth/google/callback',
    ],
    
    'instagram' => [
//        'client_id' => 'e72c96afc893456187a99dc016b6ba01',
        'client_id' => '844b9fb3a9cc465981f7851da3ba7254',//hancy.pipl@gmail.com
//        'client_secret' => '523218902f4f4a56b92f440f9d92f170',
        'client_secret' => '719f14f830d64927817d0b8568fbe7da',//hancy.pipl@gmail.com
        'redirect' => 'http://www.parasfashions.com/auth/instagram/callback',
    ],
];
