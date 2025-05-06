<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   Class Member extends CI_Controller {
   function __construct(){
   parent::__construct();
   if(! $this->session->userdata('adid'))
   redirect('admin/login');
    $this->load->library('form_validation');
    $this->load->model('Requestleave_Model');
    $this->load->model('Admin_member_Model');
    $this->load->model('User_Profile_Model');
    $this->load->model('Custom_email');

   }

   public function index()
   {
     $this->session->userdata('adid');
     $data['usersdetails']=$this->Admin_member_Model->getusersdetails();
     $data['roles']= $this->Admin_member_Model->getAllRoles();
     $this->load->view('admin/member',$data);
   }

   // For particular Record
   public function getuserdetail($adid)
   {
     $this->load->model('Admin_member_Model');
     $udetail=$this->Admin_member_Model->getuserdetail($adid);
     $this->load->view('admin/getuserdetails',['ud'=>$udetail]);
   }
   public function insert()
   {
      $this->form_validation->set_rules('email','email','trim|required|valid_email');
      $this->form_validation->set_rules('name', 'name', 'trim|required');

      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();
          if ($this->form_validation->run() == true)
          {
              $role_id = $this->input->post('role_id');
            	if($role_id == 0)
            	{
            		$is_admin = 2;
            	}
            	else
            	{
            		$is_admin = 0;
            	}
              $fourRandomDigit = mt_rand(1000,9999);
              $password = $this->input->post('password');
 
              $data = array(
                  'company_id' => $query->company_id,
                  'name' => $this->input->post('name'),
                  'email'=>$this->input->post('email'),
                  'role_id' => $this->input->post('role_id'),
                  'designation'=>$this->input->post('designation'),
                  'password' => $password,
                  'isActive'=>0,
                  'is_admin'=>$is_admin,
                  'member_color'=>$this->input->post('profilecolor'),
                  'created_at' => date("Y/m/d H:i:s"),
                  'updated_at' => date("Y/m/d H:i:s"),
                  );
              if ($_FILES['image']['size'] > 0) {
                  $this->load->library('upload');
                  $config['upload_path'] = 'image/';
                  $config['allowed_types'] = '*';
                  $config['overwrite'] = FALSE;
                  $config['encrypt_name'] = TRUE;
                  $config['max_filename'] = 25;
                  $this->upload->initialize($config);
                  if (!$this->upload->do_upload('image')) {
                      $error = $this->upload->display_errors();
                      $this->session->set_flashdata('error', $error);
                      redirect($_SERVER["HTTP_REFERER"]);
                  }
                  $photo = $this->upload->file_name;
                  $data['image'] = $photo;
              }
          } elseif ($this->input->post('add_member')) {
              $this->session->set_flashdata('error', validation_errors());
              redirect("admin/member");
          }
          if ($this->form_validation->run() == true && $this->Admin_member_Model->adddata($data)) {
            $subject = 'You\'ve Been Added to the Leave Tracker!';
            $to = $data['email'];
            $current_year = date("Y");
            $email_body .='
              <html>
                <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
                  <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;border: 1px solid #eeeff0 ">
                      <tbody>
                          <tr>
                              <td align="center" class="image-section" style="border-collapse: collapse;border: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5;padding: 5px;">
                                  <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/image/leaves1.png"></a>
                              </td>   
                          </tr>
                          <tr>
                              <td class="image-section" style="border-collapse: collapse;border: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5;padding: 30px">
                                  <p>Dear '.$data['name'].',</p>
                                  <p>I hope this email finds you well.</p>
                                  <p>I am writing to inform you that you have been successfully added to our company\'s Leave Tracker System. This system is designed to streamline and manage employee leave requests efficiently.</p>
                                  <p>Your login credentials are as follows:<br>
                                      <strong>Email: '.$data['email'].'</strong><br>
                                      <strong>Password: '.$data['password'].'</strong>
                                  </p>
                                  <p>Please use these credentials to access the Leave Tracker System.</p>
                                  <p>With the Leave Tracker System, you will be able to:<br><strong>
                                      1. Submit leave requests<br>
                                      2. View your leave balance<br>
                                      3. Check the status of your leave requests</strong>
                                  </p>
                                  <p>If you encounter any issues or have any questions regarding the system, please do not hesitate to reach out to the HR department or the designated system administrator.</p>
                                  <p>Thank you for your attention to this matter, and once again, welcome aboard!</p>
                                  <p>Best regards, <br>
                                      Softnoesis pvt. Ltd
                                  </p><br>
                                  <p align="center">
                                      <a href="https://www.facebook.com/softnoesis/" style="padding: 5px;"><img src="https://info.tenable.com/rs/tenable/images/facebook-teal.png"></a>
                                      <a href="https://www.linkedin.com/company/softnoesis/" style="padding: 5px;"><img src="https://info.tenable.com/rs/tenable/images/linkedin-teal.png"></a>
                                      <a href="https://www.youtube.com/results?search_query=softnoesis" style="padding: 5px;"><img src="https://info.tenable.com/rs/tenable/images/youtube-teal.png"></a> </td>

                                  </p>

                              </td>
                             
                          </tr>
                          <tr>
                              <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
                                      <div id="address" class="mktEditable">
                                      <p id="footer-txt"> <b>© Copyright '.$current_year.' Softnoesis. All rights reserved.</b>
                                      <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/">here</a>
                                  </p>
                                      <b>Softnoesis Private Ltd.</b><br>
                                          11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, GJ, India<br>
                                          <a style="color: #00a5b5;" href="https://leaves.softnoesis.in/">Contact Us</a>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </body>
              </htm>';
              
            $sent = $this->send_email($to, $subject, $email_body);
            $this->session->set_flashdata('message', "Member added successfully!");
            redirect("admin/member");
          } else {
              $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
              redirect("admin/member");
          }
   }
  
   public function Requestleave()
   {
      $userid = $this->session->userdata('adid');
      $data['profile']=$this->User_Profile_Model->getprofile($userid);
      $data['leaves_type'] = $this->Admin_member_Model->getleaves_typs();
      $user=$this->Admin_member_Model->getusersdetails();

      $this->load->view('admin/request_leaves',$data);
   }
  public function requestleaveinsert()
  {
      $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
      $enddate = date("Y-m-d", strtotime($this->input->post('enddate'))) ? date("Y-m-d", strtotime($this->input->post('enddate'))) :'0000-00-00';

      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query_1 = $this->db->get()->row();

      $this->db->select('emailid');
      $this->db->from('company');
      $this->db->where('id',$query_1->company_id);
      $comp_row = $this->db->get()->row();
      $company_email = $comp_row->emailid;

      $this->db->select('email');
      $this->db->from('member');
      $this->db->where('company_id',$query_1->company_id);
      $this->db->where('role_id',2);
      $hr_row = $this->db->get()->result();
      $hr_array = array();
      foreach ($hr_row as $key => $value) {
          $hr_array[] = $value->email;
      }
      $hr_email = implode(', ', $hr_array);

      $date1 = $startdate;
      $date2 = $enddate;
      if($this->input->post('half_day') == 0)
      {
          $start_time = date("H:i:s", strtotime($this->input->post('start_time')));
          $end_time = date("H:i:s", strtotime($this->input->post('end_time')));
          $duration_total = "0.5 day";
      }
      else
      {
          $start_time = "00:00:00";
          $end_time = "00:00:00";
          $diff = abs(strtotime($date2) - strtotime($date1));

          $years = floor($diff / (365*60*60*24));
          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
          $duration_total = $days + 1;
      }

      $insertdata = array(
      'user_id'=>$this->session->userdata('adid'),
      'company_id' =>$query_1->company_id,
      'leave_type'=>$this->input->post('leave_type'),
      'startdate'=>$startdate,
      'enddate'=>$enddate,
      'half_day'=>$this->input->post('half_day'),
      'full_day'=>$this->input->post('full_day'),
      'start_time'=>$start_time,
      'end_time'=>$end_time,
      'reason'=>$this->input->post('reason'),
      'duration'=>$duration_total,
      'created_at'=>date('Y-m-d H:i:s'),
      'updated_at'=>date('Y-m-d H:i:s'),
      );
      $user_id = $this->session->userdata('adid');
      $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));

      $this->db->select('name,email');
      $this->db->from('member');
      $this->db->where('user_id',$user_id);
      $query = $this->db->get()->row();


      $halfday = $insertdata['half_day'];
      $startDate = $insertdata['startdate'];
      $endDate = $insertdata['enddate'];
      $starttime = $insertdata['start_time'];
      $endtime = $insertdata['end_time'];
      $reason = $insertdata['reason'];
      if($halfday == 0)
      {
          $subject = "Leaves - ".$query->name." for ".date('j M', strtotime($startDate))." half day";
      }
      else
      {
          $subject = "Leaves - ".$query->name." for ".date('j M', strtotime($startDate))." to ".date('j M', strtotime($endDate));
      }
      $to =$query->email;
      $startdate = $insertdata['startdate'];
      $enddate = $insertdata['enddate'];
      $email_body = "";
      $current_year = date("Y");
      $email_body .='
        <htm>
          <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
            <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
              <tr>
                <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                  <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                    <tr>
                      <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
                        <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/image/leaves1.png"></a>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                          <tr>
                            <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
                          </tr>
                          <tr>
                            <td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                            <div class="mktEditable" id="main_text">
                              Dear ' . $query->name . ',<br><br>
                              '.($halfday == 0?'
                              <tr>
                                  <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform that you <strong>'. $query->name.'</strong> has applied for half day leave on this date <strong>'. date('d-m-Y', strtotime($startDate)) . ', '. date('l', strtotime($startDate)) . '</strong>  and this time <strong> ' . $starttime . ' </strong> to <strong>' . $endtime . '</strong>.)</div>
                                  </td>
                              </tr>':
                              '<tr>
                                  <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform that you <b>'. $query->name.'</b> has applied for leave on this date<strong> '. date('d-m-Y', strtotime($startDate)) . ', '. date('l', strtotime($startDate)).'</strong> to this Date <strong>'. date('d-m-Y', strtotime($endDate)).', '.date('l', strtotime($endDate)) . '</strong>.</div>
                                  </td>
                              </tr>').'
                            </div>
                            </td>
                          </tr>
                          <tr>
                              <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                  <div class="mktEditable" id="intro_title" style="float:left;">
                                  Reason: '.$reason.'
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                  <div class="mktEditable" id="intro_title" style="float:left;">
                                  Thanks You
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                  <div class="mktEditable" id="intro_title" style="float:left;">
                                  Regards,
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                  <div class="mktEditable" id="intro_title" style="float:left;">
                                  '. $query->name.'
                                  </div>
                              </td>
                          </tr>
                          <tr>
                            <td style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;">
                             &nbsp;<br>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                          <tr>
                            <td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
                              <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                              <tr>
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.facebook.com/softnoesis/"><img src="https://info.tenable.com/rs/tenable/images/facebook-teal.png"></a></td>
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.linkedin.com/company/softnoesis/"><img src="https://info.tenable.com/rs/tenable/images/linkedin-teal.png"></a></td>
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.youtube.com/results?search_query=softnoesis"><img src="https://info.tenable.com/rs/tenable/images/youtube-teal.png"></a></td>
                              </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr bgcolor="#fff" style="border-top: 4px solid #00a5b5;">
                      <td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                          <tr>
                            <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
                              <div id="address" class="mktEditable">
                                <p id="footer-txt"> <b>© Copyright '.$current_year.' Softnoesis. All rights reserved.</b>
                                <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/leaves/admin/login">here</a>
                              </p>
                                <b>Softnoesis Private Ltd.</b><br>
                                      11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, GJ, India<br>
                                      <a style="color: #00a5b5;" href="https://leaves.softnoesis.in/">Contact Us</a>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            </body>
        </htm>';
          $this->db->insert('leaves',$insertdata);
          $sent = $this->send_email($to, $subject, $email_body, $company_email, $hr_email);

          $this->session->set_flashdata('massage','Your leave has been requested');
          redirect(base_url('admin/Dashboard'));
  }
  public function deleteadmin($uid)
  {
    $this->load->model('Admin_member_Model');
    $this->Admin_member_Model->deleteadmin($uid);
    $this->session->set_flashdata('message','Member Deleted');
    redirect('admin/member');
  }

  public function edit($id)
  {
   		$this->load->model('Admin_member_Model');
      $exist =$this->Admin_member_Model->getproduct($id);
      $data=json_encode($exist);
      echo $data;

  }
  public function updatedata()
  {
      $id = $this->input->post('update_id');
      $data = array(
        'name' => $this->input->post('name'),
        'email'=>$this->input->post('email'),
        'role_id' => $this->input->post('role_id'),
        'designation'=>$this->input->post('designation'),
        'member_color'=>$this->input->post('profilecolor'),
        'isActive' => 0,
        'created_at' => date("Y/m/d H:i:s"),
        'updated_at' => date("Y/m/d H:i:s"),
      );
      // echo "<pre>";print_r($data);echo "</pre>";exit();
      if ($_FILES['image']['size'] > 0) {
          $this->load->library('upload');
          $config['upload_path'] = 'image/';
          $config['allowed_types'] = '*';
          $config['overwrite'] = FALSE;
          $config['encrypt_name'] = TRUE;
          $config['max_filename'] = 25;
          $this->upload->initialize($config);
          if (!$this->upload->do_upload('image')) {
              $error = $this->upload->display_errors();
              $this->session->set_flashdata('error', $error);
              redirect($_SERVER["HTTP_REFERER"]);
          }
          $photo = $this->upload->file_name;
          $data['image'] = $photo;
      }
      if ($this->Admin_member_Model->update_member($data,$id)) {
          $this->session->set_flashdata('message', "Member updated successfully!");
          redirect("admin/member");
      } else {

          $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
          redirect("admin/member");
      }
   }

  public function update_status()
  {
      $id     = $this->input->post('id');
      $status = $this->input->post('status');
      $this->load->model('Admin_member_Model');
      $data = $this->Admin_member_Model->change_user_status($id,$status);
      json_encode($data);
      echo $data;
  }
  public function HRProfile()
  {
      $userid = $this->session->userdata('adid');
      $profiledetails=$this->Admin_member_Model->getprofile($userid);
      $this->load->view('admin/user_profile',['profile'=>$profiledetails]);
  }
  public function updateprofile()
  {
    $userid = $this->session->userdata('adid');
    $birth_date = date("Y-m-d", strtotime($this->input->post('date_of_birth')));
    $data = array(
         'name'=>$this->input->post('name'),
         'designation'=>$this->input->post('designation'),
         'date_of_birth'=>$birth_date,
         'email'=>$this->input->post('email'),
         'address'=>$this->input->post('address'),
         'city'=>$this->input->post('city'),
         'state'=>$this->input->post('state'),
         'country'=>$this->input->post('country'),
         'phone_no'=>$this->input->post('phone_no'),
         'member_color'=>$this->input->post('profilecolor'),
      );

    if ($_FILES['profile_image']['size'] > 0) {
        $this->load->library('upload');
        $config['upload_path'] = 'image/';
        $config['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;
        $config['max_filename'] = 25;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('profile_image')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $photo = $this->upload->file_name;
        $data['image'] = $photo;
    }
    if ($this->User_Profile_Model->update_user($data,$userid)) {
        $this->session->set_flashdata('success', "Your details updated successfully!");
        redirect("admin/member/HRProfile");
    } else {
        $this->session->set_flashdata('error', "Something is wrong.");
        redirect("admin/member/HRProfile");

    }
  }
  public function filename_exists()
	{
	    $email = $this->input->post('email');
	    $exists = $this->Admin_member_Model->filename_exists($email);

	    $count = count($exists);
      if($count)
      {
        $responce = 1;
      }
      else
      {
        $responce = 0;
      }
	    $data  = json_encode($responce);
	    echo $data;
	}
  public function my_leaves()
  {
      $userid = $this->session->userdata('adid');
      $data['leaves'] = $this->Admin_member_Model->getAllMyLeaves();
      $data['leave_types'] = $this->Admin_member_Model->getAllLeaveTypes();
      $this->load->view('admin/my_leaves',$data);
  }
  public function getReason()
  {
      $id = $this->input->post('id');
      $exist =$this->Admin_member_Model->getLeaves($id);
      $data=json_encode($exist);
      echo $data;
  }
  public function cancel_leave()
  {
      $leave_id = $this->input->post('leave_id');
      $data = array(
        'reason'=>$this->input->post('reason'),
        'leave_status' =>3,
        'duration' => 0,
      );
      if ($this->Admin_member_Model->update_leave_reason($data,$leave_id)) {
        // die("kdlnf");
          $this->session->set_flashdata('message', "Your Leave Cancelled Successfully!");
          redirect(base_url('admin/Member/my_leaves'));

          exit;
      } else {

          $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
          redirect(base_url('admin/Member/my_leaves'));

          exit;
      }
  }
  public function edit_leave()
  {
      $leave_id = $this->input->post('update_id');
      $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
      $enddate = $this->input->post('enddate');

      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $user_data = $this->db->get()->row();

      $this->db->select('member.email,member.name');
      $this->db->from('member');
      $this->db->where('company_id',$user_data->company_id);
      $row_email = $this->db->get()->row();
      $admin_email = $row_email->email;

      $this->db->select('email');
      $this->db->from('member');
      $this->db->where('company_id',$user_data->company_id);
      $this->db->where('role_id',2);
      $hr_row = $this->db->get()->result();
      $hr_array = array();
      foreach ($hr_row as $key => $value) {
          $hr_array[] = $value->email;
      }
      $hr_email = implode(', ', $hr_array);

      if($this->input->post('half_day') == 0)
      {
          $duration_total = "0.5";
          $start_time = date("H:i:s", strtotime($this->input->post('start_time')));
          $end_time = date("H:i:s", strtotime($this->input->post('end_time')));
          $enddate_new = "0000-00-00";
      }
      else
      {
          $start_time = "00:00:00";
          $end_time = "00:00:00";
          $enddate_new = date("Y-m-d", strtotime($enddate));

          $date1 = $startdate;
          $date2 = $enddate_new;

          $diff = abs(strtotime($date2) - strtotime($date1));

          $years = floor($diff / (365*60*60*24));
          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
          $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
          $duration_total = $days + 1;
      }
      $insertdata = array(
        'user_id'=>$this->session->userdata('adid'),
        'company_id' =>$user_data->company_id,
        'leave_type'=>$this->input->post('leave_type'),
        'startdate'=>$startdate,
        'enddate'=>$enddate_new,
        'half_day'=>$this->input->post('half_day'),
        'start_time'=>$start_time,
        'end_time'=>$end_time,
        'reason'=>$this->input->post('reason'),
        'duration'=>$duration_total,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
      );
      $this->db->where('id',$leave_id);
      $this->db->update('leaves',$insertdata);

      $user_id=$this->session->userdata('adid');
      $this->db->select('member.name,member.email');
      $this->db->from('member');
      $this->db->join('company','company.id=member.company_id','left');
      $this->db->where('member.user_id',$user_id);
      $query = $this->db->get()->row();

      $halfday = $insertdata['half_day'];
      $startDate = $insertdata['startdate'];
      $endDate = $insertdata['enddate'];
      $starttime = $insertdata['start_time'];
      $endtime = $insertdata['end_time'];
      $reason = $insertdata['reason'];
      if($halfday == 0)
      {
          $subject = "Leaves - ".$query->name." for ".date('j M', strtotime($startDate))." half day";
      }
      else
      {
          $subject = "Leaves - ".$query->name." for ".date('j M', strtotime($startDate))." to ".date('j M', strtotime($endDate));
      }
      $to =$query->email;
      $startdate = $insertdata['startdate'];
      $enddate = $insertdata['enddate'];
      $email_body = "";
      $email_body .='
      <htm>
        <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
          <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
            <tr>
              <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                  <tr>
                    <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
                      <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/leaves/image/leaves.jpg"></a>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
                      <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                        <tr>
                          <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
                        </tr>
                        <tr>
                          <td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                          <div class="mktEditable" id="main_text">
                            Dear ' . $query->name . ',<br><br>
                            '.($halfday == 0?'
                            <tr>
                                <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform that you <strong>'. $query->name.'</strong> updated your requested half day leave on this date <strong>'. date('d-m-Y', strtotime($startDate)) . ', '. date('l', strtotime($startDate)).'</strong>  and this time <strong> ' . $starttime . ' </strong> , <strong>' . $endtime . '</strong>.)</div>
                                </td>
                            </tr>':
                            '<tr>
                                <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform that you <b>'. $query->name.'</b> updated your requested leave on this date <strong> '. date('d-m-Y', strtotime($startDate)).', '.date('l', strtotime($startDate)).'</strong> to this Date <strong>'. date('d-m-Y', strtotime($endDate)).', '.date('l', strtotime($endDate)) . '</strong>.</div>
                                </td>
                            </tr>').'
                          </div>
                          </td>
                        </tr>
                        <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                <div class="mktEditable" id="intro_title" style="float:left;">
                                Reason: '.$reason.'
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                <div class="mktEditable" id="intro_title" style="float:left;">
                                Thanks You
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                <div class="mktEditable" id="intro_title" style="float:left;">
                                Regards,
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                <div class="mktEditable" id="intro_title" style="float:left;">
                                '. $query->name.'
                                </div>
                            </td>
                        </tr>
                        <tr>
                          <td style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;">
                           &nbsp;<br>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                      <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                        <tr>
                          <td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
                            <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                            <tr>
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.facebook.com/softnoesis/"><img src="https://info.tenable.com/rs/tenable/images/facebook-teal.png"></a></td>
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.linkedin.com/company/softnoesis/"><img src="https://info.tenable.com/rs/tenable/images/linkedin-teal.png"></a></td>
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.youtube.com/results?search_query=softnoesis"><img src="https://info.tenable.com/rs/tenable/images/youtube-teal.png"></a></td>
                            </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr bgcolor="#fff" style="border-top: 4px solid #00a5b5;">
                    <td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
                      <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                        <tr>
                          <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
                            <div id="address" class="mktEditable">
                              <p id="footer-txt"> <b>© Copyright 2021 Softnoesis. All rights reserved.</b>
                              <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/leaves/admin/login">here</a>
                            </p>
                              <b>Softnoesis Private Ltd.</b><br>
                                    11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, GJ, India<br>
                                    <a style="color: #00a5b5;" href="https://leaves.softnoesis.in/">Contact Us</a>
                            </div>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          </body>
      </htm>';
      $sent = $this->send_email($to, $subject, $email_body, $admin_email,$hr_email);
      $this->session->set_flashdata('success','Your leave updated successfully!');
      redirect(base_url('admin/Member/my_leaves'));
  }
  public function reject_leave()
  {
      $leave_id = $this->input->post('leave_id');
      $data = array(
           'reject_reason'=>$this->input->post('reason'),
           'leave_status' =>2,
           'duration' => 0,
        );
      if ($this->Admin_member_Model->reject_leaves($data,$leave_id)) {
          $this->session->set_flashdata('message', "Leave rejected!");
          redirect("admin/Dashboard");
      } else {

          $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
          redirect("admin/Dashboard");

      }
  }
  public function modal_view($id)
  {

      $data = $this->Admin_member_Model->getUserLeaves($id);
      $row_data = json_encode($data);
      echo $row_data;
  }
  public function send_email($to, $subject, $body, $company_email='',$hr_email='')
  {
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();


        // SMTP configuration
        $from_email = $this->config->item('from_email');
        $password = $this->config->item('password');

        if($from_email == '' || $password == ''){
          return;   
        }

        // PHPMailer object
        $mail->isSMTP();
        $mail->Host     = $this->config->item('email_host');
        $mail->SMTPAuth = true;
        $mail->Username =  $this->config->item('from_email');
        $mail->Password = $this->config->item('password');
        $mail->SMTPSecure = $this->config->item('email_smtp_secure');
        $mail->Port     = $this->config->item('port');

        $mail->setFrom($this->config->item('from_email'), 'noreply');
        $mail->addReplyTo($this->config->item('from_email'), 'noreply');

        

        // Add a recipient
        $mail->addAddress($to);

        // Add cc or bcc 
        if($hr_email) {
          $hr_email_exp = explode(",",trim($hr_email));
          foreach ($hr_email_exp as $row_ind) {
              $mail->addCC(trim($row_ind));    
          }
        } 
        
        if($company_email) {
          $mail->addBCC($company_email);
        }

        // Email subject
        $mail->Subject = $subject;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mail->Body = $body;
        $sent = $mail->send();
        // Send email
        if($sent){
            $sent =  1;
        }else{
            $sent = 0;
        }
        return $sent;
  }

}
?>