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
        <th>NIK</th><th>BU/GBU</th><th>Division</th><th>Department</th><th>Section</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($responden as $row_1) {
          echo '<tr>';
          echo '<td>'.$row_1->nik.'</td>';
          echo '<td>'.$row_1->unit_name.'</td>';
          echo '<td>'.$row_1->div_name.'</td>';
          echo '<td>'.$row_1->dept_name.'</td>';
          echo '<td>'.$row_1->sect_name.'</td>';

          echo '</tr>';
        }
      ?>
    </tbody>
	</table>
	</div>
</div>
<hr>
