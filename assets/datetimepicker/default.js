$(function() {
	$( ".date" ).datetimepicker({
		format: 'yyyy-MM-dd',
		pickTime: false
	});
	$( ".time" ).datetimepicker({
		format: 'hh:mm:ss',
		pickDate: false
	});
	$( ".datetime" ).datetimepicker({
		format: 'yyyy-MM-dd hh:mm:ss',
	});
});
