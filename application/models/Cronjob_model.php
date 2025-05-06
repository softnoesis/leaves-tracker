<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Cronjob_model extends CI_Model 
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Custom_email');
  }
  public function getNotificationSameday()
  {
      $due_date = date('m-d');
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('user_id,company_id,name,date_of_birth,image,email');
      $this->db->from('member');
    //   $this->db->where('member.company_id',$query->company_id);
      $this->db->like('member.date_of_birth',$due_date);
      $this->db->where('member.isActive', 0);
      $res = $this->db->get()->result();

    //   $str = $this->db->last_query();
    //   echo "<pre>"; print_r($str); echo "</pre>";exit();
      return $res;    
  }
  public function getNotificationdaysBefore()
  {
      $due_date = date('Y-m-d', strtotime('1 days'));
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('user_id,company_id,name,date_of_birth,image,email');
      $this->db->from('member');
      //$this->db->where('member.company_id',$query->company_id);
      $this->db->where('DATE_FORMAT(member.date_of_birth, "%m-%d")',$due_date);
      $this->db->where('member.isActive', 0);
      $res = $this->db->get()->result();

      //$str = $this->db->last_query();
      //echo "<pre>"; print_r($str); echo "</pre>";exit();
      return $res;    
  }
  public function getNotificationforLeaves()
  {
      $due_date = date('Y-m-d', strtotime('1 days'));
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('leaves.*,member.user_id,member.company_id,member.name,member.date_of_birth,member.image,member.email');
      $this->db->from('leaves');
      $this->db->join('member','member.user_id=leaves.user_id','left');
      //$this->db->where('member.company_id',$query->company_id);
      $this->db->where('leaves.startdate =',$due_date);
    
      $this->db->where('leaves.leave_status', 1);
      $this->db->where('member.isActive', 0);
      $this->db->order_by('leaves.id','desc');
      $res = $this->db->get()->result();
      //$str = $this->db->last_query();
      
      return $res;    
  }
 
}
?>