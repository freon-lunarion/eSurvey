<div class="row">
	<div class="span3 visible-desktop">
		<div class="well" style="padding-left:0px;padding-right:0px">
			<ul class="nav nav-list">
				<li><?php echo anchor('frontend/intro', 'Pengantar');?></li>
				<li ><?php echo anchor('frontend/agreement', 'Persetujuan');?></li>
				<li ><?php echo anchor('frontend/guide', 'Petunjuk');?></li>
				<li ><?php echo anchor('frontend/term', 'Definisi');?></li>
				<li class="divider"></li>
		<?php
		foreach ($section_list as $row) {
			if ($row->section_id == $section_id){
				echo '<li class="active">';

			} else{
				echo '<li>';

			}
			echo '<a href="">'. $row->section_name.'</a>';
			// echo anchor('frontend/section/'.$row->section_id, $row->section_name);
			echo '</li>';
		}
		?>
		<li class="divider"></li>
		<li><a href="">Review</a></li>
	  </ul>
		</div>
	</div>
	<div class="span9">
		<!-- <div class="progress">
		  <div class="bar" style="width: <?php echo $progress ?>%;"><?php echo round($progress,2) ?>%</div>
		</div> -->
<?php
	echo form_open($process,'class="form-horizontal"',$hidden);
	echo '<legend>'.$section->description.'</legend>';
?>
