<dl class="dl-horizontal">
  <dt>Survey Type</dt>
  <dd><?php echo $old->survey_type_name; ?></dd>
	<dt>Question Type</dt>
  <dd>Scale</dd>
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
  <dt>Min-Max Value</dt>
  <dd><?php echo $old->min_val .' - '. $old->max_val .' ('.$old->min_text.' / '.$old->max_text.')'; ?></dd>
</dl>