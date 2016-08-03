<?php

//$url = 'http://186.42.174.236:8080/WebServicesRest/webresources/ec.gob.inamhi.puob/paramxesta/M0024';
//
////  Initiate curl
//$ch = curl_init();
//// Disable SSL verification
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//// Will return the response, if false it print the response
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//// Set the url
//curl_setopt($ch, CURLOPT_URL, $url);
//// Execute
//$result=curl_exec($ch);
//// Closing
//curl_close($ch);
//
// Will dump a beauty json :3

$result = '{"fu":"Inamhi","iE":[{"fe":"2016-08-03 10:00:00","da":"40.0","si":"%","pa":"HUMEDAD RELATIVA DEL AIRE","de":"MINIMA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"47.0","si":"%","pa":"HUMEDAD RELATIVA DEL AIRE","de":"MAXIMA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"41.0","si":"%","pa":"HUMEDAD RELATIVA DEL AIRE","de":"INSTANTANEA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"0.0","si":"mm","pa":"PRECIPITACION","de":"SUMA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"731.5","si":"hPa","pa":"PRESION ATMOSFERICA","de":"INSTANTANEA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"19.5","si":"ºC","pa":"TEMPERATURA AIRE","de":"MAXIMA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"19.3","si":"ºC","pa":"TEMPERATURA AIRE","de":"INSTANTANEA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"16.7","si":"ºC","pa":"TEMPERATURA AIRE","de":"MINIMA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"183.0","si":"º","pa":"VIENTO DIRECCION","de":"INSTANTANEA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"},{"fe":"2016-08-03 10:00:00","da":"1.9","si":"m/s","pa":"VIENTO VELOCIDAD","de":"INSTANTANEA","ti":"VAISALA CLIMATOLOGICA PRINCIPAL"}]}';
//FIXME arreglar codificacion Â° en º
$rawData = json_decode($result, true);
$weatherData = array();

foreach ($rawData['iE'] as $record) {
    //humidity
    if ($record['pa'] == 'HUMEDAD RELATIVA DEL AIRE' AND $record['de'] == 'MINIMA') {
        $weatherData['humidity']['min']['value'] = $record['da'];
        $weatherData['humidity']['min']['unit'] = $record['si'];
    }
    if ($record['pa'] == 'HUMEDAD RELATIVA DEL AIRE' AND $record['de'] == 'MAXIMA') {
        $weatherData['humidity']['max']['value'] = $record['da'];
        $weatherData['humidity']['max']['unit'] = $record['si'];
    }
    if ($record['pa'] == 'HUMEDAD RELATIVA DEL AIRE' AND $record['de'] == 'INSTANTANEA') {
        $weatherData['humidity']['now']['value'] = $record['da'];
        $weatherData['humidity']['now']['unit'] = $record['si'];
    }
    //rain
    if ($record['pa'] == 'PRECIPITACION' AND $record['de'] == 'SUMA') {
        $weatherData['rain']['sum']['value'] = $record['da'];
        $weatherData['rain']['sum']['unit'] = $record['si'];
    }
    //pressure
    if ($record['pa'] == 'PRESION ATMOSFERICA' AND $record['de'] == 'INSTANTANEA') {
        $weatherData['pressure']['now']['value'] = $record['da'];
        $weatherData['pressure']['now']['unit'] = $record['si'];
    }
    //temperature
    if ($record['pa'] == 'TEMPERATURA AIRE' AND $record['de'] == 'MINIMA') {
        $weatherData['temperature']['min']['value'] = $record['da'];
        $weatherData['temperature']['min']['unit'] = $record['si'];
    }
    if ($record['pa'] == 'TEMPERATURA AIRE' AND $record['de'] == 'MAXIMA') {
        $weatherData['temperature']['max']['value'] = $record['da'];
        $weatherData['temperature']['max']['unit'] = $record['si'];
    }
    if ($record['pa'] == 'TEMPERATURA AIRE' AND $record['de'] == 'INSTANTANEA') {
        $weatherData['temperature']['now']['value'] = $record['da'];
        $weatherData['temperature']['now']['unit'] = $record['si'];
    }
    //wind
    if ($record['pa'] == 'VIENTO DIRECCION' AND $record['de'] == 'INSTANTANEA') {
        $weatherData['windDirection']['now']['value'] = $record['da'];
        $weatherData['windDirection']['now']['unit'] = $record['si'];
    }
    if ($record['pa'] == 'VIENTO VELOCIDAD' AND $record['de'] == 'INSTANTANEA') {
        $weatherData['windSpeed']['now']['value'] = $record['da'];
        $weatherData['windSpeed']['now']['unit'] = $record['si'];
    }
}

//dump($weatherData);



header('Content-Type: application/json');
echo json_encode($weatherData);

