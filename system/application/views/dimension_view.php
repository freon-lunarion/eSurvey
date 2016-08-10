<div class="row" style="margin-bottom:10px">
	<div class="span12"><div class="btn-group pull-right"><?php echo anchor($link_add,'<i class="icon-plus"></i> Single','class="btn " title="Add Single"');?><?php echo anchor($link_multi,'<i class="icon-plus"></i> Multi','class="btn " title="Add Multi"');?></div></div>
</div>
<div class="row">
	<div class="span12">
		<?php
		$tmpl = array ( 'table_open'  => '<table class="table datatable table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('Code','Name','Status','Action');
		foreach ($list as $row) {
			if($row->is_active){
				$status = '<i class="icon-check icon-large"></i>';
				$color  = 'btn-success';
			}else{
				$status = '<i class="icon-check-empty icon-large"></i>';
				$color  = 'btn-danger';
			}
			$this->table->add_row($row->dimension_code,$row->dimension_text,anchor($link_status.$row->dimension_id,$status,'class="btn '.$color.'" title="Change Status"'),'<div class="btn-group">'.anchor($link_detail.$row->dimension_id,'<i class="icon-list icon-large"></i>','class="btn" title="Detail"').anchor($link_edit.$row->dimension_id,'<i class="icon-pencil icon-large"></i>','class="btn" title="Edit"').'</div>');
		}
		echo $this->table->generate();
		$this->table->clear(); 
		?>
	</div>
</div>