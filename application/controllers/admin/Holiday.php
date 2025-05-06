<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Holiday extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(! $this->session->userdata('adid'))
		redirect('admin/login');
		$this->load->model('Admin_holiday_Model');
	}

	public function index()
	{
		$data['current_year_holidays']=$this->Admin_holiday_Model->getCurrentYearHolidays();
		$data['previous_year_holidays']=$this->Admin_holiday_Model->getPreviousYearHolidays();
		$data['previous_year_holidays1']=$this->Admin_holiday_Model->getPreviousYearHolidays1();
		$this->load->view('admin/holiday',$data);
	}
	public function getuserdetail($uid)
	{
		$this->load->model('Admin_holiday_Model');
		$udetail=$this->Admin_holiday_Model->getuserdetail($uid);
		$this->load->view('admin/getuserdetails',['ud'=>$udetail]);
	}
	public function insert()
	{
		$this->Admin_holiday_Model->adddata();
    	$this->session->set_flashdata('success','Holiday added successfully');
		redirect('admin/holiday');    
	}
	public function deleteadmin($uid)
	{
		$this->load->model('Admin_holiday_Model');
		$this->Admin_holiday_Model->deleteadmin($uid);
    	$this->session->set_flashdata('success','Holiday deleted successfully');
		redirect('admin/holiday');
	}
	public function edit($id)
	{
        $exist =$this->Admin_holiday_Model->getproduct($id);
        $data=json_encode($exist);
        echo $data;
	}
    public function adminedit($id)
    {
        $data['result']=$this->Admin_holiday_Model->adminedit($id);
    }
	public function updatedata()
	{
		$dop_date = date("Y-m-d",strtotime($this->input->post('date')));
		// print_r($this->input->post());exit;
		$id = $this->input->post('update_id');		
		$insertdata = array(
		'name'=>$this->input->post('name'),
		'date'=>$dop_date,
		'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s')
		);       
		$this->db->where('id',$id);        
		$this->db->update('holidays',$insertdata);
    	$this->session->set_flashdata('success', 'Holiday edited successfully!');
		redirect("admin/holiday");
	}
}
?>