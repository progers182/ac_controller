<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/ACDatabase.php';
include_once '../models/ArduinoState.php';

// Connect to DB
$db = new ACDatabase();
$conn = $db->connect();


$post = new ArduinoState($conn,  'device_ids');

$result = $post->read();

$num = $result->rowCount();

if ($num > 0) {
    $post_arr = [];
    $post_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $post_item = [
            'status_time' => $row['status_time'],
            'curr_state' => $row['curr_state'],
            'device_id' => html_entity_decode($row['device_id']),

        ];

        array_push($post_arr['data'], $post_item);
    }

    echo json_encode($post_arr);
} else {
    echo json_encode(['message' => 'no posts found']);
}

