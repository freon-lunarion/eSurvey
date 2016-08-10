<h2>Sampling Responden</h2>
<div id="" class="row" style="margin-bottom:5px">
	<div id="" class="span12">
		<div class="btn-group pull-right">
		<?php echo anchor($link_import.$detail->kuesioner_id, '<i class="icon-upload"></i>', 'class="btn" title="Upload data"');?>
		<a href="<?php echo base_url().'assets/file/responden.xls'?>" class="btn" title="Download template"><i class="icon-download"></i></a>
	</div>
	</div>
</div>
<div id="" class="row">
	<div id="" class="span12">
		<table id="" class="table datatable" >
			<thead><tr><th>NIK</th><th>Position ID</th><th>SAP</th><th>Action</th></tr></thead>
			<tbody>
			<?php
				$is_sap = array(
					'<span class="label">No</span>',
					'<span class="label label-info">Yes</span>'
				);
				foreach ($responden_list as $row) {
					echo '<tr>';
					echo '<td>'.$row->nik.'</td>';
					echo '<td>'.$row->position_id.'</td>';
					echo '<td>'.$is_sap[$row->is_sap].'</td>';
					echo '<td>'.anchor($link_del.$row->responden_id, '<i class="icon-trash icon-large"></i>', 'class="btn"').'</td>';

					echo '</tr>';

				}
			?>
			</tbody>
		</table>
	</div>
</div>