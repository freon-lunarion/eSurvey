<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<title>KG eSurvey Backend</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="HRIS">

	<!-- Le styles -->
	<?php echo link_tag('assets/bootstrap/bootstrap.css'); ?>
	<?php echo link_tag('assets/bootstrap/bootstrap-responsive.css'); ?>
  <?php echo link_tag('assets/bootstrap/switch.css'); ?>
  <?php echo link_tag('assets/morris/morris.css'); ?>  
  <?php echo link_tag('assets/datetimepicker/bootstrap-datetimepicker.min.css'); ?>
  <?php echo link_tag('assets/datatable/DT_bootstrap.css'); ?>
  <?php echo link_tag('assets/fancybox/jquery.fancybox.css'); ?>
  <?php echo link_tag('assets/font-awesome/css/font-awesome.css'); ?>
  <?php echo link_tag('assets/custom_css/base.css'); ?>
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
	echo link_tag('assets/img/kg_logo.png', 'shortcut icon', 'image/ico'); 
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
          <?php 
          $atr = array(
            'src'     => 'assets/img/kg_logo.png',
            'width'   => '23px',
            'height'  => '23px'
          );
          echo anchor('backend',img($atr).' eSurvey','class="brand"');
          ?>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><?php echo anchor('survey_type','Survey Type')?></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Question <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><?php echo anchor('question_category','Category')?></li>
                  <!-- <li><?php echo anchor('temp_scale','Scale Template')?></li> -->
                  <li><?php echo anchor('question_bank','Bank')?></li>
                </ul>
              </li>
              <li><?php echo anchor('kuesioner','Kuesioner')?></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><?php echo anchor('report/responden','Responden')?></li>
                  <li><?php echo anchor('report/result','Result')?></li> 
                </ul>
              </li>

            </ul>
            <ul class="nav pull-right">
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php echo $this->session->userdata('username')?><b class="caret"></b></a><ul class="dropdown-menu">
              <li><?php echo anchor('account/logout', 'Logout');?></li>
            </ul></li>
          </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container <?php if(isset($is_fluid) && $is_fluid){ echo 'container-fluid';} ?>">