<div class="row" style="margin-bottom:10px">
	<div class="span12"><?php echo anchor($link_add,'<i class="icon-plus"></i>','class="btn pull-right" title="Add New"');?></div>
</div>
<div class="row">
	<div class="span12">
		<?php
		$tmpl = array ( 'table_open'  => '<table class="table datatable table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('Name','Description','Status','Action');
		foreach ($list as $row) {
			if($row->is_active){
				$status = '<i class="icon-check icon-large"></i>';
				$color = "btn-success";
			}else{
				$status = '<i class="icon-check-empty icon-large"></i>';
				$color = "btn-danger";

			}
			$this->table->add_row(
				$row->type_name,
				$row->description,
				anchor(
					$link_status.$row->survey_type_id,
					$status,
					'class="btn '.$color.'" title="Change Status"'
				),
				anchor(
					$link_edit.$row->survey_type_id,
					'<i class="icon-pencil icon-large"></i>',
					'class="btn" title="Edit"'
				).
				anchor(
					$link_delete.$row->survey_type_id, 
					'<i class="icon-trash icon-large"></i>', 
					'class="btn" title="Delete"'
				)
			);
		}
		echo $this->table->generate();
		$this->table->clear(); 
		?>
	</div>
</div>