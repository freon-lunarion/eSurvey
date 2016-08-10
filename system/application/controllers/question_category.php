<?php
/**
* Maintance pengelompokan pertanyaan
*
*/
class Question_category extends Controller
{
	function __construct()
	{
		parent::Controller();
		if($this->session->userdata('nik')=='' OR $this->session->userdata('role')=='responden'){
			redirect('account/login_backend');
		}
		$this->load->model('survey_model');
		$this->load->model('question_model');
	}
	public function index()
	{
		$data_header['title'] = 'Question Category';
		$data_header['sub'] 	= '';
		
		$bc[0]['link']				= 'question_category';
		$bc[0]['text']				= 'Survey List';
		$data_bc['list']			= $bc;
		$data_bc['index']			= 0;

		$data['list'] 				= $this->survey_model->get_type_list(1);
		$data['link_detail'] 		= 'question_category/variable/';

		$notif = $this->session->flashdata('notif_code');

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('template/breadcrumb',$data_bc);
		
		$this->load->view('survey_type_view',$data);
		$this->load->view('template/main_bottom');
	}
	//variable
	public function variable($head_id='null')
	{
		if(!is_numeric($head_id)){
			redirect('question_category');
		}
		$head = $this->survey_model->get_type_row($head_id);
		if(count($head)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Question Category';
		$data_header['sub'] 	= 'Variable';

		$bc[0]['link']				= 'question_category';
		$bc[0]['text']				= 'Survey List';
		$bc[1]['link']				= 'question_category/variable/'.$head_id;
		$bc[1]['text']				= $head->type_name;
		$data_bc['list']			= $bc;
		$data_bc['index']			= 1;

		$data['list'] 				= $this->question_model->get_variable_list($head_id,2);
		$data['link_add'] 		= 'question_category/variable_add/'.$head_id;
		$data['link_multi'] 	= 'question_category/variable_multi/'.$head_id;
		$data['link_edit'] 		= 'question_category/variable_edit/';
		$data['link_status'] 	= 'question_category/variable_status/';
		$data['link_detail'] 	= 'question_category/dimension/';

		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('template/breadcrumb',$data_bc);
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('variable_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function variable_add($head_id='null')
	{
		if(!is_numeric($head_id)){
			redirect('question_category');
		}
		$head = $this->survey_model->get_type_row($head_id);
		if(count($head) != 1){
			redirect('question_category');
		}
		$data_header['title'] = 'Variable';
		$data_header['sub'] 	= 'Add';

		$data['process'] 			= 'question_category/variable_add_process/';
		$data['back']					=	'question_category/variable/'.$head_id;
		$data['hidden']				= array('hdn_head'=>$head_id);
		$data['survey_type']	= $head->type_name;

		$data['code']					= '';
		$data['name']					= '';

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('variable_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function variable_add_process()
	{
		$head_id = $this->input->post('hdn_head');
		$this->form_validation->set_rules('hdn_head', 'Survey Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Variable Code', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Variable Name', 'trim|required|min_length[3]|max_length[50]|xss_clean');
		if ($this->form_validation->run() == FALSE){
			$code = 2;
			$text = validation_errors();
		}else{
			$code = $this->input->post('txt_code');
			$name = $this->input->post('txt_name');
			$return = $this->question_model->add_variable($code,$name,$head_id);
			if ($return) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Add new Variable';
		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/variable/'.$head_id);
				break;
			case 2:
				redirect('question_category/variable_add/'.$head_id);
				break;
		}
	}
	public function variable_multi($head_id='null')
	{
		if(!is_numeric($head_id)){
			redirect('question_category');
		}
		$head = $this->survey_model->get_type_row($head_id);
		if(count($head) != 1){
			redirect('question_category');
		}
		$data_header['title'] = 'Variable';
		$data_header['sub'] 	= 'Add Multi';

		$data['process'] 			= 'question_category/variable_multi_process/';
		$data['back']					=	'question_category/variable/'.$head_id;
		$data['hidden']				= array('hdn_head'=>$head_id,'hdn_num'=>2);
		$data['survey_type']	= $head->type_name;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('variable_form_multi',$data);
		$js_list[0]						= 'custom_js/question_category.multi';	
		$data_bot['js_list'] 	= $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}
	public function variable_multi_process()
	{
		$head_id = $this->input->post('hdn_head');
		$num 				 = $this->input->post('hdn_num');
		$this->form_validation->set_rules('hdn_head', 'Survey Type', 'trim|required|xss_clean');
		for ($i=1; $i <=$num ; $i++) { 
			$this->form_validation->set_rules('txt_code_'.$i, 'Variable Code #'.$i, 'trim|required|min_length[1]|max_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_name_'.$i, 'Variable Name #'.$i, 'trim|required|min_length[3]|max_length[50]|xss_clean');
		}
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();
		}else{
			$success = 0;
			$error = 0;
			for ($i=1; $i <=$num ; $i++) { 
				$code = $this->input->post('txt_code_'.$i);
				$name = $this->input->post('txt_name_'.$i);
				$return = $this->question_model->add_variable($code,$name,$head_id);
				if ($return) {
					$success++;
				}else{
					$error++;
				}

			}
			if ($success) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Add '.$success.' Variable, with '.$error .'error';
		}

		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/variable/'.$head_id);
				break;
			case 2:
				redirect('question_category/variable_multi/'.$head_id);
				break;
		}
	}
	public function variable_edit($id='null')
	{
		if(!is_numeric($id)){
			redirect('question_category');
		}
		$old = $this->question_model->get_variable_row($id);
		if(count($old)!=1){
			redirect('question_category');
		}
		$head = $this->survey_model->get_type_row($old->survey_type_id);
		$data_header['title'] = 'Variable';
		$data_header['sub'] 	= 'Edit';

		$data['process'] 			= 'question_category/variable_edit_process/';
		$data['back']					=	'question_category/variable/'.$old->survey_type_id;
		$data['hidden']				= array('hdn_head'=>$old->survey_type_id,'hdn_id'=>$old->variable_id);
		$data['survey_type']	= $head->type_name;

		$data['code']					= $old->variable_code;
		$data['name']					= $old->variable_text;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('variable_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function variable_edit_process()
	{
		$variable_id = $this->input->post('hdn_id');
		$head_id = $this->input->post('hdn_head');
		$this->form_validation->set_rules('hdn_head', 'Survey Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('hdn_id', 'Survey Type', 'trim|required|xss_clean');

		$this->form_validation->set_rules('txt_code', 'Variable Code', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Variable Name', 'trim|required|min_length[3]|max_length[50]|xss_clean');
		if($this->form_validation->run()==FALSE){
			$code = 2;
			$text = validation_errors();
		}else{
			
			$code = $this->input->post('txt_code');
			$name = $this->input->post('txt_name');
			$return = $this->question_model->edit_variable($variable_id,$code,$name);
			if ($return) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Edit Variable';
		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/variable/'.$head_id);
				break;
			case 2:
				redirect('question_category/variable_edit/'.$variable_id);
				break;
		}
	}
	public function variable_status($id)
	{
		$old = $this->question_model->get_variable_row($id);
		if($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->question_model->edit_variable_status($id,$status);
		redirect('question_category/variable/'.$old->survey_type_id);
	}
	//dimension
	public function dimension($variable_id='null')
	{
		if(!is_numeric($variable_id)){
			redirect('question_category');
		}
		$variable 						= $this->question_model->get_variable_row($variable_id);
		if(count($variable)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Question Category';
		$data_header['sub'] 	= 'Dimension';

		$bc[0]['link']				= 'question_category';
		$bc[0]['text']				= 'Survey List';
		$bc[1]['link']				= 'question_category/variable/'.$variable->survey_type_id;
		$bc[1]['text']				= $variable->type_name;
		$bc[2]['link']				= 'question_category/dimension/'.$variable_id;
		$bc[2]['text']				= $variable->variable_text;
		$data_bc['list']			= $bc;
		$data_bc['index']			= 2;

		$data['list'] 				= $this->question_model->get_dimension_list($variable_id,2);
		$data['link_add'] 		= 'question_category/dimension_add/'.$variable_id ;
		$data['link_multi'] 	= 'question_category/dimension_multi/'.$variable_id ;
		$data['link_edit'] 		= 'question_category/dimension_edit/';
		$data['link_status'] 	= 'question_category/dimension_status/';
		$data['link_detail'] 	= 'question_category/indicator/';


		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('template/breadcrumb',$data_bc);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('dimension_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function dimension_add($variable_id='null')
	{
		if(!is_numeric($variable_id)){
			redirect('question_category');
		}
		$head = $this->question_model->get_variable_row($variable_id);
		if(count($head)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Dimension';
		$data_header['sub'] 	= 'Add';

		$data['process'] 			= 'question_category/dimension_add_process/';
		$data['back']					=	'question_category/dimension/'.$variable_id;
		$data['hidden']				= array('hdn_head'=>$variable_id);
		
		$data['survey_type']	= $head->type_name;
		$data['variable']			= $head->variable_text;

		$data['code']					= '';
		$data['name']					= '';

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('dimension_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function dimension_add_process()
	{
		$head_id = $this->input->post('hdn_head');

		$this->form_validation->set_rules('hdn_head', 'Variable ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Dimension Code', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Dimension Name', 'trim|required|min_length[3]|max_length[50]|xss_clean');
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();
		}else{
			$code = $this->input->post('txt_code');
			$name = $this->input->post('txt_name');
			$return = $this->question_model->add_dimension($code,$name,$head_id);
			if ($return) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Add new Dimension';
		}

		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/dimension/'.$head_id);
				break;
			case 2:
				redirect('question_category/dimension_add/'.$head_id);
				break;
		}
	}
	public function dimension_multi($variable_id='null')
	{
		if(!is_numeric($variable_id)){
			redirect('question_category');
		}
		$head = $this->question_model->get_variable_row($variable_id);
		if(count($head)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Dimension';
		$data_header['sub'] 	= 'Multi Add';
		$data['process'] 			= 'question_category/dimension_multi_process/';
		$data['back']					=	'question_category/dimension/'.$variable_id;
		$data['hidden']				= array('hdn_head'=>$variable_id,'hdn_num'=>2);
		
		$data['survey_type']	= $head->type_name;
		$data['variable']			= $head->variable_text;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('dimension_form_multi',$data);
		$js_list[0]						= 'custom_js/question_category.multi';	
		$data_bot['js_list'] 	= $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}
	public function dimension_multi_process()
	{
		$head_id		 = $this->input->post('hdn_head');
		$num 				 = $this->input->post('hdn_num');
		$this->form_validation->set_rules('hdn_head', 'variable ID', 'trim|required|xss_clean');
		for ($i=1; $i <=$num ; $i++) { 
			$this->form_validation->set_rules('txt_code_'.$i, 'Dimension Code #'.$i, 'trim|required|min_length[1]|max_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_name_'.$i, 'Dimension Name #'.$i, 'trim|required|min_length[3]|max_length[50]|xss_clean');
		}
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();
		}else{
			$success = 0;
			$error = 0;
			for ($i=1; $i <=$num ; $i++) { 
				$code = $this->input->post('txt_code_'.$i);
				$name = $this->input->post('txt_name_'.$i);
				$return = $this->question_model->add_dimension($code,$name,$head_id);
				if ($return) {
					$success++;
				}else{
					$error++;
				}
			}
			if ($success) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Add '.$success.' Dimension, with '.$error .'error';
		}

		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/dimension/'.$head_id);
				break;
			case 2:
				redirect('question_category/dimension_multi/'.$head_id);
				break;
		}
	}
	public function dimension_edit($id='null')
	{
		if(!is_numeric($id)){
			redirect('question_category');
		}
		$old = $this->question_model->get_dimension_row($id);
		if(count($old)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Dimension';
		$data_header['sub'] 	= 'Edit';

		$data['process'] 			= 'question_category/dimension_edit_process/';
		$data['back']					=	'question_category/dimension/'.$old->survey_type_id;
		$data['hidden']				= array('hdn_head'=>$old->variable_id,'hdn_id'=>$old->dimension_id);
		$data['survey_type']	= $old->type_name;
		$data['variable']			= $old->variable_text;

		$data['code']					= $old->dimension_code;
		$data['name']					= $old->dimension_text;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('dimension_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function dimension_edit_process()
	{
		$head_id = $this->input->post('hdn_head');
		$dimension_id = $this->input->post('hdn_id');
		$this->form_validation->set_rules('hdn_head', 'Variable ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('hdn_id', 'Dimension ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Dimension Code', 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Dimension Name', 'trim|required|min_length[3]|max_length[50]|xss_clean');
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();
		}else{
			
			$code = $this->input->post('txt_code');
			$name = $this->input->post('txt_name');
			$return = $this->question_model->edit_dimension($dimension_id,$code,$name);
			if ($return) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Edit dimension';
		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/dimension/'.$head_id);
				break;
			case 2:
				redirect('question_category/dimension_edit/'.$dimension_id);
				break;
		}
	}
	public function dimension_status($id)
	{
		$old = $this->question_model->get_dimension_row($id);
		if($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->question_model->edit_dimension_status($id,$status);
		redirect('question_category/dimension/'.$old->variable_id);
	}
	//indicator
	public function indicator($dimension_id='null')
	{
		if(!is_numeric($dimension_id)){
			redirect('question_category');
		}
		$dimension 						= $this->question_model->get_dimension_row($dimension_id);
		if(count($dimension)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Question Category';
		$data_header['sub'] 	= 'Indicator';

		$bc[0]['link']				= 'question_category';
		$bc[0]['text']				= 'Survey List';
		$bc[1]['link']				= 'question_category/variable/'.$dimension->survey_type_id;
		$bc[1]['text']				= $dimension->type_name;
		$bc[2]['link']				= 'question_category/dimension/'.$dimension->variable_id;
		$bc[2]['text']				= $dimension->variable_text;
		$bc[3]['link']				= 'question_category/indicator/'.$dimension_id;
		$bc[3]['text']				= $dimension->dimension_text;
		$data_bc['list']			= $bc;
		$data_bc['index']			= 3;

		$data['list'] 				= $this->question_model->get_indicator_list($dimension_id,2);
		$data['link_add'] 		= 'question_category/indicator_add/'.$dimension_id ;
		$data['link_multi'] 	= 'question_category/indicator_multi/'.$dimension_id ;
		$data['link_edit'] 		= 'question_category/indicator_edit/';
		$data['link_status'] 	= 'question_category/indicator_status/';
		$data['link_detail'] 	= 'question_category/indicator/';

		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('template/breadcrumb',$data_bc);
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('indicator_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function indicator_add($dimension_id='null')
	{
		if (!is_numeric($dimension_id)) {
			redirect('question_category');
		}
		$head = $this->question_model->get_dimension_row($dimension_id);
		if (count($head)!=1) {
			redirect('question_category');
		}
		$data_header['title'] = 'Indicator';
		$data_header['sub'] 	= 'Add';

		$data['process'] 			= 'question_category/indicator_add_process/';
		$data['back']					=	'question_category/indicator/'.$dimension_id;
		$data['hidden']				= array('hdn_head'=>$dimension_id);
		
		$data['survey_type']	= $head->type_name;
		$data['variable']			= $head->variable_text;
		$data['dimension']		= $head->dimension_text;

		$data['code']					= '';
		$data['name']					= '';

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('indicator_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function indicator_add_process()
	{
		$head_id = $this->input->post('hdn_head');
		$this->form_validation->set_rules('hdn_head', 'Dimension ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Indicator Code', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Indicator Name', 'trim|required|min_length[3]|max_length[150]|xss_clean');
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();

		}else{
			$code = $this->input->post('txt_code');
			$name = $this->input->post('txt_name');
			$return = $this->question_model->add_indicator($code,$name,$head_id);
			if ($return) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Add new Indicator';
		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/indicator/'.$head_id);
				# code...
				break;
			case 2:
				redirect('question_category/indicator_add/'.$head_id);
				# code...
				break;
		}
	}
	public function indicator_multi($dimension_id='null')
	{
		if (!is_numeric($dimension_id)) {
			redirect('question_category');
		}
		$head = $this->question_model->get_dimension_row($dimension_id);
		if (count($head)!=1) {
			redirect('question_category');
		}
		$data_header['title'] = 'Indicator';
		$data_header['sub'] 	= 'Multi Add';

		$data['process'] 			= 'question_category/indicator_multi_process/';
		$data['back']					=	'question_category/indicator/'.$dimension_id;
		$data['hidden']				= array('hdn_head'=>$dimension_id,'hdn_num'=>2);
		
		$data['survey_type']	= $head->type_name;
		$data['variable']			= $head->variable_text;
		$data['dimension']		= $head->dimension_text;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('indicator_form_multi',$data);
		$js_list[0]						= 'custom_js/question_category.multi';	
		$data_bot['js_list'] 	= $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}
	public function indicator_multi_process()
	{
		$head_id		 = $this->input->post('hdn_head');
		$num 				 = $this->input->post('hdn_num');
		$this->form_validation->set_rules('hdn_head', 'Dimension ID', 'trim|required|xss_clean');
		for ($i=1; $i <=$num ; $i++) { 
			$this->form_validation->set_rules('txt_code_'.$i, 'Indicator Code #'.$i, 'trim|required|min_length[1]|max_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_name_'.$i, 'Indicator Name #'.$i, 'trim|required|min_length[3]|max_length[50]|xss_clean');
		}
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();
		}else{
			$success = 0;
			$error = 0;
			for ($i=1; $i <=$num ; $i++) { 
				$code = $this->input->post('txt_code_'.$i);
				$name = $this->input->post('txt_name_'.$i);
				$return = $this->question_model->add_indicator($code,$name,$head_id);
				if ($return) {
					$success++;
				}else{
					$error++;
				}
			}
			if ($success) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Add '.$success.' Indicator, with '.$error .' error';
		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/indicator/'.$head_id);
				break;
			case 2:
				redirect('question_category/indicator_multi/'.$head_id);
				break;
		}
	}
	public function indicator_edit($id='null')
	{
		if(!is_numeric($id)){
			redirect('question_category');
		}
		$old = $this->question_model->get_indicator_row($id);
		if(count($old)!=1){
			redirect('question_category');
		}
		$data_header['title'] = 'Indicator';
		$data_header['sub'] 	= 'Edit';

		$data['process'] 			= 'question_category/indicator_edit_process/';
		$data['back']					=	'question_category/indicator/'.$old->survey_type_id;
		$data['hidden']				= array('hdn_head'=>$old->dimension_id,'hdn_id'=>$old->indicator_id);
		$data['survey_type']	= $old->type_name;
		$data['variable']			= $old->variable_text;
		$data['dimension']		= $old->dimension_text;

		$data['code']					= $old->indicator_code;
		$data['name']					= $old->indicator_text;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$notif['code'] = $this->session->flashdata('notif_code');
		$notif['text'] = $this->session->flashdata('notif_text');
		switch ($notif['code']) {
			case 1://success
				$this->load->view('notif/success',$notif);
				break;
			case 2://error
				$this->load->view('notif/error',$notif);
				break;
		}
		$this->load->view('indicator_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function indicator_edit_process()
	{
		$head_id = $this->input->post('hdn_head');
		$indicator_id = $this->input->post('hdn_id');
		$this->form_validation->set_rules('hdn_head', 'Dimension ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('hdn_id', 'Indicator ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Indicator Code', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Indicator Name', 'trim|required|min_length[3]|max_length[150]|xss_clean');
		if ($this->form_validation->run()==FALSE) {
			$code = 2;
			$text = validation_errors();
		}else{
			
			$code = $this->input->post('txt_code');
			$name = $this->input->post('txt_name');
			$return = $this->question_model->edit_indicator($indicator_id,$code,$name);
			if ($return) {
				$code = 1;
			}else{
				$code = 2;
			}
			$text = 'Edit indicator';

		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_category/indicator/'.$head_id);
				break;
			case 2:
				redirect('question_category/indicator_edit/'.$indicator_id);
				break;			
		}
	}
	public function indicator_status($id)
	{
		$old = $this->question_model->get_indicator_row($id);
		if($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->question_model->edit_indicator_status($id,$status);
		redirect('question_category/indicator/'.$old->dimension_id);
	}
}
/* End of file question_category.php */
/* Location: ./system/application/controllers/question_category.php */