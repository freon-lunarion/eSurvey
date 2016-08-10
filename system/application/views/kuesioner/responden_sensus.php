<h2>Sensus Responden</h2>
<?php 
	$tab = array(
		'sap'      => 'SAP',
		'non'   => 'nonSAP');
	echo nav_tab($tab);
	?>
	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="sap">
			<div id="" class="row">
				<div id="" class="span3" style="text-align:right">All Unit</div>
				<div id="" class="span9"><div id="swt_responden" class=" make-switch"><input type="checkbox" checked></div></div>
			</div>
			 
			<div id="div_all">
				<div id="" class="row" style="margin-bottom:5px">
					<div id="" class="span12"><?php echo anchor($link_req_edit.$detail->kuesioner_id, '<i class="icon-pencil"></i>', 'class="btn pull-right" title="Edit Requirement"');?></div>
				</div>
				<div id="" class="row">
					<div id="" class="span6">
						<h3>Length of Services</h3>
						<h4>Contract</h4>
						<dl class="dl-horizontal">
							<dt>Minimum</dt>
							<dd><?php echo $detail->c_min_y; ?> Years <?php echo $detail->c_min_m; ?> Months <?php echo $detail->c_min_d; ?> Days</dd>
							<dt>Maximum</dt>
							<dd><?php echo $detail->c_max_y; ?> Years <?php echo $detail->c_max_m; ?> Months <?php echo $detail->c_max_d; ?> Days</dd>
						</dl>
						<h4>Permanent</h4>
						<dl class="dl-horizontal">
							<dt>Minimum</dt>
							<dd><?php echo $detail->p_min_y; ?> Years <?php echo $detail->p_min_m; ?> Months <?php echo $detail->p_min_d; ?> Days</dd>
							<dt>Maximum</dt>
							<dd><?php echo $detail->p_max_y; ?> Years <?php echo $detail->p_max_m; ?> Months <?php echo $detail->p_max_d; ?> Days</dd>
						</dl>
					</div>
					<div id="" class="span6">
						<h3>Length of Position</h3>
						<dl class="dl-horizontal">
							<dt>Minimum</dt>
							<dd><?php echo $detail->post_min_y; ?> Years <?php echo $detail->post_min_m; ?> Months <?php echo $detail->post_min_d; ?> Days</dd>
							<dt>Maximum</dt>
							<dd><?php echo $detail->post_max_y; ?> Years <?php echo $detail->post_max_m; ?> Months <?php echo $detail->post_max_d; ?> Days</dd>
						</dl>
					</div>
				</div>
			</div>
			<div id="div_unit">
				<div id="" class="row" style="margin-bottom:5px;">
					<div id="" class="span12"><?php echo anchor($link_unit_add.$detail->kuesioner_id, '<i class="icon-plus"></i>', 'class="btn pull-right" title="Add Unit"');?></div>
				</div>
				<div id="" class="row">
					<div id="" class="span12">
						<table id="" class="table datatable" >
							<thead><tr><th>Unit ID</th><th>Unit Name</th><th>Status</th><th>Action</th></tr></thead>
							<tbody>
								<?php
									foreach ($unit_list as $row) {
										if($row->is_active){
											$status = '<i class="icon-check icon-large"></i>';
											$color  = 'btn-success';
										}else{
											$status = '<i class="icon-check-empty icon-large"></i>';
											$color  = 'btn-danger';

										}
										echo '<tr>';
										echo '<td>'.$row->org_id.'</td>';
										echo '<td>'.$row->org_name.'</td>';
										echo '<td>'.anchor($link_unit_status.$row->res_un_id, $status, 'class="btn '.$color.'" title="status"').'</td>';
										echo '<td><div class="btn-group">';
										echo anchor($link_unit_edit.$row->res_un_id, '<i class="icon-pencil icon-large"></i>', 'class="btn" title="Edit"');
										echo ' '.anchor($link_unit_delete.$row->res_un_id, '<i class="icon-trash icon-large"></i>', 'class="btn" title="Delete"');

										echo '</div></td>';

										echo '</tr>';
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--end of  tab-pane-->
		<div class="tab-pane fade" id="non">
			<div id="" class="row">
					<div id="" class="span12">
						<table id="" class="table datatable" >
							<thead><tr><th>Name</th><th>Birthdate</th><th>Unit</th><th>Position</th><th>Status</th><th>Join Date</th><th>Action</th></tr></thead>
							<tbody>
								<?php

								?>
							</tbody>
						</table>
					</div>
				</div>
		</div><!--end of  tab-pane-->
	</div><!--end of  tab-content-->