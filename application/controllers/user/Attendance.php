<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Attendance extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		if(! $this->session->userdata('uid'))
		redirect('admin/login');
		$this->load->model('User_Attendance_Model');
		$this->load->model('User_Profile_Model');
	}
	public function index()
	{
		$userid = $this->session->userdata('uid');
		$data['attendance'] = $this->User_Attendance_Model->getAttendance($userid);
		$data['getyear'] = $this->User_Attendance_Model->getMonthandYear();
		$data['company'] = $this->User_Attendance_Model->getCompanyName();
		$data['profile']=$this->User_Profile_Model->getprofile($userid);
		$this->load->view('user/attendance',$data);
	}
	public function upload_attendance()
	{
	    if(isset($_POST["importSubmit"]))
        {
        	$userid = $this->session->userdata('uid');
		    $this->db->select('company_id');
		    $this->db->from('member');
		    $this->db->where('user_id',$userid);
		    $company_id = $this->db->get()->row();

        	$moths_year = $_POST['month_year'];
        	$total_duration = $_POST['total_duration'];
            $filename=$_FILES["upload_csv"]["tmp_name"];
            if($_FILES["upload_csv"]["size"] > 0)
            {
                $file = fopen($filename, "r");
                $count = 0;
			    $this->db->where('company_id',$company_id->company_id);
		    	$this->db->where('month_year',$moths_year);
		    	$this->db->delete('attendance');
                while (($line = fgetcsv($file, 0, ",")) !== FALSE) 
				{
				    $count++;
				    if ($count == 1) { continue; }
                    $arr = array('employee_code' => $line[0],
					 	'employee_name' => $line[1],
					 	'p' => $line[2],
					 	'a' => $line[3],
					 	'h' => $line[4],
					 	'h_p' => $line[5],
					 	'w_o' => $line[6],
					 	'w_o_p' => $line[7],
					 	'p_l' => $line[8],
					 	'c_l' => $line[9],
					 	's_l' => $line[10],
					 	'total_ot' => $line[11],
					 	't_duration' => $line[12],
					 	'early_by' => $line[13],
					 	'late_by' => $line[14],
					 	'total_leave' => $line[15],
					 	'total_present' => $line[16],
					 	'pay_days' => $line[17],
					 	'month_year' =>$moths_year,
					 	'total_duration' =>$total_duration,
					 	'created_at' =>  date('Y-m-d H:i:s'),
					 	'updated_at' =>  date('Y-m-d H:i:s'),
					 	'created_by' =>  $this->session->userdata('uid'),
					 	'updated_by' =>  $this->session->userdata('uid'),
					 	'company_id' =>  $company_id->company_id,
					);
					
                	$id = $this->Admin_Attendance_Model->upload_csv($arr);
                }
                fclose($file);
                $this->session->set_flashdata("success", "Attendance uploaded successfully!");
                redirect(base_url().'admin/attendance');
            }
        }
    }
    public function getAttendanceData()
	{
	    $month_name = $this->input->post('month_name');
	    $company_id = $this->input->post('company_id');
	    $emp_name = $this->input->post('emp_name');
	    $result = $this->Admin_Attendance_Model->getAttendanceData($month_name,$company_id,$emp_name);
	  	$data  = json_encode($result);
	    echo $data;
	}
}	