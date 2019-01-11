<?php

class TradingBeepApi {

    const API_URL = 'https://tradingbeep.com';

    private $apiKey;
    private $apiSecret;

    public function __construct($key, $secret)
    {
        $this->apiKey = $key;
        $this->apiSecret = $secret;
    }

    /**
     * Get all statuses of indecators by pair
     *
     * @return array
     */
    public function getBeeps($exchange, $symbol, $interval)
    {
        return $this->sendRequest('GET', 'api/v1/beeps-pair/'.$exchange.'/'.$symbol.'/'.$interval);
    }

    /**
     * Create request to API
     *
     * @param string $method
     * @param string $url
     * @param string | null $params
     * @param string | null $attributes
     * @return array
     */
    private function sendRequest($method, $url, $params = null, $attributes = null) {

        $query = json_encode($params == null ?  '' : http_build_query($params));
        $query = str_replace('"', '', $query);

        $nonce = time();

        $strForSign = '/' . $url . '/' . $nonce;

        $hash = hash_hmac('sha256', base64_encode($strForSign) , $this->apiSecret);

        $header = [

            "TB-API-SIGNATURE: $hash",
            "TB-API-KEY: " . $this->apiKey,
            "TB-API-NONCE: $nonce"
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, static::API_URL . '/' . $url . '?' . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $attributes);
        }

        $response = curl_exec($ch);

      //  var_dump($response);

        curl_close($ch);

        return json_decode($response, true);
    }
}
