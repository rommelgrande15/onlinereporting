<?php
$user = 'newapi_appdb';
$password = '6n30jSrE';
// $user = 'root';
// $password = '';
try{
$handler = new PDO('mysql:host=localhost;dbname=newapi_appdb',$user, $password);
$handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$handler->exec('SET CHARACTER SET utf8');
$handler->query("SET NAMES utf8");
}
catch(PDOException $e){
echo $e->getMessage();
die();
}

/*
    $host_name  = "db573123452.db.1and1.com";
    $database   = "db573123452";
    $user_name  = "dbo573123452";
    $password   = "Gv290166";

    $handler = mysqli_connect($host_name, $user_name, $password, $database) or die("Connection to MySQL Server failed: " . mysqli_connect_error());
*/

?>