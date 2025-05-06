<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class User_Attendance_Model extends CI_Model 
{
	
	public function getAttendance($userid)
  	{ 
  		$current_month = date('Y-m', strtotime(date('Y-m')." -1 month"));
	    
	    $this->db->select('company_id,name');
	    $this->db->from('member');
	    $this->db->where('user_id',$userid);
	    $company_id = $this->db->get()->row();
	    $emp_name = strtok($company_id->name, " ");
	    $this->db->select('*');
	    $this->db->from('attendance');
	    $this->db->where('company_id',$company_id->company_id);
	    $this->db->where('month_year',$current_month);
	    $this->db->like('employee_name',$emp_name);
	    $res = $this->db->get()->result();
	    
	    return $res;
  	}
  	public function getMonthandYear()
  	{ 
	    $userid = $this->session->userdata('uid');
	    $this->db->select('company_id');
	    $this->db->from('member');
	    $this->db->where('user_id',$userid);
	    $company_id = $this->db->get()->row();
	    
	    $this->db->select('month_year');
	    $this->db->from('attendance');
	    $this->db->where('company_id',$company_id->company_id);
	    $this->db->group_by('month_year');
	    $res = $this->db->get()->result();
	    return $res;
  	}
  	public function getCompanyName()
  	{ 
	    $userid = $this->session->userdata('uid');
	    $this->db->select('company_id');
	    $this->db->from('member');
	    $this->db->where('user_id',$userid);
	    $company_id = $this->db->get()->row();
	    
	    $this->db->select('id,company_name');
	    $this->db->from('company');
	    $this->db->where('id',$company_id->company_id);
	    $res = $this->db->get()->row();
	    return $res;
  	}
  	public function upload_csv($data)
	{
	    $this->db->insert("attendance", $data);
		return true;
	}
	public function getAttendanceData($month_name,$company_id,$emp_name)
  	{ 	    
  		$employee_name = strtok($emp_name, " ");
	    $this->db->select('*');
	    $this->db->from('attendance');
	    $this->db->where('company_id',$company_id);
	    $this->db->where('month_year',$month_name);
	    $this->db->like('employee_name',$employee_name);
	    $res = $this->db->get()->result();
	    return $res;
  	}
}	