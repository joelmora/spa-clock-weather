<?php

namespace WeatherManager;

require_once 'simple_html_dom.php';

class Forecast
{
    private $url;
    private $city;
    private $monthsTranslation;

    public function __construct()
    {
        //default value
//        $this->url = 'http://186.42.174.236:8080/WebServicesRest/webresources/ec.gob.inamhi.rs/pronostico';
        $this->url = 'http://www.serviciometeorologico.gob.ec/pronostico/prediccion.htm';
        $this->city = 'QUITO';

        $this->monthsTranslation = array(
            'Enero' => 'January',
            'Febrero' => 'February',
            'Marzo' => 'March',
            'Abril' => 'April',
            'Mayo' => 'May',
            'Junio' => 'June',
            'Julio' => 'July',
            'Agosto' => 'August',
            'Septiembre' => 'September',
            'Octubre' => 'October',
            'Noviembre' => 'November',
            'Diciembre' => 'December'
        );
    }

    public function getForecast()
    {
        $html = file_get_html($this->getUrl());

        $forecastInterAndina = $html->find('table', 2);

        foreach ($forecastInterAndina->find('tr') as $trCity) {
            if ($trCity->find('td', 0)->plaintext == $this->getCity()) {
                $forecastText = trim($trCity->find('td', 1)->plaintext);
                $forecastIcon = $trCity->find('td', 2)->find('img', 0)->src;
            }
        }

        //get condition
        $condition = array();
        preg_match_all('/iconografia\/(\w+)\.\w+$/', $forecastIcon, $condition);

        //get icons by condition
        $icons = $this->getIcons($condition[1][0]);

        return array(
            'timestamp' => date('Y-m-d H:i:s'),
            'description' => $forecastText,
            'dayicon' => $icons['day'],
            'nighticon' => $icons['night'],
        );
    }

    /**
     * Get icons according to condition
     * @param $condition
     * @return array
     * @author Joel Mora
     */
    private function getIcons($condition)
    {
        switch($condition) {
            case 'bruma':
                $dayIcon = 'wi-day-fog';
                $nightIcon = 'wi-night-fog';
                break;
            case 'calima':
                $dayIcon = 'wi-day-haze';
                $nightIcon = 'wi-dust';
                break;
            case 'casinubladolluvia':
                $dayIcon = 'wi-rain-mix';
                $nightIcon = 'wi-rain-mix';
                break;
            case 'cenizavolcanica':
                $dayIcon = 'wi-volcano';
                $nightIcon = 'wi-volcano';
                break;
            case 'chubascosaislados':
                $dayIcon = 'wi-day-snow-wind';
                $nightIcon = 'wi-night-alt-snow';
                break;
            case 'chubascosdispersos':
                $dayIcon = 'wi-rain-mix';
                $nightIcon = 'wi-rain-mix';
                break;
            case 'despeado':
                $dayIcon = 'wi-day-sunny';
                $nightIcon = 'wi-night-clear';
                break;
            case 'humo':
                $dayIcon = 'wi-smoke';
                $nightIcon = 'wi-smoke';
                break;
            case 'llovizna':
                $dayIcon = 'wi-sleet';
                $nightIcon = 'wi-sleet';
                break;
            case 'lluvia':
                $dayIcon = 'wi-rain';
                $nightIcon = 'wi-rain';
                break;
            case 'lluviasaisladas':
                $dayIcon = 'wi-day-showers';
                $nightIcon = 'wi-night-alt-showers';
                break;
            case 'niebla':
                $dayIcon = 'wi-day-fog';
                $nightIcon = 'wi-night-fog';
                break;
            case 'nublado':
                $dayIcon = 'wi-cloudy';
                $nightIcon = 'wi-cloudy';
                break;
            case 'nubladoconclaros':
                $dayIcon = 'wi-day-sunny-overcast';
                $nightIcon = 'wi-night-alt-partly-cloudy';
                break;
            case 'ocasionalparcialnublado':
                $dayIcon = 'wi-day-cloudy';
                $nightIcon = 'wi-night-alt-cloudy';
                break;
            case 'parcialnublado':
                $dayIcon = 'wi-day-cloudy';
                $nightIcon = 'wi-night-alt-cloudy';
                break;
            case 'pocanubosidad':
                $dayIcon = 'wi-day-sunny-overcast';
                $nightIcon = 'wi-night-alt-partly-cloudy';
                break;
            case 'tormenta':
                $dayIcon = 'wi-thunderstorm';
                $nightIcon = 'wi-thunderstorm';
                break;
            case 'viento':
                $dayIcon = 'wi-day-windy';
                $nightIcon = 'wi-strong-wind';
                break;
        }

        return array(
            'day' => $dayIcon,
            'night' => $nightIcon,
        );
    }

    /**
     * @deprecated Web service outdated
     * Format forecast to be used on GUI
     * @param $rawData
     * @return array
     * @author Joel Mora
     */
    private function formatForecast($rawData)
    {
        $forecastData = array();

        foreach ($rawData->pronostico as $record) {
            //get only this city
            if ($record->ciudad == $this->getCity()) {
                $forecastData['temp']['min'] = $record->temperaturamin;
                $forecastData['temp']['max'] = $record->temperaturamax;
                $forecastData['condition'] = $record->condicion;

                $date = array();
                preg_match_all('/(\d+)h00 del (\d+) de (\w+) del (\d+)$/', $record->observacion, $date);
                $month = strtr($date[3][0], $this->monthsTranslation);

                $expireOn = \DateTime::createFromFormat('Y-M-d H', $date[4][0] . '-' . $month . '-' . $date[2][0] . ' ' . $date[1][0]);
                $forecastData['expireOn'] = $expireOn->format('Y-m-d H:i:s');
            }
        }

        return $forecastData;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }


}