<div class="col-md-12">
<p class="questions">Special Requirements?</p>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{{Form::label('double_sampling','Double Sampling:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('double_sampling', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('seal_every_product','Seal on every product:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('seal_every_product', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('seal_opened_carton','Seal on every opened carton',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('seal_opened_carton', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				{{Form::label('seal_on_whole_quantity','Seal on whole quantity',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('seal_on_whole_quantity', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('tic_own_report','InspectOne Report or Own Report',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('tic_own_report', ['TIC'=>'InspectOne','Own'=>'Own'], null, ['class' => 'disabled form-control report']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('tic_chop','InspectOne Chop on Export Carton:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('tic_chop', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>

</div>
<hr>
</div>

