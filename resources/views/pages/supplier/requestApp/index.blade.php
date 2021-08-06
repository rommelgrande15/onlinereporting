@extends('layouts.supplier._new')
@section('title','New Order')
@section('page-title','New Order')
@section('stylesheets')
{!! Html::style('/css/admin/dashboard.css') !!}
{!! Html::style('/css/admin/project.css') !!}
<style>
	.fa-loader {
		-webkit-animation: spin 2s linear infinite;
		-moz-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}

	@-moz-keyframes spin {
		100% {
			-moz-transform: rotate(360deg);
		}
	}

	@-webkit-keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
		}
	}

	@keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	.content-header h1 {
		border-bottom: 3px solid orange;
		width: 20%;
		text-align: center;
		margin: 0 auto;
	}

</style>
@endsection

@section('content')

<div class="row">
	<div class="col-md-offset-3 col-md-6">
		<form method="POST" action="/request-app/submit">
			{!!csrf_field()!!}
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="username">Name</label>
						<input type="text" class="form-control" id="username" name="name" autocomplete="off" autofocus required>
					</div>
				</div>
				<div class="col-md-12">

					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control" name="email" id="email" autocomplete="off" required>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-success pull-right"><i class="fa fa-paper-plane"></i> Send Request</button>
		</form>
	</div>
</div>
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
<script>
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});

</script>
@if(Session::has('status'))
<script>
	swal({
		title: 'Success!',
		text: "{{Session::get('status')}}",
		timer: 2000,
		type: 'success'
	}).then((value) => {
		location.reload();
	}).catch(swal.noop);

</script>
@endif
@endsection
