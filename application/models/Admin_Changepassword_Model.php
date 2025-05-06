<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Admin_Changepassword_Model extends CI_Model 
{

  public function getcurrentpassword($adminid)
  {
      $query=$this->db->where(['user_id'=>$adminid])->get('member');
      if($query->num_rows() > 0)
      {
       	return $query->row();
      }
  }

  public function updatepassword($adminid,$newpassword)
  {
      $data = array('password' =>md5($newpassword));
      return $this->db->where(['user_id'=>$adminid])->update('member',$data);
  }
  public function getcurrentemail($adminid)
  {
      $query=$this->db->where(['user_id'=>$adminid])->get('member');
      if($query->num_rows() > 0)
      {
     	  return $query->row();
      }
  }

  public function update_email($adminid,$newemail)
  {
      $data=array('email' =>$newemail );
      return $this->db->where(['user_id'=>$adminid])->update('member',$data);
  }
}
