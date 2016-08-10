
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
			
			echo '<label class="radio" >';
			echo form_radio($atr);
			echo '<div style="height:24px;padding-top:3px;padding-left:3px">';
			echo $row->option_text;
			echo '</div>';

			echo '</label>';
		}
		?>
		<br>
		<label class="radio">
		<?php
		if ($answer == 'N'){
			$atr = array(
				'name'        => 'rd_'.$q_id,
				'id'          => 'rd_'.$q_id.'_none',
				'value'       => 'N|',
				'checked'     => TRUE,
				'style'       => 'width:20px;height:20px',
				'required'		=> ''
			);
		} else {
			$atr = array(
				'name'        => 'rd_'.$q_id,
				'id'          => 'rd_'.$q_id.'_none',
				'value'       => 'N|',
				'checked'     => FALSE,
				'style'       => 'width:20px;height:20px',
				'required'		=> ''
			);
		}
		
		echo form_radio($atr);
		echo '<div style="height:24px;padding-top:3px;padding-left:3px">';		
		echo $abstain_text;
		echo '</div>';

		?>
		</label>	
	</div>
</div>