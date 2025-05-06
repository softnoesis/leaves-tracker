<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Companyprofile extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    if(! $this->session->userdata('uid'))
    redirect('user/login');
    $this->load->model('User_Companyprofile_Model');
    $this->load->model('User_Profile_Model');
  }
  public function index()
  { 
    $userid = $this->session->userdata('uid');
    $data['com_profile']=$this->User_Companyprofile_Model->getprofile($userid);
    $data['profile']=$this->User_Profile_Model->getprofile($userid);
    $this->load->view('user/companyprofile',$data);
  }
  public function updateprofile()
  {  
    $this->form_validation->set_rules('image','image','required|alpha');
    $this->form_validation->set_rules('name','name','required|alpha');
    $this->form_validation->set_rules('website','website','required|alpha');
    $this->form_validation->set_rules('company_emailid','company_emailid','required|alpha');
    $this->form_validation->set_rules('address','address','required|alpha');
    if($this->form_validation->run())
    {
      $image=$this->input->post('image');  
      $name=$this->input->post('name');
      $website=$this->input->post('website');
      $company_emailid=$this->input->post('company_emailid');
      $address=$this->input->post('address');
      $this->User_Profile_Model->update_profile($image,$name,$website,$company_emailid,$address);
      $this->session->set_flashdata('success','Profile updated successfully.');
      return redirect('admin/companyprofile');
    } 
    else 
    {
      $this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
      redirect('admin/companyprofile');
    }
  }
}