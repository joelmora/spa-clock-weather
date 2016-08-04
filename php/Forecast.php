<?php

namespace WeatherManager;

class Forecast
{
    private $url;
    private $city;

    public function __construct()
    {
        //default value
        $this->url = 'http://186.42.174.236:8080/WebServicesRest/webresources/ec.gob.inamhi.rs/pronostico';
        $this->city = 'QUITO';
    }

    public function getForecast()
    {
//        $curl = new CurlManager();
//        $forecastRaw = $curl->getData($this->getUrl());
        
        $json = '{"fuente":"INAMHI","informacion":"PronÃ³stico","sitio":"www.inamhi.gob.ec","correo":"servicio@inamhi.gob.ec","fecha":"04/08/2016 13:20:23","pronostico":[{"ciudad":"SANTA CRUZ","condicion":"Poco nuboso a parcial nublado. Viento moderado.","iconografia":"iconografia/viento.gif","temperaturamin":"21","temperaturamax":"29","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"SAN CRISTOBAL","condicion":"Parcial nublado. Viento moderado.","iconografia":"iconografia/viento.gif","temperaturamin":"20","temperaturamax":"27","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"ZAMORA","condicion":"<div align=\"left\">Parcial nublado a nublado, lloviznas aisladas. Niebla.","iconografia":"iconografia/llovizna.gif","temperaturamin":"17","temperaturamax":"23","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"MACAS","condicion":"Nublado a parcial nublado, lloviznas dispersas. Niebla.","iconografia":"iconografia/llovizna.gif","temperaturamin":"16","temperaturamax":"24","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"PUYO","condicion":"<div align=\"left\">\r\n                             <div align=\"left\">Nublado con claros, lluvias dispersas. Niebla.","iconografia":"iconografia/casinubladolluvia.gif","temperaturamin":"16","temperaturamax":"26","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"TENA","condicion":"<div align=\"left\">\r\n                           <div align=\"left\">Nublado, ocasional parcial nublado, lluvias aisladas.","iconografia":"iconografia/lluviasaisladas.gif","temperaturamin":"20","temperaturamax":"28","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"EL COCA","condicion":"Nublado variando a parcial nublado.","iconografia":"iconografia/parcialnublado.gif","temperaturamin":"22","temperaturamax":"31","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"LAGO AGRIO","condicion":"Nublado variando a parcial nublado.","iconografia":"iconografia/parcialnublado.gif","temperaturamin":"22","temperaturamax":"30","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"LOJA","condicion":"Nublado con claros, lloviznas.","iconografia":"iconografia/llovizna.gif","temperaturamin":"12","temperaturamax":"19","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"CUENCA","condicion":"Nublado variando a   parcial nublado.","iconografia":"iconografia/parcialnublado.gif","temperaturamin":"11","temperaturamax":"20","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"RIOBAMBA","condicion":"Nublado con claros. Viento moderado.","iconografia":"iconografia/viento.gif","temperaturamin":"9","temperaturamax":"21","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"AMBATO","condicion":"Nublado a ocasional parcial nublado.","iconografia":"iconografia/parcialnublado.gif","temperaturamin":"10","temperaturamax":"19","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"LATACUNGA","condicion":"Parcial nublado a nublado. Viento moderado.","iconografia":"iconografia/viento.gif","temperaturamin":"9","temperaturamax":"20","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"QUITO","condicion":"Parcial nublado. Viento moderado.","iconografia":"iconografia/viento.gif","temperaturamin":"10","temperaturamax":"23","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"IBARRA","condicion":"Parcial nublado. Viento moderado.","iconografia":"iconografia/viento.gif","temperaturamin":"12","temperaturamax":"24","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"TULCAN","condicion":"Nublado a  parcial nublado.","iconografia":"iconografia/parcialnublado.gif","temperaturamin":"8","temperaturamax":"16","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"MACHALA","condicion":"Nublado   variando a parcial nublado Bruma.","iconografia":"iconografia/bruma.gif","temperaturamin":"22","temperaturamax":"30","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"SALINAS","condicion":"Parcial nublado. Bruma.","iconografia":"iconografia/bruma.gif","temperaturamin":"24","temperaturamax":"26","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"GUAYAQUIL","condicion":"Nublado   variando a parcial nublado. Bruma.","iconografia":"iconografia/bruma.gif","temperaturamin":"22","temperaturamax":"30","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"QUEVEDO","condicion":"Nublado con claros. Niebla.","iconografia":"iconografia/niebla.gif","temperaturamin":"21","temperaturamax":"28","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"PORTOVIEJO","condicion":"Nublado   variando a parcial nublado.","iconografia":"iconografia/parcialnublado.gif","temperaturamin":"21","temperaturamax":"30","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"MANTA","condicion":"Nublado variando a  parcial nublado. Bruma.","iconografia":"iconografia/bruma.gif","temperaturamin":"23","temperaturamax":"28","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"SANTO DOMINGO DE LOS TSACHILAS","condicion":"Nublado, ocasional parcial nublado, lloviznas. Niebla.","iconografia":"iconografia/llovizna.gif","temperaturamin":"20","temperaturamax":"26","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"},{"ciudad":"ESMERALDAS","condicion":"Nublado con claros.","iconografia":"iconografia/ocasionalparcialnublado.png","temperaturamin":"24","temperaturamax":"30","observacion":"VÃ¡lido desde las 07h00 hasta las 19h00 del 12 de Julio del 2016"}]}';
        $forecastArray = json_decode($json);

        return $this->formatForecast($forecastArray);
    }

    /**
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