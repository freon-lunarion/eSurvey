
		<?php
		foreach ($option_list as $row){
			if ($answer == $row->option_value){
				$atr = array(
					'name'        => 'rd_'.$q_id,
					'id'          => 'rd_'.$q_id.'_'.$row->option_id,
					'value'       => $row->option_value.'|'.$row->option_text,
					'checked'     => TRUE,
					'style'       => 'width:20px;height:20px',
					'required'		=> ''
				);
			}else{
				$atr = array(
					'name'        => 'rd_'.$q_id,
					'id'          => 'rd_'.$q_id.'_'.$row->option_id,
					'value'       => $row->option_value.'|'.$row->option_text,
					'checked'     => FALSE,
					'style'       => 'width:20px;height:20px',
					'required'		=> ''
				);
			}
			echo '<label class="radio" style="height:27px">';

			echo form_radio($atr);
			echo '<div style="height:24px;padding-top:3px;padding-left:3px">';
			echo $row->option_text;
			echo '</div>';
			echo '</label>';
		}
		?>
	</div>
</div>