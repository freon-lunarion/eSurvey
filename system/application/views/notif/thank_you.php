<?php 
	$attr['class']	= 'alert-info';
	$attr['dismissal'] = true;

	$attr['header'] = 'Terima Kasih';
	echo alert('Jawaban Anda telah tersimpan.
		<br/>Halaman ini akan dialihkan dalam waktu <span id="timeLeft">'.$time.'</span> detik, atau klik '
		. anchor($loc, 'disini'),$attr);
?>