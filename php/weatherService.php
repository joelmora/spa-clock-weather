<?php

require_once 'WeatherCondition.php';

$weather = new WeatherManager\WeatherCondition();
$weatherConditions = $weather->getConditions();

header('Content-Type: application/json');
echo json_encode($weatherConditions);

