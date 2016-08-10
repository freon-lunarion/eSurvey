<dl class="dl-horizontal">
  <dt>Survey Type</dt>
  <dd><?php echo $old->survey_type_name; ?></dd>
	<dt>Question Type</dt>
  <dd>Multiple Choice</dd>
  <dt>Question</dt>
  <dd><?php echo $old->question_text; ?></dd>
  <dt>Variable</dt>
  <dd><?php echo is_null($old->variable_text)?'-':$old->variable_text; ?></dd>
	<dt>Dimension</dt>
  <dd><?php echo is_null($old->dimension_text)?'-':$old->dimension_text; ?></dd>
  <dt>Indicator</dt>
  <dd><?php echo is_null($old->indicator_text)?'-':$old->indicator_text; ?></dd>
  <dt>Abstain Able</dt>
  <dd><?php 
	  if($old->abstain_flag){
	  	$status = '<i class="icon-ok"></i>';
	  }else{
	  	$status = '<i class="icon-remove"></i>';
	  }
	  echo $status; 
  ?></dd>
  <dt>Option</dt>
  <dd>
  	<ul>
  	<?php
  		foreach ($option_list as $row) {
  			echo '<li>'.$row->option_text.'</li>';
  		}
  	?>
  	</ul>
  </dd>
</dl>