<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_holiday_Model extends CI_Model
{
    public function getCurrentYearHolidays()
    {
      // $start_date="2022-01-01";
      $start_date = date("Y") . '-01-01';
      // $end_date="2022-12-31";
      $end_date= date("Y") .'-12-31';
      // $this->db->where('leaves.created_at >=',date("Y") . '-01-01'); 


      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $company_id = $this->db->get()->row();

      $this->db->select('name,date,id');
      $this->db->from('holidays');
      $this->db->where('date >=',$start_date);
      $this->db->where('date <=',$end_date);
      $this->db->where('company_id',$company_id->company_id);
      $query = $this->db->get()->result();
      return $query;      
    }
    public function getPreviousYearHolidays()
    {
      $year = date("Y");
      $previousyear = $year -1;

      $start_date= $previousyear."-01-01";
      $end_date=$previousyear."-12-31";

      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $company_id = $this->db->get()->row();

      $this->db->select('name,date,id');
      $this->db->from('holidays');
      $this->db->where('date >=',$start_date);
      $this->db->where('date <=',$end_date);
      $this->db->where('company_id',$company_id->company_id);
      $query = $this->db->get()->result();
      return $query;
    }
    public function getPreviousYearHolidays1()
    {
      $year = date("Y");
      $previousyear = $year -2;
      $start_date=$previousyear."-01-01";
      $end_date=$previousyear."-12-31";

      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $company_id = $this->db->get()->row();

      $this->db->select('name,date,id');
      $this->db->from('holidays');
      $this->db->where('date >=',$start_date);
      $this->db->where('date <=',$end_date);
      $this->db->where('company_id',$company_id->company_id);
      $query = $this->db->get()->result();
      return $query;      
    }

  public function getreportdetail($uid)
  {
      $ret=$this->db->select('name,date,id')->where('id',$uid)->get('holidays');
      return $ret->row();
  }
  public function adddata()
  {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $company_id = $this->db->get()->row();
      $dop_date = date("Y-m-d",strtotime($this->input->post('date')));
      $insertdata = array(
      'name'=>$this->input->post('name'),
      'date'=>$dop_date,
      'company_id' =>$company_id->company_id,
      'created_at' =>date('Y-m-d'),
      'updated_at' =>date('Y-m-d'),
      );       
      $this->db->insert('holidays',$insertdata);
      return true;
  }
  public function deleteadmin($uid)
  {
      $sql_query=$this->db->where('id',$uid)->delete('holidays');
  }
  public function getproduct($id)
  {
      $this->db->where('id',$id);
      return $this->db->get('holidays')->row();  
  }
  public function adminedit($id)
  {
      $this->db->where('id',$id);
      return $this->db->get('holidays')->row();  
  }
}
?>