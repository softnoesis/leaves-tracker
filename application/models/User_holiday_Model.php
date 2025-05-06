<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_holiday_Model extends CI_Model{
 public function getreportdetail($uid)
 {
    $ret = $this->db->select('name,date,description,id')->where('id',$uid)->get('holidays');
    return $ret->row();

 }
 public function getCurrentYearHolidays()
 {
  $year = date("Y");
 

  $start_date= $year."-01-01";
  $end_date=$year."-12-31";

    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row(); 
    
    $query = $this->db->select('name,date,description,id')
                  ->where('date >=',$start_date)
                  ->where('date <=',$end_date)
                  ->where('company_id',$company_id->company_id)
                  ->get('holidays');
            return $query->result();      
  }
  public function getPreviousYearHolidays()
  {
      $year = date("Y");
      $previousyear = $year -1;
      $start_date=$previousyear."-01-01";
      $end_date=$previousyear."-12-31";

    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $query = $this->db->select('name,date,description,id')
                  ->where('date >=',$start_date)
                  ->where('date <=',$end_date)
                  ->where('company_id',$company_id->company_id)
                  ->get('holidays');
            return $query->result();      
  }
  public function getPreviousYearHolidays1()
  {
    $year = date("Y");
    $previousyear = $year -2;
    $start_date=$previousyear."-01-01";
    $end_date=$previousyear."-12-31";

    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $query = $this->db->select('name,date,description,id')
                  ->where('date >=',$start_date)
                  ->where('date <=',$end_date)
                  ->where('company_id',$company_id->company_id)
                  ->get('holidays');
            return $query->result();
  }
}
?>