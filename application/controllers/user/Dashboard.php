<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('uid') == '') {
			redirect('admin/login');
		}
	}
	public function index()
	{
		$userid = $this->session->userdata('uid');
		$this->load->model('User_Profile_Model');
		$data['total_leave_days']=$this->User_Profile_Model->getTotalLeavesDays($userid);
		$data['total_leave_users']=$this->User_Profile_Model->getTotalLeavesByUsers($userid);
		$data['pending']=$this->User_Profile_Model->getPendingLeaves();
		$data['todays']=$this->User_Profile_Model->getTodaysLeaves($userid);
		$data['upcoming']=$this->User_Profile_Model->getUpcomingLeaves($userid);
		$data['reject']=$this->User_Profile_Model->getRejectLeaves($userid);
		$data['history']=$this->User_Profile_Model->gethistoryLeaves($userid);
		$data['profile']=$this->User_Profile_Model->getprofile($userid);
		$this->load->view('user/dashboard',$data);
	}
}