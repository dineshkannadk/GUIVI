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
$sql = $conn->query("SELECT username  FROM `User`;");
while($result = $sql->fetch(PDO::FETCH_ASSOC)){
    //var_dump($result);
    if($result->username==$data->username){
        http_response_code(400);
        echo "Username already used";
        return false;
    }
}
$hPass = password_hash($data->password,PASSWORD_DEFAULT);
$writer = new MongoDB\Driver\BulkWrite;
$document1 = ['username' => $data->username,'name'=>$data->name,'phoneNumber'=>null,'dob'=>null];
$writer->insert($document1);
try{
    $sql = $conn->query("INSERT INTO `User` (`name`, `username`, `password`) VALUES ('$data->name', '$data->username','$hPass');");
    $m->executeBulkWrite('db.users',$writer);
}catch (PDOException $e){
    http_response_code(400);
    echo "Username already used.";
    return false;
}
http_response_code(200);
echo "User registered successfully!";
return true;
?>