<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class Admin_LeavesPolicy_Model extends CI_Model
{
  public function getusersdetails()
  {
    $userid = $this->session->userdata('adid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves_policy.*,leaves_type.leavetype as leavetyps_name');
    $this->db->from('leaves_policy');
    $this->db->join('leaves_type','leaves_type.id = leaves_policy.leavetyps','left'); 
    $this->db->where('leaves_policy.company_id',$company_id->company_id);
    $this->db->order_by('leaves_policy.id','desc'); 
    $res = $this->db->get()->result();
    return $res; 
   
  }
  public function getreportdetail($uid)
  {
      $ret=$this->db->select('year,leavetyps,duration')->where('id',$uid)->get('leaves_policy');
      return $ret->row();
  }
  public function adddata()
  {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $query = $this->db->get()->row();

       $insertdata = array('year'=>$this->input->post('year'),
                           'company_id' =>$query->company_id,
                           'leavetyps'=>$this->input->post('leavetyps'),
                           'duration'=>$this->input->post('duration'),
                           'crated_at'=>date('Y-m-d H:i:s'),
                           'updated_at'=>date('Y-m-d H:i:s')
                         );  
      $this->db->insert('leaves_policy',$insertdata);
      return true;
  }
  public function getproduct($id)
  {
      $result=$this->db->where('id',$id)->get('leaves_policy');
      return $result->row();    
  }
  public function getleaves_typs()
  {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $company_id = $this->db->get()->row();

      $this->db->select('*');
      $this->db->from('leaves_type');
      $this->db->where('leaves_type.company_id',$company_id->company_id);
      $res = $this->db->get()->result();
      return $res;  
  }
  public function deleteadmin($uid)
  {
      $sql_query=$this->db->where('id',$uid)->delete('leaves_policy');
  }
}
   