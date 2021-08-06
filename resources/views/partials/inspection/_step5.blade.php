<div class="row step5">
	<h3>Booking Summary</h3>
<hr>
<section>
<div class="col-md-10">
	<table class="table table-bordered table-hover" id="summary-table">
		<tr class="info">
			<th colspan="5" class="text-center">Inspection Booking Summary</th>
		</tr>
		<tr>
			<th>Service Type</th>
			<td colspan="4" id="summary_service_type"></td>
		</tr>
		<tr>
			<th>Inspection Date</th>
			<td colspan="4" id="summary_inspection_date"></td>
		</tr>
		<tr class="info">
			<th colspan="5" class="text-center">Inspection Requirements</th>
		</tr>
		<tr>
			<th>Product</th>
			<th>PO Quantity</th>
			<th>Visual</th>
			<th>Functional</th>
			<th>Man/Day</th>
		</tr>
	</table>
</div>

</section>
<div class="col-md-12">
    <div class="col-md-6">
        <button class="btn btn-primary" id="fourth-back" type="button">Previous</button>
    </div>
    <div class="col-md-6 text-right">
    	<input type="hidden" name="manday" id="manday">
        <button class="btn btn-success" id="confirm_booking_btn" type="submit">Confirm Booking</button>
    </div>
</div>
</div>