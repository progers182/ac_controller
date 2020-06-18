<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Commands';
include_once '../models/Devices.php';

// Connect to DB
$db = new Database();
$conn = $db->connect();


$cmd = new Commands($conn);

echo json_encode($cmd->queueState());


