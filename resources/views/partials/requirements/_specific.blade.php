<div class="col-md-12">
<p class="questions">Product Specific Requirements?</p>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{{Form::label('temperature_test','Tempereture Test',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('temperature_test', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('humidity_test','Humidity Test',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('humidity_test', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				{{Form::label('temp_rise_test','Temperature rise measure test:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('temp_rise_test', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('noise_test','Noise Test',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('noise_test', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{{Form::label('special_requirements','Special requirement for these?',['class'=>'control-label col-sm-5'])}}
				<div class="col-sm-5">
					{{ Form::text('special_requirements',null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>
	</div>
<hr>
</div>

