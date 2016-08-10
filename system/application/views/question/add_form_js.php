<script type="text/javascript">
$(document).ready(function() {
	CKEDITOR.replace('txt_text');
	$('#scale_sect').hide();
	$('#option_sect').hide();
	$('#multi_sect').hide();
	$('#spin_1').hide();
	$('#spin_2').hide();
	var base_url = "<?php echo base_url() ?>"+"index.php"
	$('#slc_type').change(function(){
		var slc_val = $(this).val();
		if (slc_val==1) {

			$('#scale_sect').show();
			$('#option_sect').hide();
			$('#multi_sect').hide();

		}else if(slc_val==2){
			$('#option_sect').show();
			$('#scale_sect').hide();
			$('#multi_sect').hide();

		}else if(slc_val==4){
			$('#option_sect').show();
			$('#scale_sect').hide();
			$('#multi_sect').show();

		}else{
			$('#scale_sect').hide();
			$('#option_sect').hide();
			$('#multi_sect').hide();
		};
	});

	$('#slc_var').change(function(){
		if ($(this).val()!=0){
			$('#spin_1').show();
			
			$.ajax({
				// url: "http://10.10.55.25/ges/index.php/question_bank/ajax_dim",
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
				// url: "http://10.10.55.25/ges/index.php/question_bank/ajax_ind",
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
		part += ' Value <input name="txt_opt_val_'+ option_num +'" value="'+ option_num +'" id="txt_opt_val_'+ option_num +'" class="input-small" type="number">'
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