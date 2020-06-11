<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/ArduinoState.php';
include_once '../models/Devices.php';

// Connect to DB
$db = new Database();
$conn = $db->connect();


$post = new ArduinoState($conn);

$result = $post->read_single();

echo json_encode($result->fetch(PDO::FETCH_ASSOC));