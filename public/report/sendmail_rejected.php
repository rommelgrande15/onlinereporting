
<?php
	require 'vendor/autoload.php';
	require 'controller/controller.php';
	
	if(isset($_GET['id']) && isset($_GET['comp_id'])){

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
	$mail->setFrom('postmaster@the-inspection-company.com', 'TIC-SERA'); 
    $mail->addAddress('rommel@t-i-c.asia'); //factory email
    $mail->AddCC('jesser@t-i-c.asia'); //cc
	$mail->AddCC('manuel@t-i-c.asia'); 
	/* $mail->AddCC('gregor@t-i-c.asia'); */

	$mail->isHTML(true);
	$mail->Subject = "Shipment hold";

	
	 $mail->Body = "<html> 
					<head>
					</head>
		<body style='width:650px; margin:0 auto; font-family:Verdana; background-color:white;'> 
	
        <br>
		<div style='width:100%; margin-top:2%; margin-left:auto; margin-right:auto; background-color:white; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px;'>
			<div style='margin-left:auto; margin-right:auto; border-top:7px solid black; font-family:Copperplate Gothic Light;'>
				<h1 style='text-align:center; color:black'>TIC-SERA</h1>
				<h3 style='text-align:center;'>The Inspection Company</h3>
				<hr>
			</div><br>
			<h3>Hi There, </h3>

			<p>
			The shipment with inspection from ..... is not released / is released.
			Please discuss further profess with our client.
			</p>
			<br>

			<p style='font-size:14px;'>Regards,<br>
			TIC-SERA</p> <br>           
	</div><br><br>
	<div style='margin-left:auto; margin-right:auto; width:100%;'>
		<footer style='font-size:14px;'>
			<p style='font-size:14px;'>
				Copyright (C) 2018 TIC-SERA, All Rights Reserved<br>
				3rd flr. PCG Bldg., Bgy. H.Concepcion Maharlika Highway, Cabanatuan City, N.E., Philippines
			</p>
		</footer>
	</div>
	</body></html>
				";
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
		echo"<script>alert('Inspection successfully rejected');</script>";
		echo"<script>window.location.href='../mybookings.php';</script>";
	}
}
?>