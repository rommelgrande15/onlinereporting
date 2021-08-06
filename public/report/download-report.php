<?php

include 'controller/controller.php';
/* if(isset($_REQUEST["file"])){
    // Get parameters
    $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
    $filepath = "images/" . $file;
    
    // Process download
    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
    }
} */

if(isset($_REQUEST["file"])){
    // Get parameters
   $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
    $filepath = "reports/" . $file;
    
    // Process download

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
}
$id=$_GET['id'];
$table=$_GET['tbl'];
$file_path=selectFileReports("file_path",$id,$table);
$file_name=selectFileReports("file_name",$id,$table);
?>
<html>
    <head>
        <title>Download Report</title>
        <link rel="icon" type="image/png" href="assets/img/ticseralogo.png">
    </head>
    <body>
        <div align="center">
            <img src="assets/img/ticseralogo.png"  style="margin-left: auto; margin-right: auto;"></img>
            <br><br><br><br><br><br><br><br><br><br><br>
            <a href="<?= $file_path; ?>" download="<?= $file_name; ?>" style="border:1px solid #e91e63; padding:10px 40px; background:#e91e63; text-decoration:none; color:white; font-size:20px; border-radius:5px; width:650px;">Download Report</a>
        </div>
        
    </body>
</html>