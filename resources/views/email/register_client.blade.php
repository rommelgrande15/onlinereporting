<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<style type="text/css">
		body {
			font-family: Arial;
		}

		a {
			text-decoration: none;
		}

		.orange-text {
			color: #f37934 !important;
		}

		.orange-background {
			background: #f37934 !important;
			color: #fff !important;
			padding: 1px 25px;
			border: 1px solid #d5d5d5;

		}

		.tic-logo {
			margin-bottom: 25px;
		}

		.img-logo {
			max-width: 400px;
			margin: auto;
		}

		.signature {
			font-weight: bold;
		}

		.signature-logo {
			max-width: 250px;
		}

		.text-center {
			text-align: center;
		}

		.link-btn {
			padding: 10px;
			background: #3cb5d0;
			color: #fff !important;
			text-decoration: none;
			border-radius: 5px;
			border: 1px solid #3cb5d0;
		}

		.panel-body {
			border: 1px solid #d5d5d5;
			padding: 25px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading orange-background text-center" style="border-radius: 10px 10px 0px 0px;"></div>
				<div class="panel-body">
					<table style="width: 60%; margin: auto; border-collapse: collapse; border: 0; font-family: arial;">
						<tr style="background:#ffa500; height: 100px;">
							<td width="30%" style="text-align: center; vertical-align: middle;"><img src="http://www.the-inspection-company.com/htm_files/tic.png" alt="tic" style="width: 80%" /></td>
							<td style="text-align: left; vertical-align: middle; color: #fff; padding: 0">
								<h1>The Inspection Company Ltd.</h1>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="padding: 20px; background-color: #ededed;">
								<p>Dear {{ $user_gender }} {{ $full_name }},</p><br />
								<p> Thank you for registering with our online booking! Our team is now checking and evaluating your account, you will received an email response soon once your account has been approved / activated.
								</p>
									<br>
									<p>
										Thanks and Best Regards,<br>
										TIC Team
									</p><br><br>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
