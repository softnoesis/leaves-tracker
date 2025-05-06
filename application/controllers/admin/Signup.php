<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Signup extends CI_Controller 
{
	
	public function index()
	{
		$this->load->view('admin/signup');
	}
	  
	public function register()
	{
		$this->form_validation->set_rules('emailid','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('company_name','Company Name','required');
		if($this->form_validation->run())
		{
			$company_name=$this->input->post('company_name');
			$emailid=$this->input->post('emailid');
			$password=$this->input->post('password');
			$this->load->model('Admin_Signup_Model');
			$company = $this->Admin_Signup_Model->insert($company_name,$emailid,$password);
			if($company)
			{
				$this->session->set_flashdata('massage', 'Registration successfully done!');
				return redirect('admin/Login');
			}
			else
			{
				$this->session->set_flashdata('error', 'Something is wrong! Try again.');
				return redirect('admin/signup');
			}
		}
		else
		{
			$this->load->view('admin/signup');
		}
	}
}
?>
