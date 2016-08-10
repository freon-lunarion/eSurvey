<dl class="dl-horizontal">
	<dt>Order</dt>
	<dd><?php echo $detail->order; ?></dd>
	<dt>Name</dt>
	<dd><?php echo $detail->section_name; ?></dd>
	<dt>Description</dt>
	<dd><?php echo $detail->description; ?></dd>
</dl>
<hr>
<h2>Question Set</h2>
<div id="" class="row" style="margin-bottom:5px">
	<div id="" class="span12">
	<?php echo anchor($link_add.$detail->section_id, '<i class="icon-plus"></i>', 'class="btn pull-right" title="Add Question"');?>
	</div>
</div>
<div id="" class="row" style="margin-bottom:5px">
	<div id="" class="span12">
	<table id="" class="table datatable" >
		<thead><tr><th>Order</th><th>Code</th><th>Question</th><th>Type</th><th>Status</th><th>Action</th></tr></thead>
		<tbody>
		<?php
		foreach ($set_list as $row) {
			if($row->is_active){
				$status = '<i class="icon-check icon-large"></i>';
				$color  = "btn-success";
			}else{
				$status = '<i class="icon-check-empty icon-large"></i>';
				$color  = "btn-danger";

			}
			echo '<tr>';
			echo '<td>'.$row->question_order.'</td>';
			echo '<td>'.$row->question_code.'</td>';
			echo '<td>'.$row->question_text.'</td>';
			echo '<td>'.$type[$row->type].'</td>';
			echo '<td>'.anchor($link_status.$row->question_set_id, $status, 'class="btn '.$color.'" title="Change Status"').'</td>';
			echo '<td><div class="btn-group">';
				echo anchor($link_edit.$row->question_set_id, '<i class="icon-pencil icon-large"></i>', 'class="btn" title="Edit Question Set"');
				echo anchor($link_delete.$row->question_set_id, '<i class="icon-trash icon-large"></i>', 'class="btn btn-warning" title="Delete Question Set"');
			echo '</div></td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
	</div>
</div>