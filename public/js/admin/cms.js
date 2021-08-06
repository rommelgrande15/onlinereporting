$(document).ready(function(){
	$('#languages_table').DataTable();
	$('#pages_table').DataTable();
	$('#sections_table').DataTable();
	$('#lang_country').on('change',function(){
		$('#short_name').val($(this).val());
	})
});