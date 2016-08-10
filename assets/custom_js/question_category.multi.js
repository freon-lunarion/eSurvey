$(document).ready(function() {
	$('#btn_add').click(function(){
		var option_num = $('#hdn_num').val();
		option_num = parseInt(option_num);
		option_num +=1;
		$('#hdn_num').val(option_num);
		var part = '<div class="option-div">';
		part += '<hr>';
		part += '<div class="control-group clearfix">';
		part += '<label class="control-label" for="txt_code_'+ option_num +'">Code #'+option_num+'</label>';
		part += '<div class="controls"><input name="txt_code_'+ option_num +'" value="" id="txt_code_'+ option_num +'" class="input-small" type="text"></div>';
		part += '</div>'; //end of control-group
		part += '<div class="control-group clearfix">';
		part += '<label class="control-label" for="txt_name_'+ option_num +'">Name #'+option_num+'</label>';
		part += '<div class="controls"><input name="txt_name_'+ option_num +'" value="" id="txt_name_'+ option_num +'" class="input-large" type="text"></div>';
		part += '</div>'; //end of control-group
		part += '</div>'; //end of option-div

		$('#option_sect').append(part);
		
	});
	$('#btn_del').click(function(){
		var option_num = $('#hdn_num').val();
		option_num = parseInt(option_num);
		if(option_num>2){
			$('.option-div').last().remove();
			option_num -=1;
			$('#hdn_num').val(option_num);
		}
	});

});