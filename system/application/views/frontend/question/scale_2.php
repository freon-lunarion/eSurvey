		<table class="table">
		<tr style="height:60px;">
			<td></td>
		<?php
			for ($i=$min_val; $i <= $max_val ; $i++) { 
				echo '<td style="text-align:center;vertical-align:bottom;">'.$i.'</td>';
			}
		?>
			<td></td>
			<td><?php echo $abstain_text?></td>
		</tr>
		<tr>
			<td style="text-align:right"><?php echo  $min_text ?></td>
		<?php
			for ($i=$min_val; $i <= $max_val ; $i++) { 
				if($i == $answer){
					$atr = array(
						'name'        => 'rd_'.$q_id,
						'id'          => 'rd_'.$q_id.'_'.$i,
						'value'       => $i,
						'checked'     => TRUE,
						'style'       => 'width:20px;height:20px',
						'required'		=> ''
					);
				} else {
					$atr = array(
						'name'        => 'rd_'.$q_id,
						'id'          => 'rd_'.$q_id.'_'.$i,
						'value'       => $i,
						'checked'     => FALSE,
						'style'       => 'width:20px;height:20px',
						'required'		=> ''
					);
				}
				echo '<td style="text-align:center;">'.form_radio($atr).'</td>';
			}
		?>
			<td><?php echo  $max_text ?></td>
			<td>
			<?php
				if($answer == 'N'){
					$atr = array(
						'name'        => 'rd_'.$q_id,
						'id'          => 'rd_'.$q_id.'_'.$i,
						'value'       => 'N',
						'checked'     => TRUE,
						'style'       => 'width:20px;height:20px',
						'required'		=> ''
					);
				} else {
					$atr = array(
						'name'        => 'rd_'.$q_id,
						'id'          => 'rd_'.$q_id.'_'.$i,
						'value'       => 'N',
						'checked'     => FALSE,
						'style'       => 'width:20px;height:20px',
						'required'		=> ''
					);
				} 

			echo form_radio($atr) 
			?></td>
		</tr>
		</table>
	</div>
</div>