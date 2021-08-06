<?php
/* $user = 'dbo685217075';
$password = 'd9ajqgjr99';
try{
$handler = new PDO('mysql:host=db685217075.db.1and1.com;dbname=db685217075',$user, $password);
$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
echo $e->getMessage();
die();
} */

$servername = "localhost";
$dbname = "newapi_appdb";
$username = "newapi_appdb";
$password = "6n30jSrE";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>