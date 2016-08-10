<div class="row" style="margin-bottom:10px">
	<div class="span12"><?php echo anchor($link_add,'<i class="icon-plus"></i>','class="btn pull-right" title="Add New"');?></div>
</div>
<div class="row">
	<div class="span12">
		<?php
		$tmpl = array ( 'table_open'  => '<table class="table datatable table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('Code','Title','Type','Start','End','Status','Action');
		$datestring = "%D, %d %M %Y %H:%i:%s";
		foreach ($list as $row) {
			if($row->is_active){
				$status = '<i class="icon-check icon-large"></i>';
				$color  = 'btn-success';
			}else{
				$status = '<i class="icon-check-empty icon-large"></i>';
				$color  = 'btn-danger';
			}
			$this->table->add_row(
				$row->kuesioner_code,
				$row->title,
				$row->type_name,
				mdate($datestring,strtotime($row->start_time)),
				mdate($datestring,strtotime($row->end_time)),
				anchor($link_status.$row->kuesioner_id,$status,'class="btn '.$color.'" title="Change Status"'),
				'<div class="btn-group">'.
					anchor($link_detail.$row->kuesioner_id,'<i class="icon-list icon-large"></i>','class="btn" title="Detail"').
					anchor($link_edit.$row->kuesioner_id,'<i class="icon-pencil icon-large"></i>','class="btn" title="Edit"').
					anchor($link_delete.$row->kuesioner_id,'<i class="icon-trash icon-large"></i>','class="btn btn-warning" title="Delete"').
				'</div>'
			);
		}
		echo $this->table->generate();
		$this->table->clear(); 
		?>
	</div>
</div>