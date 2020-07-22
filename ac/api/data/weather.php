<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$config = parse_ini_file("config.ini");

$url = 'https://api.climacell.co/v3/weather/realtime?location_id=' . $config['provo_id'] . '&unit_system=us';
// data to request
$fields = [
    'temp',
    'feels_like'
];

$url .= '&fields=';

foreach ($fields as $field) {
    $url .= $field;
    $url .= '%2C';
}
// trim last html encoded comma
$url = substr($url, 0, -3);

$url .= '&apikey=' . $config['weather_key'];

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

$temp = number_format($data['temp']['value'], 2);
$feel = number_format($data['feels_like']['value'], 2);
echo(json_encode(
    [
        'temp' => $temp,
        'feels_like' => $feel,
        'observation_time' => $data['observation_time']['value']
    ]
));