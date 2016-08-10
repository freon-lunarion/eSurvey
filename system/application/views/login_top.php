<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>KG eSurvey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="HRIS">

    <!-- Le styles -->
    <?php echo link_tag('assets/bootstrap/bootstrap.min.css'); ?>
    <?php echo link_tag('assets/bootstrap/bootstrap-responsive.min.css'); ?>
    <?php echo link_tag('assets/datetimepicker/bootstrap-datetimepicker.min.css'); ?>
    <?php echo link_tag('assets/datatable/DT_bootstrap.min.css'); ?>
    <?php echo link_tag('assets/font-awesome/css/font-awesome.min.css'); ?>
    <?php echo link_tag('assets/custom_css/style_responden.min.css'); ?>

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
          <?php 
          $atr = array(
            'src'     => 'assets/img/kg_logo.png',
            'width'   => '23px',
            'height'  => '23px'
          );
          echo anchor('backend',img($atr).' eSurvey','class="brand"');
          ?>
        </div>
      </div>
    </div>

    <div class="container <?php if(isset($is_fluid) && $is_fluid){ echo 'container-fluid';} ?>">

<div class="row">
<div class="span4 offset4">
<div class="well">
<legend><?php echo $header ?></legend>
<?php 
echo form_open($action, '');