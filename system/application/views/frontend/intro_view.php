<div class="row">
	<div class="span3 visible-desktop">

		<div class="well" style="padding-left:0px;padding-right:0px">
			<ul class="nav nav-list">
        <li class="active"><a href="#">Pengantar</a></li>
        <li><a href="#">Persetujuan</a></li>
        <li><a href="#">Petunjuk</a></li>
        <li><a href="#">Definisi</a></li>
        <li class="divider"></li>
        <?php
        foreach ($section_list as $row) {
        	echo '<li>';
        	echo '<a href="#">'.$row->section_name.'</a>';
        	echo '</li>';
        }
        ?>
        <li class="divider"></li>
        <li><a href="#">Review</a></li>
      </ul>
		</div>
	</div>
	<div class="span9">
		<!-- <div class="progress">
		  <div class="bar" style="width: <?php echo $progress ?>%;"> <?php echo $progress ?>%</div>
		</div> -->

		<?php
			echo $intro;
		?>
	</div>
</div>
<div class="row">
	<div class="span12">
		<div class="pull-center">
		<?php echo anchor($next_link, 'Next <i class="icon-play"></i>', 'class="btn btn-primary"');?>
		<?php
			$portal_redirect = $this->session->userdata('portal_redirect');
			if ($portal_redirect) {
				if ($skipable) {
					echo anchor($skip_link, 'Skip ('.$quota.') <i class="icon-step-forward"></i>', 'class="btn" title="Ke HR Portal"');

				} else {
					echo '<a href="#" class="btn disabled" disabled="disabled" >Skip (0) <i class="icon-step-forward"></i></a>';
				}
			}


		?>
		</div>

	</div>
</div>
