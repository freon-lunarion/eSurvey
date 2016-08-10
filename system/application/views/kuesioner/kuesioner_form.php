<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label = array(
			'Kuesioner Code'
			,'Kuesioner Title'
			,'Survey Type'
			,'Method'
			,'Start'
			,'End'
			,'Survey Theme'
			,'Introduction'
			,'Agreement'
			,'Guide'
			,'Term'
			,'Abstain Text'
			,'Skip Quota');

		$element = array(
			form_input('txt_code', $code, 'class="input-small" required maxlength=10 minlength=3')
			,form_input('txt_title', $title, 'class="input-xlarge" required maxlength=50 minlength=5')
			,form_dropdown('slc_type', $type_list, $type,'class="input-medium" required')
			,form_dropdown('slc_method', array('Sensus','Sampling'), $method,'class="input-medium"')
			,'<div class="input-append datetime">'.form_input('dtp_start', $start, 'class="input-medium" data-date-format="yyyy-MM-dd hh:mm:ss"').'<span class="add-on"><i class="icon-calendar"></i></span></div>'
			,'<div class="input-append datetime">'.form_input('dtp_end', $end, 'class="input-medium" data-date-format="yyyy-MM-dd hh:mm:ss"').'<span class="add-on"><i class="icon-calendar"></i></span></div>'
			,form_input('txt_theme', $theme, 'class="input-xlarge" maxlength=150')
			,form_textarea('txt_intro', $intro, 'class="input-xlarge"')
			,form_textarea('txt_agreement', $agreement, 'class="input-xlarge"')
			,form_textarea('txt_guide', $guide, 'class="input-xlarge"')
			,form_textarea('txt_term', $term, 'class="input-xlarge"')
			,form_input('txt_abstain', $abstain, 'class="input-medium" required maxlength=50 minlength=5')
			,form_number('nm_skip_quota', $skip_qty, 'class="input-small" required'));

		if ($type!=''){
			$element[2] = form_input('', $type_list[$type], 'class="input-medium" readonly="readonly"');
		}

		for ($i=0; $i < 4; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		echo '<hr>';
		for ($i=4; $i < 6; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		echo '<hr>';
		for ($i=6; $i < 8; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		echo '<hr>';
		for ($i=8; $i < 13; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		$button = array(
			form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'))
			,anchor($link_back, 'Back', 'class="btn"'));
		echo form_action($button);
		echo form_close();

	?>