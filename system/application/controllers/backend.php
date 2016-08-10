<?php
/**
* Dashboard backend
*
*/
class Backend extends Controller
{	
	function __construct()
	{
		parent::Controller();
		if($this->session->userdata('nik')=='' OR $this->session->userdata('role')=='responden'){
			redirect('account/login_backend');
		}
		
	}

	public function index()
	{
		$this->load->model('report_model');
		$this->load->model('kuesioner_model');
		$kuesioner 					= $this->kuesioner_model->get_list(1);
		$data['kuesioner'] 	= $kuesioner;
		$cnt_sbmt						= array();
		foreach ($kuesioner as $row) {
			$cnt_sbmt[$row->kuesioner_id] = $this->report_model->count_responden_submited($row->kuesioner_id);
		}
		$data['cnt_sbmt']		= $cnt_sbmt;
		$this->load->view('template/admin_top');
		$this->load->view('backend_view',$data);
		$this->load->view('template/main_bottom');
	}
}
/* End of file Backend.php */
/* Location: ./system/application/controllers/Backend.php */