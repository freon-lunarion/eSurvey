<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
		$label[0] = 'Survey Type';
		$label[1] = 'Variable';
		$label_code = 'Code #';
		$label_name = 'Name #';

		$element[0] 	= form_input('',$survey_type, 'class="input-large" readonly="readonly"');
		$element[1] = form_input('',$variable, 'class="input-large" readonly="readonly"');

		$max = count($element);
		for ($i=0; $i < $max ; $i++) { 
			echo control_group($label[$i], $element[$i]);
		}
		?>
		<div id="" class="control-group   clearfix" style="">
		<div class="controls"><span title="Add option" class="btn" id="btn_add"><i class="icon-plus"></i></span> <span title="Remove last Option" class="btn" id="btn_del"><i class="icon-minus"></i></span></div> <!-- END OF .controls -->
		</div>
		<?php
		for ($i=1; $i <=2 ; $i++) { 
			echo '<div id="option_div_'.$i.'">';
			echo '<hr>';
			echo control_group($label_code.$i,form_input('txt_code_'.$i,'', 'class="input-small" required maxlength=10 minlength=3'));
			echo control_group($label_name.$i,form_input('txt_name_'.$i,'', 'class="input-large" required maxlength=50 minlength=5'));
			echo '</div>';
		}
		?>
		<div id="option_sect"></div>
		<?php
		
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>