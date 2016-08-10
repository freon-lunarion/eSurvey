<?php
class trans_model extends Model{
	function __construct(){
		parent::__construct();
    $this->survey = $this->load->database('survey',TRUE);

	}
	public function get_org($kuesioner_id=0,$org_id='')
	{
		$query = "SELECT TOP 1 [responden_unit_id]
      ,[kuesioner_id]
      ,[org_id]
      ,[org_name]
      ,[contract_active] AS c_active
      ,[contract_min_years] AS c_min_y
      ,[contract_min_months] AS c_min_m
      ,[contract_min_days] AS c_min_d
      ,[contract_max_years] AS c_max_y
      ,[contract_max_months] AS c_max_m
      ,[contract_max_days] AS c_max_d
      ,[permanent_active] AS p_active
      ,[permanent_min_years] AS p_min_y
      ,[permanent_min_months] AS p_min_m
      ,[permanent_min_days] AS p_min_d
      ,[permanent_max_years] AS p_max_y
      ,[permanent_max_months] AS p_max_m
      ,[permanent_max_days] AS p_max_d
      ,[position_min_years] AS post_min_y
      ,[position_min_months] AS post_min_m
      ,[position_min_days] AS post_min_d
      ,[position_max_years] AS post_max_y
      ,[position_max_months] AS post_max_m
      ,[position_max_days] AS post_max_d
      ,[insert_by]
      ,[insert_on]
      ,[update_by]
      ,[update_on]
      ,[is_active]
  		FROM GES_M_responden_unit WHERE kuesioner_id=$kuesioner_id AND org_id = '$org_id' AND is_active=1 ORDER BY responden_unit_id DESC";
		return $this->survey->query($query)->row();
	}
	public function get_section($kuesioner_id=0,$status=2,$target=0)
	{
		$query = "SELECT * FROM GES_V_question_set WHERE kuesioner_id = $kuesioner_id ";
		if ($status == 0 OR $status == 1){
			$query .= " is_active=$status";
		}
		$query .= " ORDER BY order asc";
		$list  = $this->survey->query($query)->result();
		$count = 0;
		foreach ($list as $row) {
			if ($count == $target){
				$result = $row;
				break;
			}else{
				$count++;
			}
		}
		return $result;
	}
	public function get_all_question_list($kuesioner_id=0,$is_active = 2)
	{
		$query = "SELECT * FROM GES_V_question_set WHERE kuesioner_id = $kuesioner_id ";
		if ($is_active == 0 OR $is_active == 1) {
			$query .= " AND is_active=$is_active ";
		}
		$query .= " ORDER BY section_order ASC , question_order ASC";
		return $this->survey->query($query)->result();
	}
	public function count_answer($responden_id=0,$question_id=0)
	{
		$query = "SELECT count(*) as val FROM GES_T_answer WHERE responden_id = $responden_id AND question_id = $question_id";
		return $this->survey->query($query)->row()->val;
	}
	public function get_answer_row($responden_id=0,$question_id=0)
	{
		$query = "SELECT * FROM GES_T_answer WHERE responden_id = $responden_id AND question_id = $question_id";
		return $this->survey->query($query)->row();
	}
	public function get_answer_list($responden_id=0,$question_id=0)
	{
		$query = "SELECT * FROM GES_T_answer WHERE responden_id = $responden_id AND question_id = $question_id";
		return $this->survey->query($query)->result();
	}
	public function add_answer($responden_id=0,$question_id=0,$value='',$long_value='')
	{
		$query = "INSERT INTO GES_T_answer
	           ([responden_id]
	           ,[question_id]
	           ,[value]
	           ,[value_text])
	     VALUES
	           ( $responden_id
	           , $question_id
	           ,'$value'
	           ,'$long_value')";
		$this->survey->query($query);
	}
	public function edit_answer_1($responden_id=0,$question_id=0,$value='',$value_text='')
	{
		$query = "UPDATE GES_T_answer
			   SET [value] = '$value',
			   [value_text] = '$value_text'
			 WHERE responden_id = $responden_id
			  AND question_id = $question_id";
		$this->survey->query($query);
	}
	public function edit_answer_2($answer_id=0,$value='',$value_text='')
	{
		$query = "UPDATE GES_T_answer
			   SET [value] = '$value',
			   [value_text] = '$value_text'
			 WHERE answer_id=$answer_id";
		$this->survey->query($query);
	}
	public function del_answer($answer_id=0)
	{
		$query = "DELETE FROM GES_T_answer WHERE answer_id = $answer_id";
		$this->survey->query($query);
	}
	public function del_answer_2($responden_id=0,$question_id=0)
	{
		$query = "DELETE FROM GES_T_answer WHERE responden_id = $responden_id AND question_id = $question_id";
		$this->survey->query($query);
	}
	public function update_status($responden_id=0,$status=1)
	{
		$query = "UPDATE GES_T_responden SET is_submitted = $status, submitted_on = GETDATE() WHERE responden_id = $responden_id";
		$this->survey->query($query);

		$query = "SELECT  TOP 1 * FROM GES_T_responden WHERE responden_id = $responden_id";
		$respo = $this->survey->query($query)->row();

		if ($respo->kuesioner_id == 8) {
			$portal = $this->load->database('portal',true);
			$query = "UPDATE esurvey_2016 SET is_submitted=$status WHERE nik = $respo->nik";
			$portal->query($query);

		}
	}
}
?>
