	<hr>
	<?php
		$label[0] = 'Abstain Able';
		$label[1] = 'Minimum Value';
		$label[2] = 'Minimum Text';
		$label[3] = 'Maximum Value';
		$label[4] = 'Maximum Text';

		$element[0] = form_checkbox('chk_abstain', 1, $abstain);
		$element[1] = form_number('nm_min_val',$min_val, 'id="txt_min_val" class="input-small" required');
		$element[2] = form_input('txt_min_text',$min_text, 'id="txt_min_text" class="input-large"');
		$element[3] = form_number('nm_max_val',$max_val, 'id="txt_max_val" class="input-small" required');
		$element[4] = form_input('txt_max_text',$max_text, 'id="txt_max_text" class="input-large"');

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