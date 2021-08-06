<?php
session_start();
include "config.php";
 // Upload directory
 $date_time = date("Y-m-d");
$session_user_id = $_POST['userId'];

//$target_dir = "upload/$session_user_id" . "_" . "PS_" . "$date_time/";
//$target_dir = "upload/$session_user_id/$date_time/PS/";
$target_dir = "upload/PS/$session_user_id/";

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
	$description=$_POST['description'];
	$photo_category='PS';

		$stmt=$handler->prepare("INSERT INTO `product_photos` ( `user_id`,  `file_name`, `file_path`, `file_type`, `description`, `photo_category`,	`file_size`) 
		VALUES (:user_id, :file_name, :file_path, :file_type, :description, :photo_category,:file_size)");
		$stmt->bindParam(':user_id',$session_user_id);
		$stmt->bindParam(':file_name',$file_name);
		$stmt->bindParam(':file_path',$target_dir);
		$stmt->bindParam(':file_type',$file_type);
		$stmt->bindParam(':description',$description);
		$stmt->bindParam(':photo_category',$photo_category);
		$stmt->bindParam(':file_size',$file_size);
		if($stmt->execute()){

			$msg = "Successfully uploaded";
			
		}
	    
	}else{
	    $msg = "Error while uploading";
	}

	echo $msg;
	
}

// Remove file
if($request == 2){
	
$Fname=$_POST['name'];
$stmt5=$handler->prepare("DELETE FROM `product_photos` where `file_name` = '$Fname' and status = '0' and photo_category ='PS'");
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
