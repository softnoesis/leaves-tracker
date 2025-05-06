<?php

defined('BASEPATH') OR exit('No direct script access allowed');
Class User_Profile extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(! $this->session->userdata('uid'))
        redirect('user/login');
        $this->load->model('User_Profile_Model');
        $this->load->model('Custom_email');
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function index()
    {

        $userid = $this->session->userdata('uid');
        $profiledetails = $this->User_Profile_Model->getprofile($userid);
        $this->load->view('user/User_profile',['profile'=>$profiledetails]);
    }
    public function updateprofile()
    {

        $userid = $this->session->userdata('uid');
        $birth_date = date("Y-m-d", strtotime($this->input->post('date_of_birth')));

        $data = array(
             'name'=>$this->input->post('name'),
             'date_of_birth'=>$birth_date,
             'designation'=>$this->input->post('designation'),
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
          // echo "<pre>";print_r($config['upload_path']);echo "</pre>";exit();
          $data['image'] = $photo;
        }
        // echo "<pre>";print_r($data);echo "</pre>";exit();
        if ($this->User_Profile_Model->update_user($data,$userid)) {
            $this->session->set_flashdata('message', "User updated Successfully!");
            redirect("user/User_Profile");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            redirect("user/User_Profile");

        }
    }
    public function filename_exists()
    {
        $email = $this->input->post('email');
        $exists = $this->User_Profile_Model->filename_exists($email);

        $count = count($exists);
        $data  = json_encode($count);
        echo $data;
    }
    public function my_leaves()
    {
        $userid = $this->session->userdata('uid');
        $data['profile'] = $this->User_Profile_Model->getprofile($userid);
        $data['leaves'] = $this->User_Profile_Model->getAllMyLeaves($userid);
        $data['leave_types'] = $this->User_Profile_Model->getAllLeaveTypes();
        $this->load->view('user/my_leaves',$data);
    }
    public function getReason()
    {
        $id = $this->input->post('id');
        $exist =$this->User_Profile_Model->getLeaves($id);
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
        if ($this->User_Profile_Model->update_leave_reason($data,$leave_id)) {
            $this->session->set_flashdata('message', "Your Leave Cancelled Successfully!");
            redirect("user/User_Profile/my_leaves");
        } else {

            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            redirect("user/User_Profile");

        }
    }
    public function edit_leave()
  	{
    		$leave_id = $this->input->post('update_id');
      	$startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
        $enddate = $this->input->post('enddate');

      	$userid = $this->session->userdata('uid');
      	$this->db->select('company_id');
      	$this->db->from('member');
      	$this->db->where('user_id',$userid);
      	$user_data = $this->db->get()->row();

        $this->db->select('emailid');
        $this->db->from('company');
        $this->db->where('id',$user_data->company_id);
        $comp_row = $this->db->get()->row();
        $company_email = $comp_row->emailid;

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
	      	'user_id'=>$this->session->userdata('uid'),
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

      	$user_id=$this->session->userdata('uid');
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
                        <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/image/leaves1.png" alt="Tenable Network Security"></a>
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
        $sent = $this->send_email($to, $subject, $email_body, $hr_email ,$company_email);
        $this->session->set_flashdata('success','Your leave updated successfully!');
        redirect(base_url('user/User_Profile/my_leaves'));
  	}
    public function send_email($to, $subject, $body, $company_email,$hr_email)
    {
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        
        $from_email = $this->config->item('from_email');
        $password = $this->config->item('password');
    
        if($from_email == '' || $password == ''){
          return;   
        }
        
        // SMTP configuration
        $mail = $this->phpmailer_lib->load();
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
        $hr_email_exp = explode(",",trim($hr_email));
        foreach ($hr_email_exp as $row_ind) {
            $mail->addCC(trim($row_ind));    
        }
        $company_email_exp = explode(",",trim($company_email));
        foreach ($company_email_exp as $row_ind) {
            $mail->addBCC(trim($row_ind));    
        }
        //$mail->addBCC($company_email);

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