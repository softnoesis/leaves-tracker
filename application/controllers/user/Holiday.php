<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Holiday extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(! $this->session->userdata('uid'))
		redirect('user/login');
		$this->load->model('User_holiday_Model');
		$this->load->model('User_Profile_Model');
	}

	public function index()
	{
		$userid = $this->session->userdata('uid');
		$data['current_year_holidays']=$this->User_holiday_Model->getCurrentYearHolidays();
		$data['previous_year_holidays']=$this->User_holiday_Model->getPreviousYearHolidays();
		$data['previous_year_holidays1']=$this->User_holiday_Model->getPreviousYearHolidays1();
		$data['profile']=$this->User_Profile_Model->getprofile($userid);
		$this->load->view('user/holiday',$data);
	}

	public function getuserdetail($uid)
	{
		$this->load->model('User_holiday_Model');
		$udetail=$this->User_holiday_Model->getuserdetail($uid);
		$this->load->view('admin/getuserdetails',['ud'=>$udetail]);
	}
}