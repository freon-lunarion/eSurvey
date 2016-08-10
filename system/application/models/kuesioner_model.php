<?php
class Kuesioner_model extends Model{
	function __construct(){
		parent::__construct();
		$this->survey = $this->load->database('survey',TRUE);

	}

	/**
	 * [menampilkan daftar kuesioner yang ada]
	 * @param  integer $is_active [filter status : 0=non aktif; 1=aktif; 2=all]
	 * @return [type]             [banyak record]
	 */
	public function get_list($is_active=2)
	{
		$query = "SELECT k.*, s.survey_type_name as type_name FROM GES_M_kuesioner k, GES_M_survey_type s WHERE s.survey_type_id = k.survey_type_id";
		if ($is_active == 0 or $is_active == 1) {
			$query .= " AND k.is_active = $is_active";
		}
		return $this->survey->query($query)->result();
	}

	/**
	 * [menampilkan daftar kuesioner yang ada berdasarkan jenis survei]
	 * @param  integer $survey_type_id [id jenis survey]
	 * @return [type]                  [banyak record]
	 */
	public function get_type_list($survey_type_id=0)
	{
		$query = "SELECT k.* FROM GES_M_kuesioner k WHERE k.survey_type_id = $survey_type_id ";
		return $this->survey->query($query)->result();

	}

	/**
	 * [menampilkan keterangan kuesioner yang ada]
	 * @param  integer $kuesioner_id [id kuesioner]
	 * @return [type]                [satu record]
	 */
	public function get_row($kuesioner_id=0)
	{
		$query = "SELECT k.*,
			s.survey_type_name AS type_name,
			k.contract_min_years AS c_min_y,
			k.contract_min_months AS c_min_m,
			k.contract_min_days AS c_min_d,
			k.contract_max_years AS c_max_y,
			k.contract_max_months AS c_max_m,
			k.contract_max_days AS c_max_d,
			k.permanent_active as p_active,
			k.permanent_min_years AS p_min_y,
			k.permanent_min_months AS p_min_m,
			k.permanent_min_days AS p_min_d,
			k.permanent_max_years AS p_max_y,
			k.permanent_max_months AS p_max_m,
			k.permanent_max_days AS p_max_d,
			k.position_min_years AS post_min_y,
			k.position_min_months AS post_min_m,
			k.position_min_days AS post_min_d,
			k.position_max_years AS post_max_y,
			k.position_max_months AS post_max_m,
			k.position_max_days AS post_max_d
			FROM GES_M_kuesioner k,GES_M_survey_type s WHERE k.survey_type_id = s.survey_type_id AND k.kuesioner_id = $kuesioner_id";
		return $this->survey->query($query)->row();
	}
	public function get_last()
	{
		$query = "SELECT TOP 1 * FROM GES_M_kuesioner WHERE is_active = 1 ORDER BY kuesioner_id DESC";
		return $this->survey->query($query)->row();
	}

	/**
	 * [menghitung kuesioner yang tersedia ]
	 * @param  string $nik         [description]
	 * @param  string $position_id [description]
	 * @param  string $unit_id     [description]
	 * @return [type]              [jumlah kuesioner]
	 */
	public function count_active($nik='',$position_id='',$unit_id='')
	{
		$query = "SELECT COUNT(*) as val
			FROM GES_M_kuesioner
			WHERE is_active = 1
				AND start_time <= GETDATE()
				AND end_time >= GETDATE()";

		if ($nik != '' && $position_id != '') {
			$query .= " AND kuesioner_id NOT IN
				(SELECT kuesioner_id
					FROM GES_T_responden
					WHERE nik = '$nik'
						AND position_id = '$position_id'
						AND is_submitted = 1)";
		}

		if ($unit_id != '') {
			$query .= " AND
				(
					(method = 0
					AND is_all = 0
					AND kuesioner_id IN
						(SELECT kuesioner_id
							FROM GES_M_responden_unit
							WHERE  org_id = $unit_id)
					)
				OR
					(method = 1
					AND kuesioner_id IN
						(SELECT kuesioner_id
					FROM GES_T_responden
					WHERE nik = '$nik'
						AND position_id = '$position_id'
						AND is_submitted = 0)
					)
				)";
		}

		return $this->survey->query($query)->row()->val;
	}

	/**
	 * [menghitung kuesioner aktif yang sudah di submit oleh responden]
	 * @param  string $nik         [description]
	 * @param  string $position_id [description]
	 * @return [type]              [description]
	 */
	public function count_submitted ($nik='',$position_id='')
	{
		$query = "SELECT COUNT(*) as val
			FROM GES_M_kuesioner
			WHERE is_active = 1
				AND start_time <= GETDATE()
				AND end_time >= GETDATE()";
		if ($nik != '' && $position_id != '') {
			$query .= " AND kuesioner_id IN
				(SELECT kuesioner_id
					FROM GES_T_responden
					WHERE nik = '$nik'
						AND position_id = '$position_id'
						AND is_submitted = 1)";
		}
		return $this->survey->query($query)->row()->val;
	}

	/**
	 * [mendapatkan kuesioner yang aktif dan belum diisi oleh responden]
	 * @param  string $nik         [nomor induk karyawan]
	 * @param  string $position_id [id posisi]
	 * @param  string $unit_id     [unit id GBU/BU]
	 * @return [type]              [satu record]
	 */
	public function get_active_row($nik='',$position_id='',$unit_id='')
	{
		$query = "SELECT TOP 1 * FROM GES_M_kuesioner WHERE is_active = 1 AND start_time<= GETDATE() AND end_time >=GETDATE()";
		if ($nik != '' && $position_id != '') {
			$query .= " AND kuesioner_id NOT IN
				(SELECT kuesioner_id
					FROM GES_T_responden
					WHERE nik = '$nik'
						AND position_id = '$position_id'
						AND is_submitted = 1)";
		}

		if ($unit_id != '') {
			$query .= " AND
				(
					(method = 0
					AND is_all = 0
					AND kuesioner_id IN
						(SELECT kuesioner_id
							FROM GES_M_responden_unit
							WHERE  org_id = $unit_id)
					)
				OR
					(method = 1
					AND kuesioner_id IN
						(SELECT kuesioner_id
					FROM GES_T_responden
					WHERE nik = '$nik'
						AND position_id = '$position_id'
						AND is_submitted = 0)
					)
				)";
		}
		// echo $query;
		return $this->survey->query($query)->row();
	}

	/**
	 * [mendapatkan kuesioner yang aktif dan belum diisi oleh responden]
	 * @param  string $nik         [nomor induk karyawan]
	 * @param  string $position_id [ID posisi]
	 * @param  string $unit_id     [unit ID  GBU/BU]
	 * @return [type]              [banyak record]
	 */
	public function get_active_list($nik='',$position_id='',$unit_id='')
	{
		$query = "SELECT k.*, s.survey_type_name as survey_name FROM GES_M_kuesioner k, GES_M_survey_type s WHERE s.survey_type_id = k.survey_type_id AND k.is_active = 1 AND k.start_time<= GETDATE() AND k.end_time >=GETDATE()";

		if ($nik != '' && $position_id != '') {
			$query .= " AND k.kuesioner_id NOT IN ( SELECT kuesioner_id FROM GES_T_responden WHERE nik = '$nik' AND position_id = '$position_id' AND is_submitted = 1)";
		}
		if ($unit_id != '') {
			$query .= " AND
				(
					(k.method = 0
					AND k.is_all = 0
					AND k.kuesioner_id IN
						(SELECT kuesioner_id
							FROM GES_M_responden_unit
							WHERE  org_id = $unit_id)
					)
				OR
					(k.method = 1
					AND k.kuesioner_id IN
						(SELECT kuesioner_id
					FROM GES_T_responden
					WHERE nik = '$nik'
						AND position_id = '$position_id'
						AND is_submitted = 0)
					)
				)";
		}
		return $this->survey->query($query)->result();
	}

	/**
	 * [insert kuesioner ke DB]
	 * @param integer $survey_type    [jenis survey]
	 * @param string  $code           [kode survey]
	 * @param string  $title          [judul survey]
	 * @param string  $theme          [tema survey]
	 * @param string  $intro          [intro/pengantar]
	 * @param string  $start          [waktu mulai survei]
	 * @param string  $end            [waktu selesai survei]
	 * @param string  $skip_text      [teks untuk pilihan abstain]
	 * @param integer $skip_quota     [quota untuk melewati survei]
	 * @param string  $agreement_text [persetujuan user]
	 * @param integer $is_all         [survey (sensus) berlaku untuk semua kg: 1= ya 0 = tidak ]
	 * @param integer $method         [metode survei: 0=sensus, 1=sampling]
	 * @param string  $guide          [petunjuk survei]
	 * @param string  $term           [definisi penting/istilah dalam survei]
	 * @param string  $only_once      [TRUE = Setiap NIK hanya sekali mengisi kuesioner]
	 */
	public function add($survey_type=0,$code='',$title='',$theme='',$intro='',$start='2013-01-01',$end='2013-01-01',$skip_text='Skip',$skip_quota=0,$agreement_text='',$is_all=0,$method=0,$guide='',$term='')
	{
		$by = $this->session->userdata('nik');
		$query="INSERT INTO GES_M_kuesioner
					 ([survey_type_id]
					 ,[kuesioner_code]
					 ,[title]
					 ,[theme]
					 ,[introduction]
					 ,[start_time]
					 ,[end_time]
					 ,[abstain_text]
					 ,[skip_quota]
					 ,[agreement_text]
					 ,[contract_active]
					 ,[contract_min_years]
					 ,[contract_min_months]
					 ,[contract_min_days]
					 ,[contract_max_years]
					 ,[contract_max_months]
					 ,[contract_max_days]
					 ,[permanent_active]
					 ,[permanent_min_years]
					 ,[permanent_min_months]
					 ,[permanent_min_days]
					 ,[permanent_max_years]
					 ,[permanent_max_months]
					 ,[permanent_max_days]
					 ,[position_min_years]
					 ,[position_min_months]
					 ,[position_min_days]
					 ,[position_max_years]
					 ,[position_max_months]
					 ,[position_max_days]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active]
					 ,[is_all]
					 ,[method]
					 ,[guide]
					 ,[term])
		 VALUES
					 ($survey_type
					 ,'$code'
					 ,'$title'
					 ,'$theme'
					 ,'$intro'
					 ,'$start'
					 ,'$end'
					 ,'$skip_text'
					 ,$skip_quota
					 ,'$agreement_text'
					 ,0
					 ,0
					 ,0
					 ,0
					 ,99
					 ,11
					 ,29
					 ,0
					 ,0
					 ,0
					 ,0
					 ,99
					 ,11
					 ,29
					 ,0
					 ,0
					 ,0
					 ,99
					 ,11
					 ,29
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1
					 ,$is_all
					 ,$method
					 ,'$guide'
					 ,'$term')";
		return $this->survey->query($query);
	}

	/**
	 * [mengupdate keterangan survei]
	 * @param  integer $kuesioner_id   [id kuesioner]
	 * @param  string  $kuesioner_code [kode kuesioner]
	 * @param  string  $title          [judul kuesioner]
	 * @param  string  $theme          [tema survey]
	 * @param  string  $intro          [intro/pengantar survey]
	 * @param  string  $start          [waktu mulai survei]
	 * @param  string  $end            [waktu selesai survei]
	 * @param  string  $skip_text      [teks untuk abastain]
	 * @param  integer $skip_quota     [kesempatan untuk melewati survei]
	 * @param  string  $agreement_text [persetujuan user]
	 * @param  integer $method         [metode survei]
	 * @param  string  $guide          [petunjuk penggunaan survei]
	 * @param  string  $term           [istilah dalam survei]
	 * @return [type]                  [description]
	 */
	public function edit($kuesioner_id=0,$kuesioner_code='',$title='',$theme='',$intro='',$start='',$end='',$skip_text='',$skip_quota=0,$agreement_text='',$method=0,$guide='',$term='',$only_once=1)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_kuesioner
	 SET [kuesioner_code] = '$kuesioner_code'
			,[title] = '$title'
			,[theme] = '".trim($theme)."'
			,[introduction] = '".trim($intro)."'
			,[start_time] = '$start'
			,[end_time] = '$end'
			,[abstain_text] = '$skip_text'
			,[skip_quota] = $skip_quota
			,[agreement_text] = '$agreement_text'
			,[method] = $method
			,[guide] = '$guide'
			,[term] = '$term'
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE kuesioner_id = $kuesioner_id";
		$this->survey->query($query);
	}

	/**
	 * [edit_contract description]
	 * @param  integer $kuesioner_id [description]
	 * @param  integer $min_year     [description]
	 * @param  integer $min_month    [description]
	 * @param  integer $min_day      [description]
	 * @param  integer $max_year     [description]
	 * @param  integer $max_month    [description]
	 * @param  integer $max_day      [description]
	 * @return [type]                [description]
	 */
	public function edit_contract($kuesioner_id=0,$min_year=0,$min_month=0,$min_day=0,$max_year=0,$max_month=0,$max_day=0)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_kuesioner
	 SET [contract_min_years] = $min_year
			,[contract_min_months] = $min_month
			,[contract_min_days] = $min_day
			,[contract_max_years] = $max_year
			,[contract_max_months] = $max_month
			,[contract_max_days] = $max_day
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE kuesioner_id = $kuesioner_id";

		$this->survey->query($query);
	}
	public function edit_contract_status($kuesioner_id=0,$is_active=0)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_kuesioner
	 SET [contract_active] = $is_active
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE kuesioner_id = $kuesioner_id";

		$this->survey->query($query);
	}
	public function edit_permanent($kuesioner_id=0,$min_year=0,$min_month=0,$min_day=0,$max_year=0,$max_month=0,$max_day=0)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_kuesioner
	 SET [permanent_min_years] = $min_year
			,[permanent_min_months] = $min_month
			,[permanent_min_days] = $min_day
			,[permanent_max_years] = $max_year
			,[permanent_max_months] = $max_month
			,[permanent_max_days] = $max_day
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE kuesioner_id = $kuesioner_id";

		$this->survey->query($query);
	}
	public function edit_permanent_status($kuesioner_id=0,$is_active=0)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_kuesioner
	 SET [permanent_active] = $is_active
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE kuesioner_id = $kuesioner_id";

		$this->survey->query($query);
	}
	public function edit_position($kuesioner_id=0,$min_year=0,$min_month=0,$min_day=0,$max_year=0,$max_month=0,$max_day=0)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_kuesioner
	 SET [position_min_years] = $min_year
			,[position_min_months] = $min_month
			,[position_min_days] = $min_day
			,[position_max_years] = $max_year
			,[position_max_months] = $max_month
			,[position_max_days] = $max_day
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE kuesioner_id = $kuesioner_id";

		$this->survey->query($query);
	}
	public function edit_all_unit($kuesioner_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_kuesioner
	 SET [update_by] = '$by'
			,[update_on] = GETDATE()
			,[is_all] = $status
		WHERE kuesioner_id = $kuesioner_id";
		$this->survey->query($query);
	}
	public function edit_status($kuesioner_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_kuesioner
	 SET [update_by] = '$by'
			,[update_on] = GETDATE()
			,[is_active] = $status
		WHERE kuesioner_id = $kuesioner_id";
		$this->survey->query($query);
	}
	public function delete($kuesioner_id=0)
	{
		$query = "DELETE FROM GES_M_section WHERE kuesioner_id = $kuesioner_id";
		$this->survey->query($query);

		$query = "DELETE FROM GES_M_responden_unit WHERE kuesioner_id = $kuesioner_id";
		$this->survey->query($query);
		$query = "DELETE FROM GES_M_kuesioner WHERE kuesioner_id = $kuesioner_id";
		$this->survey->query($query);
	}
	// unit yg mengikuti kuesioner online
	public function check_unit($kuesioner_id=0,$unit_array=array())
	{
		$query = "SELECT COUNT(*) as val FROM GES_M_responden_unit WHERE is_active = 1 AND kuesioner_id=$kuesioner_id AND org_id IN (";

		foreach ($unit_array as $key => $value) {
			if($key == 0 ){
				$query .= "'$value'";
			}else{
				$query .= ", '$value'";
			}
		}
		$query .=")";
		$result = $this->survey->query($query)->row()->val;
		if ($result > 0) {
			return true;
		}else{
			return false;
		}
	}
	public function get_unit_list($kuesioner_id=0,$is_active=2)
	{
		$query = "SELECT *, responden_unit_id AS res_un_id FROM GES_M_responden_unit WHERE kuesioner_id = $kuesioner_id";
		if ($is_active == 0 or $is_active == 1) {
			$query .= " AND is_active=$is_active";
		}
		return $this->survey->query($query)->result();
	}

	public function get_unit_row($responden_unit_id=0)
	{
		$query = "SELECT k.*,
			k.contract_active as c_active,
			k.contract_min_years AS c_min_y,
			k.contract_min_months AS c_min_m,
			k.contract_min_days AS c_min_d,
			k.contract_max_years AS c_max_y,
			k.contract_max_months AS c_max_m,
			k.contract_max_days AS c_max_d,
			k.permanent_active as pe_active,
			k.permanent_min_years AS pe_min_y,
			k.permanent_min_months AS pe_min_m,
			k.permanent_min_days AS pe_min_d,
			k.permanent_max_years AS pe_max_y,
			k.permanent_max_months AS pe_max_m,
			k.permanent_max_days AS pe_max_d,
			k.position_min_years AS post_min_y,
			k.position_min_months AS post_min_m,
			k.position_min_days AS post_min_d,
			k.position_max_years AS post_max_y,
			k.position_max_months AS post_max_m,
			k.position_max_days AS post_max_d
		 FROM GES_M_responden_unit k WHERE responden_unit_id=$responden_unit_id";
		return $this->survey->query($query)->row();
	}
	public function add_unit($kuesioner_id=0,$org_id=0,$org_name='',$contract,$permanent,$position)
	{
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO GES_M_responden_unit
					 ([kuesioner_id]
					 ,[org_id]
					 ,[org_name]
					 ,[contract_active]
					 ,[contract_min_years]
					 ,[contract_min_months]
					 ,[contract_min_days]
					 ,[contract_max_years]
					 ,[contract_max_months]
					 ,[contract_max_days]
					 ,[permanent_active]
					 ,[permanent_min_years]
					 ,[permanent_min_months]
					 ,[permanent_min_days]
					 ,[permanent_max_years]
					 ,[permanent_max_months]
					 ,[permanent_max_days]
					 ,[position_min_years]
					 ,[position_min_months]
					 ,[position_min_days]
					 ,[position_max_years]
					 ,[position_max_months]
					 ,[position_max_days]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active])
		 VALUES
					 ($kuesioner_id
					 ,$org_id
					 ,'$org_name'
					 ,".$contract['is_active']."
					 ,".$contract['min_y']."
					 ,".$contract['min_m']."
					 ,".$contract['min_d']."
					 ,".$contract['max_y']."
					 ,".$contract['max_m']."
					 ,".$contract['max_d']."
					 ,".$permanent['is_active']."
					 ,".$permanent['min_y']."
					 ,".$permanent['min_m']."
					 ,".$permanent['min_d']."
					 ,".$permanent['max_y']."
					 ,".$permanent['max_m']."
					 ,".$permanent['max_d']."
					 ,".$position['min_y']."
					 ,".$position['min_m']."
					 ,".$position['min_d']."
					 ,".$position['max_y']."
					 ,".$position['max_m']."
					 ,".$position['max_d']."
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1)";
		$this->survey->query($query);
	}
	public function edit_unit($responden_unit_id=0,$org_id=0,$org_name='',$contract,$permanent,$position)
	{
		$by = $this->session->userdata('nik');
		$query ="UPDATE GES_M_responden_unit
	 SET [org_id] = $org_id
			,[org_name] = '$org_name'
			,[contract_active] = ".$contract['is_active']."
			,[contract_min_years] = ".$contract['min_y']."
			,[contract_min_months] = ".$contract['min_m']."
			,[contract_min_days] = ".$contract['min_d']."
			,[contract_max_years] = ".$contract['max_y']."
			,[contract_max_months] = ".$contract['max_m']."
			,[contract_max_days] = ".$contract['max_d']."
			,[permanent_active] = ".$permanent['is_active']."
			,[permanent_min_years] = ".$permanent['min_y']."
			,[permanent_min_months] = ".$permanent['min_m']."
			,[permanent_min_days] = ".$permanent['min_d']."
			,[permanent_max_years] = ".$permanent['max_y']."
			,[permanent_max_months] = ".$permanent['max_m']."
			,[permanent_max_days] = ".$permanent['max_d']."
			,[position_min_years] = ".$position['min_y']."
			,[position_min_months] = ".$position['min_m']."
			,[position_min_days] = ".$position['min_d']."
			,[position_max_years] = ".$position['max_y']."
			,[position_max_months] = ".$position['max_m']."
			,[position_max_days] = ".$position['max_d']."
			,[update_by] = '$by'
			,[update_on] = GETDATE()
			WHERE responden_unit_id = $responden_unit_id";
		$this->survey->query($query);
	}

	public function edit_unit_status($responden_unit_id=0,$status=1)
	{
		$db = $this->session->userdata('nik');
		$query ="UPDATE GES_M_responden_unit
	 SET [update_by] = '$by'
			,[update_on] = GETDATE()
			,[is_active] = $status
		WHERE responden_unit_id = $responden_unit_id";
		$this->survey->query($query);
	}
	public function del_unit($responden_unit_id=0)
	{
		$query ="DELETE FROM GES_M_responden_unit
			WHERE responden_unit_id = $responden_unit_id";
		$this->survey->query($query);
	}
	//section kuesioner , minimal ada satu untuk tiap kuesioner
	public function get_section_list($kuesioner_id=0,$is_active=2,$is_order=0)
	{
		$query = "SELECT * FROM GES_M_section WHERE kuesioner_id = $kuesioner_id";
		if ($is_active == 0 or $is_active == 1) {
			$query .= " AND is_active = $is_active";
		}
		if ($is_order) {
			$query .= " ORDER BY [order] ASC";
		}
		return $this->survey->query($query)->result();
	}
	public function get_section_row($section_id=0)
	{
		$query = "SELECT s.*, k.title as kuesioner_title, k.survey_type_id  FROM GES_M_section s,GES_M_kuesioner k WHERE s.kuesioner_id = k.kuesioner_id AND s.section_id = $section_id";
		return $this->survey->query($query)->row();
	}
	public function get_section_last()
	{
		$query = "SELECT TOP 1 * FROM GES_M_section WHERE is_active = 1 ORDER BY section_id DESC";
		return $this->survey->query($query)->row();
	}
	public function add_section($kuesioner_id=0,$section_name='',$order=1,$description='')
	{
		$by = $this->session->userdata('nik');
		$query ="INSERT INTO GES_M_section
					 ([kuesioner_id]
					 ,[section_name]
					 ,[order]
					 ,[description]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active])
		 VALUES
					 ($kuesioner_id
					 ,'$section_name'
					 ,$order
					 ,'$description'
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1)";
		$this->survey->query($query);
	}
	public function edit_section($section_id=0,$section_name='',$order=0,$description='')
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_section
	 SET [section_name] = '$section_name'
			,[order] = $order
			,[description] = '$description'
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE section_id = $section_id";
		$this->survey->query($query);
	}
	public function edit_section_status($section_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_section
	 SET [update_by] = '$by'
			,[update_on] = GETDATE()
			,[is_active] = $status
		WHERE section_id = $section_id";
		$this->survey->query($query);
	}

	public function del_section($section_id=0)
	{
		$query = "DELETE FROM GES_M_section
			WHERE section_id = $section_id";
		$this->survey->query($query);
	}
	//question set , mengatur pertanyaan yang muncul di kuesioner
	public function get_question_list($section_id =0,$is_active=2,$order=0)
	{
		$query = "SELECT * FROM GES_V_question_set WHERE section_id = $section_id";
		if ($is_active == 0 or $is_active == 1) {
			$query .= " AND is_active = $is_active";
		}
		if ($order==1){
			$query .= ' ORDER BY question_order asc , question_set_id asc';
		}
		return $this->survey->query($query)->result();
	}
	public function get_question_row($question_set_id=0)
	{
		$query = "SELECT * FROM GES_V_question_set WHERE question_set_id = $question_set_id";
		return $this->survey->query($query)->row();
	}
	public function add_question($section_id=0,$question_id=0,$order=1)
	{
		$by = $this->session->userdata('nik');
		$query = "INSERT INTO GES_M_question_set
					 ([section_id]
					 ,[question_id]
					 ,[order]
					 ,[insert_by]
					 ,[insert_on]
					 ,[update_by]
					 ,[update_on]
					 ,[is_active])
		 VALUES
					 ($section_id
					 ,$question_id
					 ,$order
					 ,'$by'
					 ,GETDATE()
					 ,'$by'
					 ,GETDATE()
					 ,1)";
		$this->survey->query($query);
	}
	public function edit_question($question_set_id=0,$order=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_question_set
	 SET [order] = $order
			,[update_by] = '$by'
			,[update_on] = GETDATE()
		WHERE question_set_id = $question_set_id";
		$this->survey->query($query);
	}
	public function edit_question_status($question_set_id=0,$status=1)
	{
		$by = $this->session->userdata('nik');
		$query = "UPDATE GES_M_question_set
	 SET [update_by] = '$by'
			,[update_on] = GETDATE()
			,[is_active] = $status
		WHERE question_set_id = $question_set_id";
		$this->survey->query($query);
	}
	public function del_question($question_set_id=0)
	{
		$query = "DELETE FROM GES_M_question_set
			WHERE question_set_id = $question_set_id";
		return $this->survey->query($query);
	}
	public function del_question_set($section_id=0)
	{
	 $query = "DELETE FROM GES_M_question_set
			WHERE section_id = $section_id";
		return $this->survey->query($query);
	}


}
?>
