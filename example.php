<?php

require './TradingBeepApi.php';

$api = new TradingBeepApi('6c55d8e887a912e1', 'bff80d7fc7e9468f62c6576c9e62efb7');

print_r($api->getBeeps('binance', 'BTC-USDT', '1min'));
?>
