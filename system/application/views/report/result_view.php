<dl class="dl-horizontal">
  <dt>Survey</dt>
  <dd><?php echo $kuesioner->type_name ?></dd>
  <dt>Kuesioner</dt>
  <dd><?php echo '('.$kuesioner->kuesioner_code.') '. $kuesioner->title ?></dd>
  <dt>Start</dt>
  <dd><?php 
  	echo date('d-m-Y H:i:s',strtotime($kuesioner->start_time));
  ?></dd>
  <dt>End</dt>
  <dd><?php echo date('d-m-Y H:i:s',strtotime($kuesioner->end_time)) ; ?></dd>

</dl>

<hr>
<h2>Preview</h2>
<div class="row" style="margin-bottom:10px">
  <div class="span12">
    <div class="btn-group pull-right">
    <?php
      echo anchor($link_back, '<i class="icon-arrow-left"></i>', 'class="btn" title="Back"');
      echo anchor($link_export, '<i class="icon-download"></i>', 'class="btn" title="Export to Excel"');
    ?>
    </div>
  </div>
</div>
<div class="row">
	<div class="span12">
	<table class="table table-stripted table-hover datatable">
		<thead>
      <tr>
        <th>Resp.ID</th><th>Work Status</th><th>Chief Status</th><th>Layer / Group</th><th>Unit</th>
        <?php
          // foreach ($question as $row) {
          //   echo '<th>'.$row->question_code.'</td>';
          // }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
        $arr_status = array(
          '01' => 'Permanent',
          '02' => 'Contract',
          '03' => 'Probation',
          '04' => 'Trainee',
          '05' => 'Expatriat <=183',
          '06' => 'Expatriat >183',
        );
        $arr_chief  = array('','Co-Chief','Chief');
        foreach ($responden as $row_1) {
          echo '<tr>';
          echo '<td>'.$row_1->responden_id.'</td>';
          echo '<td>'.$arr_status[$row_1->status_flag].'</td>';
          echo '<td>'.$arr_chief[$row_1->chief_status].'</td>';
          echo '<td>'.$row_1->esg_text.'</td>';
          echo '<td>'.$row_1->unit_name.'</td>';
          // foreach ($question as $row_2) {
          //   echo '<td>'.$answer[$row_1->responden_id][$row_2->question_id].'</td>';
          // }
          echo '</tr>';
        }
      ?>
    </tbody>
	</table>
	</div>
</div>
<hr>
