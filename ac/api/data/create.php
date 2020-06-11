<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/ArduinoState.php';
include_once '../models/Commands';
include_once '../models/Devices.php';
include_once '../models/States.php';

// Connect to DB
$db = new Database();
$conn = $db->connect();

$id = isset($_GET['table']) ? $_GET['table'] : -1;
$table = $db->getTableName($id);

if ($id > -1 && !empty($table)) {
    $insert_request = selectClass($conn, $table);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    if ($insert_request->create($data)) {
        echo json_encode([
            'message' => 'Data received'
        ]);
    } else {
        echo json_encode([
            'message' => 'Error'
        ]);
    }


} else {
    echo json_encode([
        'Error message' => 'Please specify database table to POST to'
    ]);
}

function selectClass($conn, $table) {

    switch ($table) {
        case 'arduino_state':
            return new ArduinoState($conn);
            break;
        case 'commands':
            return new Commands($conn);
            break;
        case 'device_ids':
            return new Devices($conn);
            break;
//        case 'state_ids':
//            return new StateIds($conn);
//            break;
        default:
            return null;
    }
}