<?php
/**
* Maintance pertanyaan
*
*/
class Question_bank extends Controller
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
		$data_header['title'] = 'Question Bank';
		$data_header['sub'] 	= '';

		$bc[0]['link']				= 'question_bank';
		$bc[0]['text']				= 'Survey List';
		$data_bc['list']			= $bc;
		$data_bc['index']			= 0;

		$data['list'] 				= $this->survey_model->get_type_list(1);
		$data['link_detail'] 	= 'question_bank/repo/';

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('template/breadcrumb',$data_bc);
		
		$this->load->view('survey_type_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function repo($head_id)
	{
		$head = $this->survey_model->get_type_row($head_id);
		$data_header['title'] = 'Question Bank';
		$data_header['sub'] 	= 'Question List';
		$bc[0]['link']				= 'question_bank';
		$bc[0]['text']				= 'Survey List';
		$bc[1]['link']				= 'question_bank/list/'.$head_id;
		$bc[1]['text']				= $head->type_name;
		$data_bc['list']			= $bc;
		$data_bc['index']			= 1;
		$data['list'] 				= $this->question_model->get_bank_list($head_id,2);
		$data['link_add'] 		= 'question_bank/add/'.$head_id;
		$data['link_edit'] 		= 'question_bank/edit/';
		$data['link_status'] 	= 'question_bank/status/';
		$data['link_delete'] 	= 'question_bank/delete/';


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
		$this->load->view('repo_view',$data);
		$this->load->view('template/main_bottom');
	}
	public function add($head_id='null')
	{
		if(!is_numeric($head_id)){
			redirect('question_bank');
		}
		$head = $this->survey_model->get_type_row($head_id);
		if(count($head)!=1){
			redirect('question_bank');
		}
		$data_header['title'] = 'Question Bank';
		$data_header['sub'] 	= 'Add';
		$data['process']			= 'question_bank/add_process';
		$data['hidden']				= array('hdn_survey'=>$head_id);
		$data['back']					=	'question_bank/repo/'.$head_id;

		$data['survey_type']	= $head->type_name;
		$data['code']					= '';
		$data['text']					= '';
		$data['type_sel']			= '';
		$data['var_sel']			= '';
		$data['dim_sel']			= '';
		$data['ind_sel']			= '';
		$data['min_val']			= 1;
		$data['max_val']			= 5;
		$data['max_sel']			= 2;
		$data['min_text']			= 'Sangat Tidak Setuju';
		$data['max_text']			= 'Sangat Setuju';		

		$data['type_list']		= array('','Scale','Multiple Choice','Open Answer','Multi Answer');

		$temp_list 						= $this->question_model->get_variable_list($head_id,1);
		$var_list[]						= '';
		foreach ($temp_list as $row) {
			$var_list[$row->variable_id]	= $row->variable_text;
		}
		$data['var_list']			= $var_list;
		$data['dim_list']			= array('');
		$data['ind_list']			= array('');

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
		$js_list = array('ckeditor/ckeditor');
		$data_bot['js_list'] = $js_list;
		$this->load->view('question/add_form',$data);
		$this->load->view('template/main_bottom',$data_bot);
		$this->load->view('question/add_form_js');

	}

	public function ajax_dim()
	{
		$var_id = $this->input->post('var_id');
		$result ='<option value="0"></option>';
		if ($var_id){
			$list = $this->question_model->get_dimension_list($var_id,1);
			foreach ($list as $row) {
				$result .='<option value="'.$row->dimension_id.'">'.$row->dimension_text.'</option>';
			}
		}
		echo $result;
	}

	public function ajax_ind()
	{
		$dim_id = $this->input->post('dim_id');

		$result ='<option value="0"></option>';
		if($dim_id){
			$list = $this->question_model->get_indicator_list($dim_id,1);
			foreach ($list as $row) {
				$result .='<option value="'.$row->indicator_id.'">'.$row->indicator_text.'</option>';
			}
		}
		echo $result;
	}
	public function add_process()
	{
		$survey_type 	= $this->input->post('hdn_survey');
		$this->form_validation->set_rules('hdn_survey', 'Survey Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_type', 'Question Type', 'trim|required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Question Code', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_text', 'Question', 'trim|required|min_length[5]|xss_clean');
		$type 		= $this->input->post('slc_type');
		$q_code 	= $this->input->post('txt_code');
		$q_text 	= $this->input->post('txt_text');
		$abstain 	= $this->input->post('chk_abstain');
		$var_id 	= $this->input->post('slc_var');
		$dim_id 	= $this->input->post('slc_dim');
		$ind_id 	= $this->input->post('slc_ind');
		switch ($type) {
			case 1: // scale
				$this->form_validation->set_rules('txt_min_val', 'Minimum Value', 'trim|required|integer|greater_than[-1]|less_than[2]|xss_clean');
				$this->form_validation->set_rules('txt_max_val', 'Maximum Value', 'trim|required|integer|greater_than[1]|is_natural_no_zero|xss_clean');
				$this->form_validation->set_rules('txt_min_text', 'Minimum Text', 'trim|required|max_length[30]|xss_clean');
				$this->form_validation->set_rules('txt_max_text', 'Maximum Text', 'trim|required|max_length[30]|xss_clean');
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();

				}else{
					$min_val 	= $this->input->post('txt_min_val');
					$max_val 	= $this->input->post('txt_max_val');
					$min_text = $this->input->post('txt_min_text');
					$max_text = $this->input->post('txt_max_text');
					$result 	= $this->question_model->add_scale($q_code,$q_text,$survey_type,$var_id,$dim_id,$ind_id,$min_val,$max_val,$min_text,$max_text,$abstain);
					$text = 'Add new Question';
				}

				break;

			case 2: // multiple choice
				$opt_num	=	$this->input->post('hdn_num');
				for ($i=1; $i <=$opt_num ; $i++) { 
					$this->form_validation->set_rules('txt_option_'.$i, 'Option #'.$i, 'trim|required|xss_clean');
					$this->form_validation->set_rules('txt_opt_val_'.$i, 'Option Value #'.$i, 'trim|required|integer|xss_clean');
					
				}
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$result 	= $this->question_model->add_bank($q_code,$q_text,$type,$survey_type,$var_id,$dim_id,$ind_id,$abstain);
					$last			= $this->question_model->get_bank_last();
					// insert option
					for ($i=1; $i <=$opt_num ; $i++) { 
						$opt_text	= $this->input->post('txt_option_'.$i);
						$opt_val	= $this->input->post('txt_opt_val_'.$i);
						$this->question_model->add_option($last->question_id,$opt_text,$opt_val);
					}
					$text = 'Add new Question';
				}
				break;
			case 3: // open answer
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$result = $this->question_model->add_bank($q_code,$q_text,$type,$survey_type,$var_id,$dim_id,$ind_id,0);
					$text = 'Add new Question';
				}
				break;
			case 4: // multi answer
				$opt_num	=	$this->input->post('hdn_num');
				for ($i=1; $i <=$opt_num ; $i++) { 
					$this->form_validation->set_rules('txt_option_'.$i, 'Option #'.$i, 'trim|required|xss_clean');
					$this->form_validation->set_rules('txt_opt_val_'.$i, 'Option Value #'.$i, 'trim|required|integer|xss_clean');
					
				}
				$this->form_validation->set_rules('nm_max_sel', 'Maximum Select', 'trim|required|is_natural_no_zero|xss_clean');
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$max_sel 	= $this->input->post('nm_max_sel');
					$result 	= $this->question_model->add_checkbox($q_code,$q_text,$survey_type,$var_id,$dim_id,$ind_id,1,$max_sel,'','',$abstain);
					$last			= $this->question_model->get_bank_last();
					// insert option
					for ($i=1; $i <=$opt_num ; $i++) { 
						$opt_text	= $this->input->post('txt_option_'.$i);
						$opt_val	= $this->input->post('txt_opt_val_'.$i);
						$this->question_model->add_option($last->question_id,$opt_text,$opt_val);
					}
					$text = 'Add new Question';
				}
				break;
			default :
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}
				break;
		}
		if ($result){
			$code = 1;
		
		}else{
			$code = 2;
		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_bank/repo/'.$survey_type);
				break;
			case 2:
				redirect('question_bank/add/'.$survey_type);
				break;
		}
	}
	public function edit($id='null')
	{
		if(!is_numeric($id)){
			redirect('question_bank');
		}
		$old = $this->question_model->get_bank_row($id);
		if(count($old)!=1){
			redirect('question_bank');
		}
		$data_header['title'] = 'Question Bank';
		$data_header['sub'] 	= 'Edit';
		$data['process']			= 'question_bank/edit_process';
		$data['hidden']				= array('hdn_survey'=>$old->survey_type_id,'hdn_id'=>$old->question_id);
		$data['back']					=	'question_bank/repo/'.$old->survey_type_id;

		$data['survey_type']	= $old->type_name;
		$data['code']					= $old->question_code;
		$data['text']					= $old->question_text;
		$data['abstain']			= $old->abstain_flag;
		$data['var_sel']			= $old->variable_id;
		$data['dim_sel']			= $old->dimension_id;
		$data['ind_sel']			= $old->indicator_id;

		switch ($old->type) {
			case 1:
				$data['type'] = 'Scale';
				break;
			case 2:
				$data['type'] = 'Multiple Choice';
				break;
			case 3:
				$data['type'] = 'Open Answer';
				break;
			case 4:
				$data['type'] = 'Multi Answer';
				break;
		}
		$temp_list 	= $this->question_model->get_variable_list($old->survey_type_id,1);
		$var_list[]	= '';
		foreach ($temp_list as $row) {
			$var_list[$row->variable_id]	= $row->variable_text;
		}
		$data['var_list']			= $var_list;
		
		if($old->variable_id){
			$temp_list 	= $this->question_model->get_dimension_list($old->variable_id,1);
			$dim_list[]	= '';
			foreach ($temp_list as $row) {
				$dim_list[$row->dimension_id]	= $row->dimension_text;
			}
			$data['dim_list']		= $dim_list;
			if ($old->dimension_id){
				$temp_list 	= $this->question_model->get_indicator_list($old->dimension_id,1);
				$ind_list[]	= '';
				foreach ($temp_list as $row) {
					$ind_list[$row->indicator_id]	= $row->indicator_text;
				}
				$data['ind_list']	= $ind_list;
			}else{
				$data['ind_list']	= array();
			}
			
		} else {
			$data['dim_list']	= array();
			$data['ind_list']	= array();

		}

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
		$this->load->view('question/edit_form',$data);
		switch ($old->type) {
			case 1: //scale
				$data['min_val'] = $old->min_val;
				$data['max_val'] = $old->max_val;
				$data['min_text'] = $old->min_text;
				$data['max_text'] = $old->max_text;
				$this->load->view('question/edit_form_scale',$data);
				break;
			case 2: //multiple choice
				$opt_list = $this->question_model->get_option_list($old->question_id);
				$count_list = count($opt_list);
				$data['opt_count'] = $count_list;
				$data['opt_list'] = $opt_list;
				$this->load->view('question/edit_form_multi_1',$data);
				break;
			case 3: //open answer
				$this->load->view('question/edit_form_open');
				break;
			case 4: //multi answer
				$opt_list = $this->question_model->get_option_list($old->question_id);
				$count_list = count($opt_list);
				$data['opt_count'] 	= $count_list;
				$data['opt_list'] 	= $opt_list;
				$data['max_sel']		= $old->max_val;
				$this->load->view('question/edit_form_multi_2',$data);
				break;
		}
		$js_list = array('ckeditor/ckeditor');
		$data_bot['js_list'] = $js_list;
		$this->load->view('template/main_bottom',$data_bot);
		$this->load->view('question/edit_form_js');

	}
	public function edit_process()
	{
		$id 	= $this->input->post('hdn_id');
		$old 	= $this->question_model->get_bank_row($id);
		$survey_type  = $old->survey_type_id;
		$q_code 			= $this->input->post('txt_code');
		$q_text 			= $this->input->post('txt_text');
		$abstain 			= $this->input->post('chk_abstain');
		$var_id 			= $this->input->post('slc_var');
		$dim_id 			= $this->input->post('slc_dim');
		$ind_id 			= $this->input->post('slc_ind');
		
		$this->form_validation->set_rules('hdn_id', 'Question ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Question Code', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_text', 'Question', 'trim|required|min_length[5]|xss_clean');
		switch ($old->type) {
			case 1: //scale
				$this->form_validation->set_rules('nm_min_val', 'Minimum Value', 'trim|required|integer|greater_than[-1]|less_than[2]|xss_clean');
				$this->form_validation->set_rules('nm_max_val', 'Maximum Value', 'trim|required|integer|greater_than[1]|is_natural_no_zero|xss_clean');
				$this->form_validation->set_rules('txt_min_text', 'Minimum Text', 'trim|required|max_length[30]|xss_clean');
				$this->form_validation->set_rules('txt_max_text', 'Maximum Text', 'trim|required|max_length[30]|xss_clean');

				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$min_val = $this->input->post('nm_min_val');
					$max_val = $this->input->post('nm_max_val');
					$min_text = $this->input->post('txt_min_text');
					$max_text = $this->input->post('txt_max_text');
					$this->question_model->edit_scale($id,$q_code,$q_text,$var_id,$dim_id,$ind_id,$min_val,$max_val,$min_text,$max_text,$abstain);
					$code = 1;
					$text = 'Edit Question';
				}
				break;
			case 2: //multiple choice

				$opt_num	=	$this->input->post('hdn_num');
				for ($i=1; $i <= $opt_num; $i++) { 
					$this->form_validation->set_rules('txt_option_'.$i, 'Option #'.$i, 'trim|required|xss_clean');
					$this->form_validation->set_rules('txt_opt_val_'.$i, 'Option Value #'.$i, 'trim|required|integer|xss_clean');
					$opt_text[$i] = $this->input->post('txt_option_'.$i);
					$opt_val[$i] = $this->input->post('txt_opt_val_'.$i);
					$opt_id[$i] = $this->input->post('hdn_opt_'.$i);
				}
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$opt_list = $this->question_model->get_option_list($id);
					$result 	= $this->question_model->edit_bank($id,$q_code,$q_text,$var_id,$dim_id,$ind_id,$abstain);
					foreach ($opt_list as $row) {
						if(!array_search($row->option_id, $opt_id)){
							$this->question_model->del_option($row->option_id);
						}
					}
					//update option
					for ($i=1; $i <= $opt_num ; $i++) { 
						if($opt_id[$i]=='insert'){
							#insert
							$this->question_model->add_option($id,$opt_text[$i],$opt_val[$i]);
						}else{
							#update
							$this->question_model->edit_option($opt_id[$i],$opt_text[$i],$opt_val[$i]);

						}
					}
					$code = 1;
					$text = 'Edit Question';
				}
				break;
			case 3: //open answer
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$this->question_model->edit_bank($id,$q_code,$q_text,$var_id,$dim_id,$ind_id,0);
					$text = 'Edit Question';
					$code = 1;

				}
				break;
			case 4: //multi answer
				$opt_num	=	$this->input->post('hdn_num');
				for ($i=1; $i <= $opt_num; $i++) { 
					$this->form_validation->set_rules('txt_option_'.$i, 'Option #'.$i, 'trim|required|xss_clean');
					$this->form_validation->set_rules('txt_opt_val_'.$i, 'Option Value #'.$i, 'trim|required|integer|xss_clean');
					$opt_text[$i] = $this->input->post('txt_option_'.$i);
					$opt_val[$i] 	= $this->input->post('txt_opt_val_'.$i);
					$opt_id[$i] 	= $this->input->post('hdn_opt_'.$i);
				}
				$this->form_validation->set_rules('nm_max_sel', 'Maximum Select', 'trim|required|is_natural_no_zero|xss_clean');
				if ($this->form_validation->run()==FALSE) {
					$code = 2;
					$text = validation_errors();
				}else{
					$max_sel 	= $this->input->post('nm_max_sel');
					$opt_list = $this->question_model->get_option_list($id);
					$result 	= $this->question_model->edit_checkbox($id,$q_code,$q_text,$var_id,$dim_id,$ind_id,1,$max_sel,'','',$abstain);

					foreach ($opt_list as $row) {
						if(!array_search($row->option_id, $opt_id)){
							$this->question_model->del_option($row->option_id);
						}
					}
					//update option
					for ($i=1; $i <= $opt_num ; $i++) { 
						if($opt_id[$i]=='insert'){
							#insert
							$this->question_model->add_option($id,$opt_text[$i],$opt_val[$i]);
						}else{
							#update
							$this->question_model->edit_option($opt_id[$i],$opt_text[$i],$opt_val[$i]);

						}
					}
					$code = 1;
					$text = 'Edit Question';
				}
				break;

		}
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('question_bank/repo/'.$survey_type);
				break;
			case 2:
				redirect('question_bank/edit/'.$id);
				break;
		}
	}
	public function delete($id='null')
	{
		if(!is_numeric($id)){
			redirect('question_bank');
		}
		$old = $this->question_model->get_bank_row($id);
		if(count($old)!=1){
			redirect('question_bank');
		}
		$this->question_model->del_bank($id);
		$code = 1;
		$text = 'Delete Question';
		$this->session->set_flashdata('notif_code', $code);
		$this->session->set_flashdata('notif_text', $text);
		redirect('question_bank/repo/'.$old->survey_type_id);
	}
	public function status($id)
	{
		$old = $this->question_model->get_bank_row($id);
		if($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->question_model->edit_bank_status($id,$status);
		redirect('question_bank/repo/'.$old->survey_type_id);
	}
}
/* End of file question_bank.php */
/* Location: ./system/application/controllers/question_bank.php */