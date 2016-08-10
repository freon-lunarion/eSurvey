<div class="row">
	<div class="span12">
		<h2>Active Kuesioner</h2>
		<table class="table table-bordered table-stripted">
			<thead>
				<tr><th>Code</th><th>Title</th><th>Survey</th><th>Start</th><th>End</th><th>Submitted</th></tr>
			</thead>
			<tbody>
				<?php
				foreach ($kuesioner as $row) {
					echo '<tr>';
					echo '<td>'.$row->kuesioner_code.'</td>';
					echo '<td>'.$row->title.'</td>';
					echo '<td>'.$row->type_name.'</td>';
					echo '<td>'.date('Y-m-d H:i:s',strtotime($row->start_time)).'</td>';
					echo '<td>'.date('Y-m-d H:i:s',strtotime($row->end_time)).'</td>';
					echo '<td>'.$cnt_sbmt[$row->kuesioner_id].'</td>';

					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>