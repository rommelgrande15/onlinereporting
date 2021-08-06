<?php
session_start();
require "config.php";
//include 'vendor/autoload.php';

/* require '../vendor/autoload.php'; */
$date_now = date("Y-m-d h:i:sa");


if(isset($_POST['submit_upload_report'])){
    $gen_info_id=$_POST['gen_info_id'];
    $gen_comp_id=$_POST['gen_comp_id'];

    $file_name = $_FILES['uploaded_report']['name'];
    $file_tmp =$_FILES['uploaded_report']['tmp_name'];
    //echo $file_tmp;
    $desired_dir="reports";
    $full_file_name="reports/$file_name";
    
    /* $recipient=$_POST['recipient'];
    print_r($recipient); */
   
   

    if(is_dir($desired_dir)==false){
        mkdir($desired_dir, 0777, true);
        chmod($desired_dir, 0777);      
    }
    if(is_dir("$desired_dir/".$file_name)==false){ 
        if(move_uploaded_file($_FILES['uploaded_report']['tmp_name'],$full_file_name)){
            $id=insertInUploads($gen_info_id, $gen_comp_id,$file_name,$full_file_name, $date_now);
            $table="reports_upload";
            $client_contact=selectCompDetails("contactName",$gen_comp_id);
            $client_email=selectLogInDetails("email",$gen_comp_id);
            $title=selectInspectSummary("inssum_refnum",$gen_info_id,$gen_comp_id);
            $ins_date=selectInspectSummary("inssum_dateins",$gen_info_id,$gen_comp_id);
            $ship_date=selectInspectSummary("inssum_dateship",$gen_info_id,$gen_comp_id);
            $factory=selectInspectSummary("inssum_factory",$gen_info_id,$gen_comp_id);
            $recipient=$_POST['hide_recipient'];
            $recipient_cc=$_POST['hide_recipient_cc'];
            sendMailToClientMultiple($client_contact,$recipient,$title,$client_email,$recipient_cc,$ins_date,$ship_date,$factory,$id,$table);
            $_SESSION['result_upload']='ok';
            
        }
    }else{
        $new_dir="$desired_dir/".$file_name.time();
        rename($file_tmp,$new_dir) ;       
    }
}


if(isset($_POST['submit_upload_report_hard_coded'])){

    $file_name = $_FILES['uploaded_report']['name'];
    $file_tmp =$_FILES['uploaded_report']['tmp_name'];
    $recipient=$_POST['hide_recipient'];
    $recipient_cc=$_POST['hide_recipient_cc'];
    $title=$_POST['ref_num'];
    $ins_date=$_POST['ins_date'];
    $fac_email=$_POST['fac_email'];
    $fac_name=$_POST['fac_name'];
    /* $ship_date=$_POST['ship_date']; */

    $ship_date="";
    
    $comp_id=$_POST['hide_comp_id'];
    $desired_dir="reports";
    $full_file_name="reports/$file_name";
      
    $client_email=selectLogInDetails("email",$comp_id);

    if(is_dir($desired_dir)==false){
        mkdir($desired_dir, 0777, true);
        chmod($desired_dir, 0777);      
    }
    if(is_dir("$desired_dir/".$file_name)==false){ 
        if(move_uploaded_file($_FILES['uploaded_report']['tmp_name'],$full_file_name)){
            $get_id=insertInReportsReview($title, $ins_date,$file_name,$full_file_name, $date_now,$comp_id,$fac_email,$fac_name,$ship_date);             
            //sendMailToClientHardCoded($recipient,$title,$recipient_cc);
            $tbl="reports_reviewer";
            if(sendMailToClientHardCoded($recipient,$title,$recipient_cc,$ins_date,$ship_date,$fac_name,$get_id,$tbl,$client_email)==true){
                $_SESSION['result_upload']='ok';
            }else{
                $_SESSION['result_upload']='not_ok';
            }
            
            
        }
    }else{
        $new_dir="$desired_dir/".$file_name.time();
        rename($file_tmp,$new_dir) ;       
    }
}

if(isset($_POST['not_registered_client'])){

    $file_name = $_FILES['uploaded_report']['name'];
    $file_tmp =$_FILES['uploaded_report']['tmp_name'];
    $recipient=$_POST['hide_recipient'];
    $recipient_cc=$_POST['hide_recipient_cc'];
    $title=$_POST['ref_num'];
    $ins_date=$_POST['ins_date'];
    $fac_email=$_POST['fac_email'];
    $fac_name=$_POST['fac_name'];
    /* $ship_date=$_POST['ship_date']; */
    $ship_date="";
    $comp_id=0;
    $desired_dir="reports";
    $full_file_name="reports/$file_name";
      
    if(is_dir($desired_dir)==false){
        mkdir($desired_dir, 0777, true);
        chmod($desired_dir, 0777);      
    }
    if(is_dir("$desired_dir/".$file_name)==false){ 
        if(move_uploaded_file($_FILES['uploaded_report']['tmp_name'],$full_file_name)){
            $get_report_id=insertInReportsReview($title, $ins_date,$file_name,$full_file_name, $date_now,$comp_id,$fac_email,$fac_name,$ship_date);             
                sendMailToNotRegisteredClientHardCoded($recipient,$title,$recipient_cc,$ins_date,$ship_date,$fac_name,$get_report_id);
                $_SESSION['not_registered_client']='ok';
            
        }
    }else{
        $new_dir="$desired_dir/".$file_name.time();
        rename($file_tmp,$new_dir) ;       
    }
}

if(isset($_POST['submit_upload_report_hard_coded_edit'])){

    $file_name = $_FILES['uploaded_report']['name'];
    $file_tmp =$_FILES['uploaded_report']['tmp_name'];
    $recipient=$_POST['hide_recipient'];
    $recipient_cc=$_POST['hide_recipient_cc'];

    
    $ref_num=$_POST['ref_num'];
    $comp_id=$_POST['comp_id'];
    $fac_email=$_POST['fac_email'];
    $ins_date=$_POST['ins_date'];
    $ship_date=$_POST['ship_date'];
    $fac_name=$_POST['fac_name'];

    $client_email=selectLogInDetails("email",$comp_id);

    $desired_dir="reports";
    $full_file_name="reports/$file_name";
      
    if(is_dir($desired_dir)==false){
        mkdir($desired_dir, 0777, true);
        chmod($desired_dir, 0777);      
    }
    if(is_dir("$desired_dir/".$file_name)==false){ 
        if(move_uploaded_file($_FILES['uploaded_report']['tmp_name'],$full_file_name)){
            $get_id=insertInReportsReview($ref_num, $ins_date,$file_name,$full_file_name, $date_now,$comp_id,$fac_email,$fac_name,$ship_date);    
            $tbl="reports_reviewer";            
            sendMailToClientHardCoded($recipient,$ref_num,$recipient_cc,$ins_date,$ship_date,$fac_name,$get_id,$tbl,$client_email);
            $_SESSION['result_upload']='ok';
            
        }
    }else{
        $new_dir="$desired_dir/".$file_name.time();
        rename($file_tmp,$new_dir) ;       
    }
}

if(isset($_POST['deleteReport'])){
    $get_id=$_POST['id'];
    $check=deleteFile($get_id);
    if($check==true){
        echo 'ok';
    }
}
if(isset($_POST['edit_submit_upload_report'])){
    $get_id=$_POST['edit_report_id'];
   /*  $check=unlinkFile($get_id); */
    /* if($check==true){ */
        $gen_info_id=$_POST['edit_gen_info_id'];
        $gen_comp_id=$_POST['edit_gen_comp_id'];

        $file_name = $_FILES['edit_uploaded_report']['name'];
        $file_tmp =$_FILES['edit_uploaded_report']['tmp_name'];
        /* echo $file_tmp; */
        $desired_dir="reports";
        $full_file_name="reports/$file_name";

        if(is_dir($desired_dir)==false){
            mkdir($desired_dir, 0777, true);
            chmod($desired_dir, 0777);      
        }
        if(is_dir("$desired_dir/".$file_name)==false){ 
            /* if(){ */
                move_uploaded_file($_FILES['edit_uploaded_report']['tmp_name'],$full_file_name);
                $check_edit=editReports($file_name, $full_file_name, $get_id);
               if($check_edit==true){
                    $_SESSION['edit_result_upload']='ok';
                }
            /* } */
        }else{
            $new_dir="$desired_dir/".$file_name.time();
            rename($file_tmp,$new_dir) ;       
        }
    /* } */
}



if(isset($_POST['submit_report_client'])){

        $contact_email=$_POST['comp_contact_email'];
        $pass=$_POST['password'];
        $comp_name=$_POST['comp_name'];
        $comp_email=$_POST['comp_email'];
        $contact_name=$_POST['comp_contact_name'];

        $ref_num=$_POST['ref_num'];
        $comp_id=$_POST['comp_id'];
        $fac_email=$_POST['fac_email'];
        $ins_date=$_POST['ins_date'];

        $file_name = $_FILES['uploaded_report']['name'];
        $file_tmp =$_FILES['uploaded_report']['tmp_name'];

        $desired_dir="reports";
        $full_file_name="reports/$file_name";

        $recipient=$_POST['hide_recipient'];
        $recipient_cc=$_POST['hide_recipient_cc'];
        
        if(is_dir($desired_dir)==false){
            mkdir($desired_dir, 0777, true);
            chmod($desired_dir, 0777);      
        }
        if(is_dir("$desired_dir/".$file_name)==false){ 

            move_uploaded_file($_FILES['uploaded_report']['tmp_name'],$full_file_name);
            $check_insert=insertClientDetails($contact_email, $pass, $comp_name, $comp_email, $contact_name, $ref_num, $ins_date,$file_name,$full_file_name, $date_today, $fac_email);
            sendMailToClientHardCoded($recipient,$ref_num,$recipient_cc);
            if($check_insert==true){
                $_SESSION['edit_result_upload']='ok';
            }

        }else{
            $new_dir="$desired_dir/".$file_name.time();
            rename($file_tmp,$new_dir) ;       
        }
}

if(!empty($_POST['username'])){
    $username=$_POST['username'];
    $plain=$_POST['plain'];
    $stmt = $conn->prepare("SELECT * FROM `users` where `username` = :username and `plain` = :plain ");
    $stmt->bindParam(':username',$username);
    $stmt->bindParam(':plain',$plain);
    $stmt->execute();
    $rows=$stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount()>0){
        $_SESSION['user_id'] =$rows['id'];
        $_SESSION['username'] = $rows['username'];
       // $_SESSION['FirstName'] =$rows['FirstName'];
        //$_SESSION['LastName'] = $rows['LastName'];
        echo "ok";
    }
   
}

if(isset($_POST['approve_inspection'])){
    $inssum_id=$_POST['inssum_id'];
    $inssum_compid=$_POST['inssum_compid'];
    $stat="Confirmed";
    $check=updateStatus($stat,$inssum_id,$inssum_compid);
    $is_release="is released.";      
    $hold="released";
    $ref_num= selectInspectSummary("inssum_refnum",$inssum_id,$inssum_compid);
    $shipment_date= selectInspectSummary("inssum_dateship",$inssum_id,$inssum_compid);  
    $contact_email= selectLogInDetails("email",$inssum_compid);  
    $fac_email=selectFacDetails("factory_email",$inssum_compid, $ref_num);
    $comp_name=selectCompDetails("compName",$inssum_compid);
    $sendmail=sendMailToFactory($is_release,$shipment_date,$hold,$fac_email,$contact_email,$ref_num,$comp_name);
    if($check==true && $sendmail==true){      
        echo 'ok';
    }
}

if(isset($_POST['reject_inspection'])){
    $inssum_id=$_POST['inssum_id'];
    $inssum_compid=$_POST['inssum_compid'];
    $stat="Shipment Cancelled";
    $check=updateStatus($stat,$inssum_id,$inssum_compid);
    $is_release="is not released.";      
    $hold="hold";
    $ref_num= selectInspectSummary("inssum_refnum",$inssum_id,$inssum_compid);
    $shipment_date= selectInspectSummary("inssum_dateship",$inssum_id,$inssum_compid);  
    $contact_email= selectLogInDetails("email",$inssum_compid);  
    $fac_email=selectFacDetails("factory_email",$inssum_compid, $ref_num);
    $comp_name=selectCompDetails("compName",$inssum_compid);
    $sendmail=sendMailToFactory($is_release,$shipment_date,$hold,$fac_email,$contact_email,$ref_num,$comp_name);
    if($check==true && $sendmail==true){      
        echo 'ok';
    }
}

if(isset($_POST['approve_inspection2'])){
    
    $inssum_compid=$_POST['inssum_compid'];
    $ref_num=$_POST['ref_num'];
    $stat=1;
    $check=updateReportReviewStatus($stat,$ref_num,$inssum_compid);
    $is_release="is released.";      
    $hold="released";
   /*  $ref_num= selectInspectSummary("inssum_refnum",$inssum_id,$inssum_compid);
    $shipment_date= selectInspectSummary("inssum_dateship",$inssum_id,$inssum_compid);   */

    //$ref_num=selectReportReviewDetails("reference_num",$inssum_compid);
    $shipment_date=selectReportReviewDetails("inspection_date",$inssum_compid);
    $fac_email=selectReportReviewDetailsWithRef("factory_email",$inssum_compid,$ref_num);

    $contact_email= selectLogInDetails("email",$inssum_compid);  
    
    $comp_name=selectCompDetails("compName",$inssum_compid);
    $sendmail=sendMailToFactory($is_release,$shipment_date,$hold,$fac_email,$contact_email,$ref_num,$comp_name);
    if($check==true && $sendmail==true){      
        echo 'ok';
    }
}

if(isset($_POST['reject_inspection2'])){
    //$inssum_id=$_POST['inssum_id'];
    /* $inssum_compid=$_POST['inssum_compid'];
    $stat="Shipment Cancelled";
    $check=updateStatus($stat,$inssum_id,$inssum_compid);
    $is_release="is not released.";      
    $hold="hold";
    //$ref_num= selectInspectSummary("inssum_refnum",$inssum_id,$inssum_compid);
    //$shipment_date= selectInspectSummary("inssum_dateship",$inssum_id,$inssum_compid);  

    $ref_num=selectReportReviewDetails("reference_num",$inssum_compid);
    $shipment_date=selectReportReviewDetails("inspection_date",$inssum_compid);

    $contact_email= selectLogInDetails("email",$inssum_compid);  
    $fac_email=selectFacDetails("factory_email",$inssum_compid, $ref_num);
    $comp_name=selectCompDetails("compName",$inssum_compid);
    $sendmail=sendMailToFactory($is_release,$shipment_date,$hold,$fac_email,$contact_email,$ref_num,$comp_name);
    if($check==true && $sendmail==true){      
        echo 'ok';
    }
 */
    $inssum_compid=$_POST['inssum_compid'];
    $ref_num=$_POST['ref_num'];
    $stat=2;
    $check=updateReportReviewStatus($stat,$ref_num,$inssum_compid);
    $is_release="is not released.";      
    $hold="hold";
   /*  $ref_num= selectInspectSummary("inssum_refnum",$inssum_id,$inssum_compid);
    $shipment_date= selectInspectSummary("inssum_dateship",$inssum_id,$inssum_compid);   */

    //$ref_num=selectReportReviewDetails("reference_num",$inssum_compid);
    $shipment_date=selectReportReviewDetails("inspection_date",$inssum_compid);
    $fac_email=selectReportReviewDetailsWithRef("factory_email",$inssum_compid,$ref_num);

    $contact_email= selectLogInDetails("email",$inssum_compid);  
    
    $comp_name=selectCompDetails("compName",$inssum_compid);
    $sendmail=sendMailToFactory($is_release,$shipment_date,$hold,$fac_email,$contact_email,$ref_num,$comp_name);
    if($check==true && $sendmail==true){      
        echo 'ok';
    }
}

function updateStatus($status,$inssum_id,$inssum_compid){
    require "config.php";
    $stmt = $conn->prepare("UPDATE inspect_summary SET inssum_status=:inssum_status WHERE inssum_id=:inssum_id AND inssum_compid=:inssum_compid");
    $stmt->bindParam(':inssum_status',$status);
    $stmt->bindParam(':inssum_id',$inssum_id);
    $stmt->bindParam(':inssum_compid',$inssum_compid);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

function updateReportReviewStatus($status,$ref_num,$comp_id){
    require "config.php";
    $stmt = $conn->prepare("UPDATE reports_reviewer SET status=:status WHERE comp_id=:comp_id AND reference_num=:reference_num");
    $stmt->bindParam(':status',$status);
    $stmt->bindParam(':comp_id',$comp_id);
    $stmt->bindParam(':reference_num',$ref_num);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

function insertClientDetails($contact_email, $pass, $comp_name, $comp_email, $contact_name, $ref_num, $ins_date,$file_name,$file_path, $date_today, $fac_email){
    require "config.php";
    $hash = hash('sha256', $pass);
    $salt = createSalt();
    $act = rand(111111111,999999999);
    $new_pass = hash('sha256', $salt . $hash);
    $stat=1;
    $stmt = $conn->prepare("INSERT INTO login(email,password,salt,activ,stat) VALUES(:email,:password,:salt,:activ,:stat)");
    $stmt->bindParam(':email',$contact_email);
    $stmt->bindParam(':password',$new_pass);
    $stmt->bindParam(':salt',$salt);
    $stmt->bindParam(':activ',$act);
    $stmt->bindParam(':stat',$stat);
    $stmt->execute();
    $last_id=$conn->lastInsertId();

    $stmt_comp = $conn->prepare("INSERT INTO companydetails(compID,compName,compemail,contactName) VALUES(:compID,:compName,:compemail,:contactName)");
    $stmt_comp->bindParam(':compID',$last_id);
    $stmt_comp->bindParam(':compName',$comp_name);
    $stmt_comp->bindParam(':compemail',$comp_email);
    $stmt_comp->bindParam(':contactName',$contact_name);
    $stmt_comp->execute();
    insertInReportsReview($ref_num, $ins_date,$file_name,$file_path, $date_today, $last_id, $fac_email,"","");
   // insertInReportsReview($ref_num, $ins_date,$file_name,$file_path, $date_today, $compID, $fac_email)
    return true;
}

function createSalt()
{
  $text = md5(uniqid(rand(), TRUE));
  return substr($text, 0, 3);
}


function selectClientDetails(){
    require "config.php";
    $stmt = $conn->prepare("SELECT login.*,companydetails.* FROM login INNER JOIN companydetails ON login.id=companydetails.compID");
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function selectFacDetails($request,$inssum_compid, $factory_refnum){
    require "config.php";
    $stmt = $conn->prepare("SELECT * FROM factory WHERE factory_compid=:factory_compid AND factory_refnum=:factory_refnum");
    $stmt->bindParam(':factory_compid',$inssum_compid);
    $stmt->bindParam(':factory_refnum',$factory_refnum);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}


function selectFileReports($request,$id, $table){
    require "config.php";
    $stmt = $conn->prepare("SELECT * FROM $table WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}


function selectInspectSummary($request,$inssum_id,$inssum_compid){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from inspect_summary WHERE inssum_id=:inssum_id AND inssum_compid=:inssum_compid");
    $stmt->bindParam(':inssum_id',$inssum_id);
    $stmt->bindParam(':inssum_compid',$inssum_compid);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}

function selectLogInDetails($request,$inssum_compid){
    require "config.php";
    $stmt = $conn->prepare("SELECT *  FROM users WHERE id=:inssum_compid");
    $stmt->bindParam(':inssum_compid',$inssum_compid);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}

function selectCompDetails($request,$inssum_compid){
    require "config.php";
    $stmt = $conn->prepare("SELECT *  FROM companydetails WHERE compID=:inssum_compid");
    $stmt->bindParam(':inssum_compid',$inssum_compid);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}

function selectReportReviewDetails($request,$comp_id){
    require "config.php";
    $stmt = $conn->prepare("SELECT * FROM reports_reviewer WHERE comp_id=:comp_id");
    $stmt->bindParam(':comp_id',$comp_id);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}

function selectReportReviewDetailsWithRef($request,$comp_id,$ref_num){
    require "config.php";
    $stmt = $conn->prepare("SELECT * FROM reports_reviewer WHERE comp_id=:comp_id AND reference_num=:reference_num");
    $stmt->bindParam(':comp_id',$comp_id);
    $stmt->bindParam(':reference_num',$ref_num);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];
}

function selectClientInspection($clientid){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from gen_info WHERE gen_compid=:gen_compid");
    $stmt->bindParam(':gen_compid',$clientid);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function insertInUploads($gen_info_id, $gen_comp_id,$file_name,$file_path, $date_today){
    require "config.php";
    /* $user_id=$_SESSION['user_id']; */
    $user_id=1;
    $stmt=$conn->prepare("INSERT INTO reports_upload(user_id, gen_info_id, gen_comp_id, file_name, file_path, date_created) VALUES(:user_id, :gen_info_id, :gen_comp_id, :file_name, :file_path, :date_created)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':gen_info_id', $gen_info_id);
    $stmt->bindParam(':gen_comp_id', $gen_comp_id);
    $stmt->bindParam(':file_name', $file_name);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':date_created', $date_today);
    if($stmt->execute()){
        $last_id=$conn->lastInsertId();
        return $last_id;  
    }
}

function insertInReportsReview($ref_num, $ins_date,$file_name,$file_path, $date_today, $compID, $fac_email,$facname,$shipdate){
    require "config.php";
    $user_id=$_SESSION['user_id'];

    $stmt=$conn->prepare("INSERT INTO reports_reviewer(user_id, comp_id, file_name, file_path, reference_num, inspection_date, shipment_date, factory_name, factory_email, date_created) VALUES(:user_id, :comp_id, :file_name, :file_path, :reference_num, :inspection_date, :shipment_date, :factory_name, :factory_email, :date_created)");

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':comp_id', $compID);

    $stmt->bindParam(':file_name', $file_name);
    $stmt->bindParam(':file_path', $file_path);

    $stmt->bindParam(':reference_num', $ref_num);
    $stmt->bindParam(':inspection_date', $ins_date);

    $stmt->bindParam(':shipment_date', $shipdate);
    $stmt->bindParam(':factory_name', $facname);

    $stmt->bindParam(':factory_email', $fac_email);

    $stmt->bindParam(':date_created', $date_today);
    if($stmt->execute()){
        $last_id=$conn->lastInsertId();
        return $last_id;    
    }
}

function editReports($file_name,$file_path, $id){
    require "config.php";
    $stmt=$conn->prepare("UPDATE reports_upload SET file_name=:file_name, file_path=:file_path WHERE id=:id");
    $stmt->bindParam(':file_name', $file_name);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

function selectAllReports($gen_info_id, $gen_comp_id){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from reports_upload WHERE gen_info_id=:gen_info_id AND gen_comp_id=:gen_comp_id ORDER BY date_created DESC");
    $stmt->bindParam(':gen_info_id',$gen_info_id);
    $stmt->bindParam(':gen_comp_id',$gen_comp_id);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function selectAllReports2($comp_id){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from reports_reviewer WHERE comp_id=:comp_id");
    $stmt->bindParam(':comp_id',$comp_id);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function selectAllReportsNew2($comp_id,$ref_num){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from reports_reviewer WHERE comp_id=:comp_id AND reference_num=:reference_num");
    $stmt->bindParam(':comp_id',$comp_id);
    $stmt->bindParam(':reference_num',$ref_num);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function selectClientInspectionHardCoded($comp_id){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from reports_reviewer WHERE comp_id=:comp_id GROUP BY reference_num ORDER BY date_created DESC");
    $stmt->bindParam(':comp_id',$comp_id);
    $stmt->execute();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function selectReports($id,$request){
    require "config.php";
    $stmt = $conn->prepare("SELECT * from reports_upload WHERE id=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$request];

}
function deleteFile($id){
    require "config.php";
    $file_name=selectReports($id,"file_name");
    $file="../reports/$file_name";
    $stmt = $conn->prepare("DELETE FROM reports_upload WHERE id=:id");
    $stmt->bindParam(':id',$id);
    if($stmt->execute()){     
        unlink($file);
        return true;
    }else{
        return false;
    }
}

function unlinkFile($id){
    require "config.php";
    $file_name=selectReports($id,"file_name");
    $file="../reports/$file_name";
    if(unlink($file)){     
        return true;
    }else{
        return false;
    }
}

function sendMailToFactory($is_release,$shipment_date,$hold,$fac_email,$contact_email,$inspect_title,$comp_name){
    require '../vendor/autoload.php';
    require 'config.php';
    
    $ship_date=date("F d, Y",strtotime($shipment_date));

    $mail = new  PHPMailer\PHPMailer\PHPMailer(true);

	 //Server settings
	 $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	 //$mail->isSMTP();                                      // Set mailer to use SMTP
	 $mail->Host = 'smtp.1und1.de';  // Specify main and backup SMTP servers
	 $mail->SMTPAuth = true;                               // Enable SMTP authentication
	 $mail->Username = 'postmaster@the-inspection-company.com';                 // SMTP username
	 $mail->Password = '&';                           // SMTP password
	 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	 $mail->Port = 587;                                    // TCP port to connect to
	 //Recipients
	$mail->setFrom('postmaster@tic-sera.com', 'TIC-SERA'); 
    /* $mail->addAddress($fac_email); //factory email
    $mail->AddCC($contact_email); */
    $mail->addAddress($fac_email);
    $mail->AddCC($contact_email);
    $mail->AddCC('gregor@t-i-c.asia');
    $mail->AddCC("rommel@t-i-c.asia");
    /* $mail->AddCC("matias@slinkla.com");
    $mail->AddCC("Nancy@vtrekgroup.com"); */
    /* $mail->AddCC("jesser@t-i-c.asia");
    $mail->AddCC("manuel@t-i-c.asia"); */
   

    //$mail->AddCC('gregor@t-i-c.asia');
    /* $mail->AddCC('jesser@t-i-c.asia'); //cc contact email
	$mail->AddCC('manuel@t-i-c.asia');  */
	/* $mail->AddCC('gregor@t-i-c.asia'); */

	$mail->isHTML(true);
	$mail->Subject = "Shipment $hold";

	
	 $mail->Body = "<html> 
					<head>
					</head>
		<body style='width:650px; margin:0 auto; font-family:Verdana; background-color:white;'> 
	
        <br>
		<div style='width:100%; margin-top:2%; margin-left:auto; margin-right:auto; background-color:white; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;'>
			<div style='margin-left:auto; margin-right:auto; border-top:7px solid black; font-family:Copperplate Gothic Light;'>
				<h1 style='text-align:center; color:black'>TIC-SERA</h1>
				
				<hr>
			</div><br>
			<h3>Hi There, </h3>
            <br>
			<p style='font-size:14px;'>
			    The shipment with $inspect_title inspection from $ship_date $is_release
			    Please discuss further process with the $comp_name.
			</p>
			<br>

			<p style='font-size:14px;'>Regards,<br>
			TIC-SERA</p> <br>           
	</div><br><br>
	<div style='margin-left:auto; margin-right:auto; width:100%;'>
		<footer style='font-size:14px;'>
		
		</footer>
	</div>
	</body></html>
				";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
	} 
	else 
	{
		return true;
	}
}



function sendMailToClient($clientName,$clientEmail,$inspec_title){
    require 'vendor/autoload.php';
    /* require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php'; */
    require 'config.php';
    $mail = new  PHPMailer\PHPMailer\PHPMailer();

	 //Server settings
	 $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	 //$mail->isSMTP();                                      // Set mailer to use SMTP
	 $mail->Host = 'smtp.1und1.de';  // Specify main and backup SMTP servers
	 $mail->SMTPAuth = true;                               // Enable SMTP authentication
	 $mail->Username = 'postmaster@the-inspection-company.com';                 // SMTP username
	 $mail->Password = '&';                           // SMTP password
	 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	 $mail->Port = 587;                                    // TCP port to connect to
	 //Recipients
     $mail->setFrom('postmaster@tic-sera.com', 'TIC-SERA'); 
    $mail->addAddress($clientEmail); //factory email
    /* $mail->AddCC($contact_email); */
    $mail->AddCC('rommel@t-i-c.asia');
    /* $mail->AddCC('gregor@t-i-c.asia'); */
    $mail->AddCC('rommel.lacap07@gmail.com');
    /* $mail->AddCC('jesser@t-i-c.asia'); //cc contact email
	$mail->AddCC('manuel@t-i-c.asia');  */
	/* $mail->AddCC('gregor@t-i-c.asia'); */

	$mail->isHTML(true);
	$mail->Subject = "Inspection Report - $inspec_title";

	
	 $mail->Body = "<html> 
					<head>
					</head>
		<body style='width:650px; margin:0 auto; font-family:Verdana; background-color:white;'> 
	
        <br>
		<div style='width:100%; margin-top:2%; margin-left:auto; margin-right:auto; background-color:white; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;'>
			<div style='margin-left:auto; margin-right:auto; border-top:7px solid black; font-family:Copperplate Gothic Light;'>
				<h1 style='text-align:center; color:black'>TIC-SERA</h1>
				<hr>
			</div><br>
			<h3>Hi $clientName, </h3>
            <br>
			<p style='font-size:14px;'>
                The Inspection Report has been uploaded, you can now check it on our online booking using the link below. Please kindly also confirm your shipment.
                
            </p>
            <p> <a href='http://booking.tic-sera.com/index.php
            '>Click this link</a>
			<br>

			<p style='font-size:14px;'>Regards,<br>
			TIC-SERA</p> <br>           
	</div><br><br>
	<div style='margin-left:auto; margin-right:auto; width:100%;'>
		<footer style='font-size:14px;'>
			
		</footer>
	</div>
	</body></html>
				";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
	} 
	else 
	{
		return true;
	}
}

function sendMailToClientMultiple($clientName,$recipients,$inspec_title,$clientEMAIL,$recipientsCC,$insdate,$shipdate,$factory,$id,$tbl){
    //require 'vendor/autoload.php';
    require 'vendor/autoload.php';
    require 'config.php';

    $mail = new  PHPMailer\PHPMailer\PHPMailer(true);

	 //Server settings
	 $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	 //$mail->isSMTP();                                      // Set mailer to use SMTP
	 $mail->Host = 'smtp.1und1.de';  // Specify main and backup SMTP servers
	 $mail->SMTPAuth = true;                               // Enable SMTP authentication
	 $mail->Username = 'postmaster@the-inspection-company.com';                 // SMTP username
	 $mail->Password = '&';                           // SMTP password
	 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	 $mail->Port = 587;                                    // TCP port to connect to
	 //Recipients
     $mail->setFrom('postmaster@tic-sera.com', 'TIC-SERA'); 
    $mail->addAddress($clientEMAIL);
    $exploded_recipient = explode(",", $recipients);
    foreach($exploded_recipient as $recipient){
        $mail->addAddress($recipient);
    }

    $exploded_recipient_cc = explode(",", $recipientsCC);
    foreach($exploded_recipient_cc as $recipient_cc){
        $mail->AddCC($recipient_cc);
    }
    $c_ins_date=date('F d, Y', strtotime($insdate));
    /* $c_shipdate=date('F d, Y', strtotime($shipdate)); */
     
    $mail->AddCC('rommel@t-i-c.asia');
    $mail->AddCC('gregor@t-i-c.asia');



	$mail->isHTML(true);
	$mail->Subject = "Inspection Report - $inspec_title";

	
	 $mail->Body = "<html> 
					<head>
					</head>
		<body style='width:650px; margin:0 auto; font-family:Verdana; background-color:white;'> 
	
        <br>
		<div style='width:100%; margin-top:2%; margin-left:auto; margin-right:auto; background-color:white; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;'>
			<div style='margin-left:auto; margin-right:auto; border-top:7px solid black; font-family:Copperplate Gothic Light;'>
				<h1 style='text-align:center; color:black'>TIC-SERA</h1>
				<hr>
			</div><br>
			<h3>Hi $clientName, </h3>
            <br>
			<p style='font-size:14px;'>
                The Inspection Report has been uploaded, you can now check it on our online booking using the link below. Please kindly also confirm your shipment.
            </p>  
            <ul>
                <li> Reference Number : $inspec_title</li>
                <li> Factory : $factory </li>
                <li> Inspection Date : $c_ins_date</li>

            </ul>
                
             <a href='http://booking.tic-sera.com/index.php'>Site link</a> | <a href='http://booking.tic-sera.com/report_reviewer/download-report.php?id=$id&tbl=$tbl'>Download Report</a>
			<br>

			<p style='font-size:14px;'>Regards,<br>
			TIC-SERA</p> <br>           
	</div><br><br>
	<div style='margin-left:auto; margin-right:auto; width:100%;'>
		<footer style='font-size:14px;'>
			
		</footer>
	</div>
	</body></html>
				";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
	} 
	else 
	{
		return true;
	}
}

function sendMailToClientHardCoded($recipients,$inspec_title,$recipientsCC,$insdate,$shipdate,$facname,$id,$tbl,$client_email){
    //require 'vendor/autoload.php';
    require 'vendor/autoload.php';
    require 'config.php';

    $c_ins_date=date('F d, Y', strtotime($insdate));
    /* $c_shipdate=date('F d, Y', strtotime($shipdate)); */


    $mail = new  PHPMailer\PHPMailer\PHPMailer(true);

	 //Server settings
	 $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	 //$mail->isSMTP();                                      // Set mailer to use SMTP
	 $mail->Host = 'smtp.1und1.de';  // Specify main and backup SMTP servers
	 $mail->SMTPAuth = true;                               // Enable SMTP authentication
	 $mail->Username = 'postmaster@the-inspection-company.com';                 // SMTP username
	 $mail->Password = '&';                           // SMTP password
	 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	 $mail->Port = 587;                                    // TCP port to connect to
	 //Recipients
     $mail->setFrom('postmaster@tic-sera.com', 'TIC-SERA'); 
     $mail->addAddress($client_email);
     if($recipients!=""){
        $exploded_recipient = explode(",", $recipients);
        foreach($exploded_recipient as $recipient){
            $mail->addAddress($recipient);
        }
     }
    

    $exploded_recipient_cc = explode(",", $recipientsCC);
    foreach($exploded_recipient_cc as $recipient_cc){
        $mail->AddCC($recipient_cc);
    }
     
    $mail->AddCC('rommel@t-i-c.asia');
    $mail->AddCC('gregor@t-i-c.asia');



	$mail->isHTML(true);
	$mail->Subject = "Inspection Report - $inspec_title";

	
	 $mail->Body = "<html> 
					<head>
					</head>
		<body style='width:650px; margin:0 auto; font-family:Verdana; background-color:white;'> 
	
        <br>
		<div style='width:100%; margin-top:2%; margin-left:auto; margin-right:auto; background-color:white; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;'>
			<div style='margin-left:auto; margin-right:auto; border-top:7px solid black; font-family:Copperplate Gothic Light;'>
				<h1 style='text-align:center; color:black'>TIC-SERA</h1>
				<hr>
			</div><br>
			<h3>Hi there, </h3>
            <br>
			<p style='font-size:14px;'>
                The Inspection Report has been uploaded, you can now check it on our online booking using the link below. Please kindly also confirm your shipment.               
            </p>
            <ul>
                <li> Reference Number : $inspec_title</li>
                <li> Factory : $facname</li>
                <li> Inspection Date : $c_ins_date</li>
            </ul>
            <p> <a href='http://booking.tic-sera.com/index.php'>Click this link</a> | <a href='http://booking.tic-sera.com/report_reviewer/download-report.php?id=$id&tbl=$tbl'>Download Report</a>
			<br>

			<p style='font-size:14px;'>Regards,<br>
			TIC-SERA</p> <br>           
	</div><br><br>
	<div style='margin-left:auto; margin-right:auto; width:100%;'>
		<footer style='font-size:14px;'>
			
		</footer>
	</div>
	</body></html>
				";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
        //echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
	} 
	else 
	{
		return true;
	}
}


function sendMailToNotRegisteredClientHardCoded($recipients,$inspec_title,$recipientsCC,$insdate,$shipdate,$facname,$id){
    //require 'vendor/autoload.php';
    require 'vendor/autoload.php';
    require 'config.php';


    $c_ins_date=date('F d, Y', strtotime($insdate));
    /* $c_shipdate=date('F d, Y', strtotime($shipdate)); */


    $mail = new  PHPMailer\PHPMailer\PHPMailer(true);

	 //Server settings
	 $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	 //$mail->isSMTP();                                      // Set mailer to use SMTP
	 $mail->Host = 'smtp.1und1.de';  // Specify main and backup SMTP servers
	 $mail->SMTPAuth = true;                               // Enable SMTP authentication
	 $mail->Username = 'postmaster@the-inspection-company.com';                 // SMTP username
	 $mail->Password = '&';                           // SMTP password
	 $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	 $mail->Port = 587;                                    // TCP port to connect to
	 //Recipients
     $mail->setFrom('postmaster@tic-sera.com', 'TIC-SERA'); 
    $exploded_recipient = explode(",", $recipients);
    foreach($exploded_recipient as $recipient){
        $mail->addAddress($recipient);
    }

    $exploded_recipient_cc = explode(",", $recipientsCC);
    foreach($exploded_recipient_cc as $recipient_cc){
        $mail->AddCC($recipient_cc);
    }
     
    $mail->AddCC('rommel@t-i-c.asia');
    $mail->AddCC('gregor@t-i-c.asia');



	$mail->isHTML(true);
	$mail->Subject = "Inspection Report - $inspec_title";

	
	 $mail->Body = "<html> 
					<head>
					</head>
		<body style='width:650px; margin:0 auto; font-family:Verdana; background-color:white;'> 
	
        <br>
		<div style='width:100%; margin-top:2%; margin-left:auto; margin-right:auto; background-color:white; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;'>
			<div style='margin-left:auto; margin-right:auto; border-top:7px solid black; font-family:Copperplate Gothic Light;'>
				<h1 style='text-align:center; color:black'>TIC-SERA</h1>
				<hr>
			</div><br>
			<h3>Hi there, </h3>

			<p style='font-size:14px;'>
                The Inspection Report has been uploaded, please register on our online booking site for your future inspection to manage your booking, shipment and download your inspection report.             
            </p>
            <ul>
                <li> Reference Number : $inspec_title</li>
                <li> Factory : $facname</li>
                <li> Inspection Date : $c_ins_date</li>
            </ul>
            <p> <a href='http://booking.tic-sera.com/register.php'>Click this link to register</a> | <a href='http://booking.tic-sera.com/report_reviewer/download-report.php?id=$id&tbl=reports_reviewer'>Download Report</a>
			<br>

			<p style='font-size:14px;'>Regards,<br>
			TIC-SERA</p> <br>           
	</div><br><br>
	<div style='margin-left:auto; margin-right:auto; width:100%;'>
		<footer style='font-size:14px;'>
			
		</footer>
	</div>
	</body></html>
				";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
	} 
	else 
	{
		return true;
	}
}
?>