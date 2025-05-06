<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Requestleave extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(! $this->session->userdata('uid'))
        redirect('user/login');
        $this->load->model('Requestleave_Model');
        $this->load->model('Requestleave_Model');
        $this->load->model('User_Profile_Model');
        $this->load->model('Custom_email');
    }

    public function index()
    {
        $userid = $this->session->userdata('uid');
        $data['profile']=$this->User_Profile_Model->getprofile($userid);
        $data['leaves_type'] = $this->Requestleave_Model->getleaves_typs();
        $user=$this->Requestleave_Model->getusersdetails();
        $this->load->view('user/request_leave',$data);
    }
    public function getuserdetail($uid)
    {
        $this->load->model('Requestleave_Model');
        $udetail=$this->Requestleave_Model->getuserdetail($uid);
        $this->load->view('user/getuserdetails');
    }
    public function request_leave()
    {
        $startdate = date("Y-m-d", strtotime($this->input->post('startdate')));
        $enddate = $this->input->post('enddate');

        $userid = $this->session->userdata('uid');
        $this->db->select('company_id');
        $this->db->from('member');
        $this->db->where('user_id',$userid);
        $user_data = $this->db->get()->row();

        if($this->input->post('half_day') == 0)
        {
            $duration_total = "0.5";
            $start_time = date("H:i:s", strtotime($this->input->post('start_time')));
            $end_time = date("H:i:s", strtotime($this->input->post('end_time')));
            $enddate_new = date("Y-m-d", strtotime($startdate));
            //$enddate_new = "0000-00-00";
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
        $user_id=$this->session->userdata('uid');
        $this->db->select('member.name,member.email');
        $this->db->from('member');
        $this->db->join('company','company.id=member.company_id','left');
        $this->db->where('member.user_id',$user_id);
        $query = $this->db->get()->row();

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
        $hr_email = implode(',', $hr_array);

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
                            Hello Mr/Miss,<br><br>
                            '.($halfday == 0?'
                            <tr>
                                <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform you that <strong>'. $query->name.'</strong> has applied for half day leave on this date <strong>'. date('d-m-Y', strtotime($startDate)) . ', '. date('l', strtotime($startDate)).'</strong>  and offtime: <strong> ' . date("g:i a", strtotime($starttime)) . ' </strong> to <strong>' . date("g:i a", strtotime($endtime)) . '</strong>.</div>
                                </td>
                            </tr>':
                            '<tr>
                                <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform you that<b>'. $query->name.'</b> has applied for leave on this date <strong> '. date('d-m-Y', strtotime($startDate)).', '.date('l', strtotime($startDate)).'</strong> to this Date <strong>'. date('d-m-Y', strtotime($endDate)).', '.date('l', strtotime($endDate)) . '</strong>.</div>
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
                                <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://in.linkedin.com/in/hr-softnoesis"><img src="https://info.tenable.com/rs/tenable/images/linkedin-teal.png"></a></td>
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
            // $sent = $this->Custom_email->sendemail($to, $subject, $email_body,$company_email,$hr_email);
            $sent = $this->send_email($to, $subject, $email_body,$company_email,$hr_email);
            $this->db->insert('leaves',$insertdata);
            $this->session->set_flashdata('success','Your leave has been requested');
            redirect(base_url('user/Requestleave'));
    }
    public function send_email($to, $subject, $body, $company_email,$hr_email)
    {
        $this->load->library('phpmailer_lib');
        
        $from_email = $this->config->item('from_email');
        $password = $this->config->item('password');
    
        if($from_email == '' || $password == ''){
          return;   
        }
        // PHPMailer object
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
    // public function updateEnddate()
    // {
    //     $this->db->select('*');
    //     $this->db->from('leaves');
    //     $this->db->where('half_day',0);
    //     $this->db->Like('enddate','0000-00-00');
    //     $hr_row = $this->db->get()->result();

    //      echo "<pre>"; print_r($hr_row); echo "</pre>";exit();
    //     foreach ($hr_row as $key => $value)
    //     {
    //         $update = $this->db->query("UPDATE leaves SET enddate='".$value->startdate."' WHERE id='".$value->id."'");
    //     }
    //      echo "<pre>"; print_r($hr_row); echo "</pre>";exit();
    // }
}
