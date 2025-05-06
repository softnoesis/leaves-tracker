<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Leavespolicy extends CI_Controller 
{
  function __construct()
  {
    parent::__construct();
    if(! $this->session->userdata('adid'))
    redirect('admin/login'); 
  } 
  public function index()
  {
    $this->load->model('Admin_LeavesPolicy_Model');
    $data['userdetails']=$this->Admin_LeavesPolicy_Model->getusersdetails();
    $data['leaves_type'] = $this->Admin_LeavesPolicy_Model->getleaves_typs();
    $this->load->view('admin/leavespolicy',$data); 
  }
  public function getuserdetail($uid)
  {
    $this->load->model('Admin_LeavesPolicy_Model');
    $udetail=$this->Admin_LeavesPolicy_Model->getuserdetail($uid);
    $this->load->view('admin/getuserdetails',['ud'=>$udetail]);
  }
  public function insert()
  {      
    $this->load->model('Admin_LeavesPolicy_Model');  
    $this->Admin_LeavesPolicy_Model->adddata();
    $this->session->set_flashdata('success', 'Leaves policy added successfully!');
    redirect('admin/leavespolicy'); 
  }
  public function deleteadmin($uid)
  {
    $this->load->model('Admin_LeavesPolicy_Model');
    $this->Admin_LeavesPolicy_Model->deleteadmin($uid);
    $this->session->set_flashdata('success','Leaves policy deleted successfully');
    redirect('admin/leavespolicy');
  }   
  public function edit($id)
  {
    $this->load->model('Admin_LeavesPolicy_Model');
    $exist =$this->Admin_LeavesPolicy_Model->getproduct($id);
    $data=json_encode($exist);
    echo $data;  
  }
  public function updatedata()
  {
    $id = $this->input->post('update_id');
    $update = array(
      'id' => $this->input->post('update_id'),
      'leavetyps'=>$this->input->post('leavetyps'),
      'duration'=>$this->input->post('duration'),
      'crated_at'=>date('Y-m-d H:i:s'),
      'updated_at'=>date('Y-m-d H:i:s'),
    );  
    $this->db->where('id',$id);    
    $this->db->update('leaves_policy',$update);
    $this->session->set_flashdata('success', 'Leaves policy edited successfully!');
    redirect('admin/leavespolicy');
  }
}
?>