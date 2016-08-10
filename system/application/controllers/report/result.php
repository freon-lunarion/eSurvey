<?php
/**
* Hasil kuesioner
*
*/
class Result extends Controller
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
		$data_header['title'] = 'Result';
		$data_header['sub'] 	= 'Report';

		$result 							= $this->survey_model->get_type_list(2);
		$survey_list 					= array(0=>'');
		foreach ($result as $row) {
			$survey_list[$row->survey_type_id] = $row->type_name;
		}
		$data['survey_list'] 	= $survey_list;

		$data['process']			= 'report/result/raw_data';
		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('report/result_filter',$data);
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
				$result .= '<option value="'.$row->kuesioner_id.'">'.$row->kuesioner_code.'</option>';
			}
		}
		echo $result;
	}

	public function ajax_unit()
	{
		$kuesioner_id = $this->input->post('kuesioner_id');
		$result = '<option value=0></option>';
		if($kuesioner_id){
			$this->load->model('kuesioner_model');
			$unit_list = $this->kuesioner_model->get_unit_list($kuesioner_id);
			foreach ($unit_list as $row) {
				$result .= '<option value="'.$row->org_id.'">'.$row->org_name.'</option>';
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
			$json['start'] = date('Y-m-d H:i:s',strtotime($kuesioner->start_time));
			$json['end'] = date('Y-m-d H:i:s',strtotime($kuesioner->end_time));
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

		$kuesioner_id = $this->input->post('slc_kuesioner');
		$unit_id      = $this->input->post('slc_unit');
		$data_header['title'] = 'Result';
		$data_header['sub'] 	= 'Raw Data';
		$kuesioner = $this->kuesioner_model->get_row($kuesioner_id);
		$data['kuesioner']		= $kuesioner;

		$start_time		= $kuesioner->start_time;
		$end_time 		= $kuesioner->end_time;
		$data['responden']		= $this->report_model->get_responden_list($kuesioner_id,$start_time,$end_time,$unit_id);
		$data['link_back']		= 'report/result';
		$data['link_export']	= 'report/result/export/'.$kuesioner_id.'/'.$unit_id;

		$this->load->view('template/admin_top');
		$this->load->view('template/page_header',$data_header);
		$this->load->view('report/result_view',$data);
		$this->load->view('template/main_bottom');

	}

	public function export($kuesioner_id=0,$unit_id=0)
	{
		ini_set('memory_limit', -1);
		$this->load->library('excel');
		$this->load->model('report_model');
		$this->load->model('kuesioner_model');

		// $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_discISAM;
		// PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
		$kuesioner				= $this->kuesioner_model->get_row($kuesioner_id);

		$question 				= $this->report_model->get_question_list($kuesioner_id);
		$columns    			= $this->create_col('ZZ');
		$answer 					= $this->report_model->get_answer($kuesioner_id,$unit_id);


		$this->excel->setActiveSheetIndex(0); // mengaktifkan sheet yang akan digunakan
		$this->excel->getActiveSheet()->setTitle($kuesioner->kuesioner_code); // mengganti nama sheet yang aktif
		$this->excel->getActiveSheet()->setCellValue('A1', 'Responden ID');
		$this->excel->getActiveSheet()->setCellValue('B1', 'NIK');
		$this->excel->getActiveSheet()->setCellValue('C1', 'Gender');

		$this->excel->getActiveSheet()->setCellValue('D1', 'Birthdate');
		$this->excel->getActiveSheet()->setCellValue('E1', 'Age');

		$this->excel->getActiveSheet()->setCellValue('F1', 'Join Date');
		$this->excel->getActiveSheet()->setCellValue('G1', 'Len. Serv.');

		$this->excel->getActiveSheet()->setCellValue('H1', 'Permanent Date');
		$this->excel->getActiveSheet()->setCellValue('I1', 'Len. Permanent');

		$this->excel->getActiveSheet()->setCellValue('J1', 'Status');
		$this->excel->getActiveSheet()->setCellValue('K1', 'Chief Status');

		$this->excel->getActiveSheet()->setCellValue('L1', 'ESG');
		$this->excel->getActiveSheet()->setCellValue('M1', 'Layer/Group');

		$this->excel->getActiveSheet()->setCellValue('N1', 'Post. Name');

		$this->excel->getActiveSheet()->setCellValue('O1', 'Unit ID');
		$this->excel->getActiveSheet()->setCellValue('P1', 'Unit');

		$this->excel->getActiveSheet()->setCellValue('Q1', 'Div ID');
		$this->excel->getActiveSheet()->setCellValue('R1', 'Div');

		$this->excel->getActiveSheet()->setCellValue('S1', 'Dept ID');
		$this->excel->getActiveSheet()->setCellValue('T1', 'Dept');

		$this->excel->getActiveSheet()->setCellValue('U1', 'Sect ID');
		$this->excel->getActiveSheet()->setCellValue('V1', 'Sect');

		$y = 22;

		foreach ($question as $row) {

			$this->excel->getActiveSheet()->setCellValue($columns[$y].'1', '['.$row->question_code.']');
			switch ($row->type) {
				case 1: //scale
					$color = '0066FF';
					break;
				case 2: //multiple choice
					$color = '00CC00';
					break;
				case 3: //open answer
					$color = '6600FF';
					break;
				case 4: //checkbox
					$color = 'FFCC00';
					break;
			}
			$this->excel->getActiveSheet()->getStyle($columns[$y].'1')->applyFromArray(
					array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => $color)
							)
					)
			);
			unset($color);
			$y++;
		}
		$this->excel->getActiveSheet()->getStyle('A1:AC1')->getFont()->setBold(true);
		$arr_gender = array('Wanita','Pria');
		$arr_status = array(
			'01' => 'Permanent',
			'02' => 'Contract',
			'03' => 'Probation',
			'04' => 'Trainee',
			'05' => 'Expatriat <=183',
			'06' => 'Expatriat >183',
		);
		$arr_type 	= array('','Scale','Multiple Choice','Open Answer','Checkbox');
		$arr_chief 	= array('','Co-Chief','Chief');
		$i = 2;
		foreach ($answer as $row_1) {
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $row_1->responden_id);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $row_1->nik);
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $arr_gender[$row_1->gender]);

			$this->excel->getActiveSheet()->setCellValue('D'.$i, date('Y-m-d',strtotime($row_1->birthdate)));
			$length = $this->count_diff_date($row_1->birthdate,$row_1->submitted_on);
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $length['year'] . ' Year '.$length['month'] . ' Month ');

			$this->excel->getActiveSheet()->setCellValue('F'.$i, date('Y-m-d',strtotime($row_1->join_date)));
			$length = $this->count_diff_date($row_1->join_date,$row_1->submitted_on);
			$this->excel->getActiveSheet()->setCellValue('G'.$i, $length['year'] . ' Year '.$length['month'] . ' Month ');

			if ($row_1->status_flag!='01') {
				$date = '-';
				$len 	= '-';
			} else{
				$date 	= date('Y-m-d',strtotime($row_1->permanent_date));
				$length = $this->count_diff_date($row_1->permanent_date,$row_1->submitted_on);
				$len 		=  $length['year'] . ' Year '.$length['month'] . ' Month ';
			}
			$this->excel->getActiveSheet()->setCellValue('H'.$i, $date);
			$this->excel->getActiveSheet()->setCellValue('I'.$i, $len);
			unset($date);
			unset($len);
			unset($length);

			$this->excel->getActiveSheet()->setCellValue('J'.$i, $arr_status[$row_1->status_flag]);
			$this->excel->getActiveSheet()->setCellValue('K'.$i, $arr_chief[$row_1->chief_status]);

			$this->excel->getActiveSheet()->setCellValue('L'.$i, $row_1->esg);
			$this->excel->getActiveSheet()->setCellValue('M'.$i, $row_1->esg_text);

			$this->excel->getActiveSheet()->setCellValue('N'.$i, $row_1->position_name);

			$this->excel->getActiveSheet()->setCellValue('O'.$i, $row_1->unit_id);
			$this->excel->getActiveSheet()->setCellValue('P'.$i, $row_1->unit_name);

			$this->excel->getActiveSheet()->setCellValue('Q'.$i, $row_1->div_id);
			$this->excel->getActiveSheet()->setCellValue('R'.$i, $row_1->div_name);

			$this->excel->getActiveSheet()->setCellValue('S'.$i, $row_1->dept_id);
			$this->excel->getActiveSheet()->setCellValue('T'.$i, $row_1->dept_name);

			$this->excel->getActiveSheet()->setCellValue('U'.$i, $row_1->sect_id);
			$this->excel->getActiveSheet()->setCellValue('V'.$i, $row_1->sect_name);
			$y = 22;

			foreach ($question as $row_2) {
				$temp = $row_2->question_id;
				$this->excel->getActiveSheet()->setCellValue($columns[$y].$i, $row_1->$temp );
				$y++;
			}
			unset($y);
			$i++;
		}

		// $this->excel->getActiveSheet()->freezePane('L2');
		// $this->excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
		// $filename = $kuesioner->type_name.' - '.$kuesioner->kuesioner_code.' - result - '. $unit_id.' - '.date('ymd his').'.xls';
		// header('Content-Type: application/vnd.ms-excel');
		// header('Content-Disposition: attachment;filename="'.$filename.'"');
		// header('Cache-Control: max-age=0');

		// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$filename = $kuesioner->type_name.' - '.$kuesioner->kuesioner_code.' - result - '. $unit_id.' - '.date('ymd his').'.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

		$objWriter->save('php://output');

		$this->excel->disconnectWorksheets();
		unset($this->excel);
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
	      // Add value and interval
	      // if value is bigger than 0

		// Add value and interval to times array
			$times[] = $value . " " . $interval;
			$result[$interval] = $value;
			$count++;

	  }

	  // Return string with times
	  // return implode(", ", $times);
	  return $result;
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
