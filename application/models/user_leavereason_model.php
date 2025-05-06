<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class user_leavereason_Model extends CI_Model
{
	public function getusersdetails()
	{
		$query = $this->db->select('date,time,username,leave_reason,id')->get('leave_from');
		return $query->result();      
	}
 	public function getreportdetail($uid)
 	{
 		$ret = $this->db->select('date,time,username,leave_reason,id')->where('id',$uid)->get('leave_from');
 	    return $ret->row();
 	}

	public function deletereport($uid)
	{
		$sql_query = $this->db->where('id', $uid)->delete('leave_from');
    }

	public function useredit($id)
    {
    	$result = $this->db->where('id',$id)->get('leave_from');
	    return $result->row();	
	}
}
?>