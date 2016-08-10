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
			echo '<li>';
			echo anchor('frontend/section/'.$row->section_id, $row->section_name);

			// echo anchor('#', $row->section_name);
			echo '</li>';
		}
		?>
		<li class="divider"></li>
		<li class="active"><a href="#">Review</a></li>
	  </ul>
		</div>
	</div>
	<div class="span9">
		<!-- <div class="progress">
		  <div class="bar" style="width:100%;">100%</div>
		</div> -->
	</div>
	<div class="span9">
		<?php
			if ($submitable) {
				echo '<p>Klik tombol <b>Kirim</b> untuk mengirimkan jawaban Anda.</p>';
			} else {
				echo '<div class="alert alert-error">';
				echo 'Ada pertanyaan yang belum terjawab, mohon melengkapinya dahulu dengan menggunakan tombol <b>Ubah</b>';
				echo '</div>';
			}
		?>

	</div>

	<div class="span9">
		<table class="table table-bordered table-stripted datatable_span9">
			<thead>
				<tr><th>No.</th><th>Question</th><th width="200px">Answer</th></tr>
			</thead>
			<tbody>
				<?php
				$number = 1;
				foreach ($question as $row) {
					echo '<tr>';
					echo '<td>'.$number.'</td>';
					echo '<td>'.$row->question_text.'</td>';
					echo '<td>'.$answer[$row->question_id].'</td>';

					echo '</tr>';
					$number++;
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="span12">
		<div class="pull-center">
		<?php
		if ($submitable) {
			echo anchor($next_link, 'Kirim', 'class="btn btn-primary"');
		} else {

		}
		?>
		<?php echo anchor($back_link, 'Ubah', 'class="btn" title="Ubah jawaban"');?>

		</div>

	</div>
</div>
