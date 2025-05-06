<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Signup_Model extends CI_Model
{
	public function insert($fname,$lname,$emailid,$regDate,$mobilenumber,$designation,$password,$status)
	{
	 	$this->db->select('id');
	 	$this->db->from('member');
	 	$this->db->limit(1);
	 	$this->db->order_by('id','desc');
	    $result = $this->db->get()->row();
		$data=array(
			'name'=>$name,
			'image'=>$image,
			'personal_emailid'=>$personal_emailid,
			'company_emailid'=>$company_emailid,
			'website'=>$website,
			'address'=>$address,
			'city'=>$city,
			'state'=>$state,
			'country  '=>$country,
			'phone_no  '=>$phone_no,
			'role_id  '=>$role_id,
			'isActive'=>$status
		);
		$sql_query=$this->db->insert('member',$data);
		if($sql_query)
		{
			$this->session->set_flashdata('success', 'Registration successfully done');
				redirect('user/signup');
		}
		else
		{
			$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
			redirect('user/signup');
		}	
	}
}