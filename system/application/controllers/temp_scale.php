<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * template skala 
 */

class Temp_scale extends CI_Controller {

	function __construct()
	{
		parent::Controller();
		if($this->session->userdata('nik')=='' OR $this->session->userdata('role')=='responden'){
			redirect('account/login_backend');
		}
		$this->load->model('survey_model');
	}
	public function index()
	{
		
		$data_header['title'] = 'Survey Type';
		$data_header['sub'] 	= '';

		$data['list'] 				= $this->survey_model->get_scale_list(2);
		$data['link_add'] 		= 'temp_scale/add/';
		$data['link_edit'] 		= 'temp_scale/edit/';
		$data['link_edit'] 		= 'temp_scale/remove/';
		$data['link_status'] 	= 'temp_scale/status/';
		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);

		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('survey_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function add()
	{
		$data_header['title'] = 'Scale Template'
		$data_header['sub'] 	= 'Add';
		$data['process'] 			= 'temp_scale/add_process/';
		$data['back'] 				= 'temp_scale';

		$data['name'] 				= '';
		$data['min_val'] 			= '';
		$data['max_val'] 			= '';
		$data['min_text'] 		= '';
		$data['max_text'] 		= '';
		$data['abstain']			= TRUE;
		$data['hidden']				= '';
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('scale_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function add_process()
	{
		
	}
	public function edit($id='')
	{
		# code...
	}
	public function edit_process()
	{
		# code...
	}
	public function remove($id='')
	{
		# code...
	}
	public function status($id='')
	{
		# code...
	}

}

/* End of file temp_scale.php */
/* Location: ./application/controllers/temp_scale.php */