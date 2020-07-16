<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$url = 'api.openweathermap.org/data/2.5/weather?q=provo,ut,usa&appid=cbbdaab56e1b8f479d7dcd5402126854';

$ch = curl_init();
//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, $url);

//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = curl_exec($ch);
curl_close($ch);

// decode json string
$data = json_decode($data, true);
// return relevant data
echo (json_encode(
    [
        'temp' => $data['main']['temp'],
        'feels_like' => $data['main']['feels_like'],
    ]
));