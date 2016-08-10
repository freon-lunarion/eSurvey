<?php
class Responden_model extends Model{
	function __construct(){
		parent::__construct();
		$this->survey = $this->load->database('survey',TRUE);
    $this->portal = $this->load->database('portal',TRUE);

	}
	public function get_list($kuesioner_id=0,$is_submitted=2) //mencari list responden berdasarkan kuesioner dan status responden (sudah mengirimkan jawaban atau belum)
	{
		$query = "SELECT * FROM GES_T_responden WHERE kuesioner_id = $kuesioner_id";
		if ($is_submitted==0 OR $is_submitted==1){
			$query .= " AND is_submitted = $is_submitted";
		}
		return $this->survey->query($query)->result();
	}
	public function get_row($responden_id=0) //mencari data lengkap responden
	{
		$query = "SELECT * FROM GES_T_responden WHERE responden_id = $responden_id";
		return $this->survey->query($query)->row();
	}
	public function get_responden($kuesioner_id=0,$nik='',$position_id='nonSAP') //mencari data responden berdasarkan kuesioner dan nik
	{
    if ($position_id=='nonSAP'){
		  $query = "SELECT TOP 1 * FROM GES_T_responden WHERE kuesioner_id = $kuesioner_id AND nik = '$nik' ORDER BY responden_id DESC";
    }else{
      $query = "SELECT  TOP 1 * FROM GES_T_responden WHERE kuesioner_id = $kuesioner_id AND nik = '$nik' AND position_id = '$position_id' ORDER BY responden_id DESC";

    }
		return $this->survey->query($query)->row();
	}

  public function get_by_nik($nik='')
  {
    $query = "SELECT TOP 1 * FROM GES_T_responden WHERE nik = '$nik' ORDER BY responden_id DESC";
    return $this->survey->query($query)->row();
  }

	public function add($kuesioner_id=0,$nik='',$name='',$gender=0,$birthdate='',$birthplace='',$religion='',$join_date='',$permanent_date='0000-00-00',$status_flag='',$position_id='',$position_name='',$chief_status=0,$esg='',$esg_text='',$unit_id='',$unit_name='',$div_id='',$div_name='',$dept_id='',$dept_name='',$sect_id='',$sect_name='',$skip_count=0,$is_sap=1) //menambahkan data responden
	{
		if ($join_date == '0000-00-00' && $kuesioner_id == 8) {
			$join_date = '2016-06-06';
		}
		$query = "INSERT INTO GES_T_responden
           ([kuesioner_id]
           ,[nik]
           ,[name]
           ,[gender]
           ,[birthdate]
           ,[birthplace]
           ,[religion]
           ,[join_date]
           ,[permanent_date]
           ,[status_flag]
           ,[position_id]
           ,[position_name]
           ,[chief_status]
           ,[esg]
           ,[esg_text]
           ,[unit_id]
           ,[unit_name]
           ,[div_id]
           ,[div_name]
           ,[dept_id]
           ,[dept_name]
           ,[sect_id]
           ,[sect_name]
           ,[is_submitted]
           ,[submitted_on]
           ,[skip_count]
           ,[is_sap])
     VALUES
           ($kuesioner_id
           ,'$nik'
           ,'$name'
           ,$gender
           ,'$birthdate'
           ,'$birthplace'
           ,'$religion'
           ,'$join_date'";
    if($permanent_date=='0000-00-00'){
      $query .= ",NULL";
    }else{
      $query .= ",'$permanent_date'";
    }

    $query .= ",'$status_flag'
           ,'$position_id'
           ,'$position_name'
           , $chief_status
           , '$esg'
           ,'$esg_text'
           ,'$unit_id'
           ,'$unit_name'
           ,'$div_id'
           ,'$div_name'
           ,'$dept_id'
           ,'$dept_name'
           ,'$sect_id'
           ,'$sect_name'
           , 0
           , NULL
           , $skip_count
           , $is_sap)";
		$this->survey->query($query);
	}
  public function add_import($kuesioner_id=0,$nik='',$position_id='',$skip_count=0,$is_sap=1) //menambahkan data responden via import
  {
    $query = "INSERT INTO GES_T_responden
           ([kuesioner_id]
           ,[nik]
           ,[position_id]
           ,[skip_count]
           ,[is_sap]
           ,[is_submitted])
     VALUES
           ($kuesioner_id
           ,'$nik'
           ,'$position_id'
           , $skip_count
           , $is_sap
           , 0)";
    $this->survey->query($query);
  }
	public function edit_data($responden_id=0,$name='',$gender=NULL,$birthdate='',$birthplace='',$religion='',$join_date='',$permanent_date=NULL,$status_flag='',$position_id='',$position_name='',$chief_status=0,$esg='',$esg_text='',$unit_id='',$unit_name='',$div_id='',$div_name='',$dept_id='',$dept_name='',$sect_id='',$sect_name='')
	{
		if ($join_date == '0000-00-00') {
			$join_date = '2016-06-06';
		}
		$query = "UPDATE GES_T_responden
   SET [name] = '$name'
      ,[gender] = $gender
      ,[birthdate] = '$birthdate'
      ,[birthplace] = '$birthplace'
      ,[religion] = '$religion'
      ,[join_date] = '$join_date'
      ,[permanent_date] = '$permanent_date'
      ,[status_flag] ='$status_flag'
      ,[position_id] = '$position_id'
      ,[position_name] = '$position_name'
      ,[chief_status] = $chief_status
      ,[esg] = '$esg'
      ,[esg_text] = '$esg_text'
      ,[unit_id] = '$unit_id'
      ,[unit_name] = '$unit_name'
      ,[div_id] = '$div_id'
      ,[div_name] = '$div_name'
      ,[dept_id] = '$dept_id'
      ,[dept_name] = '$dept_name'
      ,[sect_id] = '$sect_id'
      ,[sect_name] = '$sect_name'
 		WHERE responden_id = $responden_id";
		$this->survey->query($query);
	}
	public function edit_count($responden_id=0,$new_value=0) // update kuota skip
	{
		$query = "UPDATE GES_T_responden
   SET [skip_count] = $new_value
		 WHERE responden_id = $responden_id";
		$this->survey->query($query);
		// khusus esurvey 2016
		$query = "SELECT nik FROM GES_T_responden WHERE kuesioner_id = 8 and responden_id = $responden_id ";
		$nik = $this->survey->query($query)->row()->nik;

		$query = "UPDATE esurvey_2016
			SET skip_count = $new_value
			WHERE nik = $nik";
		$this->portal->query($query);
	}
	public function edit_submit($responden_id=0) // edit status responden dengan status "submit"
	{
		$query = "UPDATE GES_T_responden
   SET [is_submitted] = 1
      ,[submitted_on] = GETDATE()
 		WHERE responden_id = $responden_id";
		$this->survey->query($query);
		// khusus esurvey 2016
		$query = "SELECT nik FROM GES_T_responden WHERE kuesioner_id = 8 and responden_id = $responden_id ";
		$nik = $this->survey->query($query)->row()->nik;

		$query = "UPDATE esurvey_2016
			SET is_submitted = 1
			WHERE nik = $nik";
		$this->portal->query($query);
	}
	public function del($responden_id=0) // hapus data responden
	{
		$query = "DELETE FROM GES_T_responden WHERE responden_id = $responden_id";
		$this->survey->query($query);
	}
}
?>
