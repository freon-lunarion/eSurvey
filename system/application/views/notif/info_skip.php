<?php 
	$attr['class']	= 'alert-info';
	$attr['dismissal'] = true;
	$attr['header'] = 'Mohon tunggu';
	echo alert('Halaman ini akan dialihkan dalam waktu <span id="timeLeft">'.$time.'</span> detik, atau klik '
		. anchor($loc, 'disini'),$attr);

?>