<?php
return [
    'client_id' => env('PAYPAL_CLIENT_ID', ''),
	'secret' => env('PAYPAL_API_SECRET', ''),
    'settings' => array(
        'mode' => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'.
        'http.ConnectionTimeOut' => 1000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ),
];
