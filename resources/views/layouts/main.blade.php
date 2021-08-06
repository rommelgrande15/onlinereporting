<!DOCTYPE html>
<html lang="en">
<head>@include('partials._head')</head>
	<body>
		@if(Request::path() != '/')
			@include('partials._nav')
		@endif
		<div class="container-fluid">
			@include('partials._messages')
			@yield('content')
		</div>
		@include('partials._js')
		@yield('scripts')
		@if(Request::path() != '/')
			@include('partials._footer')
		@endif
		
	</body>
</html>
