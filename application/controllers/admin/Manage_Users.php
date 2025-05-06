<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Manage_Users extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('adid'))
redirect('admin/login');
}

public function index(){
$this->load->model('ManageUsers_Model');
$user=$this->ManageUsers_Model->getusersdetails();
$this->load->view('admin/manage_users',['userdetails'=>$user]);
}

// For particular Record
public function getuserdetail($uid)
{
$this->load->model('ManageUsers_Model');
$udetail=$this->ManageUsers_Model->getuserdetail($uid);
$this->load->view('admin/getuserdetails',['ud'=>$udetail]);
}

public function deleteuser($uid)
{
$this->load->model('ManageUsers_Model');
$this->ManageUsers_Model->deleteuser($uid);
$this->session->set_flashdata('success', 'User data deleted');
redirect('admin/manage_users');
}

public function useredit($id)
	{
		/*echo "<pre>";print_r($data);echo "</pre>";exit();*/
		$this->load->model('ManageUsers_Model');
		$data['result'] = $this->ManageUsers_Model->useredit($id);
		$this->load->view('admin/useredit',$data);
	}
	public function updatedata()
	{
	$id=$this->input->post('id');
	
		/*if($this->input->post('Update'))
		{
		*/	//echo "<pre>";print_r($post);echo "</pre>";
		$insertdata = array(
		'firstname'=>$this->input->post('firstname'),
		'lastname'=>$this->input->post('lastname'),
		'emailid'=>$this->input->post('emailid'),
		'mobilenumber'=>$this->input->post('mobilenumber'),
		'regDate'=>$this->input->post('regDate'),
		);
		//echo "<pre>";print_r($id);echo "</pre>";exit();
    	$this->db->where('id',$id);        
        $this->db->update('member',$insertdata);
                redirect('admin/manage_users');
   	

}

}
?>
