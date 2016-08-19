<?php

namespace WeatherManager;

require_once 'CurlManager.php';

class WeatherCondition
{
    private $weatherUrl;
    private $sunsetUrl;
    private $station;

    public function __construct()
    {
        //default values
        $this->weatherUrl = 'http://186.42.174.236:8080/WebServicesRest/webresources/ec.gob.inamhi.puob/paramxesta/';
        $this->sunsetUrl = 'http://api.sunrise-sunset.org/json';
        $this->station = 'M0024';
        $this->latitude = '-0.132829';
        $this->longitude = '-78.499351';
    }

    /**
     * Get weather conditions from selected station
     * @return array
     * @author Joel Mora
     */
    public function getConditions()
    {
        $curl = new CurlManager();
        $forecastRaw = $curl->getData($this->getWeatherUrl());

        //sunrise & sunset
        $today = new \DateTime();
        $tomorrow = new \DateTime('tomorrow');
        $sunset = $curl->getData($this->getSunsetUrl($today));
        $sunrise = $curl->getData($this->getSunsetUrl($tomorrow));

        return $this->formatConditions($forecastRaw, $sunrise, $sunset);
    }

    /**
     * Format condition to be used on GUI
     * @param $weatherRaw
     * @param $sunriseData
     * @param $sunsetData
     * @return array
     * @author Joel Mora
     */
    private function formatConditions($weatherRaw, $sunriseData, $sunsetData)
    {
        $weatherData = array();

        foreach ($weatherRaw->iE as $record) {
            //current timestamp
            if ($record->fe AND !isset($weatherData['timestamp'])) {
                $weatherData['timestamp'] = $record->fe;
            }

            //humidity
            if ($record->pa == 'HUMEDAD RELATIVA DEL AIRE' AND $record->de == 'MINIMA') {
                $weatherData['humidity']['min']['value'] = $record->da;
                $weatherData['humidity']['min']['unit'] = $record->si;
            }
            if ($record->pa == 'HUMEDAD RELATIVA DEL AIRE' AND $record->de == 'MAXIMA') {
                $weatherData['humidity']['max']['value'] = $record->da;
                $weatherData['humidity']['max']['unit'] = $record->si;
            }
            if ($record->pa == 'HUMEDAD RELATIVA DEL AIRE' AND $record->de == 'INSTANTANEA') {
                $weatherData['humidity']['now']['value'] = $record->da;
                $weatherData['humidity']['now']['unit'] = $record->si;
            }
            //rain
            if ($record->pa == 'PRECIPITACION' AND $record->de == 'SUMA') {
                $weatherData['rain']['sum']['value'] = $record->da;
                $weatherData['rain']['sum']['unit'] = $record->si;
            }
            //pressure
            if ($record->pa == 'PRESION ATMOSFERICA' AND $record->de == 'INSTANTANEA') {
                $weatherData['pressure']['now']['value'] = $record->da;
                $weatherData['pressure']['now']['unit'] = $record->si;
            }
            //temperature
            if ($record->pa == 'TEMPERATURA AIRE' AND $record->de == 'MINIMA') {
                $weatherData['temperature']['min']['value'] = $record->da;
                $weatherData['temperature']['min']['unit'] = $record->si;
            }
            if ($record->pa == 'TEMPERATURA AIRE' AND $record->de == 'MAXIMA') {
                $weatherData['temperature']['max']['value'] = $record->da;
                $weatherData['temperature']['max']['unit'] = $record->si;
            }
            if ($record->pa == 'TEMPERATURA AIRE' AND $record->de == 'INSTANTANEA') {
                $weatherData['temperature']['now']['value'] = $record->da;
                $weatherData['temperature']['now']['unit'] = $record->si;
            }
            //wind
            if ($record->pa == 'VIENTO DIRECCION' AND $record->de == 'INSTANTANEA') {
                $weatherData['windDirection']['now']['value'] = $record->da;
                $weatherData['windDirection']['now']['unit'] = $record->si;
                $weatherData['windDirection']['now']['round'] = $this->windDegreesRound($record->da);
            }
            if ($record->pa == 'VIENTO VELOCIDAD' AND $record->de == 'INSTANTANEA') {
                $velocity = $this->msTokh($record->da);
                $weatherData['windSpeed']['now']['value'] = $velocity['value'];
                $weatherData['windSpeed']['now']['unit'] = $velocity['unit'];
                $weatherData['windSpeed']['now']['beaufort'] = $this->windToBeaufort($velocity['value']);
            }
        }

        //calculate thermic sensation
        if (isset($weatherData['windSpeed']) AND isset($weatherData['temperature']['now'])) {

            $t = $weatherData['temperature']['now']['value'];
            $w = $weatherData['windSpeed']['now']['value'];

            $windChill = $this->calculateWindChill($t, $w);

            $weatherData['windChill']['now']['value'] = $windChill;
            $weatherData['windChill']['now']['unit'] = $weatherData['temperature']['now']['unit'];
        }

        //if temperature now doesn't exist
        if (!isset($weatherData['temperature']['now']) AND isset($weatherData['temperature']['min']) AND $weatherData['temperature']['max']) {
            $weatherData['temperature']['now']['value'] = ($weatherData['temperature']['min']['value'] + $weatherData['temperature']['max']['value']) / 2;
            $weatherData['temperature']['now']['unit'] = $weatherData['temperature']['min']['unit'];
        }

        //if no wind speed
        if (!isset($weatherData['windSpeed'])) {
            $weatherData['windSpeed']['now']['value'] = 'N/A';
            $weatherData['windSpeed']['now']['unit'] = '';
            $weatherData['windSpeed']['now']['beaufort'] = $this->windToBeaufort();
        }

        //sunset
        $sunset = new \DateTime($sunsetData->results->sunset);
        $sunset->setTimezone(new \DateTimeZone('America/Guayaquil'));
        $weatherData['sunsetAt'] = $sunset->format('H:m');

        $sunrise = new \DateTime($sunriseData->results->sunrise);
        $sunrise->setTimezone(new \DateTimeZone('America/Guayaquil'));
        $weatherData['sunriseAt'] = $sunrise->format('H:m');

        return $weatherData;
    }

    /**
     * Return closest value from available icons
     * @param $degree
     * @return mixed|null
     * @author Joel Mora
     */
    private function windDegreesRound($degree)
    {
        $availableIcons = array(0, 23, 45, 68, 90, 113, 135, 158, 180, 203, 225, 248, 270, 293, 313, 336);

        $closest = null;
        foreach ($availableIcons as $item) {
            if ($closest === null || abs($degree - $closest) > abs($item - $degree)) {
                $closest = $item;
            }
        }
        
        return $closest;
    }

    /**
     * Wind is Km/h to beaufort scale
     * @param $wind
     * @return array
     * @author Joel Mora
     */
    private function windToBeaufort($wind = null)
    {
        if ($wind === null) {
            return array('force' => -1, 'description' => 'N/A');
        } elseif ($wind < 1) {
            return array('force' => 0, 'description' => 'Calm');
        } elseif ($wind > 1 AND $wind < 5) {
            return array('force' => 1, 'description' => 'Light Air');
        } elseif ($wind > 6 AND $wind < 11) {
            return array('force' => 2, 'description' => 'Light Breeze');
        } elseif ($wind > 12 AND $wind < 19) {
            return array('force' => 3, 'description' => 'Gentle Breeze');
        } elseif ($wind > 20 AND $wind < 28) {
            return array('force' => 4, 'description' => 'Moderate Breeze');
        } elseif ($wind > 29 AND $wind < 38) {
            return array('force' => 5, 'description' => 'Fresh Breeze');
        } elseif ($wind > 39 AND $wind < 49) {
            return array('force' => 6, 'description' => 'Strong Breeze');
        } elseif ($wind > 50 AND $wind < 61) {
            return array('force' => 7, 'description' => 'Near Gale');
        } elseif ($wind > 62 AND $wind < 74) {
            return array('force' => 8, 'description' => 'Gale');
        } elseif ($wind > 75 AND $wind < 88) {
            return array('force' => 9, 'description' => 'Strong Gale');
        } elseif ($wind > 89 AND $wind < 102) {
            return array('force' => 10, 'description' => 'Storm');
        } elseif ($wind > 103 AND $wind < 107) {
            return array('force' => 11, 'description' => 'Violent Storm');
        } elseif ($wind > 108) {
            return array('force' => 12, 'description' => 'Hurricane');
        }
    }

    /**
     * @param $velocity
     * @return array
     * @author Joel Mora
     */
    private function msTokh($velocity)
    {
        return array(
            'value' => ($velocity / 1000) * 3600,
            'unit' => 'k/h',
        );
    }

    /**
     * @param $temperature float temperature in ºC
     * @param $wind float wind in m/s
     * @return array
     * @author Joel Mora
     */
    private function calculateWindChill($temperature, $wind)
    {
        $sensation = 13.12 + 0.6215 * $temperature - 11.37 * pow($wind, 0.16) + 0.3965 * $temperature * pow($wind, 0.16);

        return $sensation;
    }

    /**
     * @return string
     */
    public function getWeatherUrl()
    {
        return $this->weatherUrl . $this->station;
    }

    /**
     * @param string $url
     */
    public function setWeatherUrl($url)
    {
        $this->weatherUrl = $url;
    }

    /**
     * @return mixed
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * @param mixed $station
     */
    public function setStation($station)
    {
        $this->station = $station;
    }

    /**
     * @return string
     */
    public function getSunsetUrl(\DateTime $date)
    {
        $query = array(
            'lat' => $this->latitude,
            'lng' => $this->longitude,
            'date' => $date->format('Y-m-d'),
            'formatted' => 0,
        );
        return $this->sunsetUrl . '?' . http_build_query($query);
    }

    /**
     * @param string $sunsetUrl
     */
    public function setSunsetUrl($sunsetUrl)
    {
        $this->sunsetUrl = $sunsetUrl;
    }
    
    

}