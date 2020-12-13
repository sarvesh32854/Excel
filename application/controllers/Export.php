<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Excel_model','export');

	}
	public function index()
	{
		$data['title'] = "Export Excel Data";
		$data['excelData'] = $this->export->Allmobilelist();
		$this->load->view('export/export',$data);
	}
	public function createXLS()
	{
		$this->load->library('Excel');
		$object = new PHPExcel();

		$object->setActiveSheetIndex(0);
		$table_columns = array('Model No.','Mobile Name','Price','Company','Category');

		$column =0;
		foreach ($table_columns as $field) 
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
			$column++;
		}

		$exportData =$this->export->Allmobilelist();

		$excel_row = 2;

		foreach ($exportData as $row) 
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->model_no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->mobile_name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->price);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->company);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->mobile_category);
			$excel_row++;
		}

		$object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="feedbackData.xls"');
		$object_writer->save('php://output');
	}
}