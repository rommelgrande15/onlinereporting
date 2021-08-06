$(document).ready(function(){
	var dateToday = new Date();
	$('#inspection_date').datepicker({
		dateFormat : 'yy-mm-dd',
		minDate: dateToday,
	});

	$('#aql_btn').click(function(){
		$('#aqlModal').modal({
			backdrop: 'static',
			keyboard: false
		});
	})
})