<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class User_Companyprofile_Model extends CI_Model
{
  public function getprofile($userid)
  {
      $this->db->select("company_id");
      $this->db->from("member");
      $this->db->where("user_id",$userid);
      $company_id = $this->db->get()->row();

      $this->db->select("company.id,company.image as company_image,company.company_name,company.website_name,company.emailid,company.phone_no,company.address,member.image as member_image");
      $this->db->from("company");
      $this->db->join("member","member.company_id=company.id");
      $this->db->where("company.id",$company_id->company_id);
      $query = $this->db->get()->row();
      return $query;
  }
  public function update_profile($name,$image,$website,$email,$address)
  {
      if(is_uploaded_file($_FILES['image']['tmp_name']))
      {
            $time = time();
            $config['upload_path'] = 'image/';
            $config['allowed_types'] = '*';
            $config['overwrite'] = TRUE;
            $ext = explode(".", $_FILES['image']['name']);
            $config['file_name'] = $time.".".$ext[1];

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image'))
            {
                $this->session->set_flashdata("errormsg", $this->upload->display_errors());
            }
            else
            {
                $arr["image"] = $time.".".$ext[1]; 
                $data = array(
                  'image' =>$arr["image"],
                  'name' =>$name,
                  'website'=>$this->input->post('website'),
                  'email'=>$this->input->post('email'),
                  'address'=>$this->input->post('address'),
                );
            }
      }
      $sql_query=$this->db->where('user_id', $userid)->update('member', $data); 
  }
}