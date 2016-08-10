function unique(list) {
	var result = [];
	$.each(list, function(i, e) {
		if ($.inArray(e, result) == -1) result.push(e);
	});
	return result;
}
$(document).ready(function(){
	// $('input[type="submit"]').attr('disabled', 'disabled');
	var myArray1 = new Array();
	myArray1 =$( "*[data-group]" ).map(function() {
		if ($( this ).data('type')=='max'){
			return $( this ).data('group');
		}
	})
	.get();
	myArray2 = unique(myArray1);

	jQuery.each(myArray2, function(index, val) {

		var max;
		var min;
		min = $('*[data-group="'+val+'"][data-type="min"]').val();
		max = $('*[data-group="'+val+'"][data-type="max"]').val();
		$("input[type=checkbox]").on('change',function(){
			if($('*[data-group="'+val+'"]:checked').length > max){
				 $(this).prop('checked', false);
			}
		});
	});


});
