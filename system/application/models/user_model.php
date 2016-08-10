<?php
class User_model extends Model{
	function __construct(){
		parent::__construct();
		$this->portal = $this->load->database('portal',TRUE);
	}
	public function get_pass ($NIK){
		$query = "SELECT convert(varchar(16), decryptbypassphrase(userLogin, password)) as pass, StatusNonSAP as is_non_sap FROM tr_login WHERE userLogin = '$NIK'";
		return $this->portal->query($query)->row();
	}
	public function get_detail($nik){
		$query = "SELECT a.NIK
							,a.Telp
							,a.Email
							,a.Nama
							,b.ModuleRoleID
							,b.StatusNonSAP
							,b.counterPassword
							,b.lock
							,b.lastSessionID
							,b.lastLoginTime
							,b.isActive
						FROM ms_niktelp a, tr_login b
						WHERE a.NIK='$nik'
							AND a.NIK=b.userLogin";
		return $this->portal->query($query)->row();
	}

	public function update_login($nik){
		$query = "UPDATE tr_login SET lastLoginTime = GETDATE(), lastSessionID = WHERE userLogin='$nik'";
	}
	public function get_roleAdmin_row($nik,$module=24){
		$query="SELECT * FROM ms_ModuleAdmin where ModuleID=$module and isActive=1 and UserLogin='$nik'";
    return $this->portal->query($query)->row();
	}
	public function count_roleAdmin($nik,$module=24){
    $query="SELECT count(*) as val FROM ms_ModuleAdmin where ModuleID=$module and isActive=1 and UserLogin='$nik'";
    return $this->portal->query($query)->row()->val;
  }


}
?>
