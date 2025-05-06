<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Change_password extends CI_Controller {
function __construct()
{
	parent::__construct();
	if(! $this->session->userdata('adid'))
	redirect('admin/login');
}

public function index()
{
	$this->form_validation->set_rules('currentpassword','Current Password','required|min_length[6]');	
	$this->form_validation->set_rules('password','Password','required|min_length[6]');
	$this->form_validation->set_rules('confirmpassword','Confirm Password','required|min_length[6]|matches[password]');
	if($this->form_validation->run())
	{
		$cpassword = md5($this->input->post('currentpassword'));
		$newpassword = $this->input->post('password');
		$confirm_password = $this->input->post('confirmpassword');
		$adminid = $this->session->userdata('adid');
		$this->load->model('Admin_Changepassword_Model');
		$cpass = $this->Admin_Changepassword_Model->getcurrentpassword($adminid);

		$dbpass=$cpass->password;

		if($dbpass==$cpassword)
		{
			if($this->Admin_Changepassword_Model->updatepassword($adminid,$newpassword))
			{
				$this->session->set_flashdata('success', 'Password changed successfully');
				redirect('admin/change_password');
			} 
			else
			{
				$this->session->set_flashdata('error', 'Password is wrong');
				redirect('admin/change_password');	
			}
			
		}
		else 
		{
			$this->session->set_flashdata('error', 'Current password is wrong. Error!!');
			redirect('admin/change_password');	
		}
	} 
	else 
	{
		$this->load->view('admin/change_password');
	}
}

public function my_profile()
{
	$adminid = $this->session->userdata('adid');
	$this->load->model('Admin_Changepassword_Model');
	$data['email'] = $this->Admin_Changepassword_Model->getcurrentemail($adminid);
	$this->load->view('admin/my_profile',$data);	
}
public function update_profile()
{
	$newemail=$this->input->post('email');
	$adminid = $this->session->userdata('adid');	
	$this->load->model('Admin_Changepassword_Model');
	$this->Admin_Changepassword_Model->update_email($adminid,$newemail);
	$this->session->set_flashdata('success', 'Email Changed Successfully');
	redirect('admin/change_password/my_profile');
}
}