<?php
echo form_open($process, 'class="form-horizontal"', $hidden);
echo '<legend>Terdapat lebih dari satu survey yang aktif saat ini, silahkan memilih salah satu survey dibawah ini</legend>';
foreach ($kuesioner_list as $row) {
  $data = array(
    'name'    => 'rd_kuesioner',
    'id'      => 'rd_kuesioner_'.$row->kuesioner_id,
    'value'   => $row->kuesioner_id,
    'checked' => false
    );
  echo control_group('', form_label(form_radio($data).$row->survey_name .' ('.$row->title .')', '', array('class'=>'radio')));
}
$button[0] = form_button(array('type'=>'submit','content'=>'Next','class'=>'btn btn-primary'));
echo form_action($button);
echo form_close();
?>