<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
	echo form_open($process, 'class="form-horizontal"', $hidden);
	echo control_group('Unit', form_dropdown('slc_unit', $unit_list, $unit_id,'class="input-xlarge"'));
	?>
	<hr>
	<h2>Contract</h2>
	<?php
	echo control_group('Minimum',form_input('nm_co_min_yr', $co_min_yr, 'class="input-small"').' Years ' .form_input('nm_co_min_mo', $co_min_mo, 'class="input-small"').' Months '.form_input('nm_co_min_dy', $co_min_dy, 'class="input-small"').' Days ');
	echo control_group('Maximum',form_input('nm_co_max_yr', $co_max_yr, 'class="input-small"').' Years ' .form_input('nm_co_max_mo', $co_max_mo, 'class="input-small"').' Months '.form_input('nm_co_max_dy', $co_max_dy, 'class="input-small"').' Days ');
	?>
	<h2>Permanent</h2>
	<?php
	echo control_group('Minimum',form_input('nm_pe_min_yr', $pe_min_yr, 'class="input-small"').' Years ' .form_input('nm_pe_min_mo', $pe_min_mo, 'class="input-small"').' Months '.form_input('nm_pe_min_dy', $pe_min_dy, 'class="input-small"').' Days ');
	echo control_group('Maximum',form_input('nm_pe_max_yr', $pe_max_yr, 'class="input-small"').' Years ' .form_input('nm_pe_max_mo', $pe_max_mo, 'class="input-small"').' Months '.form_input('nm_pe_max_dy', $pe_max_dy, 'class="input-small"').' Days ');
	?>
	<hr>
	<h2>Length of Position</h2>
	<?php
	echo control_group('Minimum',form_input('nm_po_min_yr', $po_min_yr, 'class="input-small"').' Years ' .form_input('nm_po_min_mo', $po_min_mo, 'class="input-small"').' Months '.form_input('nm_po_min_dy', $po_min_dy, 'class="input-small"').' Days ');
	echo control_group('Maximum',form_input('nm_po_max_yr', $po_max_yr, 'class="input-small"').' Years ' .form_input('nm_po_max_mo', $po_max_mo, 'class="input-small"').' Months '.form_input('nm_po_max_dy', $po_max_dy, 'class="input-small"').' Days ');
	?>
	<?php
	$button = array(
	form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'))
	,anchor($link_back, 'Back', 'class="btn"'));
	echo form_action($button);
	echo form_close();
	?>
	</div>
</div>