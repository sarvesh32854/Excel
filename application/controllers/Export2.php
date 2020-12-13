<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export2 extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Excel_model','export');

	}
	public function index()
	{
		// echo 1234;die;
		$this->load->view('export/export2');
	}
	public function createXLS()
	{
		$this->load->library('Excel');
		$object = new PHPExcel();

		$object->setActiveSheetIndex(0);
		$table_columns = array('Name','Desc','Price');

		$column =0;
		foreach ($table_columns as $field) 
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
			$column++;
		}

		$exportData =$this->export->AllProducts();
		// echo "<pre>";print_r($exportData);die;
		$excel_row = 2;

		foreach ($exportData as $row) 
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow(0,$excel_row,$row->p_name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1,$excel_row,$row->p_description);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2,$excel_row,$row->p_rate);
			// $object->getActiveSheet()->setCellValueByColumnAndRow(3,$excel_row,$row->company);
			// $object->getActiveSheet()->setCellValueByColumnAndRow(4,$excel_row,$row->mobile_category);
			$excel_row++;
		}

		$object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="feedbackData.xls"');
		$object_writer->save('php://output');
	}
}