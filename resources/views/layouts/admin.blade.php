<!DOCTYPE html>
<html lang="en">
<head>
	@include('partials._head')
	{!! Html::style('/css/admin/admin.css') !!}
</head>
	<body>
		<div class="">
			@if(Request::path() != '/')
				{{-- @include('partials._navadmin') --}}
			@endif
			
			
			@if(Request::path() != '/')
				<div class="">
					{{-- @include('partials.admin._sidemenu') --}}
				</div>
				<div class="" id="content-wrapper">

					@yield('content')			
				</div>
			@else
			<div class="row">
				<div class="col-md-12">
					@yield('content')			
				</div>
			</div>
			@endif
			

		</div>
		@include('partials._js')
		@yield('scripts')
	</body>
</html>
