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
					@php
						$logo_link='http://www.the-inspection-company.com/htm_files/tic.png';
						$company_header='The Inspection Company Ltd.';
						$ch_align='left';
						$db_link='https://tic-service.company';
						$bg_color='#ffa500';
						$company_code = 'TIC';
					@endphp
					@if($user_type)
						@if($user_type=='tic_sera')
							@php
								$logo_link='http://tic-service.company/images/ticsera-logo.png';
								$company_header='TIC-SERA';
								$ch_align='center';
								$bg_color='#dd4b39';
								$db_link='https://tic-service.company/tic-sera-login';
								$company_code = 'TIC';
							@endphp
						@endif
					@endif
					<table style="width: 60%; margin: auto; border-collapse: collapse; border: 0; font-family: arial;">
						<tr style="background:{{$bg_color}}; height: 100px;">
							<td width="30%" style="text-align: center; vertical-align: middle;"><img src="{{$logo_link}}" alt="tic" style="width: 80%" /></td>
							<td style="text-align: {{$ch_align}}; vertical-align: middle; color: #fff; padding: 0">
								<h1>{{$company_header}}</h1>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="padding: 20px; background-color: #ededed;">
								<p>Dear {{ $user_gender }} {{ $full_name }},</p><br />
								<p> Greetings! Your account has now activated. You may now login to our online booking through this <a href="{{ $db_link}}">link</a>.
									
									<br>
									<p>
										Thanks and Best Regards,<br>
										{{ $company_code }} Team
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
