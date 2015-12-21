<?php

class CurlService{

    public $timeout = 3;

    public function init(){

    }

    /**
     * Get запрос
     */
    public function get($url, $request = array()){
        $address = $url . '?' . http_build_query($request);
        return $this->download($address);
    }

    /**
     * Post запрос
     */
    public function post($url, $request = array()){

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($request),
            CURLOPT_TIMEOUT => $this->timeout,
        ));

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Загружаем данные
     */
    private function download($url){

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => $this->timeout,
        ));

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

}