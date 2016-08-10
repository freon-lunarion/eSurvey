<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label[0] = 'Type Name';
		$label[1] = 'Description';

		$element[0] = form_input('txt_name',$name, 'id="txt_name" class="input-large" required maxlength=50 minlength=3');
		$element[1] = form_textarea('txt_desc',$desc, 'id="txt_desc" class="input-xlarge" cols="30" rows="5"');

		echo control_group($label[0], $element[0]);
		echo control_group($label[1], $element[1]);
		
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>