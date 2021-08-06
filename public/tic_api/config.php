<?php
$user = 'ticasia_appdb2';
$password = 'appdb2';
try{
$conn = new PDO('mysql:host=localhost;dbname=ticasia_appdb2',$user, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo 'success';
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