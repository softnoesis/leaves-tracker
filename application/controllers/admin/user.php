<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Levae_approval extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('adid'))
redirect('admin/login');
}

public function index(){
$this->load->model('Levae_Model');
$user=$this->Levae_Model->getusersdetails();
$this->load->view('admin/levae',['userdetails'=>$user]);
}

// For particular Record
public function getuserdetail($uid)
{
$this->load->model('Levae_Model');
$udetail=$this->Levae_Model->getuserdetail($uid);
$this->load->view('admin/getuserdetails',['ud'=>$udetail]);
}

public function deleteuser($uid)
{
$this->load->model('Levae_Model');
$this->Levae_Model->deleteuser($uid);
$this->session->set_flashdata('success', 'User data deleted');
redirect('admin/levae');
}

public function useredit($id)
	{
		/*echo "<pre>";print_r($data);echo "</pre>";exit();*/
		$this->load->model('Levae_Model');
		$data['result'] = $this->Levae_Model->useredit($id);
		$this->load->view('admin/useredit',$data);
	}
	public function updatedata()
	{
	$id=$this->input->post('id');
	
		/*if($this->input->post('Update'))
		{
		*/	//echo "<pre>";print_r($post);echo "</pre>";
		$insertdata = array(
		'date'=>$this->input->post('date'),
		'time'=>$this->input->post('time'),
		'username'=>$this->input->post('username'),
		'leave_reasons'=>$this->input->post('leave_reasons'),
		'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
		//echo "<pre>";print_r($id);echo "</pre>";exit();
	);
    	$this->db->where('id',$id);        
        $this->db->update('leave_from',$insertdata);
                redirect('admin/levae');
   	}

}
?>
