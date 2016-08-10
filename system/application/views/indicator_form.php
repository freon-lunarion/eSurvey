<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label[0] = 'Survey Type';
		$label[1] = 'Variable';
		$label[2] = 'Dimension';

		$label[3] = 'Indicator Code';
		$label[4] = 'Indicator Name';

		$element[0] = form_input('',$survey_type, 'class="input-large" readonly="readonly"');
		$element[1] = form_input('',$variable, 'class="input-large" readonly="readonly" required maxlength=10 minlength=3');
		$element[2] = form_input('',$dimension, 'class="input-large" readonly="readonly" required maxlength=50 minlength=5');

		$element[3] = form_input('txt_code',$code, 'class="input-small"');
		$element[4] = form_input('txt_name',$name, 'class="input-large"');

		$count = count($element);
		for ($i=0; $i < $count ; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>