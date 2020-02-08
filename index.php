<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//echo '<pre>';
require_once __DIR__ . '/vendor/autoload.php';

//$key = 'bRiJLMgRnPrjnUnPRZlZNt3E';
//$secret = '704mzedvg1gNLfslbjPvB1yjQn0yxIpqWGr9EPOb1Vc_rIMb';
//$host = 'https://www.bitmex.com';

$bitmex = new \Lin\Bitmex\Bitmex($key, $secret);

//$pos = $bitmex->orderBook()->get(['symbol' => 'XBTUSD', 'depth' => 1]);

//$pos = $bitmex->position()->get(['symbol' => '']);
//var_dump($pos);