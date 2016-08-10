	
	<?php
		$button[0] = form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'));
		
		$button[1] = anchor($back, 'Back', 'class="btn"');

		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>