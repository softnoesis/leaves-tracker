<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class User_Login_Model extends CI_Model {


public function validatelogin($email,$password){
	$this->db->select("is_admin");
	$this->db->from("member");
	$this->db->where(['email'=>$email,'password'=>$password]);
	$status=$this->db->get()->row();

	$query=$this->db->where(['email'=>$email,'password'=>$password,'is_admin'=>$status->is_admin]);
	$account=$this->db->get('member')->row();
	if(!empty($account))
	{
 		$dbstatus=$account->is_admin;
 		if($dbstatus == 0){
			$account->user_id;
		} else {
			$this->session->set_flashdata('error', 'Your accounis is not active contact admin');
			redirect('user/login');
		}
	}
	return $account->user_id;;
}

public function insert($name,$date,$in_time,$out_time,$work_hour,$over_time,$late_time,$early_out_time){
		 	
$data=array(
			'name'=>$name,
			'date'=>$date,
			'in_time'=>$in_time,
			'out_time'=>$out_time,
			'work_hour'=>$work_hour,
			'over_time'=>$over_time,
			'late_time'=>$late_time,
			'early_out_time'=>$early_out_time,
			'isActive'=>$status
		);
$sql_query=$this->db->insert('absexnt',$data);
if($sql_query){
$this->session->set_flashdata('success','Attendance successfull');
		redirect('user/login/User_attendance');
	}
	else{
		$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
		redirect('user/login/User_attendance');
	}

}

}
?>