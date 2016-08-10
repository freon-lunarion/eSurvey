<?php
/**
* Hasil kuesioner
*
*/
class Responden extends Controller
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
		$this->load->model('survey_model');
		$data_header['title'] = 'Responden';
		$data_header['sub'] 	= 'Report';

		$result 							= $this->survey_model->get_type_list(2);
		$survey_list 					= array(0=>'');
		foreach ($result as $row) {
			$survey_list[$row->survey_type_id] = $row->type_name;
		}
		$data['survey_list'] 	= $survey_list;
		$data['process']			= 'report/responden/raw_data';
		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('report/responden_filter',$data);
		$this->load->view('template/main_bottom');
		$this->load->view('report/result_filter_js');

	}

	public function ajax_kuesioner()
	{
		$survey_type_id = $this->input->post('survey_type');
		$result = '<option value=0></option>';
		if($survey_type_id){
			$this->load->model('kuesioner_model');
			$kuesioner_list = $this->kuesioner_model->get_type_list($survey_type_id);
			foreach ($kuesioner_list as $row) {
				$result .= '<option value="'.$row->kuesioner_id.'">'.$row->title.'</option>';
			}
		}
		echo $result;
	}

	public function ajax_date()
	{
		$kuesioner_id = $this->input->post('kuesioner_id');
		if($kuesioner_id){
			$this->load->model('kuesioner_model');
			$kuesioner = $this->kuesioner_model->get_row($kuesioner_id);
			$json['start'] = date('Y-m-d',strtotime($kuesioner->start_time));
			$json['end'] = date('Y-m-d',strtotime($kuesioner->end_time));
		}else {
			$json['start'] = '';
			$json['end']   = '';
		}

		echo json_encode($json);
	}

	public function raw_data()
	{
		$this->load->model('report_model');
		$this->load->model('kuesioner_model');

		$kuesioner_id 				 = $this->input->post('slc_kuesioner');
		$start_time		         = $this->input->post('dtp_start');
		$end_time 		         = $this->input->post('dtp_end');

		$data_header['title'] = 'Responden';
		$data_header['sub'] 	= 'Raw Data';
		$responden 						= $this->report_model->get_responden_list($kuesioner_id,$start_time,$end_time);

		$data['kuesioner']		= $this->kuesioner_model->get_row($kuesioner_id);
		$data['responden']		= $responden;


		$data['link_export']	= 'report/responden/export/'.$kuesioner_id.'/'.$start_time.'/'.$end_time;
		$data['link_back']		= 'report/responden';

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('report/responden_view',$data);
		$this->load->view('template/main_bottom');

	}
	public function export($kuesioner_id=0,$start_time,$end_time)
	{
		$this->load->library('excel');
		$this->load->model('report_model');
		$this->load->model('kuesioner_model');
		$start_time        = str_replace('%20',' ',$start_time);
		$end_time          = str_replace('%20',' ',$end_time);
		$kuesioner				 = $this->kuesioner_model->get_row($kuesioner_id);
		$responden 				 = $this->report_model->get_responden_list($kuesioner_id,$start_time,$end_time);
		$columns 			     = $this->create_col('K');

		$this->excel->setActiveSheetIndex(0); // mengaktifkan sheet yang akan digunakan
		$this->excel->getActiveSheet()->setTitle($kuesioner->kuesioner_code); // mengganti nama sheet yang aktif
		$this->excel->getActiveSheet()->setCellValue('A1', 'NIK');
		$this->excel->getActiveSheet()->setCellValue('B1', 'Name');

		$this->excel->getActiveSheet()->setCellValue('C1', 'Unit ID');
		$this->excel->getActiveSheet()->setCellValue('D1', 'Unit Name');

		$this->excel->getActiveSheet()->setCellValue('E1', 'Div ID');
		$this->excel->getActiveSheet()->setCellValue('F1', 'Div Name');

		$this->excel->getActiveSheet()->setCellValue('G1', 'Dept ID');
		$this->excel->getActiveSheet()->setCellValue('H1', 'Dept Name');

		$this->excel->getActiveSheet()->setCellValue('I1', 'Sect ID');
		$this->excel->getActiveSheet()->setCellValue('J1', 'Sect Name');

		$this->excel->getActiveSheet()->setCellValue('K1', 'Submit On');
		$this->excel->getActiveSheet()->setCellValue('L1', 'Responden ID');

		$this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);

		$i = 2;
		foreach ($responden as $row_1) {
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $row_1->nik);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $row_1->name);

			$this->excel->getActiveSheet()->setCellValue('C'.$i, $row_1->unit_id);
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $row_1->unit_name);

			$this->excel->getActiveSheet()->setCellValue('E'.$i, $row_1->div_id);
			$this->excel->getActiveSheet()->setCellValue('F'.$i, $row_1->div_name);

			$this->excel->getActiveSheet()->setCellValue('G'.$i, $row_1->dept_id);
			$this->excel->getActiveSheet()->setCellValue('H'.$i, $row_1->dept_name);

			$this->excel->getActiveSheet()->setCellValue('I'.$i, $row_1->sect_id);
			$this->excel->getActiveSheet()->setCellValue('J'.$i, $row_1->sect_name);

			$this->excel->getActiveSheet()->setCellValue('K'.$i, date('y-m-d H:i:s',strtotime($row_1->submitted_on)));
			$this->excel->getActiveSheet()->setCellValue('L'.$i, $row_1->responden_id);

			$i++;
		}

		$this->excel->getActiveSheet()->freezePane('C2');
		$this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
		$filename = $kuesioner->type_name.' - '.$kuesioner->kuesioner_code.' - responden - '.date('ymd his').'.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}
	private function create_col($end_column, $first_letters = '')
	{
		$columns 	= array();
		$length 	= strlen($end_column);
		$letters 	= range('A', 'Z');

		// Iterate over 26 letters.
		foreach ($letters as $letter) {
				// Paste the $first_letters before the next.
				$column = $first_letters . $letter;

				// Add the column to the final array.
				$columns[] = $column;

				// If it was the end column that was added, return the columns.
				if ($column == $end_column)
						return $columns;
		}

		// Add the column children.
		foreach ($columns as $column) {
				// Don't itterate if the $end_column was already set in a previous itteration.
				// Stop iterating if you've reached the maximum character length.
				if (!in_array($end_column, $columns) && strlen($column) < $length) {
						$new_columns = $this->create_col($end_column, $column);
						// Merge the new columns which were created with the final columns array.
						$columns = array_merge($columns, $new_columns);
				}
		}

		return $columns;
	}
}
/* End of file result.php */
/* Location: ./system/application/controllers/result.php */
