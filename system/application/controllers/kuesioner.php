<?php
/**
* Pengaturan Kuesioner
*
*/
class Kuesioner extends Controller
{
	function __construct()
	{
		parent::Controller();
		if($this->session->userdata('nik')=='' OR $this->session->userdata('role')=='responden'){
			redirect('account/login_backend');
		}
		$this->load->model('kuesioner_model');
		$this->load->library('saprfc');
	}
	public function index()
	{
		$data_header['title']	= 'Kuesioner';
		$data_header['sub']		= '';

		$bc[0]['link']				= 'kuesioner';
		$bc[0]['text']				= 'Kuesioner';
		$data_bc['list']			= $bc;
		$data_bc['index']			= 0;

		$data['list']					= $this->kuesioner_model->get_list(2);
		$data['link_add'] 		= 'kuesioner/add/';
		$data['link_edit'] 		= 'kuesioner/edit/';
		$data['link_status'] 	= 'kuesioner/status/';
		$data['link_delete'] 	= 'kuesioner/delete/';

		$data['link_detail'] 	= 'kuesioner/detail/';

		$notif['code'] = $this->session->userdata('notif_code');
		$notif['text'] = $this->session->userdata('notif_text');
		$this->session->unset_userdata('notif_code');
		$this->session->unset_userdata('notif_text');

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
		$this->load->view('kuesioner/kuesioner_view',$data);
		$this->load->view('template/main_bottom');
	}

	/**
	 * [form untuk menambahkan kuesioner]
	 */
	public function add()
	{
		$this->load->model('survey_model');
		$data_header['title']	= 'Kuesioner';
		$data_header['sub']		= 'Add';

		$list						= $this->survey_model->get_type_list(1);
		$type_list['']	= '';
		foreach ($list as $row) {
			$type_list[$row->survey_type_id] = $row->type_name;
		}
		$data['type_list']		= $type_list;
		$data['link_back']		= 'kuesioner';
		$data['process']			= 'kuesioner/add_process';
		$data['code']					= '';
		$data['title']				= '';
		$data['type']					= '';
		$data['start']				= date('Y-m-d'). ' 00:00:00';
		$data['end']					= date('Y-m-d'). ' 23:59:59';
		$data['agreement']		= '';
		$data['guide']				= '';
		$data['term']					= '';
		$data['theme']				= '';
		$data['intro']				= '';
		$data['only_once']		= 1;
		$data['abstain']			= 'Tidak Tahu';
		$data['skip_qty']			= 0;
		$data['method']				= 0;

		$data['hidden']				= array();
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
		$this->load->view('kuesioner/kuesioner_form',$data);
		$js_list = array('ckeditor/ckeditor','custom_js/kuesioner');
		$data_bot['js_list'] = $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}

	/**
	 * [proses menambahkan kuesioner]
	 */
	public function add_process()
	{
		$this->form_validation->set_rules('txt_code', 'Kuesioner Code', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_title', 'Kuesioner Title', 'trim|required|min_length[5]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('slc_type', 'Survey Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dtp_start', 'Start', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dtp_end', 'End', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_theme', ' Theme', 'trim|min_length[5]|max_length[150]|xss_clean');
		$this->form_validation->set_rules('txt_intro', 'Introduction', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('txt_agreement', 'Agreement', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_abstain', '"No Answer" Text', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('nm_skip_quota', '"Skip Quota', 'trim|required|is_natural|xss_clean');
		if ($this->form_validation->run() == FALSE){
			$code = 2;
			$text = validation_errors();
		}else{
			$code 				= $this->input->post('txt_code');
			$title 				= $this->input->post('txt_title');
			$type 				= $this->input->post('slc_type');
			$start				= $this->input->post('dtp_start');
			$end			 		= $this->input->post('dtp_end');
			$theme				= $this->input->post('txt_theme');
			$intro				= $this->input->post('txt_intro');
			$guide				= $this->input->post('txt_guide');
			$term					= $this->input->post('txt_term');

			$agreement		= $this->input->post('txt_agreement');
			$abstain_text	= $this->input->post('txt_abstain');
			$skip_qty			= $this->input->post('nm_skip_quota');
			$method				= $this->input->post('slc_method');



			$return 			= $this->kuesioner_model->add($type,$code,$title,$theme,$intro,$start,$end,$abstain_text,$skip_qty,$agreement,1,$method,$guide,$term);
			if ($return) {
				$code = 1;
				$last	= $this->kuesioner_model->get_last();
				$this->kuesioner_model->add_section($last->kuesioner_id,'Question Section',1,'');
			}else{
				$code = 2;
			}
			$text = 'Add new Kuesioner';

		}
		$this->session->set_userdata('notif_code', $code);
		$this->session->set_userdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('kuesioner/');
				break;
			case 2:
				redirect('kuesioner/add/');
				break;
		}
	}

	/**
	 * [halaman/form untuk mengedit form yang ada]
	 * @param  string $id [id kuesioner]
	 */
	public function edit($id='null')
	{
		if(!is_numeric($id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_row($id);
		if(count($old)!=1){
			redirect('kuesioner');
		}

		$this->load->model('survey_model');
		$data_header['title']	= 'Kuesioner';
		$data_header['sub']		= 'Edit';

		$data['link_back'] = 'kuesioner';
		$data['process']   = 'kuesioner/edit_process';
		$list              = $this->survey_model->get_type_list(2);
		$type_list['']     = '';
		foreach ($list as $row) {
			$type_list[$row->survey_type_id] = $row->type_name;
		}
		$data['type_list'] = $type_list;
		$data['code']      = $old->kuesioner_code;
		$data['title']     = $old->title;
		$data['type']      = $old->survey_type_id;
		$data['start']     = $old->start_time;
		$data['end']       = $old->end_time;
		$data['agreement'] = $old->agreement_text;
		$data['theme']     = $old->theme;
		$data['intro']     = $old->introduction;
		$data['guide']     = $old->guide;
		$data['term']      = $old->term;

		$data['abstain']   = $old->abstain_text;
		$data['skip_qty']  = $old->skip_quota;
		$data['method']    = $old->method;

		$data['hidden']    = array('hdn_id'=>$old->kuesioner_id);

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
		$this->load->view('kuesioner/kuesioner_form',$data);
		$js_list = array('ckeditor/ckeditor','custom_js/kuesioner');
		$data_bot['js_list'] = $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}
	/**
	 * [proses mengupdate data kuesioner]
	 */
	public function edit_process()
	{
		$this->form_validation->set_rules('hdn_id', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_code', 'Kuesioner Code', 'trim|required|min_length[3]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_title', 'Kuesioner Title', 'trim|required|min_length[5]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('dtp_start', 'Start Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dtp_end', 'End Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_theme', ' Theme', 'trim|min_length[5]|max_length[150]|xss_clean');
		$this->form_validation->set_rules('txt_intro', 'Introduction', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('text_agreement', 'Agreement', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_abstain', '"No Answer" Text', 'trim|required|min_length[1]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('nm_skip_quota', 'Skip Quota', 'trim|required|is_natural|xss_clean');
		if ($this->form_validation->run() == FALSE){
			$code = 2;
			$text = validation_errors();
		}else{
			$id 					= $this->input->post('hdn_id');
			$code 				= $this->input->post('txt_code');
			$title 				= $this->input->post('txt_title');
			$start 				= $this->input->post('dtp_start');
			$end 					= $this->input->post('dtp_end');
			$theme				= $this->input->post('txt_theme');
			$intro				= $this->input->post('txt_intro');
			$agreement		= $this->input->post('txt_agreement');
			$guide				= $this->input->post('txt_guide');
			$term					= $this->input->post('txt_term');
			$agreement		= $this->input->post('txt_agreement');
			$abstain_text	= $this->input->post('txt_abstain');
			$skip_qty			= $this->input->post('nm_skip_quota');
			$method				= $this->input->post('slc_method');

			$this->kuesioner_model->edit($id,$code,$title,$theme,$intro,$start,$end,$abstain_text,$skip_qty,$agreement,$method,$guide,$term);
			$code = 1;
			$text = 'Edit Kuesioner';

		}
		$this->session->set_userdata('notif_code', $code);
		$this->session->set_userdata('notif_text', $text);
		switch ($code) {
			case 1:
				redirect('kuesioner/');
				break;
			case 2:
				redirect('kuesioner/edit/');
				break;
		}
	}

	/**
	 * [merubah status aktif/non aktif kuesioner]
	 * @param  string $id [id kuesioner]
	 */
	public function status($id='null')
	{
		if(!is_numeric($id)){
			redirect('kuesioner');
		}

		$old = $this->kuesioner_model->get_row($id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		if($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->kuesioner_model->edit_status($id,$status);
		redirect('kuesioner');
	}

	/**
	 * [halaman detail kuesioner]
	 * @param  string $id [id kuesioner]
	 */
	public function detail($id='null')
	{
		if(!is_numeric($id)){
			redirect('kuesioner');
		}
		$detail = $this->kuesioner_model->get_row($id);

		if(count($detail)!=1)
		{
			redirect('kuesioner');
		}

		$data_header['title'] = 'Kuesioner';
		$data_header['sub']   = '';

		$bc[0]['link']    = 'kuesioner';
		$bc[0]['text']    = 'Kuesioner';
		$bc[1]['link']    = 'kuesioner/detail/'.$id;
		$bc[1]['text']    = $detail->title;
		$data_bc['list']  = $bc;
		$data_bc['index'] = 1;

		$data['detail']						= $detail;
		$data['sect_list']				= $this->kuesioner_model->get_section_list($detail->kuesioner_id,1);
		$data['link_sect_detail'] = 'kuesioner/section/';
		$data['link_sect_add'] 		= 'kuesioner/section_add/';
		$data['link_sect_edit'] 	= 'kuesioner/section_edit/';
		$data['link_sect_delete'] = 'kuesioner/section_delete/';
		$data['link_req_edit'] 		= 'kuesioner/criteria_edit/';
		$data['link_unit_add']		= 'kuesioner/unit_add/';
		$data['link_unit_edit']		= 'kuesioner/unit_edit/';
		$data['link_unit_delete']	= 'kuesioner/unit_delete/';
		$data['link_unit_status']	= 'kuesioner/unit_status/';
		$data['unit_list']				= $this->kuesioner_model->get_unit_list($id,2);

		$notif['code'] = $this->session->userdata('notif_code');
		$notif['text'] = $this->session->userdata('notif_text');

		$this->session->unset_userdata('notif_code');
		$this->session->unset_userdata('notif_text');

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
		$this->load->view('kuesioner/detail_view',$data);
		switch ($detail->method) {
			case 0:// sensus
				$this->load->view('kuesioner/responden_sensus');
				$this->load->view('template/main_bottom');
				$data_js['all_unit'] 			= $detail->is_all;
				$data_js['kuesioner_id'] 	= $id;
				$this->load->view('kuesioner/detail_view_js', $data_js);
				break;
			case 1://sampling
				$this->load->model('responden_model');
				$data_res['responden_list'] = $this->responden_model->get_list($id);
				$data_res['link_del']			= 'kuesioner/responden_delete/';
				$data_res['link_popup'] 	= 'kuesioner/responden_popup/';
				$data_res['link_import'] 	= 'kuesioner/responden_import/';
				$this->load->view('kuesioner/responden_sampling',$data_res);
				$this->load->view('template/main_bottom');
				break;
		}
	}

	/**
	 * [halaman section berisi daftar pertanyaan pada bagian/section/halaman tersebut]
	 * @param  string $section_id [id sesction]
	 */
	public function section($section_id='null')
	{
		if(!is_numeric($section_id)){
			redirect('kuesioner');
		}
		$detail = $this->kuesioner_model->get_section_row($section_id);
		if(count($detail)!=1){
			redirect('kuesioner');
		}
		$data_header['title'] = 'Section';
		$data_header['sub']   = '';

		$bc[0]['link']    = 'kuesioner';
		$bc[0]['text']    = 'Kuesioner';
		$bc[1]['link']    = 'kuesioner/detail/'.$detail->kuesioner_id;
		$bc[1]['text']    = $detail->kuesioner_title;
		$bc[2]['link']    = 'kuesioner/section/'.$section_id;
		$bc[2]['text']    = $detail->section_name;
		$data_bc['list']  = $bc;
		$data_bc['index'] = 2;

		$data['detail']   = $detail;
		$data['set_list'] = $this->kuesioner_model->get_question_list($section_id);
		$data['type']     = array('','Scale','Multiple Choice','Open Answer','Multi Answer');

		$data['link_add']    = 'kuesioner/question_add/';
		$data['link_edit']   = 'kuesioner/question_edit/';
		$data['link_delete'] = 'kuesioner/question_del/';
		$data['link_status'] = 'kuesioner/question_status/';

		$notif['code'] = $this->session->userdata('notif_code');
		$notif['text'] = $this->session->userdata('notif_text');
		$this->session->unset_userdata('notif_code');
		$this->session->unset_userdata('notif_text');

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
		$this->load->view('kuesioner/section_view',$data);
		$this->load->view('template/main_bottom');
	}

	/**
	 * [form untuk menambahkan section pada kuesioner]
	 * @param  string $kuesioner_id [id kuesioner]
	 */
	public function section_add($kuesioner_id='null')
	{
		if(!is_numeric($kuesioner_id)){
			redirect('kuesioner');
		}
		$head = $this->kuesioner_model->get_row($kuesioner_id);
		if(count($head)!=1)
		{
			redirect('kuesioner');
		}
		$data_header['title']	= 'Section';
		$data_header['sub']		= 'Add';

		$data['link_back'] = 'kuesioner/detail/'.$kuesioner_id;
		$data['process']   = 'kuesioner/section_add_process';
		$data['title']     = $head->title;
		$data['order']     = 1;
		$data['name']      =	'Question';
		$data['desc']      = '';
		$data['hidden']    = array('hdn_kuesioner'=>$kuesioner_id);

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
		$this->load->view('kuesioner/section_form',$data);
		$js_list = array('ckeditor/ckeditor','custom_js/section');
		$data_bot['js_list'] = $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}

	/**
	 * [proses tambah section baru pada kuesioner]
	 * @return [type] [description]
	 */
	public function section_add_process()
	{
		$kuesioner_id = $this->input->post('hdn_kuesioner');
		$this->form_validation->set_rules('hdn_kuesioner', 'Kuesioner ID', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_order', 'Order', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Section Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('txt_desc', 'Description', 'trim|max_length[200]|xss_clean');
		if($this->form_validation->run()==FALSE){
			$code = 2;//error
			$text = validation_errors();
		}else{
			$order = $this->input->post('nm_order');
			$name  = $this->input->post('txt_name');
			$desc  = $this->input->post('txt_desc');

			$this->kuesioner_model->add_section($kuesioner_id,$name,$order,$desc);

			$code = 1;//
			$text = 'Add new Section';
		}
		$this->session->set_userdata('notif_code', $code);
		$this->session->set_userdata('notif_text', $text);
		switch ($code) {
			case 1: //success
				redirect('kuesioner/detail/'.$kuesioner_id);
				break;
			case 2: //error
				redirect('kuesioner/section_add/'.$kuesioner_id);
				break;
		}
	}
	public function section_edit($section_id='null')
	{
		if(!is_numeric($section_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_section_row($section_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		$data_header['title']	= 'Section';
		$data_header['sub']		= 'Edit';

		$data['link_back']		= 'kuesioner/detail/'.$old->kuesioner_id;
		$data['process']			= 'kuesioner/section_edit_process';
		$data['title']				= $old->kuesioner_title;
		$data['order']				= $old->order;
		$data['name']					=	$old->section_name;
		$data['desc']					= $old->description;
		$data['hidden']				= array('hdn_kuesioner'=>$old->kuesioner_id,'hdn_id'=>$section_id);

		$notif['code'] 				= $this->session->userdata('notif_code');
		$notif['text'] 				= $this->session->userdata('notif_text');
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
		$this->load->view('kuesioner/section_form',$data);
		$js_list = array('ckeditor/ckeditor','custom_js/section');
		$data_bot['js_list'] = $js_list;
		$this->load->view('template/main_bottom',$data_bot);
	}
	public function section_edit_process()
	{
		$kuesioner_id = $this->input->post('hdn_kuesioner');
		$this->form_validation->set_rules('hdn_kuesioner', 'Kuesioner ID', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('hdn_id', 'Section ID', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_order', 'Order', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('txt_name', 'Section Name', 'trim|required|min_length[3]|max_length[100]|xss_clean');
		$this->form_validation->set_rules('txt_desc', 'Description', 'trim|max_length[200]|xss_clean');
		if($this->form_validation->run()==FALSE){
			$code = 2;//error
			$text = validation_errors();
		}else{
			$section_id = $this->input->post('hdn_id');
			$order      = $this->input->post('nm_order');
			$name       = $this->input->post('txt_name');
			$desc       = $this->input->post('txt_desc');

			$this->kuesioner_model->edit_section($section_id,$name,$order,$desc);

			$code = 1;//success
			$text = 'Edit Section';
		}
		$this->session->set_userdata('notif_code', $code);
		$this->session->set_userdata('notif_text', $text);
		switch ($code) {
			case 1: //success
				redirect('kuesioner/detail/'.$kuesioner_id);
				break;
			case 2: //error
				redirect('kuesioner/section_add/'.$kuesioner_id);
				break;
		}
	}
	public function section_delete($section_id='null')
	{
		if(!is_numeric($section_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_section_row($section_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		#delete question set
		$this->kuesioner_model->del_question_set($section_id);
		#delete section
		$this->kuesioner_model->del_section($section_id);
		// $this->session->set_userdata('notif_code', 1);
		// $this->session->set_userdata('notif_text', 'Delete Section and Question Set');
		redirect('kuesioner/detail/'.$old->kuesioner_id);
	}
	public function criteria_edit($kuesioner_id='null')
	{
		if(!is_numeric($kuesioner_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_row($kuesioner_id);
		if(count($old)!=1){
			redirect('kuesioner/detail/'.$kuesioner_id);
		}
		$data_header['title']	= 'Responden Criteria';
		$data_header['sub']		= 'Edit';

		$data['link_back']		= 'kuesioner/detail/'.$old->kuesioner_id;
		$data['process']			= 'kuesioner/criteria_edit_process';

		//criteria contract
		$data['co_status']		= $old->contract_active;
		$data['co_min_yr']		= $old->c_min_y;
		$data['co_min_mo']		= $old->c_min_m;
		$data['co_min_dy']		= $old->c_min_d;
		$data['co_max_yr']		= $old->c_max_y;
		$data['co_max_mo']		= $old->c_max_m;
		$data['co_max_dy']		= $old->c_max_d;

		//criteria permanent
		$data['pe_status']		= $old->p_active;
		$data['pe_min_yr']		= $old->p_min_y;
		$data['pe_min_mo']		= $old->p_min_m;
		$data['pe_min_dy']		= $old->p_min_d;
		$data['pe_max_yr']		= $old->p_max_y;
		$data['pe_max_mo']		= $old->p_max_m;
		$data['pe_max_dy']		= $old->p_max_d;

		//criteria lama memangku jabatan/posisi
		$data['po_min_yr']		= $old->post_min_y;
		$data['po_min_mo']		= $old->post_min_m;
		$data['po_min_dy']		= $old->post_min_d;
		$data['po_max_yr']		= $old->post_max_y;
		$data['po_max_mo']		= $old->post_max_m;
		$data['po_max_dy']		= $old->post_max_d;

		$data['hidden']				= array('hdn_kuesioner'=>$old->kuesioner_id);

		$notif['code'] 				= $this->session->userdata('notif_code');
		$notif['text'] 				= $this->session->userdata('notif_text');
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
		$this->load->view('kuesioner/criteria_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function criteria_edit_process()
	{
		$kuesioner_id = $this->input->post('hdn_kuesioner');

		$this->form_validation->set_rules('nm_co_min_yr', 'Minimum Contract Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_min_mo', 'Minimum Contract Month', 'trim|required|less_than[11]|xss_clean');
		$this->form_validation->set_rules('nm_co_min_dy', 'Minimum Contract Day', 'trim|required|less_than[29]|xss_clean');
		$this->form_validation->set_rules('nm_co_max_yr', 'Maxmimum Contract Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_mo', 'Maxmimum Contract Month', 'trim|required|less_than[11]|xss_clean');
		$this->form_validation->set_rules('nm_co_max_dy', 'Maxmimum Contract Day', 'trim|required|less_than[29]|xss_clean');

		$this->form_validation->set_rules('nm_pe_min_yr', 'Minimum Permanent Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_min_mo', 'Minimum Permanent Month', 'trim|required|less_than[11]|xss_clean');
		$this->form_validation->set_rules('nm_pe_min_dy', 'Minimum Permanent Day', 'trim|required|less_than[29]|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_yr', 'Maxmimum Permanent Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_mo', 'Maxmimum Permanent Month', 'trim|required|less_than[11]|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_dy', 'Maxmimum Permanent Day', 'trim|required|less_than[29]|xss_clean');

		$this->form_validation->set_rules('nm_po_min_yr', 'Minimum Position Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_min_mo', 'Minimum Position Month', 'trim|required|less_than[11]|xss_clean');
		$this->form_validation->set_rules('nm_po_min_dy', 'Minimum Position Day', 'trim|required|less_than[29]|xss_clean');
		$this->form_validation->set_rules('nm_po_max_yr', 'Maxmimum Position Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_mo', 'Maxmimum Position Month', 'trim|required|less_than[11]|xss_clean');
		$this->form_validation->set_rules('nm_po_max_dy', 'Maxmimum Position Day', 'trim|required|less_than[29]|xss_clean');
		if($this->form_validation->run()==FALSE){

			// $this->session->set_userdata('notif_code', 2);
			// $this->session->set_userdata('notif_text', validation_errors());

			redirect('kuesioner/criteria_edit/'.$kuesioner_id);
		}else{

			// $co_status		= $this->input->post('chk_co');
			$co_min_yr 		= $this->input->post('nm_co_min_yr');
			$co_min_mo 		= $this->input->post('nm_co_min_mo');
			$co_min_dy 		= $this->input->post('nm_co_min_dy');
			$co_max_yr 		= $this->input->post('nm_co_max_yr');
			$co_max_mo 		= $this->input->post('nm_co_max_mo');
			$co_max_dy 		= $this->input->post('nm_co_max_dy');
			$this->kuesioner_model->edit_contract($kuesioner_id,$co_min_yr,$co_min_mo,$co_min_dy,$co_max_yr,$co_max_mo,$co_max_dy);
			// $this->kuesioner_model->edit_c_status($kuesioner_id,$co_status);

			// $pe_status		= $this->input->post('chk_pe');
			$pe_min_yr 		= $this->input->post('nm_pe_min_yr');
			$pe_min_mo 		= $this->input->post('nm_pe_min_mo');
			$pe_min_dy 		= $this->input->post('nm_pe_min_dy');
			$pe_max_yr 		= $this->input->post('nm_pe_max_yr');
			$pe_max_mo 		= $this->input->post('nm_pe_max_mo');
			$pe_max_dy 		= $this->input->post('nm_pe_max_dy');
			$this->kuesioner_model->edit_permanent($kuesioner_id,$pe_min_yr,$pe_min_mo,$pe_min_dy,$pe_max_yr,$pe_max_mo,$pe_max_dy);
			// $this->kuesioner_model->edit_pe_status($kuesioner_id,$pe_status);

			$po_min_yr 		= $this->input->post('nm_po_min_yr');
			$po_min_mo 		= $this->input->post('nm_po_min_mo');
			$po_min_dy 		= $this->input->post('nm_po_min_dy');
			$po_max_yr 		= $this->input->post('nm_po_max_yr');
			$po_max_mo 		= $this->input->post('nm_po_max_mo');
			$po_max_dy 		= $this->input->post('nm_po_max_dy');
			$this->kuesioner_model->edit_position($kuesioner_id,$po_min_yr,$po_min_mo,$po_min_dy,$po_max_yr,$po_max_mo,$po_max_dy);

			// $this->session->set_userdata('notif_code', 1);
			// $this->session->set_userdata('notif_text', 'Edit Responden Criteria');

			redirect('kuesioner/detail/'.$kuesioner_id);
		}
	}
	public function question_add($section_id='null')
	{
		if(!is_numeric($section_id)){
			redirect('kuesioner');
		}
		$head = $this->kuesioner_model->get_section_row($section_id);
		if(count($head)!=1){
			redirect('kuesioner/detail/'.$head->kuesioner_id);
		}
		$this->load->model('question_model');
		$data_header['title']	= 'Question Set';
		$data_header['sub']		= 'Add';
		$data['link_pop']			= 'kuesioner/question_popup/';
		$data['link_back']		= 'kuesioner/section/'.$section_id;
		$data['process']			= 'kuesioner/question_add_process';
		$data['head']					= $head;
		$data['q_type']				= array('','Scale','Multiple Choice','Open Answer','Multi Answer');
		$data['bank']					= $this->question_model->get_bank_list($head->survey_type_id,1);
		$data['hidden']				= array('hdn_section'=>$section_id);
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
		$this->load->view('kuesioner/question_add',$data);
		$this->load->view('template/main_bottom');
	}
	public function question_add_process()
	{
		$section_id = $this->input->post('hdn_section');
		$head = $this->kuesioner_model->get_section_row($section_id);
		$this->load->model('question_model');
		$bank = $this->question_model->get_bank_list($head->survey_type_id,1);
		$count = 0;
		foreach ($bank as $row) {
			$check = 0;
			$check = $this->input->post('chk_select_'.$row->question_id);
			if ($check==1){
				$order = $this->input->post('nm_order_'.$row->question_id);
				$this->kuesioner_model->add_question($section_id,$row->question_id,$order);
				$count++;
			}
		}
		// $this->session->set_userdata('notif_code', 1);
		// $this->session->set_userdata('notif_text', 'Add '.$count .' question(s)');

		redirect('kuesioner/section/'.$section_id);
	}
	public function question_edit($q_set_id='null')
	{
		if(!is_numeric($q_set_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_question_row($q_set_id);
		if(count($old)!=1){
			redirect('kuesioner/');
		}
		$data_header['title']	= 'Question Set';
		$data_header['sub']		= 'Edit';
		$q_type								= array('','Scale','Multiple Choice','Open Answer','Multi Answer');
		$data['link_back']		= 'kuesioner/section/'.$old->section_id;
		$data['process']			= 'kuesioner/question_edit_process';
		$data['k_title']			= $old->title;
		$data['s_name']				= $old->section_name;
		$data['q_code']				= $old->question_code;
		$data['q_type']				= $q_type[$old->type];
		$data['question']			= $old->question_text;
		$data['order']				= $old->question_order;

		$data['hidden']				= array('hdn_section'=>$old->section_id,'hdn_id'=>$q_set_id);
		$notif['code'] 				= $this->session->userdata('notif_code');
		$notif['text'] 				= $this->session->userdata('notif_text');
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
		$this->load->view('kuesioner/question_edit',$data);
		$this->load->view('template/main_bottom');
	}
	public function question_edit_process()
	{
		$section_id = $this->input->post('hdn_section');
		$q_id 			= $this->input->post('hdn_id');
		$order 			= $this->input->post('nm_order');
		$this->kuesioner_model->edit_question($q_id,$order);
		// $this->session->set_userdata('notif_code', 1);
		// $this->session->set_userdata('notif_text', 'Edit Question Set');

		redirect('kuesioner/section/'.$section_id);
	}
	public function question_status($q_set_id='null')
	{
		if(!is_numeric($q_set_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_question_row($q_set_id);
		if(count($old)!=1){
			redirect('kuesioner/');
		}
		if ($old->is_active){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->kuesioner_model->edit_question_status($q_set_id,$status);
		redirect('kuesioner/section/'.$old->section_id);
	}
	public function question_del($q_set_id='null')
	{
		if(!is_numeric($q_set_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_question_row($q_set_id);
		if(count($old)!=1){
			redirect('kuesioner/');
		}
		$this->kuesioner_model->del_question($q_set_id);
		// $this->session->set_userdata('notif_code', 1);
		// $this->session->set_userdata('notif_text', 'Edit Question Set');
		redirect('kuesioner/section/'.$old->section_id);
	}
	public function unit_add($kuesioner_id='null')
	{
		if(!is_numeric($kuesioner_id)){
			redirect('kuesioner');
		}
		$head = $this->kuesioner_model->get_row($kuesioner_id);
		if(count($head)!=1){
			redirect('kuesioner');
		}
		$data_header['title']	= 'Responden Unit & Criteria';
		$data_header['sub']		= 'Add';

		$data['link_back']		= 'kuesioner/detail/'.$head->kuesioner_id;
		$data['process']			= 'kuesioner/unit_add_process';
		#BAPI List Unit
		$this->saprfc->connect();
		$this->saprfc->functionDiscover('ZHRFM_LISTORGANISASI');
		$importParamName=array('DEPTH','KEYDATE','OBJID');
		$importParamValue=array(2,date('Ymd'),'50002147');
		$this->saprfc->importParameter($importParamName, $importParamValue);
		$this->saprfc->setInitTable("T_OBJECTSDATA");
		$this->saprfc->executeSAP();
		$unit_temp = $this->saprfc->fetch_rows("T_OBJECTSDATA");
		$this->saprfc->free();
		$this->saprfc->close();
		$unit_list = array();
		$flag = 0;
		foreach ($unit_temp as $row) {
			if($flag) {
				$unit_list[$row['OBJECT_ID']] = $row['LONG_TEXT'];
			} else {
				$unit_list[''] = '';
				$flag = 1;
			}
		}
		$data['unit_list']		= $unit_list;
		$data['unit_id']			= '';
		//criteria contract
		$data['co_status']		= 0;
		$data['co_min_yr']		= 0;
		$data['co_min_mo']		= 0;
		$data['co_min_dy']		= 0;
		$data['co_max_yr']		= 99;
		$data['co_max_mo']		= 99;
		$data['co_max_dy']		= 99;

		//criteria permanent
		$data['pe_status']		= 0;
		$data['pe_min_yr']		= 0;
		$data['pe_min_mo']		= 0;
		$data['pe_min_dy']		= 0;
		$data['pe_max_yr']		= 99;
		$data['pe_max_mo']		= 99;
		$data['pe_max_dy']		= 99;

		//criteria lama memangku jabatan/posisi
		$data['po_min_yr']		= 0;
		$data['po_min_mo']		= 0;
		$data['po_min_dy']		= 0;
		$data['po_max_yr']		= 99;
		$data['po_max_mo']		= 99;
		$data['po_max_dy']		= 99;

		$data['hidden']				= array('hdn_kuesioner'=>$head->kuesioner_id);

		$notif['code'] 				= $this->session->userdata('notif_code');
		$notif['text'] 				= $this->session->userdata('notif_text');
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
		$this->load->view('kuesioner/unit_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function unit_add_process()
	{
		$kuesioner_id = $this->input->post('hdn_kuesioner');
		$this->form_validation->set_rules('slc_unit', 'Unit', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nm_co_min_yr', 'Minimum Contract Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_min_mo', 'Minimum Contract Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_min_dy', 'Minimum Contract Day', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_yr', 'Maxmimum Contract Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_mo', 'Maxmimum Contract Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_dy', 'Maxmimum Contract Day', 'trim|required|is_natural|xss_clean');

		$this->form_validation->set_rules('nm_pe_min_yr', 'Minimum Permanent Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_min_mo', 'Minimum Permanent Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_min_dy', 'Minimum Permanent Day', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_yr', 'Maxmimum Permanent Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_mo', 'Maxmimum Permanent Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_dy', 'Maxmimum Permanent Day', 'trim|required|is_natural|xss_clean');

		$this->form_validation->set_rules('nm_po_min_yr', 'Minimum Position Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_min_mo', 'Minimum Position Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_min_dy', 'Minimum Position Day', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_yr', 'Maxmimum Position Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_mo', 'Maxmimum Position Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_dy', 'Maxmimum Position Day', 'trim|required|is_natural|xss_clean');
		if($this->form_validation->run()==FALSE){
			// $this->session->set_userdata('notif_code', 2);
			// $this->session->set_userdata('notif_text', validation_errors());
			redirect('kuesioner/unit_add/'.$kuesioner_id);
		} else {
			$unit_id 						= $this->input->post('slc_unit');
			#BAPI List Unit
			$this->saprfc->connect();
			$this->saprfc->functionDiscover('ZHRFM_LISTORGANISASI');
			$importParamName=array('DEPTH','KEYDATE','OBJID');
			$importParamValue=array(1,date('Ymd'),$unit_id);
			$this->saprfc->importParameter($importParamName, $importParamValue);
			$this->saprfc->setInitTable("T_OBJECTSDATA");
			$this->saprfc->executeSAP();
			$unit_temp = $this->saprfc->fetch_row("T_OBJECTSDATA");
			$this->saprfc->free();
			$this->saprfc->close();
			$unit_name 					= $unit_temp['LONG_TEXT'];
			$co['is_active']		= 1;
			$co['min_y'] 		= $this->input->post('nm_co_min_yr');
			$co['min_m'] 		= $this->input->post('nm_co_min_mo');
			$co['min_d'] 		= $this->input->post('nm_co_min_dy');
			$co['max_y'] 		= $this->input->post('nm_co_max_yr');
			$co['max_m'] 		= $this->input->post('nm_co_max_mo');
			$co['max_d'] 		= $this->input->post('nm_co_max_dy');

			$pe['is_active']		= 1;
			$pe['min_y'] 		= $this->input->post('nm_pe_min_yr');
			$pe['min_m'] 		= $this->input->post('nm_pe_min_mo');
			$pe['min_d'] 		= $this->input->post('nm_pe_min_dy');
			$pe['max_y'] 		= $this->input->post('nm_pe_max_yr');
			$pe['max_m'] 		= $this->input->post('nm_pe_max_mo');
			$pe['max_d']		= $this->input->post('nm_pe_max_dy');

			$po['min_y'] 		= $this->input->post('nm_po_min_yr');
			$po['min_m'] 		= $this->input->post('nm_po_min_mo');
			$po['min_d'] 		= $this->input->post('nm_po_min_dy');
			$po['max_y'] 		= $this->input->post('nm_po_max_yr');
			$po['max_m'] 		= $this->input->post('nm_po_max_mo');
			$po['max_d'] 		= $this->input->post('nm_po_max_dy');

			$this->kuesioner_model->add_unit($kuesioner_id,$unit_id,$unit_name,$co,$pe,$po);

			$this->session->set_userdata('notif_code', 1);
			$this->session->set_userdata('notif_text', 'Add Unit Responden');
			redirect('kuesioner/detail/'.$kuesioner_id);
		}
	}
	public function unit_edit($responden_unit_id='null')
	{
		if(!is_numeric($responden_unit_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_unit_row($responden_unit_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		$data_header['title']	= 'Responden Unit & Criteria';
		$data_header['sub']		= 'Add';

		$data['link_back']		= 'kuesioner/detail/'.$old->kuesioner_id;
		$data['process']			= 'kuesioner/unit_edit_process';
		#BAPI List Unit
		$this->saprfc->connect();
		$this->saprfc->functionDiscover('ZHRFM_LISTORGANISASI');
		$importParamName=array('DEPTH','KEYDATE','OBJID');
		$importParamValue=array(2,date('Ymd'),'50002147');
		$this->saprfc->importParameter($importParamName, $importParamValue);
		$this->saprfc->setInitTable("T_OBJECTSDATA");
		$this->saprfc->executeSAP();
		$unit_temp = $this->saprfc->fetch_rows("T_OBJECTSDATA");
		$this->saprfc->free();
		$this->saprfc->close();
		$unit_list = array();
		$flag = 0;
		foreach ($unit_temp as $row) {
			if($flag) {
				$unit_list[$row['OBJECT_ID']] = $row['LONG_TEXT'];
			} else {
				$unit_list[''] = '';
				$flag = 1;
			}
		}
		$data['unit_list']		= $unit_list;
		$data['unit_id']			= $old->org_id;
		//criteria contract
		$data['co_status']		= $old->c_active;
		$data['co_min_yr']		= $old->c_min_y;
		$data['co_min_mo']		= $old->c_min_m;
		$data['co_min_dy']		= $old->c_min_d;
		$data['co_max_yr']		= $old->c_max_y;
		$data['co_max_mo']		= $old->c_max_m;
		$data['co_max_dy']		= $old->c_max_d;

		//criteria permanent
		$data['pe_status']		= $old->pe_active;
		$data['pe_min_yr']		= $old->pe_min_y;
		$data['pe_min_mo']		= $old->pe_min_m;
		$data['pe_min_dy']		= $old->pe_min_d;
		$data['pe_max_yr']		= $old->pe_max_y;
		$data['pe_max_mo']		= $old->pe_max_m;
		$data['pe_max_dy']		= $old->pe_max_d;

		//criteria lama memangku jabatan/posisi
		$data['po_min_yr']		= $old->post_min_y;
		$data['po_min_mo']		= $old->post_min_m;
		$data['po_min_dy']		= $old->post_min_d;
		$data['po_max_yr']		= $old->post_max_y;
		$data['po_max_mo']		= $old->post_max_m;
		$data['po_max_dy']		= $old->post_max_d;

		$data['hidden']				= array('hdn_kuesioner'=>$old->kuesioner_id,'hdn_id'=>$responden_unit_id);

		$notif['code'] 				= $this->session->userdata('notif_code');
		$notif['text'] 				= $this->session->userdata('notif_text');
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
		$this->load->view('kuesioner/unit_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function unit_edit_process()
	{
		$responden_unit_id 	= $this->input->post('hdn_id');
		$kuesioner_id 			= $this->input->post('hdn_kuesioner');
		$this->form_validation->set_rules('slc_unit', 'Unit', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nm_co_min_yr', 'Minimum Contract Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_min_mo', 'Minimum Contract Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_min_dy', 'Minimum Contract Day', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_yr', 'Maxmimum Contract Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_mo', 'Maxmimum Contract Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_co_max_dy', 'Maxmimum Contract Day', 'trim|required|is_natural|xss_clean');

		$this->form_validation->set_rules('nm_pe_min_yr', 'Minimum Permanent Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_min_mo', 'Minimum Permanent Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_min_dy', 'Minimum Permanent Day', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_yr', 'Maxmimum Permanent Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_mo', 'Maxmimum Permanent Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_pe_max_dy', 'Maxmimum Permanent Day', 'trim|required|is_natural|xss_clean');

		$this->form_validation->set_rules('nm_po_min_yr', 'Minimum Position Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_min_mo', 'Minimum Position Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_min_dy', 'Minimum Position Day', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_yr', 'Maxmimum Position Year', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_mo', 'Maxmimum Position Month', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('nm_po_max_dy', 'Maxmimum Position Day', 'trim|required|is_natural|xss_clean');
		if($this->form_validation->run()==FALSE){
			// $this->session->set_userdata('notif_code', 2);
			// $this->session->set_userdata('notif_text', validation_errors());
			redirect('kuesioner/unit_edit/'.$kuesioner_id);
		} else {
			$unit_id 						= $this->input->post('slc_unit');
			#BAPI List Unit
			$this->saprfc->connect();
			$this->saprfc->functionDiscover('ZHRFM_LISTORGANISASI');
			$importParamName=array('DEPTH','KEYDATE','OBJID');
			$importParamValue=array(1,date('Ymd'),$unit_id);
			$this->saprfc->importParameter($importParamName, $importParamValue);
			$this->saprfc->setInitTable("T_OBJECTSDATA");
			$this->saprfc->executeSAP();
			$unit_temp = $this->saprfc->fetch_row("T_OBJECTSDATA");
			$unit_name 					= $unit_temp['LONG_TEXT'];
			$this->saprfc->free();
			$this->saprfc->close();
			$co['is_active']		= 1;
			$co['min_y'] 				= $this->input->post('nm_co_min_yr');
			$co['min_m'] 				= $this->input->post('nm_co_min_mo');
			$co['min_d'] 				= $this->input->post('nm_co_min_dy');
			$co['max_y'] 				= $this->input->post('nm_co_max_yr');
			$co['max_m'] 				= $this->input->post('nm_co_max_mo');
			$co['max_d'] 				= $this->input->post('nm_co_max_dy');

			$pe['is_active']		= 1;
			$pe['min_y'] 				= $this->input->post('nm_pe_min_yr');
			$pe['min_m'] 				= $this->input->post('nm_pe_min_mo');
			$pe['min_d'] 				= $this->input->post('nm_pe_min_dy');
			$pe['max_y'] 				= $this->input->post('nm_pe_max_yr');
			$pe['max_m'] 				= $this->input->post('nm_pe_max_mo');
			$pe['max_d']				= $this->input->post('nm_pe_max_dy');

			$po['min_y'] 		= $this->input->post('nm_po_min_yr');
			$po['min_m'] 		= $this->input->post('nm_po_min_mo');
			$po['min_d'] 		= $this->input->post('nm_po_min_dy');
			$po['max_y'] 		= $this->input->post('nm_po_max_yr');
			$po['max_m'] 		= $this->input->post('nm_po_max_mo');
			$po['max_d'] 		= $this->input->post('nm_po_max_dy');

			$this->kuesioner_model->edit_unit($responden_unit_id,$unit_id,$unit_name,$co,$pe,$po);


			redirect('kuesioner/detail/'.$kuesioner_id);
		}
	}
	public function unit_status($responden_unit_id = 'null')
	{
		if(!is_numeric($responden_unit_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_unit_row($responden_unit_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		if($old->is_active){
			$status = 0;
		} else {
			$status = 1;
		}
		$this->kuesioner_model->edit_unit_status($responden_unit_id,$status);
		redirect('kuesioner/detail/'.$old->kuesioner_id);
	}
	public function unit_delete($responden_unit_id = 'null')
	{
		if(!is_numeric($responden_unit_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_unit_row($responden_unit_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		$this->kuesioner_model->del_unit($responden_unit_id);
		$this->session->set_userdata('notif_code', 1);
		$this->session->set_userdata('notif_text', 'Delete Unit Responden');
		redirect('kuesioner/detail/'.$old->kuesioner_id);
	}
	public function question_popup($question_id='null')
	{

		if(!is_numeric($question_id)){
			redirect('kuesioner');
		}
		$this->load->model('question_model');
		$old = $this->question_model->get_bank_row($question_id);
		if(count($old)!=1){
			redirect('kuesioner/');
		}
		$data_header['title']	= 'Question Detail';
		$data_header['sub']		= $old->question_code;
		$this->load->view('template/popup_top');
		$data['old'] = $old;
		$this->load->view('template/page_header',$data_header);
		switch ($old->type) {
			case 1: //scale
				$this->load->view('kuesioner/popup_scale',$data);
				break;
			case 2: //multiple choice
				$data['option_list'] = $this->question_model->get_option_list($question_id);
				$this->load->view('kuesioner/popup_multiple',$data);
				break;
			case 3: //open answer
				$this->load->view('kuesioner/popup_open',$data);
				break;
			case 4: //multi answer
				$data['option_list'] = $this->question_model->get_option_list($question_id);
				$this->load->view('kuesioner/popup_checkbox',$data);
				break;
			default:
				$this->load->view('kuesioner/popup_open',$data);
				break;
		}

		$this->load->view('template/popup_bottom');
	}
	public function responden_popup($responden_id='null')
	{
		# code...
	}
	public function responden_delete($responden_id='null')
	{
		if(!is_numeric($responden_id)){
			redirect('kuesioner');
		}
		$this->load->model('responden_model');
		$old = $this->responden_model->get_row($responden_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}
		$this->responden_model->del($responden_id);
		$this->session->set_userdata('notif_code', 1);
		$this->session->set_userdata('notif_text', 'Delete '. $old->nik .' from responden');
		redirect('kuesioner/detail/'.$old->kuesioner_id);
	}

	public function responden_import($kuesioner_id='null')
	{
		if(!is_numeric($kuesioner_id)){
			redirect('kuesioner');
		}
		$head = $this->kuesioner_model->get_row($kuesioner_id);
		if(count($head)!=1){
			redirect('kuesioner');
		}
		$data_header['title']	= 'Responden';
		$data_header['sub']		= 'Import';
		$data['link_back']		= 'kuesioner/detail/'.$kuesioner_id;
		$data['process']			= 'kuesioner/responden_import_process';
		$data['hidden']				= array('hdn_kuesioner'=> $kuesioner_id);
		$notif['code'] 				= $this->session->userdata('notif_code');
		$notif['text'] 				= $this->session->userdata('notif_text');
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
		$this->load->view('kuesioner/import_form',$data);
		$this->load->view('template/main_bottom');
	}
	public function responden_import_process()
	{
		$kuesioner_id = $this->input->post('hdn_kuesioner');
		$head = $this->kuesioner_model->get_row($kuesioner_id);
		$file = 'fl_upload';
		$path ='./temp/';
	 	if ( ! file_exists($path) )
    {
      $create = mkdir($path, 0777);
    }

		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'xls';
		$config['max_size']				= '2048';
		$config['file_name']			= 'responden.xls';
		$config['overwrite']			= TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file)){
			#failed
			$this->session->set_userdata('notif_code', 2);
			$text ='';
			foreach ($this->upload->data() as $key => $value) {
				$text .= '['.$key.'] = '.$value.'<br>';
			}
			echo $text .= $this->upload->display_errors();
			$this->session->set_userdata('notif_text', $text );

			redirect('kuesioner/responden_import/'.$kuesioner_id);
		} else {
			$this->load->model('responden_model');
			$this->load->library('excel');
			$objReader 		= PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel 	= $objReader->load('temp/responden.xls');
			$sheetData 		= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$count 				= 0;
			$replica			= 0;
			$flag					= 0;
			foreach ($sheetData as $data) {
				if($flag==0){
					$flag++;
				} else{
					$cek = $this->responden_model->get_responden($kuesioner_id,$data['A']);
					if(!count($cek)){
						$this->responden_model->add_import($kuesioner_id,str_pad($data['A'], 6,"0",STR_PAD_LEFT),$data['B'],$head->skip_quota,$data['C']);
						$count++;
					}else{
						$replica++;
					}
				}
				// $data['A']
			}

			#success
			$this->session->set_userdata('notif_code', 1);
			$this->session->set_userdata('notif_text', 'Import '. $count.' Responden. '. $replica .' not import');
			redirect('kuesioner/detail/'.$kuesioner_id);
		}
	}
	public function delete($kuesioner_id='null')
	{
		if(!is_numeric($kuesioner_id)){
			redirect('kuesioner');
		}
		$old = $this->kuesioner_model->get_row($kuesioner_id);
		if(count($old)!=1){
			redirect('kuesioner');
		}

		$old = $this->kuesioner_model->delete($kuesioner_id);

		$this->session->set_userdata('notif_code', 1);
		$this->session->set_userdata('notif_text', 'Delete Kuesioner');
		redirect('kuesioner');
	}
	public function ajax_responden()
	{
		$kuesioner_id = $this->input->post('kuesioner_id');
		$old = $this->kuesioner_model->get_row($kuesioner_id);
		if ($old->is_all){
			$status = 0;
		}else{
			$status = 1;
		}
		$this->kuesioner_model->edit_all_unit($kuesioner_id,$status);
	}
}
/* End of file Kuesioner.php */
/* Location: ./system/application/controllers/Kuesioner.php */
