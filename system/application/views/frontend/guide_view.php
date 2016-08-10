<div class="row">
	<div class="span3 visible-desktop">
		<div class="well" style="padding-left:0px;padding-right:0px">
			<ul class="nav nav-list">
				<li><?php echo anchor('frontend/intro', 'Pengantar');?></li>
        <li ><?php echo anchor('frontend/agreement', 'Persetujuan');?></li>
        <li class="active"><a href="#">Petunjuk</a></li>
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
		  <div class="bar" style="width: <?php echo $progress ?>%;"><?php echo round($progress,2) ?>%</div>
		</div> -->
		<?php
			echo $guide;
		?>
	</div>
</div>
<div class="row">
	<div class="span12">
		<div class="pull-center">
		<!-- <?php echo anchor($next_link, 'Menolak', 'class="btn btn-danger"');?> -->
		<?php echo anchor($next_link, 'Lanjut', 'class="btn btn-primary"');?>

		</div>

	</div>
</div>
