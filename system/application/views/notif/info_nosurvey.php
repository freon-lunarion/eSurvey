<?php 
	$attr['class']	= 'alert-info';
	$attr['dismissal'] = true;
	$attr['header'] = 'Maaf';
	echo alert('Tidak ada survey yang tersedia saat ini.
		<br/>Halaman ini akan dialihkan dalam waktu <span id="timeLeft">'.$time.'</span> detik, atau klik '
		. anchor($loc, 'disini'),$attr);

?>