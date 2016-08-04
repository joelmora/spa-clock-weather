<?php

namespace WeatherManager;

class CurlManager
{
    private $url;

    public function __construct() {}

    /**
     * Get data given an URL
     * @param $url
     * @return mixed
     * @throws \Exception
     * @author Joel Mora
     */
    public function getData($url)
    {
        $this->setUrl($url);
        $response = $this->curlCall();
        
        return json_decode($response);
    }

    /**
     * Call an URL and return its data
     * @return mixed
     * @throws \Exception
     * @author Joel Mora
     */
    private function curlCall()
    {
        if (!$this->getUrl()) {
            throw new \Exception('No URL defined');           
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        
        $result = curl_exec($ch);
        
        curl_close($ch);
        
        return $result;
    }

    /**
     * @return mixed
     */
    private function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    
}