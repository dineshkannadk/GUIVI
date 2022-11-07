<?php
require_once "pdo.php";
require_once "mongo.php";
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(json_decode(json_encode(file_get_contents("php://input"))));

$filter = ['username' => $data->username];
$options = [];
$query = new MongoDB\Driver\Query($filter, $options);
$result = $m->executeQuery('db.users', $query);
http_response_code(200);
//echo json_decode(json_encode(($result->toArray()[0])));
echo json_decode(json_encode(json_encode((array)$result->toArray()[0])));
return true;
?>