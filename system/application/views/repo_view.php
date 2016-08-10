<div class="row" style="margin-bottom:10px">
	<div class="span12"><?php echo anchor($link_add,'<i class="icon-plus"></i>','class="btn pull-right" title="Add New"');?></div>
</div>
<div class="row">
	<div class="span12">
		<?php
		$tmpl = array ( 'table_open'  => '<table class="table datatable table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('Type','Code','Question','Variable','Dimension','Indicator','Status','Action');
		foreach ($list as $row) {
			if($row->is_active){
				$status = '<i class="icon-check icon-large"></i>';
				$color  = 'btn-success';
			}else{
				$status = '<i class="icon-check-empty icon-large"></i>';
				$color  = 'btn-danger';
			}
			switch ($row->type) {
				case 1:
					$type = 'Scale';
					break;
				case 2:
					$type = 'Multiple Choice';
					break;
				case 3:
					$type = 'Open Answer';
					break;
				case 4:
					$type = 'Multi Answer';
					break;
				default:
					$type = '';
					break;
			}
			$this->table->add_row(
				$type,$row->question_code,$row->question_text,
				$row->variable_code,
				$row->dimension_code,
				$row->indicator_code,
				anchor($link_status.$row->question_id,$status,'class="btn '.$color.'" title="Change Status"'),
				'<div class="btn-group">'.
					anchor($link_edit.$row->question_id,'<i class="icon-pencil icon-large"></i>','class="btn" title="Edit"').
					anchor($link_delete.$row->question_id,'<i class="icon-trash icon-large"></i>','class="btn btn-warning" title="Delete"')
				.'</div>'
				);
		}
		echo $this->table->generate();
		$this->table->clear(); 
		?>
	</div>
</div>