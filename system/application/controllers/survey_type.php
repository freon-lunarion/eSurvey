<?php
/**
* Jenis - jenis Survey
*
*/
class Survey_type extends Controller
{
	
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

		$data['list'] 				= $this->survey_model->get_type_list(2);
		$data['link_add'] 		= 'survey_type/add/';
		$data['link_edit'] 		= 'survey_type/edit/';
		$data['link_delete'] 	= 'survey_type/delete/';
		$data['link_status'] 	= 'survey_type/status/';

		$notif['code'] = $this->session->userdata('notif_code');
		$notif['text'] = $this->session->userdata('notif_text');
		$this->session->unset_userdata('notif_code');
		$this->session->unset_userdata('notif_text');

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
		$data_header['title'] = 'Survey Type';
		$data_header['sub'] 	= 'Add';

		$data['process'] 			= 'survey_type/add_process/';
		$data['back'] 				= 'survey_type';

		$data['name'] 				= '';
		$data['desc'] 				= '';
		$data['hidden']				= '';
		$notif['code'] = $this->session->userdata('notif_code');
		$notif['text'] = $this->session->userdata('notif_text');

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
		$this->load->view('survey_form',$data);
		$this->load->view('template/main_bottom');
	}

	public function add_process()
	{
		$this->form_validation->set_rules('txt_name', 'Type Name', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_desc', 'Type Name', 'trim|max_length[140]|xss_clean');
		if ($this->form_validation->run() == FALSE){
			$code = 2;
			$text = validation_errors();
		}else{
			$name = $this->input->post('txt_name');
			$desc = $this->input->post('txt_desc');
			$return = $this->survey_model->add_type($name,$desc);
			if($return){
				$code = 1;
			}else {
				$code = 2;
			}
			$text = 'Add new Survey Type';
		}
		$this->session->set_userdata('notif_code', $code);
		$this->session->set_userdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('survey_type');
				break;
			case 2:
				redirect('survey_type/add');
				break;
		}


	}

	public function edit($id='a')
	{
		if(!is_numeric($id) or $id==0 or $id==''){
			redirect('survey_type');
		}
		$old = $this->survey_model->get_type_row($id);
		if(count($old)!=1){
			redirect('survey_type');
		}
		$data_header['title'] = 'Survey Type';
		$data_header['sub'] 	= 'Edit';
		$data['process'] 			= 'survey_type/edit_process/';
		$data['back'] 				= 'survey_type';

		$data['name']					= $old->type_name;
		$data['desc'] 				= $old->description;
		$data['hidden']				= array('hdn_id'=>$old->survey_type_id);
		$notif['code']				= $this->session->userdata('notif_code');
		$notif['text']				= $this->session->userdata('notif_text');

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
		$this->load->view('survey_form',$data);
		$this->load->view('template/main_bottom');
	}

	public function edit_process()
	{
		$id = $this->input->post('hdn_id');
		$this->form_validation->set_rules('hdn_id', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Type Name', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_desc', 'Type Name', 'trim|max_length[140]|xss_clean');
		if ($this->form_validation->run() == FALSE){
			$code = 2;
			$text = validation_errors();

		}else{
			$name = $this->input->post('txt_name');
			$desc = $this->input->post('txt_desc');
			$return = $this->survey_model->edit_type($id,$name,$desc);
			if($return){
				$code = 1;

			}else {
				$code = 2;
			}
			$text = 'Edit Survey Type';
		}
		$this->session->set_userdata('notif_code', $code);
		$this->session->set_userdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('survey_type');
				break;
			case 2:
				redirect('survey_type/edit/'.$id);
				break;
		}
	}
	public function status($id)
	{
		$old = $this->survey_model->get_type_row($id);
		if($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->survey_model->edit_type_status($id,$status);
		redirect('survey_type');		
	}
	public function delete($id)
	{
		$this->survey_model->del_type($id);
		$this->session->set_userdata('notif_code', 1);
		$this->session->set_userdata('notif_text', 'Delete Survey Type');

		redirect('survey_type');
	}

	
}
/* End of file survey_type.php */
/* Location: ./system/application/controllers/survey_type.php */