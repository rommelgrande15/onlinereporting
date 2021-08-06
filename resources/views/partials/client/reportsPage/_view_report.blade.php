<div id="modalViewReport" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Uploaded Reports</h4>

			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6"><label>Reference #:</label> <span id="ref_nu"></span></div>
					<div class="col-md-6 pull-right" id="download_button"></div>
				</div>
				<div id="uploads_table_content"></div>
				<!--<table id='uploads_table' class='table table-condensed cell-border small dataTable no-footer display'>
					<thead>
						<tr>
							<th class='text-left'>Report File</th>
							<th class='text-left'>Size</th>
							<th class='text-left'>Uploaded By</th>
							<th class='text-left'>Date</th>
							<th class='text-left'>Action</th>
						</tr>
					</thead>
					<tbody id="uploads_table_content">
					</tbody>
				</table>-->
			</div>
		</div>
	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		var token = "{{csrf_token()}}";
		$('.btn_view').click(function() {
			console.log('Btn view clicked');
			var table = $("#uploads_table_content");
			var tableString = "";
			table.empty();
			var dis = this;
			var id = $(dis).data('id');
			var ref_no = $(dis).data('ref_no');

			$.ajax({
				url: "/view-uploaded-report",
				method: "POST",
				data: {
					id: id,
					_token: token
				},
				success: function(data) {
					if (data == "") {
						swal({
							position: 'top-end',
							type: 'error',
							title: 'No file/s found.',
							showConfirmButton: true,
							timer: 1000
						});
					} else {
						$('#ref_nu').html(ref_no);
						//$('#download_button').html("<a href='/download-report-file/" + id + "' class='btn btn-sm btn-primary pull-right' download><i class='fa fa-download'></i> Download</a>");
						tableString += "<table id='reports_table' class='table table-condensed cell-border small dataTable no-footer'><thead><tr><th class='text-center'>Report File</th><th class='text-center'>Size</th><th class='text-center'>Reviewer</th><th class='text-center'>Status</th><th class='text-center'>Date</th><th class='text-center'>Download</th></tr></thead><tbody>";
						$.each(data, function(a, b) {
							function humanFileSize(size) {
								var i = size == 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
								return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'KB', 'MB', 'GB', 'TB'][i];
							};
							tableString += "<tr>" +
								"<td>" + b.report_file + "</td>" +
								"<td>" + humanFileSize(b.report_file_size) + "</td>" +
								"<td>" + b.name + "</td>" +
								"<td>" + b.report_status + "</td>" +
								"<td>" + b.created_at + "</td>" +
								"<td class='text-center'><a href='/download-report-file/" + b.inspection_id + "/" + b.report_file + "' class='btn btn-block btn-xs btn-primary' download><i class='fa fa-download'></i></a></td></tr>";
						});
						tableString += "</tbody></table>";
						table.append(tableString);
						$('#modalViewReport').modal("show");
					}
				},
			});

		});
	});

</script>
