<div class="col-md-12">
<p class="questions">Do you want us to continue if we face following conditions in the factory?</p>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{{Form::label('no_key_component','No key component list available:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('no_key_component', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('no_serial_number','No serial No. on the product:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('no_serial_number', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('no_rating_label','No rating label:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('no_rating_label', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('no_removable_sticker_product','No removable sticker on Product:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('no_removable_sticker_product', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('missing_logo_product','Missing logo on product:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('missing_logo_product', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{{Form::label('no_removable_sticker_carton','No removable sticker on carton:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('no_removable_sticker_carton', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('no_imp_exp_info','Packaging label does not contain imp/exp info:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('no_imp_exp_info', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('packing_not_finished','Packing is not finished by 80%:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('packing_not_finished', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('production_not_finished','Production is Not Finished by 100%:',['class'=>'control-label col-sm-9'])}}
				<div class="col-sm-3">
					{{ Form::select('production_not_finished', ['0'=>'No','1'=>'Yes'], null, ['class' => 'disabled form-control choice']) }}
				</div>
			</div>

		</div>
	</div>
	<div class="row">
		<div class="col-md-10">
			<div class="form-group">
				{{Form::label('report_requirement','Report Requirement:',['class'=>'control-label col-sm-3'])}}
				<div class="col-sm-3">
					{{ Form::select('report_requirement_1', ['CE'=>'CE','CCC'=>'CCC','GS'=>'GS','ROHS'=>'ROHS','FCC'=>'FCC','PCT'=>'PCT'], null, ['class' => 'disabled form-control report_requirement']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('report_requirement_2', ['CE'=>'CE','CCC'=>'CCC','GS'=>'GS','ROHS'=>'ROHS','FCC'=>'FCC','PCT'=>'PCT'], null, ['class' => 'disabled form-control report_requirement']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('report_requirement_3', ['CE'=>'CE','CCC'=>'CCC','GS'=>'GS','ROHS'=>'ROHS','FCC'=>'FCC','PCT'=>'PCT'], null, ['class' => 'disabled form-control report_requirement']) }}
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>

