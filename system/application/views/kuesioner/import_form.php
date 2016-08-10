<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open_multipart($process, array('class'=>"form-horizontal", 'enctype'=>"multipart/form-data"), $hidden);
		echo control_group('File .xls', form_upload('fl_upload'));

		$button = array(
			form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'))
			,anchor($link_back, 'Back', 'class="btn"'));
		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>