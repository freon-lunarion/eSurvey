<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label[0] = 'Scale Name';
		$label[1] = 'Abstain Able?';
		$label[2] = 'Min. Value';
		$label[3] = 'Min. Text';
		$label[4] = 'Max. Value';
		$label[5] = 'Max. Text';

		$element[2] = form_number('txt_min_val',$min_val, 'id="txt_min_val" class="input-small"');
		$element[3] = form_input('txt_min_text',$min_text, 'id="txt_min_text" class="input-large"');
		$element[4] = form_number('txt_max_val',$max_val, 'id="txt_max_val" class="input-small"');
		$element[5] = form_input('txt_max_text',$max_text, 'id="txt_max_text" class="input-large"');

		echo control_group($label[0], $element[0]);
		echo control_group($label[1], $element[1]);
		
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>