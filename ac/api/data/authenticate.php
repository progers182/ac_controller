<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/ACDatabase.php';
include_once '../models/ArduinoState.php';
include_once '../models/Devices.php';

// Connect to DB
$db = new ACDatabase();
$conn = $db->connect();

$device = new Devices($conn);
$ip_address = getenv('REMOTE_ADDR');  // "127.0.0.1"; // for testing

$auth = isset($_GET["auth"]) ? $_GET["auth"] : false;
if ($auth) {
    $data = json_decode(file_get_contents("php://input"));
    $data->ip_address = $ip_address;
    $response = $device->create($data);
    if (isset($response["authenticated"])) {
        echo json_encode($response);
    } else {
        echo json_encode($response);
    }
} else {
    $data = $device->get_device($ip_address, ["internal_id"]);
    if (isset($data["internal_id"]) && $data["internal_id"] > 0) {
        echo json_encode([
            "authenticated" => true
        ]);
    } else {
        echo json_encode(
            $data
        );
    }
}