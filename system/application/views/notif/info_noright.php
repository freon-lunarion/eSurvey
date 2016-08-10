<?php 
	$attr['class']	= 'alert-warning';
	$attr['dismissal'] = true;
	$attr['header'] = 'Maaf';
	echo alert('Anda tidak diperkenankan mengisi survey ini.
		<br/>Halaman ini akan dialihkan dalam waktu <span id="timeLeft">'.$time.'</span> detik, atau klik '
		. anchor($loc, 'disini'),$attr);

?>