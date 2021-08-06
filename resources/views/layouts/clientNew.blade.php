<!DOCTYPE html>
<html>

<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

<head>
	@include('new-partials._head')
	@yield('stylesheets')
</head>

<body class="hold-transition skin-blue sidebar-mini fixed skin-yellow">
	<div class="wrapper">

		@include('new-partials._clienTopbar')

		@include('new-partials._clientleftbar')

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>@yield('page-title')</h1>
			</section>

			<!-- Main content -->
			<section class="content">

				@yield('content')

			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->


		@include('new-partials._footer')
		@include('new-partials._rightbar')
		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->


	@include('new-partials._js')


	@yield('scripts')
</body>

</html>
