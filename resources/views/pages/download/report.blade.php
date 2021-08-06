@extends('layouts.wide')
@section('title','Download Report')
@section('stylesheets')
  <link type="text/css" rel="stylesheet" href="{{ asset('/css/pace.css') }}">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">
			<img src="{{URL::asset('/images/tic.png')}}" class="img-responsive">
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-5 text-center" style="height: 205px">
			<div class="pace">
				<div class="pace-activity"></div>
				<div class="pace-progress" data-progress-text="0%"></div>
			</div>
			<small>Generating report... please standby..</small>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-5 text-center">
			<a href="" class="btn btn-warning btn-block btn-lg" disabled>Download Report </a> <br><br>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
        $(document).ready(function(){
            $.ajax({
                url: '/getreport/{{ $id }}',
                cache: false,
                contentType: false,
                processData: false,
                type: 'GET',
                dataType: "text",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(jqXHR, settings) {
                    var self = this;
                    var xhr = settings.xhr;
                    settings.xhr = function() {
                        var output = xhr();
                        output.onreadystatechange = function() {
                            if (typeof(self.readyStateChanged) == "function") {
                                self.readyStateChanged(this);
                            }
                        };
                        return output;
                    };
                },
                readyStateChanged: function(jqXHR) {
                    if (jqXHR.readyState == 3) {
                        if(jqXHR.responseText.split(",")[jqXHR.responseText.split(",").length-2] !== undefined)
                        	$('.pace-progress').attr('data-progress-text', jqXHR.responseText.split(",")[jqXHR.responseText.split(",").length-2] + '%');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                success: function(data, status, jqXHR){
					var id = '{{ $id }}';
                    $('.pace').hide();
                    $('small').hide();
                    $('a').attr('href', '/' + id.toUpperCase() + '.doc').removeAttr('disabled');
                }
            });
		})
	</script>
@endsection


