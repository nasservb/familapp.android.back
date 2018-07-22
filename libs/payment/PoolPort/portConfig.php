<?php
return array(
    //-------------------------------
    // Timezone for insert dates in database
    // If you want PoolPort not set timezone, just leave it empty
    //--------------------------------
    'timezone' => 'Asia/Tehran',
    //--------------------------------
    // Database configuration
    //--------------------------------
    'database' => array(
        'host'     => 'localhost',
        'dbname'   => 'accounting',
        'username' => 'root',
        'password' => '',
        'create' => false             // For first time you must set this to true for create tables in database
    ),
    //--------------------------------
    // Zarinpal gateway
    //--------------------------------
    'zarinpal' => array(
        'merchant-id'  => '',
        'type'         => 'zarin-gate',                           // Types: [zarin-gate || normal]
        'callback-url' => 'http://www.example.org/result',
        'server'       => 'germany',                              // Servers: [germany || iran]
        'email'        => 'email@gmail.com',
        'mobile'       => '09xxxxxxxxx',
        'description'  => 'description',
    ),
    //--------------------------------
    // Mellat gateway
    //--------------------------------
    'mellat' => array(
        'username'     => '',
        'password'     => '',
        'terminalId'   => 275,
        'callback-url' => 'http://sitelegram.ir/index.php/user/buyFinish'
    ),
    //--------------------------------
    // Payline gateway
    //--------------------------------
    'payline' => array(
        'api' => '--------',
        'callback-url' => 'http://www.example.org/result'
    ),
    //--------------------------------
    // Sadad gateway
    //--------------------------------
    'sadad' => array(
        'merchant'      => '',
        'transactionKey'=> '',
        'terminalId'    => ,
        'callback-url'  => 'http://sitelegram.ir/index.php/user/buyFinish'
    ),
    //--------------------------------
    // JahanPay gateway
    //--------------------------------
    'jahanpay' => array(
        'api' => 'xxxxxxxxxxx',
        'callback-url' => 'http://example.org/result'
    ),
    //--------------------------------
    // Parsian gateway
    //--------------------------------
    'parsian' => array(
        'pin'          => 'xxxxxxxxxxxxxxxxxxxx',
        'callback-url' => 'http://example.org/result'
    ),
);