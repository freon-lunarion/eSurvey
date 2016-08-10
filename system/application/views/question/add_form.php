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
		$element[2] = form_textarea('txt_text', $text, 'id="txt_text" class="input-xlarge" required maxlength=140 minlength=5');

		$element[3] = form_dropdown('slc_var',$var_list,$var_sel,'class="input-large" id="slc_var"');

		$element[4] = form_dropdown('slc_dim',$dim_list,$dim_sel,'class="input-large" id="slc_dim"').'<i class="icon-spinner icon-2x icon-spin" id="spin_1"></i>';

		$element[5] = form_dropdown('slc_ind',$ind_list,$ind_sel,'class="input-large" id="slc_ind"').'<i class="icon-spinner icon-2x icon-spin" id="spin_2"></i>';
		
		$element[6] = form_dropdown('slc_type',$type_list,$type_sel,'class="input-medium" id="slc_type" required');

		$count = count($element);
		for ($i=0; $i < $count ; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		unset($label);
		unset($element);
	?>
	<div id="scale_sect">
		<hr/>
	<?php
		echo control_group('Abstain Able', form_checkbox('chk_abstain', 1, FALSE));
		$label[0] = 'Minimum Value';
		$label[1] = 'Minimum Text';
		$label[2] = 'Maximum Value';
		$label[3] = 'Maximum Text';

		$element[0] = form_number('txt_min_val',$min_val, 'id="txt_min_val" class="input-small"');
		$element[1] = form_input('txt_min_text',$min_text, 'id="txt_min_text" class="input-large"');
		$element[2] = form_number('txt_max_val',$max_val, 'id="txt_max_val" class="input-small"');
		$element[3] = form_input('txt_max_text',$max_text, 'id="txt_max_text" class="input-large"');

		$count = count($element);
		for ($i=0; $i < $count ; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
	?>	
	</div>
	<div id="option_sect">
		<hr/>
		<?php
		echo control_group('Abstain Able', form_checkbox('chk_abstain', 1, FALSE));
		?>
		<input type="hidden" id="hdn_num" name="hdn_num" value="2">
		<div id="" class="control-group   clearfix" style="">
			<div class="controls"><span title="Add option" class="btn" id="btn_add"><i class="icon-plus"></i></span> <span title="Remove last Option" class="btn" id="btn_del"><i class="icon-minus"></i></span></div> <!-- END OF .controls -->
		</div>
		<?php 
		for ($i=1; $i <=2 ; $i++) { 
			echo control_group('Option #'.$i, form_input('txt_option_'.$i,'', 'id="txt_option_'.$i.'" class="input-medium"').' Value '.form_number('txt_opt_val_'.$i,$i, 'id="txt_opt_val_'.$i.'" class="input-small"'),array('id'=>'option_div_'.$i));
		}

		?>
	</div>
	<div id="multi_sect">
	<?php
		$label[0] = 'Maximum Selection';
		$element[0] = form_number('nm_max_sel',$max_sel, 'class="input-small"');
		echo control_group($label[0], $element[0]);


	?>
	</div>
	<?php
		
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>