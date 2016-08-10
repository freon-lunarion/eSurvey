<script type="text/javascript">
$(document).ready(function() {
	CKEDITOR.replace( 'txt_text');
	$('#spin_1').hide();
	$('#spin_2').hide();
	var base_url = "<?php echo base_url() ?>" + "index.php"
	$('#slc_var').change(function(){
		if ($(this).val()!=0){
			$('#spin_1').show();
			
			$.ajax({
				url: base_url + "/question_bank/ajax_dim",
				data: {var_id: $(this).val()},
				type: "post",
				success: function(msg){
					$("#slc_dim").html(msg);
					$('#spin_1').hide();
				}
			});
		}else{
			$("#slc_dim").empty();

			$("#slc_ind").empty();
		}
	});
	$('#slc_dim').change(function(){
		if ($(this).val()!=''){
			$('#spin_2').show();

			$.ajax({
				url: base_url + "/question_bank/ajax_ind",
				data: {dim_id: $(this).val()},
				type: "post",
				success: function(msg){
					$("#slc_ind").html(msg);
					$('#spin_2').hide();
				}
			});
		}else{
			$("#slc_ind").empty();
		}
	});
	$('#btn_add').click(function(){
		var option_num = $('#hdn_num').val();
		option_num = parseInt(option_num);
		option_num +=1;
		$('#hdn_num').val(option_num);
		$('#nm_max_sel').val(option_num);
		var part = '<div class="control-group option-div  clearfix">';
		part += '<label class="control-label" for="txt_option_'+ option_num +'">Option #'+option_num+'</label>';
		part += '<div class="controls"><input name="txt_option_'+ option_num +'" value="" id="txt_option_'+ option_num +'" class="input-medium" type="text">';
		part += ' Value <input name="txt_opt_val_'+ option_num +'" value="" id="txt_opt_val_'+ option_num +'" class="input-small" type="text">';
		part += '<input type="hidden" name="hdn_opt_'+ option_num +'" value="insert">';
		part +=' </div>';
		part += '</div>';

		$('#option_sect').append(part);
		
	});
	$('#btn_del').click(function(){
		var option_num = $('#hdn_num').val();
		option_num = parseInt(option_num);
		if(option_num>2){
			$('.option-div').last().remove();
			option_num -=1;
			$('#hdn_num').val(option_num);
			$('#nm_max_sel').val(option_num);
		}
	});

});

</script>