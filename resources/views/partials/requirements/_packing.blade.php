<div class="col-md-12">
<p class="questions">Special Packing Instructions</p>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{{ Form::textarea('instructions', null, ['class' => 'disabled form-control','rows'=>'5']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				{{Form::label('blister_packing','Blister Packing',['class'=>'control-label col-sm-7'])}}
				<div class="col-sm-5">
					{{ Form::select('blister_packing', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{{Form::label('carton_packing','Carton Packing',['class'=>'control-label col-sm-7'])}}
				<div class="col-sm-5">
					{{ Form::select('carton_packing', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{{Form::label('tape','Tape',['class'=>'control-label col-sm-7'])}}
				<div class="col-sm-5">
					{{ Form::select('tape', ['PVC'=>'PVC','Fibre Tape'=>'Fibre Tape','PET'=>'PET','PT'=>'PT'], null, ['class' => 'disabled form-control tape']) }}
				</div>
			</div>
		</div>	
	</div>
<hr>
</div>

