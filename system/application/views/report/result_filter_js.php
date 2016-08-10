<script type="text/javascript">
$(document).ready(function() {
	var base_url = "<?php echo base_url() ?>";
	$('#spin_kuesioner').hide();
	$('#spin_unit').hide();
	$('#spin_div').hide();

	$('#slc_survey').change(function(){
		if ($(this).val()!=0){
			$('#spin_kuesioner').show();
			$.ajax({
				url: base_url + "index.php/report/result/ajax_kuesioner",
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
	$('#slc_kuesioner').change(function() {
		if ($(this).val()!=0) {

			$.ajax({
				url: base_url + "index.php/report/result/ajax_date",
				type: 'post',
				dataType: 'json',
				data: {kuesioner_id: $(this).val()}
			})
			.done(function(respond) {
				$('#dtp_start').val(respond.start);
				$('#dtp_end').val(respond.end);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});


			$('spin_unit').show();
			$.ajax({
				url: base_url + "index.php/report/result/ajax_unit",
				type: 'post',
				data: {kuesioner_id: $(this).val()},
				success: function(msg){
					$("#slc_unit").html(msg);
					$('#spin_unit').hide();
				}
			})
		} else {
			$("#slc_unit").empty();

		}
	});
	// $('#slc_unit').change(function() {
	// 	if ($(this).val()!=0) {
	// 		$('spin_div').show();
	// 		$.ajax({
	// 			url: base_url + "index.php/report/result/ajax_div",
	// 			type: 'post',
	// 			data: {
	// 				kuesioner_id : $('#slc_kuesioner').val() ,
	// 				unit_id : $('#slc_unit').val()
	// 			},
	// 			success: function(msg){
	// 				$("#slc_div").html(msg);
	// 				$('#spin_div').hide();
	// 			}
	// 		})
	// 	} else {
	// 		$("#slc_div").empty();

	// 	}
	// });
});
</script>
