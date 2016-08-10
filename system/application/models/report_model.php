<?php
class report_model extends Model{
	function __construct(){
		parent::__construct();
    $this->survey = $this->load->database('survey',TRUE);

	}
	public function count_responden($kuesioner_id=0)
	{
		$query = "SELECT COUNT(*) as val FROM GES_T_responden WHERE kuesioner_id=$kuesioner_id";
		return $this->survey->query($query)->row()->val;
	}
	public function count_responden_submited($kuesioner_id=0)
	{
		$query = "SELECT COUNT(*) as val FROM GES_T_responden WHERE kuesioner_id=$kuesioner_id AND is_submitted=1";
		return $this->survey->query($query)->row()->val;
	}

	public function get_responden_list($kuesioner_id=0,$start_time,$end_time,$unit_id=0,$work_sta=array(),$esg=array(),$gender=2,$religion=array())
	{
		$query = "SELECT * FROM GES_T_responden WHERE is_submitted = 1 AND kuesioner_id = $kuesioner_id AND submitted_on >= '$start_time' AND submitted_on <= '$end_time'";
		if ($unit_id != 0) {
			$query .= " AND (unit_id = $unit_id OR (unit_id = '' AND div_id = $unit_id))";
		}
		if (count($work_sta)==1) {
			$query .= "AND status_flag = '".$work_sta[0]."'";
		} elseif (count($work_sta)>1) {
			$query .= "AND status_flag IN ('".$work_sta[0]."'";
			for ($i=1; $i < count($work_sta) ; $i++) {
				$query .= ",'". $work_sta[$i]."'";
			}
			$query .= ")";
		}

		if (count($esg)==1) {
			$query .= "AND esg = '".$esg[0]."'";
		} elseif (count($esg)>1) {
			$query .= "AND esg IN ('".$esg[0]."'";
			for ($i=1; $i < count($esg) ; $i++) {
				$query .= ",'". $esg[$i]."'";
			}
			$query .= ")";
		}

		if ($gender==0 OR $gender==1) {
			$query .= " AND gender = $gender";
		}

		if (count($religion)==1) {
			$query .= "AND religion = '".$religion[0]."'";
		} elseif (count($esg)>1) {
			$query .= "AND religion IN ('".$religion[0]."'";
			for ($i=1; $i < count($religion) ; $i++) {
				$query .= ",'". $religion[$i]."'";
			}
			$query .= ")";
		}
		$query .= " ORDER BY nik";
		return $this->survey->query($query)->result();
	}
	public function count_question($kuesioner_id=1,$var=0,$dim=0,$ind=0)
	{
		$query = "SELECT count(*) as val FROM GES_V_question_set WHERE is_active = 1 AND kuesioner_id = $kuesioner_id";

		if($var!=0){
			$query .= " AND variable_id = $var";
		}
		if($dim!=0){
			$query .= " AND dimension_id = $dim";
		}
		if($ind!=0){
			$query .= " AND indicator_id = $ind";
		}
		return $this->survey->query($query)->row()->val;
	}
	public function get_question_list($kuesioner_id=1,$var=0,$dim=0,$ind=0)
	{
		$query = "SELECT question_id, question_code, type FROM GES_V_question_set WHERE is_active = 1 AND kuesioner_id = $kuesioner_id";

		if($var!=0){
			$query .= " AND variable_id = $var";
		}
		if($dim!=0){
			$query .= " AND dimension_id = $dim";
		}
		if($ind!=0){
			$query .= " AND indicator_id = $ind";
		}
		$query .= "ORDER BY section_order , question_order";
		return $this->survey->query($query)->result();
	}
	public function count_unit($kuesioner_id=0)
	{
		$query = "SELECT count(distinct(unit_name)) as val FROM GES_V_answer WHERE kuesioner_id = $kuesioner_id GROUP BY unit_name";
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

	public function get_answer($kuesioner_id=0, $unit_id=0)
	{
		$query = "EXEC get_answer $kuesioner_id, $unit_id";
		return $this->db->query($query)->result();
	}

	public function get_div_list($kuesioner_id=0,$unit_id=0)
	{
		$query = "SELECT div_id,
								div_name,
								count(*) as num_responden
							FROM GES_T_responden
							WHERE unit_id = $unit_id AND
								kuesioner_id = $kuesioner_id AND
								is_submitted = 1
							GROUP BY div_id, div_name";
		return $this->db->query($query)->result();
	}
}
?>
