<div class="row">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"');
		$label = array(
			'Survey Type',
			'Kuesioner',
			'Filter Start',
			'Filter End',
		);
		$element = array(
			form_dropdown('slc_survey', $survey_list, ''),
			form_dropdown('slc_kuesioner', array(), '').' <i id="spin_kuesioner" class="icon-spinner icon-spin icon-2x"></i>',
			'<div class="input-append datetime">'.form_input('dtp_start', '', 'class="input-medium" data-date-format="yyyy-MM-dd hh:mm:ss"').'<span class="add-on"><i class="icon-calendar"></i></span></div>',
			'<div class="input-append datetime">'.form_input('dtp_end', '', 'class="input-medium" data-date-format="yyyy-MM-dd hh:mm:ss"').'<span class="add-on"><i class="icon-calendar"></i></span></div>'
		);
		for ($i=0; $i < count($label) ; $i++) {
			echo control_group($label[$i],$element[$i]);
		}

		echo form_action(form_submit('btn_submit', 'Next','class="btn btn-primary"'));
		echo form_close();
	?>
	</div>
</div>
