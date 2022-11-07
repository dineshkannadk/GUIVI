<?php
require_once "pdo.php"; // <3
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(json_decode(json_encode(file_get_contents("php://input"))));
$hPass = password_hash($data->password,PASSWORD_DEFAULT);
$sql = $conn->query("SELECT username,password  FROM `User` WHERE username='$data->username';");
while($result = $sql->fetch(PDO::FETCH_ASSOC)){
//    var_dump($result);
//    echo $result["username"];
    if($result["username"]==$data->username&&password_verify($data->password,$result["password"])){
        http_response_code(200);
        echo json_encode(array("message" => "ok","username" => $data->username,"password"=>$result["password"]));
        return true;
    }
}
http_response_code(400);
echo "Username or password is wrong.";
return false;
?>