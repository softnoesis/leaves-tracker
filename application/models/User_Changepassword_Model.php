<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class User_Changepassword_Model extends CI_Model 
{
	public function getcurrentpassword($userid)
	{
		$query=$this->db->where(['user_id'=>$userid])->get('member');
       	if($query->num_rows() > 0)
       	{
       		return $query->row();
       	}
	}
	public function updatepassword($userid,$newpassword)
	{
		$data = array('Password' =>md5($newpassword));
		return $this->db->where(['user_id'=>$userid])->update('member',$data);
	}
}