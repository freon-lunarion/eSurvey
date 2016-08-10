<div class="row">
	<div class="span12">
		<?php
		$tmpl = array ( 'table_open'  => '<table class="table datatable table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_heading('Name','Description','Action');
		foreach ($list as $row) {
		
			$this->table->add_row($row->type_name,$row->description,anchor($link_detail.$row->survey_type_id,'<i class="icon-list icon-large"></i>','class="btn" title="Detail"'));
		}
		echo $this->table->generate();
		$this->table->clear(); 
		?>
	</div>
</div>