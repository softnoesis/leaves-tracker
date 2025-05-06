<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Leave_type extends CI_Controller 
{
  function __construct()
  {
    parent::__construct();
    if(! $this->session->userdata('adid'))
    redirect('admin/login'); 
  } 
  public function index()
  {
    $this->load->model('Admin_Leaves_Model');
      $user=$this->Admin_Leaves_Model->getusersdetails();
      $this->load->view('admin/leaves',['userdetails'=>$user]); 
  }
  public function getuserdetail($uid)
  {
    $this->load->model('Admin_Leaves_Model');
    $udetail=$this->Admin_Leaves_Model->getuserdetail($uid);
    $this->load->view('admin/getuserdetails',['ud'=>$udetail]);
  }
   public function insert()
    {      
      $this->load->model('Admin_Leaves_Model');  
      $this->Admin_Leaves_Model->adddata();
      $this->session->set_flashdata('success', 'Leaves added successfully!');
      redirect('admin/leave_type');    
    }
     public function deleteadmin($uid)
    {
      $this->load->model('Admin_Leaves_Model');
      $this->Admin_Leaves_Model->deleteadmin($uid);
      $this->session->set_flashdata('success','Leaves deleted successfully');
      redirect('admin/leave_type');
    }
   
    public function edit($id)
    {
      $this->load->model('Admin_Leaves_Model');
      $exist =$this->Admin_Leaves_Model->getproduct($id);
      $data=json_encode($exist);
      echo $data;   
    }
    public function updatedata()
    {
      $id = $this->input->post('update_id');
      $insertdata = array(
       'leavetype'=>$this->input->post('leavetype'),
       'crated_at'=>date('Y-m-d H:i:s'),
       'updated_at'=>date('Y-m-d H:i:s'),
      );
      $this->db->where('id',$id);        
      $this->db->update('leaves_type',$insertdata);
      $this->session->set_flashdata('success', 'Leaves edited successfully!');
      redirect('admin/leave_type');   
    }
}
?>