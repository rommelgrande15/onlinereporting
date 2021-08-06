<?php
	include 'config.php';

	function getInspectionDetails($ref_num){
		require "config.php";
        $stmt = $conn->prepare("SELECT * FROM inspections WHERE client_project_number=:client_project_number");
        $stmt->bindParam(':client_project_number',$ref_num);
        $stmt->execute();
        $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    function getImages($rep_num,$table){
		require "config.php";
        $stmt = $conn->prepare("SELECT * FROM $table WHERE report_number=:report_number");
        $stmt->bindParam(':report_number',$rep_num);
        $stmt->execute();
        $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    

	function factoryDetails($id,$request){
		require "config.php";
        $stmt = $conn->prepare("SELECT * FROM factories WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row[$request];
    }
    
    function inspectionDetails($ref_num,$request){
		require "config.php";
        $stmt = $conn->prepare("SELECT * FROM inspections WHERE client_project_number=:client_project_number");
        $stmt->bindParam(':client_project_number',$ref_num);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row[$request];
	}
?>
