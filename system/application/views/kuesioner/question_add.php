<div class="row" style="margin-bottom:10px">
	<div class="span12">
	<?php
		echo form_open($process, 'class="form-horizontal"', $hidden);
	?>
	<dl class="dl-horizontal">
	  <dt>Kuesioner Title</dt>
	  <dd><?php echo $head->kuesioner_title; ?></dd>
	  <dt>Section Name</dt>
	  <dd><?php echo $head->section_name; ?></dd>
	  <dt>Question Bank</dt>
	  <dd>
	  	<table id="" class="table table-bordered table-stripted" >
	  		<thead><tr><th>Code</th><th width="500">Question</th><th>Type</th><th width="75">Select</th><th width="75">Order</th></tr></thead>
	  		<tbody>
	  		<?php
	  			foreach ($bank as $row) {
	  				echo '<tr>';
	  				echo '<td>'.anchor('kuesioner/question_popup/'.$row->question_id,$row->question_code,'class="fancybox-nonrefresh" data-fancybox-type="iframe" title="Detail"').'</td>';
	  				echo '<td>'.$row->question_text.'</td>';
	  				echo '<td>'.$q_type[$row->type].'</td>';
	  				echo '<td>'.form_checkbox('chk_select_'.$row->question_id, 1, FALSE).'</td>';
	  				echo '<td>'.form_number('nm_order_'.$row->question_id, 1, 'class="input-small" min="1"').'</td>';
	  				echo '</tr>';
	  			}
	  		?>
	  		</tbody>
	  	</table>
	  </dd>
	</dl>
	<?php
		$button = array(
			form_button(array('type'=>'submit','content'=>'Save','class'=>'btn btn-primary'))
			,anchor($link_back, 'Back', 'class="btn"'));
		echo form_action($button);
		echo form_close();
	?>
	</div>
</div>