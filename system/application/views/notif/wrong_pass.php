<?php 
	$attr['class']	= 'alert-error';
	$attr['dismissal'] = true;
	$attr['header'] = 'Access Denied';
	echo alert('Wrong NIK or password ',$attr);
?>