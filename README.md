# php-tradingbeep-api
PHP TradingBeep API is a PHP library for the TradingBeep.com API designed to be easy to use.

#### Installation
```
composer require "molotoksoftware/php-tradingbeep-api"
```

#### Getting started
```php
// 1. class initialization
$tradingbeep = new TradingBeepApi('API_KEY', 'APY_SECRET');

// 2. getting all indicators by pair
print_r($tradingbeep->getBeeps('binance', 'BTC-USDT', '5min'));

```
