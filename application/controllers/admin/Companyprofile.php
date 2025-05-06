<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Companyprofile extends CI_Controller 
{
  function __construct()
  {
    parent::__construct();
    if(! $this->session->userdata('adid'))
    redirect('admin/login');
    $this->load->model('Admin_companyprofile_Model');
  }
  public function index()
  { 
    $id = $this->session->userdata('adid');
    $profiledetails=$this->Admin_companyprofile_Model->getprofile($id);
    $this->load->view('admin/companyprofile',['profile'=>$profiledetails]);
  }
  public function updateprofile()
  { 
      $id = $this->input->post('update_id');
      if($_FILES['images']['tmp_name'] == "")
      {     
        $update = array(
          'company_name' =>$this->input->post('company_name'),
          'website_name'=>$this->input->post('website_name'),
          'emailid'=>$this->input->post('emailid'),
          'phone_no'=>$this->input->post('phone_no'),
          'address'=>$this->input->post('address'),
          'created_at'=>date('Y-m-d H:i:s'),
          'updated_at'=>date('Y-m-d H:i:s'),
          );
        $this->db->where('id',$id);        
        $this->db->update('company',$update);
        $this->session->set_flashdata('success','Company details updated successfully');
        redirect('admin/companyprofile');
      }
      else
      {
        if(is_uploaded_file($_FILES['images']['tmp_name']))
        {
          $time = time();
          $config['upload_path'] = 'image/';
          $config['allowed_types'] = '*';
          $config['overwrite'] = TRUE;
          $ext = explode(".", $_FILES['images']['name']);
          $config['file_name'] = $time.".".$ext[1];

          $this->load->library('upload', $config);

          $this->upload->initialize($config);

          if (!$this->upload->do_upload('images'))
          {
            $this->session->set_flashdata("errormsg", $this->upload->display_errors());
          }
          else
          {
            $arr["image"] = $time.".".$ext[1];
            $update = array(
              'image' =>$arr["image"],
              'company_name' =>$this->input->post('company_name'),
              'website_name'=>$this->input->post('website_name'),
              'emailid'=>$this->input->post('emailid'),
              'phone_no'=>$this->input->post('phone_no'),
              'address'=>$this->input->post('address'),
              'created_at'=>date('Y-m-d H:i:s'),
              'updated_at'=>date('Y-m-d H:i:s'),
              );
            $this->db->where('id',$id);        
            $this->db->update('company',$update);
            $this->session->set_flashdata('success','Company details updated successfully');
            redirect('admin/companyprofile');  
          }
        }
      }
  }
  public function add($id)
  {
    $this->load->model('Admin_companyprofile_Model');
    $exist =$this->Admin_companyprofile_Model->getdata($id);
    $data=json_encode($exist);
    echo $data;
  }
}
?>