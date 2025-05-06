<?php 
   defined('BASEPATH') OR exit('No direct script access allowed'); 
   Class Admin_Leaves_Model extends CI_Model
   {
    public function getusersdetails()
    {
        $userid = $this->session->userdata('adid');
        $this->db->select('company_id');
        $this->db->from('member');
        $this->db->where('user_id',$userid);
        $company_id = $this->db->get()->row();          
        $query=$this->db->select('leavetype,id')->where('company_id',$company_id->company_id)->get('leaves_type');
        return $query->result();   
    }     
    public function getreportdetail($uid)
    {
      $ret=$this->db->select('leavetype')->where('id',$uid)->get('leaves_type');
      return $ret->row();
    
    }
    public function adddata() 
    {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $query = $this->db->get()->row();
      $insertdata = array('leavetype'=>$this->input->post('leavetype'),
                          'company_id' =>$query->company_id,
                          'crated_at'=>date('Y-m-d H:i:s'),
                          'updated_at'=>date('Y-m-d H:i:s'));  
      $this->db->insert('leaves_type',$insertdata);
      return true;
     }

    // Function for use deletion
    public function deleteadmin($uid)
    {
        $sql_query=$this->db->where('id',$uid)->delete('leaves_type');
    }
   
    public function getproduct($id)
    {
        $result=$this->db->where('id',$id)->get('leaves_type');
        return $result->row();
    }
}
?>