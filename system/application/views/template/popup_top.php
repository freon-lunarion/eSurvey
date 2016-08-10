<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<title>Awsomeness from Freon L</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Freon L">

	<!-- Le styles -->
	<?php echo link_tag('assets/bootstrap/bootstrap.css'); ?>
	<?php echo link_tag('assets/bootstrap/bootstrap-responsive.css'); ?>
	<?php echo link_tag('assets/datetimepicker/bootstrap-datetimepicker.min.css'); ?>
  <?php echo link_tag('assets/datatable/DT_bootstrap.css'); ?>
	<?php
		if(isset($css_list))
		{
			foreach ($css_list as $key => $css_path) {
				echo link_tag('assets/'.$css_path.'.css');
			}
		}
	?>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="../assets/js/html5shiv.js"></script>
	<![endif]-->

	<!-- Fav and touch icons -->
	<?php 
	echo link_tag('assets/ico/apple-touch-icon-144-precomposed.png', 'apple-touch-icon-precomposed', 'image/ico');
	echo link_tag('assets/ico/apple-touch-icon-72-precomposed.png', 'apple-touch-icon-precomposed', 'image/ico');
	echo link_tag('assets/ico/apple-touch-icon-57-precomposed.png', 'apple-touch-icon-precomposed', 'image/ico');
	echo link_tag('assets/ico/favicon.png', 'apple-touch-icon-precomposed', 'image/ico');
	?>
  </head>

  <body>

    <div class="container">