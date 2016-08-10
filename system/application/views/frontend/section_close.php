
<?php
	$button = array(
		// anchor('frontend/back', '<i class="icon-arrow-left"></i> Back', 'class="btn"'),
		form_submit('', 'Next','class="btn btn-primary"'),
		);
	echo form_action($button, $attr = NULL);
	echo form_close();
?>
	</div>
</div>