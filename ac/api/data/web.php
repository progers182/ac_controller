<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With, X-Forwarded-For');

include_once '../config/ACDatabase.php';
include_once '../models/Commands';

// Connect to DB
$db = new ACDatabase();
$conn = $db->connect();

$insert_request = new Commands($conn);

// Get posted data
if (isset($_POST)) {
    $data = json_decode(json_encode($_POST));
//$data->ip_address = /*getenv('REMOTE_ADDR');*/  "127.0.0.1";  // for testing;

    $insert_request->create($data, true);

//    echo json_encode($data);
    echo 'Form Submitted!';

    $config = parse_ini_file("db_config.ini");
    $environment = strval($_SERVER['SERVER_NAME']);
    header("Location: http://{$environment}/ac/mike/dash.php");
}

else {
    echo json_encode(['error' => 500]);
}