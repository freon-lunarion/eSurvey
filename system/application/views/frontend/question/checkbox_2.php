
		<?php

		foreach ($option_list as $row){
			echo '<label class="checkbox">';

			if ( in_array($row->option_value, $answer)){
				echo form_checkbox(
					'chk_'.$q_id.'[]', 
					$row->option_value.'|'.$row->option_text, 
					TRUE,
					'data-group="'.$q_id.'" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Minimal satu" data-type="option" data-validation-maxchecked-message="Melebihi batas maksimum" data-validation-maxchecked-maxchecked="'.$max_val.'"'
				);
			}else{
				echo form_checkbox(
					'chk_'.$q_id.'[]', 
					$row->option_value.'|'.$row->option_text, 
					FALSE,
					'data-group="'.$q_id.'" data-validation-minchecked-minchecked="1" data-validation-minchecked-message="Minimal satu" data-type="option" data-validation-maxchecked-message="Melebihi batas maksimum" data-validation-maxchecked-maxchecked="'.$max_val.'"'
				);
				
			}

			echo $row->option_text;
			echo '</label>';
		}
		?>
		<br>
		<label class="checkbox">
		<?php
		if ( in_array('N', $answer)){
			echo form_checkbox('chk_'.$q_id.'[]', 'N|', TRUE,'data-group="'.$q_id.'" data-type="abstain"');

		}else{
			echo form_checkbox('chk_'.$q_id.'[]', 'N|', FALSE,'data-group="'.$q_id.'" data-type="abstain"');
			
		}
		echo $abstain_text;
		?>
		</label>
	</div>
</div>