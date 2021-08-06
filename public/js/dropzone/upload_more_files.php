<?php
session_start();
include "../../include/config.php";
 
 $date_time = date("Y-m-d");
$session_user_id = $_SESSION['user_id'];
/* $photo_category="PS"; */
$prod_id= $_COOKIE['productID'];
$photo_category= $_COOKIE['productCategory'];
$target_dir = "upload/$session_user_id" . "_" . $photo_category . "_" . "$date_time/";


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
	$description=$_POST['description'];
	

		$stmt=$conn->prepare("INSERT INTO `product_photos` ( `user_id`, `product_id`,  `file_name`, `file_path`, `file_type`, `description`, `photo_category`) 
		VALUES (:user_id, :product_id, :file_name, :file_path, :file_type, :description, :photo_category)");
		$stmt->bindParam(':user_id',$session_user_id);
		$stmt->bindParam(':product_id',$prod_id);
		$stmt->bindParam(':file_name',$file_name);
		$stmt->bindParam(':file_path',$target_dir);
		$stmt->bindParam(':file_type',$file_type);
		$stmt->bindParam(':description',$description);
		$stmt->bindParam(':photo_category',$photo_category);
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
$stmt5=$conn->prepare("DELETE FROM `product_photos` where `file_name` = '$Fname' and status = '0' and photo_category ='$photo_category'");
	if($stmt5->execute()){
		$msg = "Successfully";
	}else{
		$msg = "error";
	}
	/* echo $msg; */
	$filename = $target_dir.$_POST['name']; 
	unlink($filename); exit;
}
