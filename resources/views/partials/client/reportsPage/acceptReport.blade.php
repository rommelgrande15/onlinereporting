<div id="approveReport" class="modal fade" role="dialog">
	<div class="modal-dialog modal-xs">

		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate='' id="invoice_form">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Accept Report</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Reference #:</label>
								<input type="text" class="form-control" id="ref_no_accept" required readonly>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Comments / Suggestion:</label>
								<textarea class="form-control" rows="4" name="accept_comments" cols="50" id="accept_comments"></textarea>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<input type="hidden" id="inspection_id" required>
							<button type="button" class="btn btn-block btn-default" data-dismiss="modal">Cancel</button>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::button('<i class="fa fa-check"></i> Accept', ['type'=>'button','class' => 'btn btn-block btn-success','id'=>'btn-approve-report']) !!}
						</div>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {

		var token = "{{csrf_token()}}";

		$('.btn_select_approve').click(function() {
			var dis = $(this);
			var inspection_id = $(dis).data('id');
			var ref_no = $(dis).data('ref_no');
			$.ajax({
				url: '/get-client-report/' + $(this).data('id'),
				type: 'GET',
				dataType: 'json',
				success: function(response) {
					$('#inspection_id').val(inspection_id);
					$('#ref_no_accept').val(ref_no);
					$('#approveReport').modal('show');
				},
				error: function(err) {
					console.log(err);
				}
			})

		});
		
		$('#btn-approve-report').click(function() {
			$.ajax({
				url: '/approve-reject-Report',
				type: 'POST',
				data: {
					_token: token,
					'inspection_id': $('#inspection_id').val(),
					'comments': $('#accept_comments').val(),
					'status': 1
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					//console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Report's Accepter",
						type: "success",
					}, function() {
						$('#approve_rejectReport').modal('hide');
						location.reload();
					});
				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
				}
			});
		});

	});

</script>
