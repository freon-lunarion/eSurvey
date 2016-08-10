<dl class="dl-horizontal">
  <dt>Survey Type</dt>
  <dd><?php echo $old->survey_type_name; ?></dd>
	<dt>Question Type</dt>
  <dd>Open Answer</dd>
  <dt>Question</dt>
  <dd><?php echo $old->question_text; ?></dd>
  <dt>Variable</dt>
  <dd><?php echo is_null($old->variable_text)?'-':$old->variable_text; ?></dd>
	<dt>Dimension</dt>
  <dd><?php echo is_null($old->dimension_text)?'-':$old->dimension_text; ?></dd>
  <dt>Indicator</dt>
  <dd><?php echo is_null($old->indicator_text)?'-':$old->indicator_text; ?></dd>
</dl>