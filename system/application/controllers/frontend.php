<?php
/**
* FrontEnd
* untuk responden menjawab kuesioner
*/
class Frontend extends Controller
{

	function __construct()
	{
		parent::Controller();
		//cek Authentifikasi responden
		// if ($this->session->userdata('nik') == '') {
		// 	redirect('account/login');
		// }
		$this->load->model('kuesioner_model');
		$this->load->model('responden_model');
		$this->load->model('trans_model');
	}

	public function index()
	{
		redirect('account/logout');
	}
	/**
	 * [menampilkan pesan sistem]
	 * @param  string $value [kode message yang akan digunak]
	 */
	public function message($value='')
	{

		$portal_redirect = $this->session->userdata('portal_redirect'); //tanda sehabis menampilkan pesan, perlu redirect ke HR Portal

		$url = str_replace('http://', '', base_url()) ;
		$loc = 'http://';
		if ($url == '10.10.55.25/eSurvey/') {
			$loc .= '10.10.55.25';
		} else if ($url == 'esurvey.kompasgramedia.com/') {
			$loc .= 'hr.kompasgramedia.com';

		} else if ($url == 'esurvey.kompasgramedia.co.id/' OR $url == '10.10.55.45/' OR $url == '10.9.70.34/') {
			$loc .= 'hr.kompasgramedia.co.id';
		}
		$loc .= $this->session->userdata('host_from');
		$loc .= '/login-transfer.php?u='.base64_encode($this->session->userdata('nik'));
		// $loc .= '&l='. $this->session->userdata('lang');
		$loc .= '&l=EN';
		$loc .= '&a=skip';
		$loc .= '&t=home.php';
		$data['loc'] 	= $loc;


		// $url = str_replace('http://', '', base_url()) ;
		// $loc = 'http://';
		//
		// $from = $this->session->userdata('host_from'); //server HR Portal asal
		//
		// if ($from != '') {
		// 	$loc .= $from;
		//
		// 	$loc .= '/login-transfer.php?u='.base64_encode($this->session->userdata('nik')).'&l='.$this->session->userdata('lang');
		// } else {
		// 	$loc .= $url.'/account/logout';
		// }
		// $data['loc']     = $loc; //lokasi redirect tujuan

		if ($portal_redirect) { //redirect ke HR portal
			switch ($value) {
				case 'no_survey':
					$data['time'] = 1; //waktu redirect dalam detik
					$this->load->view('template/responden_top');
					$this->load->view('notif/info_nosurvey',$data);
					$this->load->view('template/main_bottom');
					break;
				case 'submitted':
					$data['time'] = 1;//waktu redirect dalam detik

					$this->load->view('template/responden_top');
					$this->load->view('notif/info_submitted',$data);
					$this->load->view('template/main_bottom');
					break;
				case 'thank_you':
					$data['time'] = 3; //waktu redirect dalam detik
					$this->load->view('template/responden_top');
					$this->load->view('notif/thank_you',$data);
					$this->load->view('template/main_bottom');
					break;
				case 'no_right':
					$data['time'] = 1; //waktu redirect dalam detik
					$this->load->view('template/responden_top');
					$this->load->view('notif/info_noright',$data);
					$this->load->view('template/main_bottom');
					break;
				default:
					$this->load->view('template/responden_top');
					$this->load->view('template/main_bottom');
					break;
			}
			$this->load->view('template/redirect',$data); //js untuk redirect
		} else { //tidak redirect ke HR Portal
			switch ($value) {
				case 'no_survey':
					$this->load->view('template/responden_top');
					$this->load->view('notif_2/info_nosurvey',$data);
					$this->load->view('template/main_bottom');
					break;
				case 'submitted':
					$this->load->view('template/responden_top');
					$this->load->view('notif_2/info_submitted',$data);
					$this->load->view('template/main_bottom');
					break;
				case 'thank_you':
					$this->load->view('template/responden_top');
					$this->load->view('notif_2/thank_you',$data);
					$this->load->view('template/main_bottom');
					break;
				case 'no_right':
					$this->load->view('template/responden_top');
					$this->load->view('notif_2/info_noright',$data);
					$this->load->view('template/main_bottom');
					break;
				default:
					$this->load->view('template/responden_top');
					$this->load->view('template/main_bottom');
					break;
			}
		}
	}
	/**
	 * [cek kuesioner yang tersedia]
	 */
	public function kuesioner()
	{
		$nik 			= $this->session->userdata('nik');
		$post_id 	= $this->session->userdata('position_id');
		if ($post_id != 'nonSAP') {
			$this->load->library('saprfc');
			$this->saprfc->connect(); //buat sambungan BAPI
			$this->saprfc->functionDiscover('ZHRFM_GETORGPOSDETAIL');
			$importParamName 	= array('KEYDATE','OBJID','DEPTH');
			$importParamValue = array(date('Ymd'),$post_id,0);
			$this->saprfc->importParameter($importParamName, $importParamValue);
			$this->saprfc->setInitTable('T_OBJECTSDATA');
			$this->saprfc->executeSAP();
			$chief_flag 	= $this->saprfc->getParameter('T_CHIEF');
			$cochief_flag = $this->saprfc->getParameter('T_COCHIEF');
			$esg					= $this->saprfc->getParameter('T_ESG');
			$esg_text			= $this->saprfc->getParameter('T_ESGTEXT');
			$post_name		= str_replace("'","",$this->saprfc->getParameter('T_POSITIONNAME'));
			$om = $this->saprfc->fetch_rows('T_OBJECTSDATA');
			$this->saprfc->free(); //membersihkan hasil BAPI
			$this->saprfc->close(); //menutup sambungan BAPI

			$unit_id 			= '';
			$div_id 			= '';

			foreach ($om as $row) {
				if(substr($row['SHORT_TEXT'], 0,1)=='1'){
					$unit_id 		= $row['OBJECT_ID'];

				} else if(substr($row['SHORT_TEXT'], 0,1)=='2') {
					$div_id 		= $row['OBJECT_ID'];

				}
			}
			if ($unit_id == '') {
				$unit_id = $div_id;
			}
			$count_ks = $this->kuesioner_model->count_active($nik,$post_id,$unit_id);
		} else {
			$count_ks = $this->kuesioner_model->count_active($nik,$post_id);

		}
		// $count_ks = 2;
		if($count_ks == 0){
			#tampilkan peringatan/pemberitahuan
			$submit = $this->kuesioner_model->count_submitted($nik,$post_id);
			if ($submit == 0) {
				redirect('frontend/message/no_survey');
			} else {
				redirect('frontend/message/submitted');
			}

		}elseif($count_ks == 1){
			if ($post_id !='nonSAP') {
				$kuesioner_id = $this->kuesioner_model->get_active_row($nik,$post_id,$unit_id)->kuesioner_id;
			} else {
				$kuesioner_id = $this->kuesioner_model->get_active_row($nik,$post_id)->kuesioner_id;
			}
			$this->session->set_userdata('kuesioner_id',$kuesioner_id);
			#lanjut ke intro
			redirect('frontend/check');
		}else{
			#berikan pilihan kuesioner
			$data_header['title'] 	= 'Choose Survey';
			$data_header['sub'] 		= '';
			if ($post_id !='nonSAP') {
				$kuesioner_ls = $this->kuesioner_model->get_active_list($nik,$post_id,$unit_id)->kuesioner_id;
			} else {
				$kuesioner_ls = $this->kuesioner_model->get_active_list($nik,$post_id)->kuesioner_id;
			}
			$data['kuesioner_list'] = $kuesioner_ls;
			$data['process'] 				= 'frontend/kuesioner_process';
			$data['hidden'] 				= array();

			$this->load->view('template/responden_top');
			$this->load->view('template/page_header',$data_header);
			$this->load->view('frontend/kuesioner_form',$data);
			$this->load->view('template/main_bottom');

		}
	}
	public function kuesioner_process()
	{
		$kuesioner_id = $this->input->post('rd_kuesioner');
		$this->session->set_userdata('kuesioner_id',$kuesioner_id);
		redirect('frontend/check');
	}

	/**
	 * [cek syarat responden dengan data PA dan OM responden]
	 */
	public function check()
	{
		$this->load->model('responden_model');
		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		#cek metode yang digunakan
		$nik 	= $this->session->userdata('nik');
		$post = $this->session->userdata('position_id');
		if ($kuesioner->method==0) {//sensus
			if ($post !='nonSAP'){
				#cek scope sensus
				$this->load->library('saprfc');

				$this->saprfc->connect(); //buat sambungan BAPI
				#ambil data PA
				$this->saprfc->functionDiscover('ZHRFM_GET_PA');
				$importParamName=array('FI_TANGGAL','FI_PERNR');
				$importParamValue=array(date('Ymd'),$nik);
				$this->saprfc->importParameter($importParamName, $importParamValue);

				$this->saprfc->setInitTable('FI_CV');
				$this->saprfc->executeSAP();
				$pa = $this->saprfc->fetch_row('FI_CV');
				$this->saprfc->free(); //membersihkan hasil BAPI
				#ambil data OM
				$this->saprfc->functionDiscover('ZHRFM_GETORGPOSDETAIL');
				$importParamName 	= array('KEYDATE','OBJID','DEPTH');

				$importParamValue = array(date('Ymd'),$post,0);
				$this->saprfc->importParameter($importParamName, $importParamValue);
				$this->saprfc->setInitTable('T_OBJECTSDATA');
				$this->saprfc->executeSAP();
				$chief_flag 	= $this->saprfc->getParameter('T_CHIEF');
				$cochief_flag = $this->saprfc->getParameter('T_COCHIEF');
				$esg					= $this->saprfc->getParameter('T_ESG');
				$esg_text			= $this->saprfc->getParameter('T_ESGTEXT');
				$post_name		= str_replace("'","",$this->saprfc->getParameter('T_POSITIONNAME'));
				$om = $this->saprfc->fetch_rows('T_OBJECTSDATA');
				$this->saprfc->free(); //membersihkan hasil BAPI
				$this->saprfc->close(); //menutup sambungan BAPI

				$chief_status = 0;
				if(($chief_flag == '' OR $chief_flag == 0) && ($cochief_flag == 0 OR $cochief_flag =='') ) {
					$chief_status = 0;
				} else if($chief_flag != '' OR $chief_flag != 0) {
					$chief_status = 2;
				}	else if($cochief_flag != '' OR $cochief_flag != 0) {
					$chief_status = 1;
				}

				if ($esg == ''){
					$esg = $pa['PERSK'];
				}
				if ($esg_text == ''){
					$esg_text = $pa['ESGTEXT'];
				}

				$sect_id 			= '';
				$sect_name 		= '';
				$dept_id 			= '';
				$dept_name 		= '';
				$div_id 			= '';
				$div_name 		= '';
				$unit_id 			= '';
				$unit_name 		= '';
				foreach ($om as $row) {
					if(substr($row['SHORT_TEXT'], 0,1)=='1'){
						$unit_id 		= $row['OBJECT_ID'];
						$unit_name 	= str_replace("'","", $row['LONG_TEXT']);
					} elseif (substr($row['SHORT_TEXT'], 0,1)=='2') {
						$div_id 		= $row['OBJECT_ID'];
						$div_name 	= str_replace("'","", $row['LONG_TEXT']);
					} elseif (substr($row['SHORT_TEXT'], 0,1)=='3') {
						$dept_id 		= $row['OBJECT_ID'];
						$dept_name 	= str_replace("'","", $row['LONG_TEXT']);
					} elseif (substr($row['SHORT_TEXT'], 0,1)=='4') {
						$sect_id 		= $row['OBJECT_ID'];
						$sect_name 	= str_replace("'","", $row['LONG_TEXT']);
					}
				}
				$join_date 		= substr($pa['TGLMASUK'], 0,4).'-'.substr($pa['TGLMASUK'], 4,2).'-'.substr($pa['TGLMASUK'], 6,2);
				$today				= date('Y-m-d');

				$len_service 	= $this->count_diff_date($join_date,$today); //hitung masa kerja (length of services)
				$auth_flag		= FALSE; // tanda hak suara survei

				if ($kuesioner->is_all == TRUE) { //semua unit KG
					if ($pa['STATUS']=='01') { //permanent
						if ($len_service['year'] >= $kuesioner->p_min_y && $len_service['year'] <= $kuesioner->p_max_y) {
							if ($len_service['month'] >= $kuesioner->p_min_m && $len_service['month'] <= $kuesioner->p_max_m) {
								if ($len_service['day'] >= $kuesioner->p_min_d && $len_service['day'] <= $kuesioner->p_max_d) {
									$auth_flag = TRUE;
								}
							}
						}
					}elseif($pa['STATUS']=='02') { //contract
						if ($len_service['year'] >= $kuesioner->c_min_y && $len_service['year'] <= $kuesioner->c_max_y) {
							if ($len_service['month'] >= $kuesioner->c_min_m && $len_service['month'] <= $kuesioner->c_max_m) {
								if ($len_service['day'] >= $kuesioner->c_min_d && $len_service['day'] <= $kuesioner->c_max_d) {
									$auth_flag = TRUE;
								}
							}
						}
					}
				}else{ //beberapa atau hanya satu unit
					#cek unit responden apakah mengikuti survey
					$org_array = array($unit_id,$div_id,$dept_id,$sect_id);
					$check_unit = $this->kuesioner_model->check_unit($kuesioner_id,$org_array);

					if ($check_unit==TRUE){ //cocok
						#cek persyaratan responden

						if ($unit_id != '') {
							$org = $this->trans_model->get_org($kuesioner_id,$unit_id);
						} elseif ($div_id !='') {
							$org = $this->trans_model->get_org($kuesioner_id,$div_id);
						}

						if ($pa['STATUS']=='01') {
							if ($len_service['year'] >= $org->p_min_y && $len_service['year'] <= $org->p_max_y) {
								if ($len_service['month'] >= $org->p_min_m && $len_service['month'] <= $org->p_max_m) {
									if ($len_service['day'] >= $org->p_min_d && $len_service['day'] <= $org->p_max_d) {
										$auth_flag = TRUE;
									}
								}
							}
						} elseif ($pa['STATUS']=='02') {
							if ($len_service['year'] >= $org->c_min_y && $len_service['year'] <= $org->c_max_y) {
								if ($len_service['month'] >= $org->c_min_m && $len_service['month'] <= $org->c_max_m) {
									if ($len_service['day'] >= $org->c_min_d && $len_service['day'] <= $org->c_max_d) {
										$auth_flag = TRUE;
									}
								}
							}
						}
					}

					if ($unit_id == '' && $div_id == '' && $dept_id == '' && $sect_id == '' && $post !='') {
						$auth_flag = TRUE;
					}
				}

				if ($auth_flag == TRUE) {

					#cek lama menjabat
					$this->saprfc->connect(); //buat sambungan BAPI
					$this->saprfc->functionDiscover('ZHRFM_REL_HOLDER_ORG');
					$importParamName 	= array('FI_PERNR','FI_POSITION');
					$importParamValue = array($this->session->userdata('nik'),$this->session->userdata('position_id'));
					$this->saprfc->importParameter($importParamName, $importParamValue);
					$this->saprfc->setInitTable('FO_DATA');
					$this->saprfc->executeSAP();
					// $hold = $this->saprfc->fetch_rows('FO_DATA');
					// $i = 0;
					// $start_date = '';
					// foreach ($hold as $row) {
					// 	if ($i == 0) {
					// 		$start_date = substr($row['BEGDA'], 0,4).'-'.substr($row['BEGDA'], 4,2).'-'.substr($row['BEGDA'], 6,2);
					// 	}
					// 	$i++;
					// }
					$hold = $this->saprfc->fetch_row('FO_DATA');
					$start_date = date('Y-m-d',strtotime($hold['BEGDA']));

					$this->saprfc->free(); //membersihkan hasil BAPI
					$this->saprfc->close(); //menutup sambungan BAPI
					$today				= date('Y-m-d');
					$len_hold 		= $this->count_diff_date($start_date,$today); //hitung masa posisi (length of holding

					if ($kuesioner->is_all == TRUE) {
						$base = $kuesioner;
					} else {
						$base = $org;
					}
					if ($len_hold['year'] >= $base->post_min_y && $len_hold['year'] <= $base->post_max_y) {
						if ($len_hold['month'] >= $base->post_min_m && $len_hold['month'] <= $base->post_max_m) {
							if ($len_hold['day'] >= $base->post_min_d && $len_hold['day'] <= $base->post_max_d) {
								$auth_flag = TRUE;
							}
						}
					} else {
						#cek apakah posisi sebelumnya ada di unit yang sama
						$end_date = date('Ymd', strtotime($start_date .' -1 day'));
						#search posisi yang dijabat sebelumnya
						$nik = $this->session->userdata('nik');
						$this->saprfc->connect();
						$this->saprfc->functionDiscover('ZHRFM_GETPOSORG_OM');
						$importParamName=array('KEYDATE','OBJID');
						$importParamValue=array($end_date,$nik);
						$this->saprfc->importParameter($importParamName, $importParamValue);
						$this->saprfc->setInitTable('FI_OUT');
						$this->saprfc->executeSAP();
						$old_post = $this->saprfc->fetch_rows('FI_OUT');
						$this->saprfc->free();
						$this->saprfc->close();
						if (count($old_post)==1){
							$old_post_id = $old_post['OBJECT_ID'];
							#ambil data OM
							$this->saprfc->connect();
							$this->saprfc->functionDiscover('ZHRFM_GETORGPOSDETAIL');
							$importParamName=array('KEYDATE','OBJID','DEPTH');
							$importParamValue=array($end_date,$old_post_id,0);
							$this->saprfc->importParameter($importParamName, $importParamValue);
							$this->saprfc->setInitTable('T_OBJECTSDATA');
							$this->saprfc->executeSAP();
							$old_om = $this->saprfc->fetch_rows('T_OBJECTSDATA');
							$this->saprfc->free(); //membersihkan hasil BAPI
							$this->saprfc->close(); //menutup sambungan BAPI
							$old_unit_id 	= '';
							foreach ($old_om as $row) {
								if(substr($row['SHORT_TEXT'], 0,1)=='1'){
									$old_unit_id	= $row['OBJECT_ID'];
								}
							}
							if ($old_unit_id == $unit_id) { //jika posisi sebelumnya ada di unit yang sama dengan posisi sekarang
								$auth_flag = TRUE;
							}
						} else {
							foreach ($old_post as $row) {
								#ambil data OM
								$this->saprfc->connect();
								$this->saprfc->functionDiscover('ZHRFM_GETORGPOSDETAIL');
								$importParamName=array('KEYDATE','OBJID','DEPTH');
								$importParamValue=array($end_date,$row['OBJECT_ID'],0);
								$this->saprfc->importParameter($importParamName, $importParamValue);
								$this->saprfc->setInitTable('T_OBJECTSDATA');
								$this->saprfc->executeSAP();
								$old_om = $this->saprfc->fetch_rows('T_OBJECTSDATA');
								$this->saprfc->free(); //membersihkan hasil BAPI
								$this->saprfc->close(); //menutup sambungan BAPI
								$old_unit_id 	= '';
								foreach ($old_om as $row) {
									if(substr($row['SHORT_TEXT'], 0,1)=='1'){
										$old_unit_id	= $row['OBJECT_ID'];
									}
								}
								if ($old_unit_id == $unit_id) { //jika posisi sebelumnya ada di unit yang sama dengan posisi sekarang
									$auth_flag = TRUE;
									break;
								}
							}
						}
					}

				}

			} else { // orang dari unit nonSAP
				$responden = $this->responden_model->get_responden($kuesioner_id,$nik);
				if (count($responden)==1){
					$auth_flag = TRUE;
				}
			}
		}elseif($kuesioner->method==1){//sampling
				#cek data responden

			$auth_flag 	= FALSE;
			$post_id 		= $this->session->userdata('position_id');
			$responden 	= $this->responden_model->get_responden($kuesioner_id,$nik,$post_id);
			if (count($responden)==1){
				$auth_flag = TRUE;
				#cek scope sensus
				$this->load->library('saprfc');

				$this->saprfc->connect(); //buat sambungan BAPI
				#ambil data PA
				$this->saprfc->functionDiscover('ZHRFM_GET_PA');
				$importParamName=array('FI_TANGGAL','FI_PERNR');
				$importParamValue=array(date('Ymd'),$nik);
				$this->saprfc->importParameter($importParamName, $importParamValue);

				$this->saprfc->setInitTable('FI_CV');
				$this->saprfc->executeSAP();
				$pa = $this->saprfc->fetch_row('FI_CV');
				$this->saprfc->free(); //membersihkan hasil BAPI
				#ambil data OM
				$this->saprfc->functionDiscover('ZHRFM_GETORGPOSDETAIL');
				$importParamName 	= array('KEYDATE','OBJID','DEPTH');
				$importParamValue = array(date('Ymd'),$responden->position_id,0);
				$this->saprfc->importParameter($importParamName, $importParamValue);
				$this->saprfc->setInitTable('T_OBJECTSDATA');
				$this->saprfc->executeSAP();
				$chief_flag 	= $this->saprfc->getParameter('T_CHIEF');
				$cochief_flag = $this->saprfc->getParameter('T_COCHIEF');
				$esg					= $this->saprfc->getParameter('T_ESG');
				$esg_text			= $this->saprfc->getParameter('T_ESGTEXT');
				$post_name		= $this->saprfc->getParameter('T_POSITIONNAME');
				$om = $this->saprfc->fetch_rows('T_OBJECTSDATA');
				$this->saprfc->free(); //membersihkan hasil BAPI
				$this->saprfc->close(); //menutup sambungan BAPI
				$chief_status = 0;
				if(($chief_flag == '' OR $chief_flag == 0) && ($cochief_flag == 0 OR $cochief_flag =='') ) {
					$chief_status = 0;
				} else if($chief_flag != '' OR $chief_flag != 0) {
					$chief_status = 2;
				}	else if($cochief_flag != '' OR $cochief_flag != 0) {
					$chief_status = 1;
				}

				if ($esg == ''){
					$esg = $pa['PERSK'];
				}
				if ($esg_text == ''){
					$esg_text = $pa['ESGTEXT'];
				}

				$sect_id 			= '';
				$sect_name 		= '';
				$dept_id 			= '';
				$dept_name 		= '';
				$div_id 			= '';
				$div_name 		= '';
				$unit_id 			= '';
				$unit_name 		= '';
				foreach ($om as $row) {
					if(substr($row['SHORT_TEXT'], 0,1)=='1'){
						$unit_id 		= $row['OBJECT_ID'];
						$unit_name 	= str_replace("'", "", $row['LONG_TEXT']);
					} elseif (substr($row['SHORT_TEXT'], 0,1)=='2') {
						$div_id 		= $row['OBJECT_ID'];
						$div_name 	= str_replace("'", "", $row['LONG_TEXT']);
					} elseif (substr($row['SHORT_TEXT'], 0,1)=='3') {
						$dept_id 		= $row['OBJECT_ID'];
						$dept_name 	= str_replace("'", "", $row['LONG_TEXT']);
					} elseif (substr($row['SHORT_TEXT'], 0,1)=='4') {
						$sect_id 		= $row['OBJECT_ID'];
						$sect_name 	= str_replace("'", "", $row['LONG_TEXT']);
					}
				}
				$join_date 		= substr($pa['TGLMASUK'], 0,4).'-'.substr($pa['TGLMASUK'], 4,2).'-'.substr($pa['TGLMASUK'], 6,2);
				$today				= date('Y-m-d');
				$len_service 	= $this->count_diff_date($join_date,$today); //hitung masa kerja (length of services)
			}

		}
		if ($auth_flag==TRUE ) {

			$responden = $this->responden_model->get_responden($kuesioner_id,$nik,$post);
			if (count($responden) && $responden->is_submitted==1) {
				redirect('frontend/message/submitted');
			}
			if (count($responden) && $post !='nonSAP'){
				#update
				$birthdate = substr($pa['TTL'], 0,4).'-'.substr($pa['TTL'], 4,2).'-'.substr($pa['TTL'], 6,2);
				$join_date = substr($pa['TGLMASUK'], 0,4).'-'.substr($pa['TGLMASUK'], 4,2).'-'.substr($pa['TGLMASUK'], 6,2);
				$permanent_date = substr($pa['TGLDIANGKAT'], 0,4).'-'.substr($pa['TGLDIANGKAT'], 4,2).'-'.substr($pa['TGLDIANGKAT'], 6,2);
				if ($pa['JENISKELAMIN']==2) {
					$gender = 0;
				} else {
					$gender = 1;
				}
				if ($permanent_date == '0000-00-00'){
					$this->responden_model->edit_data(
						$responden->responden_id,
						str_replace("'","",$pa['NAMALENGKAP']),
						$gender,$birthdate,
						$pa['TEMPATLAHIR'],
						$pa['AGAMA'],
						$join_date,
						NULL,
						$pa['STATUS'],
						$post,
						$post_name,
						$chief_status,
						$esg,
						$esg_text,
						$unit_id,
						$unit_name,
						$div_id,
						$div_name,
						$dept_id,
						$dept_name,
						$sect_id,
						$sect_name
					);
				} else {
					$this->responden_model->edit_data(
						$responden->responden_id,
						str_replace("'","",$pa['NAMALENGKAP']),
						$gender,
						$birthdate,
						$pa['TEMPATLAHIR'],
						$pa['AGAMA'],
						$join_date,
						$permanent_date,
						$pa['STATUS'],
						$post,
						$post_name,
						$chief_status,
						$esg,
						$esg_text,
						$unit_id,
						$unit_name,
						$div_id,
						$div_name,
						$dept_id,
						$dept_name,
						$sect_id,
						$sect_name,
						$kuesioner->skip_quota,
						1
					);
				}
			}else if(count($responden) && $post =='nonSAP'){
				#nothing
			}else{
				#insert
				if ($pa['JENISKELAMIN']==2) {
					$gender = 0;
				} else {
					$gender = 1;
				}
				$birthdate 			= substr($pa['TTL'], 0,4).'-'.substr($pa['TTL'], 4,2).'-'.substr($pa['TTL'], 6,2);
				$join_date 			= substr($pa['TGLMASUK'], 0,4).'-'.substr($pa['TGLMASUK'], 4,2).'-'.substr($pa['TGLMASUK'], 6,2);
				$permanent_date = substr($pa['TGLDIANGKAT'], 0,4).'-'.substr($pa['TGLDIANGKAT'], 4,2).'-'.substr($pa['TGLDIANGKAT'], 6,2);

				if ($permanent_date == '0000-00-00'){
					$this->responden_model->add(
						$kuesioner_id,
						$nik,
						str_replace("'","",$pa['NAMALENGKAP']),
						$gender,
						$birthdate,
						$pa['TEMPATLAHIR'],
						$pa['AGAMA'],
						$join_date,
						NULL,
						$pa['STATUS'],
						$post,
						$post_name,
						$chief_status,
						$esg,
						$esg_text,
						$unit_id,
						$unit_name,
						$div_id,
						$div_name,
						$dept_id,
						$dept_name,
						$sect_id,
						$sect_name,
						$kuesioner->skip_quota,
						1
					);

				} else {
					$this->responden_model->add(
						$kuesioner_id,
						$nik,
						str_replace("'","",$pa['NAMALENGKAP']),
						$gender,
						$birthdate,
						$pa['TEMPATLAHIR'],
						$pa['AGAMA'],
						$join_date,
						$permanent_date,
						$pa['STATUS'],
						$post,
						$post_name,
						$chief_status,
						$esg,
						$esg_text,
						$unit_id,
						$unit_name,
						$div_id,
						$div_name,
						$dept_id,
						$dept_name,
						$sect_id,
						$sect_name,
						$kuesioner->skip_quota,
						1
					);
				}
			}
			$responden = $this->responden_model->get_responden($kuesioner_id,$nik,$post);
			$this->session->set_userdata( 'responden_id',$responden->responden_id );
			redirect('frontend/intro');
		}else{
			echo '<br>'. print_r($len_service);
			redirect('frontend/message/no_right');
		}
	}

	public function intro()
	{
		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$responden 						= $this->responden_model->get_responden(
			$kuesioner_id,
			$this->session->userdata('nik'),
			$this->session->userdata('position_id')
		);

		$top['title']					= $kuesioner->title;
		$data_header['title'] = $kuesioner->title;
		$data_header['sub']		= 'Pengantar';
		$data['intro']				= $kuesioner->introduction;
		$data['theme']				= $kuesioner->theme;
		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		$current_step 				= 0;
		$all_step							= 5 + count($section_list);
		$data['progress']			= $current_step/$all_step * 100;
		$data['skipable']     = TRUE;
		if ($responden->skip_count <= 0){
			$data['skipable']   = FALSE;
		}
		$data['quota']				= $responden->skip_count;
		$data['section_list']	= $section_list;
		$data['nav_index']		= 'intro';
		$data['next_link']		= 'frontend/agreement';
		$data['skip_link']		= 'frontend/skip';

		$this->load->view('template/responden_top',$top);
		$this->load->view('template/page_header',$data_header);
		$this->load->view('frontend/intro_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function skip()
	{
		$url = str_replace('http://', '', base_url()) ;
		$loc = 'http://';
		if ($url == '10.10.55.25/eSurvey/') {
			$loc .= '10.10.55.25';
		} else if ($url == 'esurvey.kompasgramedia.com/') {
			$loc .= 'hr.kompasgramedia.com';

		} else if ($url == 'esurvey.kompasgramedia.co.id/' OR $url == '10.10.55.45/') {
			$loc .= 'hr.kompasgramedia.co.id';
		}
		$loc .= $this->session->userdata('host_from');
		$loc .= '/login-transfer.php?u='.base64_encode($this->session->userdata('nik'));
		// $loc .= '&l='. $this->session->userdata('lang');
		$loc .= '&l=EN';
		$loc .= '&a=skip';
		$loc .= '&t=home.php';
		$data['loc'] 	= $loc;
		$data['time'] = 3;
		$responden 						= $this->responden_model->get_responden(
			$this->session->userdata('kuesioner_id'),
			$this->session->userdata('nik'),
			$this->session->userdata('position_id')
		);
		$value = $responden->skip_count - 1;
		$this->responden_model->edit_count($responden->responden_id,$value);

		$this->load->view('template/responden_top');
		$this->load->view('notif/info_skip',$data);
		$this->load->view('template/main_bottom');
		$this->load->view('template/redirect',$data);
	}
	public function agreement()
	{
		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$top['title']					= $kuesioner->title;
		$data_header['title'] = $kuesioner->title;
		$data_header['sub']		= 'Persetujuan';
		$data['agreement'] 		= $kuesioner->agreement_text;
		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		foreach ($section_list as $row) {
			$section_id = $row->section_id;
			break;
		}
		$current_step 				= 1;
		$all_step							= 5 + count($section_list);
		$data['progress']			= $current_step/$all_step * 100;
		$this->session->set_userdata('step',$current_step);
		$this->session->set_userdata('section_number',0 );
		$data['section_list']	= $section_list;
		$data['nav_index']		= 'agree';
		$data['section_link']	= 'frontend/section/';
		// $data['next_link']		= 'frontend/section/'.$section_id;
		$data['next_link']		= 'frontend/guide';
		$this->load->view('template/responden_top',$top);
		$this->load->view('template/page_header',$data_header);
		$this->load->view('frontend/agreement_view',$data);
		$this->load->view('template/main_bottom');

	}
	public function guide()
	{
		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$top['title']					= $kuesioner->title;
		$data_header['title'] = $kuesioner->title;
		$data_header['sub']		= 'Petunjuk';
		$data['guide'] 				= $kuesioner->guide;
		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		foreach ($section_list as $row) {
			$section_id = $row->section_id;
			break;
		}
		$current_step 				= 2;
		$all_step							= 5 + count($section_list);
		$data['progress']			= $current_step/$all_step * 100;
		$this->session->set_userdata('step',$current_step);
		$this->session->set_userdata('section_number',0 );
		$data['section_list']	= $section_list;
		$data['nav_index']		= 'guide';
		$data['section_link']	= 'frontend/section/';
		$data['next_link']		= 'frontend/term';
		$this->load->view('template/responden_top',$top);
		$this->load->view('template/page_header',$data_header);
		$this->load->view('frontend/guide_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function term()
	{
		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$top['title']					= $kuesioner->title;
		$data_header['title'] = $kuesioner->title;
		$data_header['sub']		= 'Definisi';
		$data['term'] 				= $kuesioner->term;
		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		foreach ($section_list as $row) {
			$section_id = $row->section_id;
			break;
		}
		$current_step 				= 3;
		$all_step							= 5 + count($section_list);
		$data['progress']			= $current_step/$all_step * 100;
		$this->session->set_userdata('step',$current_step);
		$this->session->set_userdata('section_number',0 );
		$data['section_list']	= $section_list;
		$data['nav_index']		= 'term';
		$data['section_link']	= 'frontend/section/';
		$data['next_link']		= 'frontend/section/'.$section_id;
		$this->load->view('template/responden_top',$top);
		$this->load->view('template/page_header',$data_header);
		$this->load->view('frontend/term_view',$data);
		$this->load->view('template/main_bottom');

	}
	public function section($section_id='null')
	{
		$this->load->model('question_model');

		$current_step	= $this->session->userdata('step');

		if ($current_step>=3) {
			$current_step +=1;
		} else {
			$current_step = 3;
		}
		$this->session->set_userdata('step',$current_step);

		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$responden_id					= $this->session->userdata('responden_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$section 							= $this->kuesioner_model->get_section_row($section_id);

		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		$question_list 				= $this->kuesioner_model->get_question_list($section_id,1,1);
		$all_step							= 4 + count($section_list);
		$top['title']					= $kuesioner->title;
		$data_header['title'] = $kuesioner->title;
		$data_header['sub']		= $section->section_name;
		$open['section_link']	= 'frontend/section/';
		$open['progress']			= $current_step/$all_step * 100;
		$open['section_list']	= $section_list;
		$open['section']			= $section;
		$open['process']			= 'frontend/section_process';
		$open['hidden']				= array('section_id'=>$section_id,'mode'=>'add');
		$open['section_id']		= $section_id;
		$this->load->view('template/responden_top',$top);
		$this->load->view('template/page_header',$data_header);
		$this->load->view('frontend/section_open',$open);

		$number = 1;
		foreach ($question_list as $row) {
			$data['number'] = $number;
			$data['text'] 	= $row->question_text;
			$data['q_id'] 	= $row->question_id;
			$this->load->view('frontend/question/question_view', $data, FALSE);
			switch ($row->type) {
				case 1: //scale
					$answer 					= $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($answer)==0){
						$data['answer']		= '';
					} else {
						$data['answer']		= $answer->value;
					}
					$data['min_val'] 	= $row->min_val;
					$data['max_val'] 	= $row->max_val;
					$data['min_text'] = $row->min_text;
					$data['max_text'] = $row->max_text;
					if ($row->abstain_flag==TRUE){
						$data['abstain_text'] = $kuesioner->abstain_text;
						$this->load->view('frontend/question/scale_2', $data, FALSE);
					} else {
						$this->load->view('frontend/question/scale_1', $data, FALSE);
					}
					break;
				case 2: //multi choice
					$answer 					= $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($answer)==0){
						$data['answer']		= '';
					} else {
						$data['answer']		= $answer->value;
					}
					$data['option_list'] = $this->question_model->get_option_list($row->question_id);
					if ($row->abstain_flag==TRUE){
						$data['abstain_text'] = $kuesioner->abstain_text;
						$this->load->view('frontend/question/multi_choice_2', $data, FALSE);
					} else {
						$this->load->view('frontend/question/multi_choice_1', $data, FALSE);
					}
					break;
				case 3: //open
					$answer 					= $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($answer)==0){
						$data['answer']		= '';
					} else {
						$data['answer']		= $answer->value_text;
					}
					$this->load->view('frontend/question/open', $data, FALSE);
					break;
				case 4: //multi answer
					$answer_list 					= $this->trans_model->get_answer_list($responden_id,$row->question_id);
					$answer 							= array();
					foreach ($answer_list as $row_2) {
						$answer[]						= $row_2->value;
					}
					$data['answer']				= $answer;
					$data['option_list'] 	= $this->question_model->get_option_list($row->question_id);
					$data['max_val']			= $row->max_val;
					if ($row->abstain_flag==TRUE){
						$data['abstain_text'] = $kuesioner->abstain_text;
						$this->load->view('frontend/question/checkbox_2', $data, FALSE);
					} else {
						$this->load->view('frontend/question/checkbox_1', $data, FALSE);
					}
					break;
			}
			$number++;
		}
		$this->load->view('frontend/section_close');
		$bot['js_list'] = array('custom_js/checkbox/abstain');
		$this->load->view('template/main_bottom',$bot);
	}

	public function section_process()
	{
		$mode 					= $this->input->post('mode');
		$responden_id		= $this->session->userdata('responden_id');

		$section_id 		= $this->input->post('section_id');
		$question_list 	= $this->kuesioner_model->get_question_list($section_id,1,1);
		foreach ($question_list as $row) {
			$check = $this->trans_model->count_answer($responden_id,$row->question_id);
			if($check==0){
				#insert
				switch ($row->type) {
					case 1: //scale
						$answer = $this->input->post('rd_'.$row->question_id);
						$this->trans_model->add_answer($responden_id,$row->question_id,$answer,'');
						break;
					case 2: //multi choice
						$answer = $this->input->post('rd_'.$row->question_id);
						$post 	= strpos($answer, '|');
						$answer_val = substr($answer, 0,$post);
						$answer_txt = substr($answer, ($post+1));
						$this->trans_model->add_answer($responden_id,$row->question_id,$answer_val,$answer_txt);
						break;
					case 3: // open answer
						$answer = $this->input->post('txt_'.$row->question_id);
						$this->trans_model->add_answer($responden_id,$row->question_id,'',$answer);
						break;
					case 4: //multi answer / checkbox
						$answer = $this->input->post('chk_'.$row->question_id);
						foreach ($answer as $key => $value) {
							$post 	= strpos($value, '|');
							$answer_val = substr($value, 0,$post);
							$answer_txt = substr($value, ($post+1));
							$this->trans_model->add_answer($responden_id,$row->question_id,$answer_val,$answer_txt);
						}
						break;
				}
			} else {
				#update
				switch ($row->type) {
					case 1: //scale
						$answer = $this->input->post('rd_'.$row->question_id);
						$this->trans_model->edit_answer_1($responden_id,$row->question_id,$answer,'');
						break;
					case 2: //multi choice
						$answer = $this->input->post('rd_'.$row->question_id);
						$post 	= strpos($answer, '|');
						$answer_val = substr($answer, 0,$post);
						$answer_txt = substr($answer, ($post+1));
						$this->trans_model->edit_answer_1($responden_id,$row->question_id,$answer_val,$answer_txt);
						break;
					case 3: // open answer
						$answer = $this->input->post('txt_'.$row->question_id);
						$this->trans_model->edit_answer_1($responden_id,$row->question_id,'',$answer);
						break;
					case 4: //multi answer / checkbox
						$old_list	= $this->trans_model->get_answer_list($responden_id,$row->question_id);
						$answer 	= $this->input->post('chk_'.$row->question_id);
						$new			= array();
						foreach ($answer as $key => $value) {
							$new[]		  = $value;
						}
						$old = array();
						foreach ($old_list as $row_2) {
							if(in_array($old->value, $new)==FALSE){
								$this->trans_model->del_answer($row_2->answer_id);
							}
						}
						foreach ($answer as $key => $value) {
							$post 			= strpos($value, '|');
							$answer_val = substr($value, 0,$post);
							$answer_txt = substr($value, ($post+1));
							$this->trans_model->add_answer($responden_id,$row->question_id,$answer_val,$answer_txt);

						}


						break;
				}
			}
		}
		$kuesioner_id		= $this->session->userdata('kuesioner_id');
		$section_number = $this->session->userdata('section_number');
		$section_list		= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		if ($section_number!=(count($section_list)-1)){
			$counter 				= 0;
			$section_id			= 0;
			$section_number++;
			foreach ($section_list as $row) {
				// echo '<br>'.$section_id = $row->section_id;
				if ($section_number == $counter){
					$section_id = $row->section_id;
					break;
				}	else {
					$counter++;
				}
			}
			$this->session->set_userdata('section_number', $section_number);
			redirect('frontend/section/'.$section_id);
		} else {
			redirect('frontend/review/');
		}
	}
	public function review()
	{
		$kuesioner_id					= $this->session->userdata('kuesioner_id');
		$responden_id 				= $this->session->userdata('responden_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$data_header['title'] = $kuesioner->title;
		$data_header['sub']		= 'Review';
		$is_submitable				= TRUE;
		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1,1);
		foreach ($section_list as $row) {
			$section_id = $row->section_id;
			break;
		}
		$this->session->set_userdata('section_number',0 );
		$question 						= $this->trans_model->get_all_question_list($kuesioner_id,1);
		$data['question'] 		= $question;
		$answer 							= array();
		foreach ($question as $row) {
			switch ($row->type) {
				case 1: //scale
					$result = $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($result)){
						if ($result->value=='N'){
							$answer[$row->question_id] = '<span class="label label-info">'.$kuesioner->abstain_text.'</span>';
						}else{
							$answer[$row->question_id] = $result->value;
						}
					} else {
						$answer[$row->question_id] = '<span class="label label-important">Kosong</span>';
						$is_submitable				= FALSE;

					}
					break;
				case 2: //multichoice
					$result = $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($result)) {
						if ($result->value=='N'){
							$answer[$row->question_id] = '<span class="label label-info">'.$kuesioner->abstain_text.'</span>';
						}else{
							$answer[$row->question_id] = $result->value_text;
						}
					} else{
						$answer[$row->question_id] = '<span class="label label-important">Kosong</span>';
						$is_submitable				= FALSE;

					}
					break;
				case 3: //open answer
					$result = $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($result)) {
						$answer[$row->question_id] = $result->value_text;
					} else {
						$answer[$row->question_id] = '<span class="label label-important">Kosong</span>';
						$is_submitable				= FALSE;

					}
					break;
				case 4: //multi answer/ checkbox
					$result = $this->trans_model->get_answer_list($responden_id,$row->question_id);
					if (count($result)) {
						$answer[$row->question_id] = '<ul>';
						foreach ($result as $row_2) {
							if ($row_2->value != 'N'){
								$answer[$row->question_id] .= '<li>'.$row_2->value_text .'</li>';

							} else{
								$answer[$row->question_id] = '<span class="label label-info">'.$kuesioner->abstain_text.'</span>';
								break;
							}
						}
						$answer[$row->question_id] .= '</ul>';
						# code...
					} else {
						$answer[$row->question_id] = '<span class="label label-important">Kosong</span>';
						$is_submitable				= FALSE;

					}

					break;

			}
		}
		$data['answer']				= $answer;
		$data['section_list']	= $section_list;
		$data['nav_index']		= 'review';
		$data['section_link']	= 'frontend/section/';
		$data['submitable']		= $is_submitable;
		if ($is_submitable) {
			$data['next_link']		= 'frontend/submit';
		} else {
			$data['next_link']		= '';

		}
		$data['back_link']		= 'frontend/change';

		$this->load->view('template/responden_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('frontend/review_view',$data);
		$this->load->view('template/main_bottom');
	}

	public function change()
	{
		$kuesioner_id 				= $this->session->userdata('kuesioner_id');
		$kuesioner 						= $this->kuesioner_model->get_row($kuesioner_id);
		$section_list					= $this->kuesioner_model->get_section_list($kuesioner_id,1);
		foreach ($section_list as $row) {
			$section_id = $row->section_id;
			break;
		}
		$this->session->set_userdata('section_number',0 );
		redirect('frontend/section/'.$section_id);
	}
	public function submit()
	{
		$responden_id = $this->session->userdata('responden_id');
		$kuesioner_id = $this->session->userdata('kuesioner_id');
		$question 		= $this->trans_model->get_all_question_list($kuesioner_id,1);
		$is_submitable	= TRUE;
		foreach ($question as $row) {
			switch ($row->type) {
				case 1: //scale
					$result = $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($result) == 0){
						$is_submitable				= FALSE;
					}
					break;
				case 2: //multichoice
					$result = $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($result) == 0) {
						$is_submitable				= FALSE;
					}
					break;
				case 3: //open answer
					$result = $this->trans_model->get_answer_row($responden_id,$row->question_id);
					if (count($result) == 0) {
						$is_submitable				= FALSE;
					}
					break;
				case 4: //multi answer/ checkbox
					$result = $this->trans_model->get_answer_list($responden_id,$row->question_id);
					if (count($result) == 0) {
						$is_submitable				= FALSE;
					}

					break;

			}
		}
		if ($is_submitable == TRUE) {
			$this->trans_model->update_status($responden_id,1);
			$this->session->set_userdata('portal_redirect',TRUE);
			redirect('frontend/message/thank_you');

		} else {
			redirect('frontend/change');

		}
	}
	function count_diff_date($time1='', $time2='',$precision=6)
	{
		// If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }

    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }

    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 		$result = array();
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }

			$time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;

    }

    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
				break;
	    }
			$result[$interval] = $value;
			$count++;
	  }


	  // Return string with times
	  // return implode(", ", $times);
	  return $result;
	}
}
/* End of file Frontend.php */
/* Location: ./system/application/controllers/Frontend.php */
