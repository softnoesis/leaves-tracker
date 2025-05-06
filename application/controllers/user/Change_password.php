<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Change_password extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(! $this->session->userdata('uid'))
		redirect('user/login');
		$this->load->model('User_Profile_Model');
		$this->load->model('User_Changepassword_Model');

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
			$userid = $this->session->userdata('uid');
			$cpass = $this->User_Changepassword_Model->getcurrentpassword($userid);
			$dbpass = $cpass->password;

			if($dbpass == $cpassword)
			{
				if($this->User_Changepassword_Model->updatepassword($userid,$newpassword))
				{
					$this->session->set_flashdata('success', 'Password changed successfully');
					redirect('user/change_password');
				}
			} 
			else 
			{
				$this->session->set_flashdata('error', 'Current password is wrong. Error!!');
				redirect('user/change_password');	
			} 
		} 
		else 
		{
			$userid = $this->session->userdata('uid');
			$data['profile']=$this->User_Profile_Model->getprofile($userid);
			$this->load->view('user/change_password',$data);
		}
	}
}