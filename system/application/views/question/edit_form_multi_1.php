	
	<div id="option_sect">
	<hr>
	<?php echo control_group('Abstain Able', form_checkbox('chk_abstain', 1, $abstain)); ?>
	<input type="hidden" id="hdn_num" name="hdn_num" value="<?php echo $opt_count ?>">
		<div id="" class="control-group   clearfix" style="">
			<div class="controls"><span title="Add option" class="btn" id="btn_add"><i class="icon-plus"></i></span> <span title="Remove last Option" class="btn" id="btn_del"><i class="icon-minus"></i></span></div> <!-- END OF .controls -->
		</div>
	<?php
		$i=1;
		foreach ($opt_list as $row) {
			echo control_group('Option #'.$i, form_input('txt_option_'.$i,$row->option_text, 'id="txt_option_'.$i.'" class="input-medium"').' Value '.form_input('txt_opt_val_'.$i,$row->option_value, 'id="txt_opt_val_'.$i.'" class="input-small"').form_hidden('hdn_opt_'.$i, $row->option_id),array('class'=>'control-group option-div  clearfix','id'=>'option_div_'.$i));
			$i++;
		}
	?>
	</div>
	<?php
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>