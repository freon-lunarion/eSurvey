<div class="row">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"');
		$label = array(
			'Survey Type',
			'Kuesioner',
			'Unit'

		);
		$element = array(
			form_dropdown('slc_survey', $survey_list, ''),
			form_dropdown('slc_kuesioner', array(), '').' <i id="spin_kuesioner" class="icon-spinner icon-spin icon-2x"></i>',
			form_dropdown('slc_unit', array(), '').' <i id="spin_unit" class="icon-spinner icon-spin icon-2x"></i>'
		);
		for ($i=0; $i < count($label) ; $i++) { 
			echo control_group($label[$i],$element[$i]);		
		}
		echo form_action(form_submit('btn_submit', 'Next','class="btn btn-primary"'));
		echo form_close();
	?>
	</div>
</div>