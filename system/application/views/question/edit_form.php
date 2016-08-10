<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label[0] = 'Survey Type';
		$label[1] = 'Question Code';
		$label[2] = 'Question';
		$label[3] = 'Variable';

		$label[4] = 'Dimension';

		$label[5] = 'Indicator';
		$label[6] = 'Question Type';

		$element[0] = form_input('',$survey_type, 'class="input-large" readonly="readonly"');
		$element[1] = form_input('txt_code',$code, 'id="txt_code" class="input-small" required maxlength=10 minlength=3');
		$element[2] = form_textarea('txt_text', $text, 'id="txt_text" class="input-xlarge"');

		$element[3] = form_dropdown('slc_var',$var_list,$var_sel,'class="input-large" id="slc_var"');

		$element[4] = form_dropdown('slc_dim',$dim_list,$dim_sel,'class="input-large" id="slc_dim"').'<i class="icon-spinner icon-2x icon-spin" id="spin_1"></i>';

		$element[5] = form_dropdown('slc_ind',$ind_list,$ind_sel,'class="input-large" id="slc_ind"').'<i class="icon-spinner icon-2x icon-spin" id="spin_2"></i>';
		
		$element[6] = form_input('',$type, 'class="input-large" readonly="readonly"');

		$count = count($element);
		for ($i=0; $i < $count ; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		unset($label);
		unset($element);
	?>