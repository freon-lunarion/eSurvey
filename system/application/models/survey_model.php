<?php
class Survey_model extends Model{
	function __construct(){
		parent::__construct();
    $this->survey = $this->load->database('survey',TRUE);

 	}
	public function get_type_list($is_active=2)
	{
		$query = "SELECT *, survey_type_name AS type_name FROM GES_M_survey_type";
		if ($is_active==0 or $is_active ==1) {
			$query .= " WHERE is_active = $is_active";
		}
		return $this->survey->query($query)->result();
	}

	public function get_type_row($survey_type_id=0)
	{
		$query = "SELECT *, survey_type_name AS type_name FROM GES_M_survey_type WHERE survey_type_id = $survey_type_id";
		return $this->survey->query($query)->row();
	}
	public function get_type_last()
	{
		$query = "SELECT TOP 1 * FROM GES_M_survey_type WHERE is_active = 1 ORDER BY survey_type_id DESC";
		return $this->survey->query($query)->row();
	}
	public function add_type($type_name='',$description='')
	{
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO GES_M_survey_type
           ([survey_type_name]
           ,[description]
           ,[insert_by]
           ,[insert_on]
           ,[update_by]
           ,[update_on]
           ,[is_active])
     VALUES
           ('$type_name'
           ,'$description'
           ,'$by'
           ,GETDATE()
           ,'$by'
           ,GETDATE()
           ,1)";
		echo $query;
		return $this->survey->query($query);
	}
	public function edit_type($type_id=0,$type_name='',$description='')
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_survey_type
					   SET [survey_type_name] = '$type_name'
					      ,[description] = '$description'
					      ,[update_by] = '$by'
					      ,[update_on] = GETDATE()
					 WHERE survey_type_id = $type_id";
		return $this->survey->query($query);
		

	}
	public function edit_type_status($type_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_survey_type
					   SET [update_by] = '$by'
					      ,[update_on] = GETDATE()
					      ,[is_active] = $status
					 WHERE survey_type_id = $type_id";
		return $this->survey->query($query);

	}
	/**
	 * [menghapus survey type]
	 * @param  integer $type_id [id survey type]
	 */
	public function del_type($type_id=0)
	{
		$query ="DELETE FROM GES_M_survey_type
      WHERE survey_type_id = $type_id";
		$this->survey->query($query);					   
	}

	/**
	 * [menarik daftar template skala yang ada]
	 * @param  integer $status [status 0 = hanya yg tdk aktif; 1 = hanya yg aktif; 2 = semua]
	 * @return [type]          [banyak record]
	 */
	public function get_scale_list($status = 2)
	{
		$query = "SELECT * FROM GES_M_scale";
		if ($status == 0 OR $status == 1) {
			$query .= " WHERE is_active = $status";
		}
		return $this->survey->query($query)->result();
	}

	/**
	 * [mendapatkan detail dari satu record template skala]
	 * @param  integer $scale_id [id dari template skala]
	 * @return [type]            [satu record]
	 */
	public function get_scale_row($scale_id=0)
	{
		$query = "SELECT * FROM GES_M_scale WHERE scale_id = $scale_id";
		return $this->survey->query($query)->row();

	}
	/**
	 * [menambahkan template skala]
	 * @param integer $min_val      [nilai minimum]
	 * @param integer $max_val      [nilai maksimum]
	 * @param string  $min_text     [ket. untuk nilai minimum]
	 * @param string  $max_text     [ket. unutk nilai maksimum]
	 * @param boolean $abstain_flag [TRUE = responden dapat abstain/tidak tahu; FALSE = tidak dapat abstain/tidak tahu ]
	 */
	public function add_scale($scale_name='',$min_val=0, $max_val=0, $min_text='', $max_text='', $abstain_flag = FALSE)
	{
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO [eSurvey].[dbo].[GES_M_scale]
           ([scale_name]
           ,[min_val]
           ,[max_val]
           ,[min_text]
           ,[max_text]
           ,[insert_by]
           ,[insert_on]
           ,[update_by]
           ,[update_on]
           ,[abstain_flag]
           ,[is_active])
     VALUES
           ('$scale_name'
           ,$min_val
           ,$max_val
           ,'$min_text'
           ,'$max_text'
           ,'$by'
           ,GETDATE()
           ,'$by'
           ,GETDATE()
           ,$abstain_flag
           ,1)";
		$this->survey->query($query);
	}
	/**
	 * [edit template skala yang ada]
	 * @param  integer $scale_id     [id skala]
	 * @param string  $scale_name    [name skala]
	 * @param integer $min_val      [nilai minimum]
	 * @param integer $max_val      [nilai maksimum]
	 * @param string  $min_text     [ket. untuk nilai minimum]
	 * @param string  $max_text     [ket. unutk nilai maksimum]
	 * @param boolean $abstain_flag [TRUE = responden dapat abstain/tidak tahu; FALSE = tidak dapat abstain/tidak tahu ]
	 */
	public function edit_scale($scale_id = 0, $scale_name='', $min_val=0, $max_val=0, $min_text='', $max_text='', $abstain_flag = FALSE)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE [eSurvey].[dbo].[GES_M_scale]
		   SET [min_val] = $min_val
		      ,[max_val] = $max_val
		      ,[min_text] = '$min_text'
		      ,[max_text] = '$max_text'
		      ,[update_by] = '$by'
		      ,[update_on] = GETDATE()
		      ,[abstain_flag] = $abstain_flag
		 WHERE scale_id = $scale_id";
		$this->survey->query($query);
	}

	/**
	 * [edit template status skala ]
	 * @param  integer $scale_id [id skala]
	 * @param  boolean $status   [status]
	 */
	public function edit_scale_status($scale_id = 0, $status = TRUE)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE [eSurvey].[dbo].[GES_M_scale]
		   SET [update_by] = '$by'
		      ,[update_on] = GETDATE()
		      ,[is_active] = $status
		 WHERE scale_id = $scale_id";
		$this->survey->query($query);
	}
}
?>