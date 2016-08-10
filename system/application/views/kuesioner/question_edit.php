<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
	echo form_open($process, 'class="form-horizontal"', $hidden);
	?>
	<dl class="dl-horizontal">
	  <dt>Kuesioner Title</dt>
	  <dd><?php echo $k_title; ?></dd>
	  <dt>Survey Name</dt>
	  <dd><?php echo $s_name; ?></dd>
	  <dt>Question Code</dt>
	  <dd><?php echo $q_code; ?></dd>
	  <dt>Question Type</dt>
	  <dd><?php echo $q_type; ?></dd>
	  <dt>Question</dt>
	  <dd><?php echo $question; ?></dd>
	</dl>
	<?php
	echo control_group('Order',form_number('nm_order', $order, 'class="input-small" min="1"')); 
	$button = array(
	form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'))
	,anchor($link_back, 'Back', 'class="btn"'));
	echo form_action($button);
	echo form_close();
	?>
	</div>
</div>