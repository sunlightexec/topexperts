<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 10.10.2018
 * Time: 23:34
 */

namespace app\components\api;


use yii\helpers\Json;

class CoinMarketCap
{
    const API_KEY_PARAM_NAME = 'CMC_PRO_API_KEY';
    const API_KEY_HEADER_PARAM_NAME = 'X-CMC_PRO_API_KEY';

    private $version;
    private $apiKey = 'eefb4cac-cdbf-4f28-9fef-b24483ad58c4';

    private $url = [
        'test' => 'https://sandbox.coinmarketcap.com/',
        'work' => 'https://pro-api.coinmarketcap.com/',
    ];

    public function __construct($version = 'test', $apiKey = null)
    {
        $this->version = $version;
        if(!empty($apiKey)) {
            $this->apiKey = $apiKey;
        }
    }

    private function makeUrl($url)
    {
        return $this->url[$this->version] . $url . '?' . self::API_KEY_PARAM_NAME . '=' . $this->apiKey .'&limit=5000';
    }

    private function doQuery( $url )
    {
//        die(print_r($this->makeUrl($url)));
        try {

            $httpheader = [
                self::API_KEY_HEADER_PARAM_NAME => $this->apiKey
            ];
            $curl = curl_init();
            if (false === $curl) {
                throw new \Exception('CURL: Failed to initialize');
            }

            curl_setopt_array($curl, [
                CURLOPT_URL => $this->makeUrl($url),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $httpheader,
            ]);

            $response = curl_exec($curl);
            if (false === $response) {
                throw new Exception(curl_error($curl), curl_errno($curl));
            }

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (200 != $http_status)
                throw new \Exception($response, $http_status);
            curl_close($curl);

            /*$response = [
                'status' => 'success',
                'data' =>  Json::decode($response),
            ];*/
        }
        catch(\Exception $e)
        {
            $response = [
                'status' => 'error',
                'message' => $e->getCode() . $e->getMessage()
            ];

            echo $response;
        }

        return $response;
    }

    public function getLatestData()
    {
        $url = 'v1/cryptocurrency/listings/latest';
        return $this->doQuery($url);
    }
}