<?php
/**
* controller login, logout dan mengatur hak akses
*
*/
class Account extends Controller
{

	function __construct()
	{
		parent::Controller();
		$this->load->model('user_model');
	}
	public function index()
	{
		if($this->session->userdata('nik')){
			redirect('backend');
		}else{
			redirect('account/login');
		}
	}
	/**
	 * [halaman login]
	 */
	public function login()
	{
		if ($this->session->userdata('nik')) {
			//redirect
		}
		$data['action'] = 'account/login_process';
		$atr = array(
      'src'     => 'assets/img/kg_logo.png',
      'width'   => '36px',
      'height'  => '36px'
    );
		$data['header']      = img($atr).' eSurvey';
		$data['switch']      = 'account/login_backend';
		$data['switch_text'] = 'Admin Panel';

		$this->load->view('login_top',$data);
		switch ($this->session->userdata('notif')) {
			case 1://salah password atau nik tidak ditemukan
				$this->load->view('notif/wrong_pass');
				break;
			case 2://tidak memiliki akses
				$this->load->view('notif/no_access');
				break;
			case 3://tidak memiliki akses
				$this->load->view('notif/no_auth');
				break;
		}
		$this->session->unset_userdata('notif');
		$this->load->view('login_form');
	}
	/**
	 * [mengecek login berdasarkan nik dan password HR Portal]
	 */
	public function login_process()
	{
		$nik 			= $this->input->post('txt_nik');
		$password = trim($this->input->post('txt_pass'));
		$db_pass 	= $this->user_model->get_pass($nik)->pass;
		$non_sap	= $this->user_model->get_pass($nik)->is_non_sap;
		if(count($db_pass) && $db_pass==$password && $non_sap==FALSE ){
			$this->load->library('saprfc');
			#search posisi yang dijabat saat ini
			$this->saprfc->connect();
			$this->saprfc->functionDiscover('ZHRFM_GETPOSORG_OM');
			$importParamName  = array('KEYDATE','OBJID');
			$importParamValue = array(date('Ymd'),$nik);
			$this->saprfc->importParameter($importParamName, $importParamValue);
			$this->saprfc->setInitTable('FI_OUT');
			$this->saprfc->executeSAP();
			$post = $this->saprfc->fetch_rows('FI_OUT');
			$this->session->set_userdata('portal_redirect',0);

			if (count($post)==1){

				$post = $this->saprfc->fetch_row('FI_OUT');
				$this->saprfc->free();
				$this->saprfc->close();
				$username = $this->user_model->get_detail($nik)->Nama;
				$session = array(
					'nik'         => $nik ,
					'role'        => 'responden',
					'position_id' => $post['OBJECT_ID']
				);
				$this->session->set_userdata($session);
				redirect('frontend/kuesioner');
			}else{
				$this->saprfc->free();
				$this->saprfc->close();

				$i=0;
				foreach ($post as $row) {
					$this->saprfc->connect();
					$this->saprfc->functionDiscover('ZHRFM_GETTOP_ORGANIZATION');
					$importParamName  = array('FI_ORG');
					$importParamValue = array($row['ORG_ID']);
					$this->saprfc->importParameter($importParamName, $importParamValue);

					$this->saprfc->executeSAP();
					$unit_name = $this->saprfc->getParameter('FI_ORG_NAME');
					$post_opt[$i]['OBJECT_ID'] = $row['OBJECT_ID'];
					$post_opt[$i]['LONG_TEXT'] = $row['LONG_TEXT'] . ' - '. $unit_name;
					$i++;
				}
				$this->load->model('responden_model');
				$post =  $this->responden_model->get_by_nik($nik);
				if (count($post)) {
					$data['def_post'] = $post->position_id;
				} else {
					$data['def_post'] = 0;

				}
				$data['post'] 		= $post_opt;

				$session = array(
					'nik'  => $nik ,
					'role' => 'responden'
				);
				$this->session->set_userdata($session);
				$data['hidden'] 	= array();
				$data['process'] 	= 'account/position_process';
				$this->load->view('frontend/position_form', $data, FALSE);
			}
		}else if(count($db_pass) && $db_pass==$password && $non_sap==TRUE){
			$session = array(
				'nik' 				=> $nik ,
				'role' 				=> 'responden',
				'username'		=> $username,
				'position_id'	=> 'nonSAP'
			);
			$this->session->set_userdata($session);
			redirect('frontend/kuesioner');
		}else{
			$this->session->set_userdata('notif', 1);//salah password
			redirect('account/login');
		}
	}
	public function position_process()
	{
		$post = $this->input->post('rd_position');
		$array = array(
			'position_id' => $post
		);

		$this->session->set_userdata( $array );
		redirect('frontend/kuesioner');
	}
	/**
	 * [Halaman login untuk admin]
	 * @return [type] [description]
	 */
	public function login_backend()
	{
		$data['action'] = 'account/login_backend_process';
		$atr = array(
      'src'     => 'assets/img/kg_logo.png',
      'width'   => '36px',
      'height'  => '36px'
    );
		$data['header'] = img($atr).' eSurvey<br/>Admin Panel';
		$data['switch'] = 'account/login';
		$data['switch_text'] = 'to Frontend';

		$this->load->view('login_top',$data);
		switch ($this->session->userdata('notif')) {
			case 1://salah password atau nik tidak ditemukan
				$this->load->view('notif/wrong_pass');
				break;
			case 2://tidak memiliki akses
				$this->load->view('notif/no_access');
				break;
			case 3://tidak memiliki akses
				$this->load->view('notif/no_auth');
				break;
		}
		$this->session->unset_userdata('notif');
		$this->load->view('login_form');
	}
	/**
	 * [login_backend_process description]
	 * @return [type] [description]
	 */
	public function login_backend_process()
	{
		$nik = $this->input->post('txt_nik');
		$password = trim($this->input->post('txt_pass'));
		$db_pass = $this->user_model->get_pass($nik)->pass;
		if (count($db_pass) && $db_pass==$password){
			$permission = $this->user_model->get_roleAdmin_row($nik);
			if (count($permission)){
				$username = $this->user_model->get_detail($nik)->Nama;
				$session = array(
					'nik'      => $nik ,
					'role'     => $permission->SpecialID,
					'username' => $username
				);
				$this->session->set_userdata( $session );
				redirect('backend');
			}else{
				$this->session->set_userdata('notif', '2');
				redirect('account/login_backend');
			}
		}else{
			$this->session->set_userdata('notif', '1');//salah password atau nik tidak ditemukan
			redirect('account/login_backend');
		}
	}
	public function logout($flag='front')
	{
		$this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
    $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
    $this->output->set_header("Pragma: no-cache");
    $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		$this->session->sess_destroy();
		switch ($flag) {
			case 'back':
				redirect('account/login_backend');
				break;
			case 'front':
				redirect('account/login');
				break;
			default:
				redirect('account/login');
				break;
		}
	}
	/**
	 * [Login dari HR Portal]
	 * @param  [type] $nik_64   [nik dengan encode base 64]
	 * @param  [type] $md5_pass [password dengan md5]
	 * @param  string $lang     [bahasa pilihan EN / ID]
	 * @param  string $from     [domain HR Portal asal]
	 */
	public function login_transfer($nik_64,$md5_pass,$lang='EN',$from='')
	{

		$nik = base64_decode($nik_64);
		$db_pass = $this->user_model->get_pass($nik)->pass;
		if (count($db_pass) && md5($db_pass) == $md5_pass){
			$this->load->library('saprfc');
			#search posisi yang dijabat saat ini
			$this->saprfc->connect();
			$this->saprfc->functionDiscover('ZHRFM_GETPOSORG_OM');
			$importParamName = array('KEYDATE','OBJID');
			$importParamValue = array(date('Ymd'),$nik);
			$this->saprfc->importParameter($importParamName, $importParamValue);
			$this->saprfc->setInitTable('FI_OUT');
			$this->saprfc->executeSAP();
			$post = $this->saprfc->fetch_rows('FI_OUT');
			$this->session->set_userdata('portal_redirect',1);

			$host_from = str_replace('http://','',$from);
			$this->session->set_userdata('host_from',$host_from);

			if (count($post)==1) {
				$post = $this->saprfc->fetch_row('FI_OUT');
				$this->saprfc->free();
				$this->saprfc->close();
				$session 	= array(
					'nik' 				=> $nik ,
					'role' 				=> 'responden',
					'position_id'	=> $post['OBJECT_ID'],
					'lang'				=> $lang
				);
				$this->session->set_userdata($session);
				redirect('frontend/kuesioner');
			} else {
				$this->saprfc->free();
				$this->saprfc->close();

				$i=0;
				foreach ($post as $row) {
					$this->saprfc->connect();
					$this->saprfc->functionDiscover('ZHRFM_GETTOP_ORGANIZATION');
					$importParamName  = array('FI_ORG');
					$importParamValue = array($row['ORG_ID']);
					$this->saprfc->importParameter($importParamName, $importParamValue);

					$this->saprfc->executeSAP();
					$unit_name = $this->saprfc->getParameter('FI_ORG_NAME');
					$post_opt[$i]['OBJECT_ID'] = $row['OBJECT_ID'];
					$post_opt[$i]['LONG_TEXT'] = $row['LONG_TEXT'] . ' - '. $unit_name;
					$i++;
				}
				$this->load->model('responden_model');
				$post =  $this->responden_model->get_by_nik($nik);
				if (count($post)) {
					$data['def_post'] = $post->position_id;
				} else {
					$data['def_post'] = 0;

				}
				$data['post'] 		= $post_opt;

				$session = array(
					'nik'  => $nik ,
					'role' => 'responden',
					'lang' => $lang
				);
				$this->session->set_userdata($session);
				$data['hidden'] 	= array();
				$data['process'] 	= 'account/position_process';
				$this->load->view('frontend/position_form', $data, FALSE);
			}
		}else{
			$this->session->set_userdata('notif', '1');//salah password atau nik tidak ditemukan
			// redirect('account/login');
		}
	}

	/**
	 * [panggil porthole.js dan create cookies]
	 * @return [type] [description]
	 */
	function catch_kompas(){

		$this->load->view('frontend/catch_kompas');
		// redirect('account/login_kompas');
	}
	/**
	 * [login dari portal kompas dengan menggunakan active directory]
	 * @param  string $nik   [nomor induk karyawan 6 digit]
	 * @param  string $email [description]
	 * @return [type]        [description]
	 */
	function login_kompas($nik='')
	{
		if ($nik == '') {
			$cookies_kompas = $_COOKIE['HRIFA'];
			$url="http://202.146.0.117/nurkartiko/login.aspx?key=".$cookies_kompas;
		} else if ($nik == '015111') {
			$url="http://202.146.0.117/nurkartiko/login.aspx?key=VnQrZ1l3cWJNZHNxRk9DcjVGMmFhUldLRTFaNktkUWE1TmN6SE56Ky9McWxqOUFGaEh6eUxDckZReXcycEJwSA2";
		} else {
			$cookies_kompas = $_COOKIE['HRIFA'];
			$url="http://202.146.0.117/nurkartiko/login.aspx?key=".$cookies_kompas;
		}

		$xml = simplexml_load_file($url); //retrieve URL and parse XML content
		$nik = $xml->nik;
		$email = $xml->email;
		$hp_number = $xml->hp;


		// if ($email != '') {
			$this->session->set_userdata('portal_redirect',0);

			$this->load->library('saprfc');
			#search posisi yang dijabat saat ini
			$this->saprfc->connect();
			$this->saprfc->functionDiscover('ZHRFM_GETPOSORG_OM');
			$importParamName  = array('KEYDATE','OBJID');
			$importParamValue = array(date('Ymd'),$nik);
			$this->saprfc->importParameter($importParamName, $importParamValue);
			$this->saprfc->setInitTable('FI_OUT');
			$this->saprfc->executeSAP();
			$post = $this->saprfc->fetch_rows('FI_OUT');

			if (count($post)==1){

				$post = $this->saprfc->fetch_row('FI_OUT');
				$this->saprfc->free();
				$this->saprfc->close();
				$username = $this->user_model->get_detail($nik)->Nama;
				$session = array(
					'nik'         => $nik ,
					'role'        => 'responden',
					'position_id' => $post['OBJECT_ID']
				);
				$this->session->set_userdata($session);

				redirect('frontend/kuesioner');
			} else {

				$this->saprfc->free();
				$this->saprfc->close();

				$i=0;
				foreach ($post as $row) {
					$this->saprfc->connect();
					$this->saprfc->functionDiscover('ZHRFM_GETTOP_ORGANIZATION');
					$importParamName  = array('FI_ORG');
					$importParamValue = array($row['ORG_ID']);
					$this->saprfc->importParameter($importParamName, $importParamValue);

					$this->saprfc->executeSAP();
					$unit_name = $this->saprfc->getParameter('FI_ORG_NAME');
					$post_opt[$i]['OBJECT_ID'] = $row['OBJECT_ID'];
					$post_opt[$i]['LONG_TEXT'] = $row['LONG_TEXT'] . ' - '. $unit_name;
					$i++;
				}
				$data['post'] 		= $post_opt;

				$session = array(
					'nik'  => $nik ,
					'role' => 'responden'
				);

				$this->session->set_userdata($session);
				$data['hidden']  = array();
				$data['process'] = 'account/position_process';
				$this->load->view('frontend/position_form', $data, FALSE);
			}
		// } else {
		// 	$this->session->set_userdata('notif', 1);//salah password
		// 	redirect('account/login');
		// }
	}
}
/* End of file account.php */
/* Location: ./system/application/controllers/account.php */
