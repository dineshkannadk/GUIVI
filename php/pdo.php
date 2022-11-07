<?php
$servername = "localhost";
$username = "madhavan-r7";
$password = "password";
try {
    $conn = new PDO("mysql:host=$servername;dbname=GUVI_GEEK", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>