<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label = array(
			'Survey Title'
			,'Order'
			,'Name'
			,'Description');

		$element = array(
			form_input('txt_title', $title, 'class="input-medium" readonly="readonly"')
			,form_input('nm_order', $order, 'class="input-small"')
			,form_input('txt_name', $name,'class="input-medium"')
			,form_textarea('txt_desc', $desc, 'class="input-xlarge"'));
		for ($i=0; $i < 4; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		$button = array(
			form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'))
			,anchor($link_back, 'Back', 'class="btn"'));
		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>