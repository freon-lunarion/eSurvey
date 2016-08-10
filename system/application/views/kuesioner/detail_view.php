<dl class="dl-horizontal">
  <dt>Code</dt>
  <dd><?php echo $detail->kuesioner_code; ?></dd>
  <dt>Title</dt>
  <dd><?php echo $detail->title; ?></dd>
  <dt>Survey Type</dt>
  <dd><?php echo $detail->type_name; ?></dd>
  <dt>Start & End</dt>
  <dd><?php echo mdate('%D, %d %M %Y %H:%i:%s',strtotime($detail->start_time)) .' - '. mdate('%D, %d %M %Y %H:%i:%s',strtotime($detail->end_time)); ?></dd>
  <dt>Theme</dt>
  <dd><?php echo $detail->theme; ?></dd>
  <dt>Introduction</dt>
  <dd><?php echo $detail->introduction; ?></dd>
  <dt>Skip Quota</dt>
  <dd><?php echo $detail->skip_quota; ?></dd>
  <dt>Abstain Text</dt>
  <dd><?php echo $detail->abstain_text; ?></dd>
</dl>

<hr>
<h2>Section</h2>
<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo anchor($link_sect_add.$detail->kuesioner_id, '<i class="icon-plus"></i>', 'class="btn pull-right" title="Add Section"');
	?>
	</div>
</div>
<div class="row">
	<div class="span12">
	<table class="table datatable">
		<thead><tr><th>#</th><th>Section Name</th><th>Description</th><th>Action</th></tr></thead>
		<tbody>
			<?php
			foreach ($sect_list as $row) {
				echo '<tr>';
				echo '<td>'.$row->order.'</td>';
				echo '<td>'.$row->section_name.'</td>';
				echo '<td>'.$row->description.'</td>';
				echo '<td><div class="btn-group">';
				echo anchor($link_sect_detail.$row->section_id, '<i class="icon-list icon-large"></i>', 'class="btn" title="Detail"').' ';
				echo anchor($link_sect_edit.$row->section_id, '<i class="icon-pencil icon-large"></i>', 'class="btn" title="Edit"'). ' ';
				echo anchor($link_sect_delete.$row->section_id, '<i class="icon-trash icon-large"></i>', 'class="btn btn-warning" title="Delete"');
				echo '</div></td>';
				echo '</tr>';

			}
			?>
		</tbody>
	</table>
	</div>
</div>
<hr>
