<?php
class Question_model extends Model{
	function __construct(){
		parent::__construct();
    $this->survey = $this->load->database('survey',TRUE);
		
	}
	public function get_variable_list($survey_type=0,$is_active=2)
	{
		$query = "SELECT v.*,t.survey_type_name FROM GES_M_variable v,GES_M_survey_type t WHERE v.survey_type_id=t.survey_type_id AND v.survey_type_id = $survey_type ";
		if ($is_active==0 or $is_active==1){
			$query .= " AND v.is_active = $is_active";
		}
		return $this->survey->query($query)->result();
	}
	public function get_variable_row($variable_id=0)
	{
		$query = "SELECT v.*,t.survey_type_name AS type_name FROM GES_M_variable v,GES_M_survey_type t WHERE v.survey_type_id=t.survey_type_id AND v.variable_id=$variable_id";
		return $this->survey->query($query)->row();
	}
	public function get_variable_last()
	{
		$query = "SELECT TOP 1 * FROM GES_M_variable WHERE is_active=1 ORDER BY variable_id DESC";
		return $this->survey->query($query)->row();
	}
	public function add_variable($code='',$name='',$survey_type=0)
	{
		$by = $this->session->userdata('nik');
		$query ="INSERT INTO GES_M_variable
					 ([variable_code]
					 ,[variable_text]
					 ,[survey_type_id]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active])
		 VALUES
					 ('$code'
					 ,'$name'
					 ,$survey_type
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1)";
		return $this->survey->query($query);
	}
	public function edit_variable($variable_id = 0,$code='',$name='')
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_variable
	 SET [variable_code] = '$code'
			,[variable_text] = '$name'
			,[update_by] = '$by'
			,[update_on] = GETDATE()
 WHERE variable_id=$variable_id";
		return $this->survey->query($query);

	}
	public function edit_variable_status($variable_id = 0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_variable
	 SET [update_by] = $by
			,[update_on] = GETDATE()
			,[is_active] = $status
 WHERE variable_id=$variable_id";
		return $this->survey->query($query);
	}
	public function del_variable($variable_id = 0)
	{
		$query = "DELETE FROM GES_M_variable
			WHERE variable_id = $variable_id";
		return $this->survey->query($query);
	}
	//dimension
	public function get_dimension_list($variable_id=0, $is_active=2)
	{
		$query = "SELECT d.*,v.variable_text FROM GES_M_dimension d, GES_M_variable v  WHERE d.variable_id=v.variable_id AND d.variable_id = $variable_id";
		if ($is_active == 0 or $is_active == 1){
			$query .= " AND d.is_active = $is_active";
		}
		return $this->survey->query($query)->result();
	}

	public function get_dimension_row($dimension_id=0)
	{
		$query = "SELECT d.*,v.variable_text,v.variable_code, v.survey_type_id, t.survey_type_name AS type_name FROM GES_M_dimension d, GES_M_variable v, GES_M_survey_type t  WHERE v.survey_type_id=t.survey_type_id AND d.variable_id=v.variable_id AND d.dimension_id = $dimension_id
		";
		return $this->survey->query($query)->row();
	}

	public function get_dimension_last()
	{
		$query = "SELECT TOP 1 * FROM GES_M_dimension WHERE is_active = 1 ORDER BY dimension_id DESC";
		return $this->survey->query($query)->row();
	}
	public function add_dimension($code='',$name='',$variable_id=0)
	{
		$by = $this->session->userdata('nik');
		$query ="INSERT INTO GES_M_dimension
					 ([dimension_code]
					 ,[dimension_text]
					 ,[variable_id]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active])
		 VALUES
					 ('$code'
					 ,'$name'
					 ,$variable_id
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1)";
		return $this->survey->query($query);
	}
	public function edit_dimension($dimension_id=0,$code='',$name='')
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_dimension
					 SET [dimension_code] = '$code'
							,[dimension_text] = '$name'
							,[update_by] = '$by'
							,[update_on] = GETDATE()
				 WHERE dimension_id = $dimension_id";
		return $this->survey->query($query);
	}
	public function edit_dimension_status($dimension_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_dimension
					 SET [update_by] = '$by'
							,[update_on] = GETDATE()
							,[is_active] = $status
				 WHERE dimension_id = $dimension_id";
		return $this->survey->query($query);
	}
	public function del_dimension($dimension_id=0)
	{
		$query = "DELETE FROM GES_M_dimension]
			WHERE dimension_id=$dimension_id";
		return $this->survey->query($query);
	}
	//indicator
	public function get_indicator_list($dimension_id=0, $is_active=2)
	{
		$query = "SELECT * FROM GES_V_category WHERE dimension_id = $dimension_id";
		if ($is_active == 0 or $is_active == 1){
			$query .= " AND is_active = $is_active";
		}
		return $this->survey->query($query)->result();
	}

	public function get_indicator_row($indicator_id=0)
	{
		$query = "SELECT * FROM GES_V_category WHERE indicator_id = $indicator_id
		";
		return $this->survey->query($query)->row();
	}

	public function get_indicator_last()
	{
		$query = "SELECT TOP 1 * FROM GES_M_indicator WHERE is_active = 1 ORDER BY indicator_id DESC";
		return $this->survey->query($query)->row();
	}
	public function add_indicator($code='',$name='',$dimension_id=0)
	{
		$by = $this->session->userdata('nik');
		$query ="INSERT INTO GES_M_indicator
					 ([indicator_code]
					 ,[indicator_text]
					 ,[dimension_id]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active])
		 VALUES
					 ('$code'
					 ,'$name'
					 ,$dimension_id
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1)";
		return $this->survey->query($query);
	}
	public function edit_indicator($indicator_id=0,$code='',$name='')
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_indicator
					 SET [indicator_code] = '$code'
							,[indicator_text] = '$name'
							,[update_by] = '$by'
							,[update_on] = GETDATE()
				 WHERE indicator_id = $indicator_id";
		return $this->survey->query($query);
	}
	public function edit_indicator_status($indicator_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_indicator
					 SET [update_by] = '$by'
							,[update_on] = GETDATE()
							,[is_active] = $status
				 WHERE indicator_id = $indicator_id";
		return $this->survey->query($query);
	}
	public function del_indicator($indicator_id=0)
	{
		$query = "DELETE FROM GES_M_indicator]
			WHERE indicator_id=$indicator_id";
		return $this->survey->query($query);
	}
	// question bank
	public function get_bank_list($survey_type=0,$is_active = 2)
	{
		$query = "SELECT * FROM GES_V_question_bank WHERE survey_type_id = $survey_type";
		if ($is_active == 0 or $is_active == 1) {
			$query .= " AND is_active=$is_active";
		}
		return $this->survey->query($query)->result();
	}
	public function get_bank_row($question_id=0)
	{
		$query = "SELECT *,survey_type_name AS type_name FROM GES_V_question_bank WHERE question_id = $question_id";
		return $this->survey->query($query)->row();
	}
	public function get_bank_last()
	{
		$query = "SELECT TOP 1 * FROM GES_V_question_bank WHERE is_active =1 ORDER BY question_id DESC";
		return $this->survey->query($query)->row();
	}
	public function add_bank($code='',$text='',$type=0,$survey_type=0,$variable=0,$dimension=0,$indicator=0,$abstain=0)
	{
		if ($abstain==''){
			$abstain = 0 ;
		}
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO GES_M_question
					 ([question_code]
					 ,[question_text]
					 ,[type]
					 ,[survey_type_id]
					 ,[variable_id]
					 ,[dimension_id]
					 ,[indicator_id]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active]
					 ,[abstain_flag])
		 VALUES
					 ('$code'
					 ,'$text'
					 ,$type
					 ,$survey_type";

			if($variable==0){
				$query .= ",NULL";
			}else{
				$query .= ",$variable";
			}			 
			
			if($dimension==0){
				$query .= ",NULL";
			}else{
				$query .= ",$dimension";
			}
			
			if($indicator==0){
				$query .= ",NULL";
			}else{
				$query .= ",$indicator";
			}
			$query .=",'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1,$abstain)";
		return $this->survey->query($query);
	}
	public function add_scale($code='',$text='',$survey_type=0,$variable=0,$dimension=0,$indicator=0,$min_val=1,$max_val=5,$min_text='',$max_text='',$abstain=0)
	{
		if ($abstain==''){
			$abstain = 0 ;
		}
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO GES_M_question
					 ([question_code]
					 ,[question_text]
					 ,[type]
					 ,[survey_type_id]
					 ,[variable_id]
					 ,[dimension_id]
					 ,[indicator_id]
					 ,[min_val]
					 ,[max_val]
					 ,[min_text]
					 ,[max_text]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active]
					 ,[abstain_flag])
		 VALUES
					 ('$code'
					 ,'$text'
					 ,1
					 ,$survey_type";
		if($variable==0){
			$query .= ",NULL";
		}else{
			$query .= ",$variable";
		}			 
		
		if($dimension==0){
			$query .= ",NULL";
		}else{
			$query .= ",$dimension";
		}
		
		if($indicator==0){
			$query .= ",NULL";
		}else{
			$query .= ",$indicator";
		}

	  $query .=",$min_val
					 ,$max_val
					 ,'$min_text'
					 ,'$max_text'
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1
					 ,$abstain)";
		return $this->survey->query($query);
	}
	public function add_checkbox($code='',$text='',$survey_type=0,$variable=0,$dimension=0,$indicator=0,$min_val=1,$max_val=5,$min_text='',$max_text='',$abstain=0)
	{
		if ($abstain==''){
			$abstain = 0 ;
		}
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO GES_M_question
					 ([question_code]
					 ,[question_text]
					 ,[type]
					 ,[survey_type_id]
					 ,[variable_id]
					 ,[dimension_id]
					 ,[indicator_id]
					 ,[min_val]
					 ,[max_val]
					 ,[min_text]
					 ,[max_text]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active]
					 ,[abstain_flag])
		 VALUES
					 ('$code'
					 ,'$text'
					 ,4
					 ,$survey_type";
		if($variable==0){
			$query .= ",NULL";
		}else{
			$query .= ",$variable";
		}			 
		
		if($dimension==0){
			$query .= ",NULL";
		}else{
			$query .= ",$dimension";
		}
		
		if($indicator==0){
			$query .= ",NULL";
		}else{
			$query .= ",$indicator";
		}

	  $query .=",$min_val
					 ,$max_val
					 ,'$min_text'
					 ,'$max_text'
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1
					 ,$abstain)";
		return $this->survey->query($query);
	}
	public function edit_bank($question_id=0,$code='',$text='',$variable=0,$dimension=0,$indicator=0,$abstain=0)
	{
		if ($abstain==''){
			$abstain = 0 ;
		}
		$by = $this->session->userdata('nik');
		$query="UPDATE GES_M_question
   SET [question_code] = '$code'
      ,[question_text] = '$text'
      ,[abstain_flag] = $abstain";
    if($variable==0){
    	$query .= ",[variable_id] = NULL";
    }else{
    	$query .= ",[variable_id] = $variable";
    }
		if($dimension==0){
    	$query .= ",[dimension_id] = NULL";
    }else{
    	$query .= ",[dimension_id] = $dimension";
    }
    if($indicator==0){
    	$query .= ",[indicator_id] = NULL";
    }else{
    	$query .= ",[indicator_id] = $indicator";
    }
    $query .= ",[update_by] = '$by'
      ,[update_on] = GETDATE()
 WHERE question_id=$question_id";
		return $this->survey->query($query);
		
	}
	public function edit_scale($question_id=0,$code='',$text='',$variable=0,$dimension=0,$indicator=0,$min_val=1,$max_val=5,$min_text='',$max_text='',$abstain=0)
	{
		if ($abstain==''){
			$abstain = 0 ;
		}
		$by = $this->session->userdata('nik');
		$query="UPDATE GES_M_question
   SET [question_code] = '$code'
      ,[question_text] = '$text'
      ,[abstain_flag] = $abstain";
      if($variable==0){
	    	$query .= ",[variable_id] = NULL";
	    }else{
	    	$query .= ",[variable_id] = $variable";
	    }
			if($dimension==0){
	    	$query .= ",[dimension_id] = NULL";
	    }else{
	    	$query .= ",[dimension_id] = $dimension";
	    }
	    if($indicator==0){
	    	$query .= ",[indicator_id] = NULL";
	    }else{
	    	$query .= ",[indicator_id] = $indicator";
	    }
    $query .= ",[min_val] = $min_val
      ,[max_val] = $max_val
      ,[min_text] = '$min_text'
      ,[max_text] = '$max_text'
      ,[update_by] = '$by'
      ,[update_on] = GETDATE()
 WHERE question_id=$question_id";
		return $this->survey->query($query);
		
	}
	public function edit_checkbox($question_id=0,$code='',$text='',$variable=0,$dimension=0,$indicator=0,$min_val=1,$max_val=5,$min_text='',$max_text='',$abstain=0)
	{
		$this->edit_scale($question_id,$code,$text,$variable,$dimension,$indicator,$min_val,$max_val,$min_text,$max_text,$abstain);		
	}
	public function edit_bank_status($question_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query="UPDATE GES_M_question
   SET [update_by] = '$by'
      ,[update_on] = GETDATE()
      ,[is_active] = $status
 WHERE question_id=$question_id";
		return $this->survey->query($query);
		
	}
	public function del_bank($question_id=0)
	{
		$query ="DELETE FROM GES_M_question_option
      WHERE question_id = $question_id";
    $this->survey->query($query);
		echo $query ="DELETE FROM GES_M_question
      WHERE question_id=$question_id";
    $this->survey->query($query);
	}
	public function get_option_list($question_id=0)
	{
		$query = "SELECT * FROM GES_M_question_option WHERE question_id=$question_id";
		return $this->survey->query($query)->result();
	}
	public function get_option_row($option_id=0)
	{
		$query = "SELECT * FROM GES_M_question_option WHERE option_id = $option_id";
		return $this->survey->query($query)->row();
	}
	public function add_option($question_id=0,$text='',$value=0)
	{
		$query = "INSERT INTO GES_M_question_option
           ([question_id]
           ,[option_text]
           ,[option_value])
     VALUES
           ($question_id
           ,'$text'
           ,$value)";
		return $this->survey->query($query);
	}
	public function edit_option($option_id=0,$text='',$value=0)
	{
		$query = "UPDATE GES_M_question_option
   SET [option_text] = '$text'
      ,[option_value] = $value
 WHERE option_id=$option_id";
		return $this->survey->query($query);
	}

	public function del_option($option_id=0)
	{
		$query = "DELETE FROM GES_M_question_option WHERE option_id = $option_id";
		return $this->survey->query($query);

	}
	
}
?>
