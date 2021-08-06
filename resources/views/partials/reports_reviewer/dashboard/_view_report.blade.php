<div id="modalViewReport" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center">Uploaded Report</h4>

			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6"><label>Reference #:</label> <span id="ref_nu"></span></div>
					<div class="col-md-6 pull-right" id="download_button"></div>
				</div>
				<br>
				<table id='reports_table' class='table table-condensed cell-border small dataTable no-footer display'>
					<thead>
						<tr>
							<th class='text-left'>Report File</th>
							<th class='text-left'>Size</th>
							<th class='text-left'>Uploaded By</th>
							<th class='text-left'>Status</th>
							<th class='text-left'>Date</th>
							<th class='text-left'>Download</th>
						</tr>
					</thead>
					<tbody id="table_report_content">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
