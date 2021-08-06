<?php
session_start();
include "config.php";
 // Upload directory
 $date_time = date("Y-m-d");
$session_user_id = $_POST['userId'];

//$target_dir = "upload/$session_user_id" . "_" . "PS_" . "$date_time/";
//$target_dir = "upload/$session_user_id/$date_time/PS/";
$target_dir = "upload/reports/$session_user_id/";

    mkdir("$target_dir", 0707);// Create directory if it does not exist

   
$request = 1;
if(isset($_POST['request'])){
	$request = $_POST['request'];
}

// Upload file
if($request == 1){
	$target_file = $target_dir . basename($_FILES["file"]["name"]);

	$msg = "";
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$_FILES['file']['name'])) {

		$file_name = $_FILES['file']['name'];
		$file_type=$_FILES['file']['type'];	
		$file_size =$_FILES['file']['size'];
		$handler->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); 
		$stmt=$handler->prepare("INSERT INTO `report_uploads`(`client_code`,`report_file`) VALUES (:client_code,:report_file)");
		$stmt->bindParam(':client_code',$session_user_id);
		$stmt->bindParam(':report_file',$file_name);
		if($stmt->execute()){
			$msg = "Successfully uploaded";
		} else {
			print_r($dbh->errorInfo());
			echo "Error";
		}
	}else{
	    print_r($dbh->errorInfo());
	}
	echo $msg;
}

// Remove file
if($request == 2){
	
$Fname=$_POST['name'];
$stmt5=$handler->prepare("DELETE FROM `report_uploads` where `file_name` = '$Fname' and status = '0'");
	if($stmt5->execute()){
		$msg = "Successfully";
	}else{
		$msg = "error";
	}
	echo $msg;

	$filename = $target_dir.$_POST['name']; 
	unlink($filename); 
	
	
	exit;

	$message = "wrong answer";

}
