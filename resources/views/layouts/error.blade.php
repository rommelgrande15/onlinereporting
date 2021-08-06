<!DOCTYPE html>
<html lang="en">
<head>@include('partials._head')</head>
	<body>
		<div class="container-fluid">
			@yield('content')
		</div>
		@include('partials._js')
		@yield('scripts')
	</body>
</html>
