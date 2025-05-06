<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class Admin_companyprofile_Model extends CI_Model
{
  public function getprofile($userid)
  {
      $this->db->select("company_id");
      $this->db->from("member");
      $this->db->where("user_id",$userid);
      $company_id = $this->db->get()->row();
      $query=$this->db->select('id,image,company_name,website_name,emailid,phone_no,address')->from('company')->where('id',$company_id->company_id)->get();
      return $query->row(); 
  }
  public function update_profile($id,$image,$company_name,$website_name,$emailid,$phone_no,$address)
  {
      $config['upload_path']   = './image/'; 
      $config['allowed_types'] = 'gif|jpg|png'; 
      $config['max_size']      = 100; 
      $config['max_width']     = 1024; 
      $config['max_height']    = 768;  
      $this->load->library('upload', $config);
  
      if ( ! $this->upload->do_upload('images')) {
        $error = array('error' => $this->upload->display_errors()); 
        redirect('admin/companyprofile');
      }
      else 
      { 
        $data = array('image' => $this->upload->data()); 
        
      }
      $data = array(
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
      $this->db->update('company',$data);
      return redirect('admin/companyprofile');
  }        
  public function getdata($id)
  {
    $result=$this->db->where('id',$id)->get('company');
    return $result->row();  
  }
}