<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<title>KG eSurvey</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="HRIS">

	<!-- Le styles -->
	<?php echo link_tag('assets/bootstrap/bootstrap.css'); ?>
	<?php echo link_tag('assets/bootstrap/bootstrap-responsive.css'); ?>
  <?php echo link_tag('assets/bootstrap/switch.css'); ?>
  <?php echo link_tag('assets/datetimepicker/bootstrap-datetimepicker.min.css'); ?>
  <?php echo link_tag('assets/datatable/DT_bootstrap.css'); ?>
  <?php echo link_tag('assets/fancybox/jquery.fancybox.css'); ?>
  <?php echo link_tag('assets/font-awesome/css/font-awesome.css'); ?>
  <?php echo link_tag('assets/custom_css/base.css'); ?>
  <?php echo link_tag('assets/custom_css/style_responden.css'); ?>
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

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php echo anchor('backend','GES','class="brand"')?>
          <div class="nav-collapse collapse">
            <ul class="nav">

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
      <?php
      echo form_open($process, 'class="form-horizontal"', $hidden);
      echo '<legend style="font-size:14px;">Anda memiliki lebih dari satu posisi. <br/>Silahkan memilih posisi yang dimaksud untuk mengisi Survey. <br/>Jika sudah mengisi survey, Anda dapat melewati survey ini dengan mengklik <b>Next</b> pada posisi yang sudah terpilih.</legend>';
      foreach ($post as $row) {
        if ($def_post != $row['OBJECT_ID']) {
          $data = array(
            'name'    => 'rd_position',
            'id'      => 'rd_position_'.$row['OBJECT_ID'],
            'value'   => $row['OBJECT_ID'],
            'checked' => false
            );
        } else {
          $data = array(
            'name'    => 'rd_position',
            'id'      => 'rd_position_'.$row['OBJECT_ID'],
            'value'   => $row['OBJECT_ID'],
            'checked' => true
          );
        }
        echo control_group('', form_label(form_radio($data).$row['LONG_TEXT'], '', array('class'=>'radio')));
      }
      $button[0] = form_button(array('type'=>'submit','content'=>'Next','class'=>'btn btn-primary'));
      echo form_action($button);
      echo form_close();
      ?>
    </div>