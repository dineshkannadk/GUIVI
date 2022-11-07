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

$hPass = password_hash($data->password,PASSWORD_DEFAULT);
$writer = new MongoDB\Driver\BulkWrite;
$document1 = ['username' => $data->username,'name'=>$data->name,'phoneNumber'=>$data->phoneNumber,'dob'=>$data->dob];
$writer->update(
    ['username' => $data->username],
    $document1
);
try{
    $sql = $conn->query("UPDATE `User` SET `name`='$data->name', `username`='$data->username',`password`='$hPass' WHERE username='$data->username';");
    $m->executeBulkWrite('db.users',$writer);
}catch (PDOException $e){
    http_response_code(400);
    echo "Update failed.";
    return false;
}
http_response_code(200);
echo "Profile updated successfully!";
//echo $data->name;
return true;
?>