<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Requestleave_Model extends CI_Model
{
	public function getusersdetails()
	{
    	$query=$this->db->select('user_id,leave_type,startdate,enddate,half_day,full_day,start_time,end_time,reason,id')
                  ->get('leaves');
            return $query->result();  
             
  	}
  	public function getleaves_typs()
  	{
	  	$userid = $this->session->userdata('uid');
	    $this->db->select('company_id');
	    $this->db->from('member');
	    $this->db->where('user_id',$userid);
	    $company_id = $this->db->get()->row();
	    
	    $query = $this->db->select('*')->where('company_id',$company_id->company_id)->get('leaves_type');
	    return $query->result();   
	}
}