<?php

require_once 'Forecast.php';

$forecast = new WeatherManager\Forecast();
$forecastConditions = $forecast->getForecast();
//dump($forecastConditions);die();

header('Content-Type: application/json');
echo json_encode($forecastConditions);

