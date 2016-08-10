$(document).ready(function() {

	$('#spin_kuesioner').hide();

	$('#slc_survey').change(function(){
		if ($(this).val()!=0){
			$('#spin_kuesioner').show();
			$.ajax({
				url: "http://10.10.55.25/ges/index.php/result/ajax_kuesioner",
				data: {survey_type: $(this).val()},
				type: "post",
				success: function(msg){
					$("#slc_kuesioner").html(msg);
					$('#spin_kuesioner').hide();
				}
			});
		}else{
			$("#slc_kuesioner").empty();
		}
	});
});