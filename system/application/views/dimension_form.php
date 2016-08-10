<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label[0] = 'Survey Type';
		$label[1] = 'Variable';
		$label[2] = 'Dimension Code';
		$label[3] = 'Dimension Name';

		$element[0] = form_input('',$survey_type, 'class="input-large" readonly="readonly"');
		$element[1] = form_input('',$variable, 'class="input-large" readonly="readonly"');
		$element[2] = form_input('txt_code',$code, 'class="input-small" required maxlength=10 minlength=3');
		$element[3] = form_input('txt_name',$name, 'class="input-large" required maxlength=50 minlength=5');

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