<?php
class Excel_model extends CI_Model
{
	public function Allmobilelist()
	{
		$query =  $this->db->select('model_no,mobile_name,company,mobile_category,price')
				->from('mobiles')
				->get();
				// echo "<pre>";print_r($query->result());die;
				return $query->result();
	}
	public function AllProducts()
	{
		return $this->db->get_where('products',array('p_status'=>1))->result();
		// $query =  $this->db->select('p_name,p_description,p_rate')
		// 		->from('products')
		// 		->get();
		// 		// echo "<pre>";print_r($query->result());die;
		// 		return $query->result();
	}
}

?>