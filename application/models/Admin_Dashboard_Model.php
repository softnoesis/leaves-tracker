<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Dashboard_Model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    if(! $this->session->userdata('adid'))
    redirect('admin/login');
    $this->load->model('Custom_email');
  }
  public function getPendingLeaves()
  {
    $start_date="2020-01-01";
    $end_date="2020-12-31";

    $userid = $this->session->userdata('adid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,member.role_id,leaves_type.leavetype');
    $this->db->from('leaves');
    $this->db->where('leave_status=',0);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type','left');
    $this->db->order_by('leaves.created_at','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getUpcomingLeaves()
  {
    $start_date="2020-01-01";
    $end_date="2020-12-31";

    $userid = $this->session->userdata('adid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,m.name as approved_name, member.role_id,leaves_type.leavetype');
    $this->db->from('leaves');
    $this->db->where('leave_status=',1);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type','left');
    $this->db->join('member as m','m.user_id = leaves.approved_by','left');
    $this->db->order_by('leaves.created_at','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getRejectLeaves()
  {
    $start_date="2020-01-01";
    $end_date="2020-12-31";

    $userid = $this->session->userdata('adid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,m.name as approved_name,member.role_id,leaves_type.leavetype');
    $this->db->from('leaves');
    $this->db->where('leave_status=',2);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type','left');
    $this->db->join('member as m','m.user_id = leaves.approved_by','left');
    $this->db->order_by('leaves.created_at','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getreportdetail($uid)
  {
    $ret=$this->db->select('*')->where('id',$uid)->order_by("id","desc")->get('leaves');
    return $ret->row();
  }
  public function change_user_status($id,$leave_status)
  {
    $this->db->select('user_id as userid,startdate,enddate');
    $this->db->from('leaves');
    $this->db->where('id',$id);
    $user_data = $this->db->get()->row();

    $this->db->select('name,email,company_id');
    $this->db->from('member');
    $this->db->where('user_id',$user_data->userid);
    $userName = $this->db->get()->row();

    $this->db->select('company_name');
    $this->db->from('company');
    $this->db->where('id',$userName->company_id);
    $query = $this->db->get()->row();

    $this->db->select('emailid');
    $this->db->from('company');
    $this->db->where('id',$userName->company_id);
    $comp_row = $this->db->get()->row();
    $company_email = $comp_row->emailid;

    $this->db->select('email');
    $this->db->from('member');
    $this->db->where('company_id',$userName->company_id);
    $this->db->where('role_id',2);
    $hr_row = $this->db->get()->result();
    $hr_array = array();
    foreach ($hr_row as $key => $value) {
        $hr_array[] = $value->email;
    }
    $hr_email = implode(', ', $hr_array);

    $update = $this->db->query("UPDATE leaves SET leave_status='".$leave_status."', approved_by='".$this->session->userdata('adid')."' WHERE id='".$id."'");
    if($update)
    {
        if($leave_status == 1)
        {
            $subject = "Leave Approved";

            $massage = '<p>Your leave request from '.date('dS F Y', strtotime($user_data->startdate)).' to '.date('dS F Y', strtotime($user_data->enddate)).' has been approved.<p>Please ensure a smooth transition of your tasks before your absence. If you have any concerns, feel free to reach out.</p>';
        }
        else
        {
            $subject = "Leave Rejected";
            $massage =  '<p>We regret to inform you that your leave request for the period '.$user_data->startdate.' to '.$user_data->enddate.' has been rejected.</p><p>Thank you for your understanding.</p>';
        }
        $to = $userName->email;
        $from ="softnoesis@gmail.com";
        $email_body = "";
        $email_body .=   '<html>
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
                                  <p>Dear '. $userName->name.',</p>
                                  <p>'.$massage.'</p>
                                  
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
                                      <p id="footer-txt"> <b>© Copyright 2021 Softnoesis. All rights reserved.</b>
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
            $sent = $this->Custom_email->sendemail($to, $subject, $email_body,$company_email,$hr_email);
            return $leave_status;
    }
    else
    {
        return 0;
    }
  }
  public function sendemail($to, $subject, $body, $company_email,$hr_email)
  {
    $this->load->library("email");

    $from_email = $this->config->item('from_email');
    $password = $this->config->item('password');

    if($from_email == '' || $password == ''){
      return;   
    }

    $config['protocol']     = 'smtp';
    $config['smtp_host']    = $this->config->item('email_host');
    $config['smtp_port']    = $this->config->item('port');
    $config['smtp_timeout'] = '60';
    // $config['smtp_crypto'] = 'ssl';

    $config['smtp_user']    = $this->config->item('from_email');;    //Important
    $config['smtp_pass']    = $this->config->item('password');  //Important

      $config['charset']      = 'utf-8';
      $config['newline']      = "\r\n";
      $config['mailtype']     = 'html'; // or html
      $config['validation']   = TRUE; // bool whether to validate email or not

      $this->load->library('email', $config);
      //$this->email->initialize($config);
      $this->email->set_mailtype("html");
      $this->email->set_newline("\r\n");
      $this->email->from($from);
      $this->email->to($to);
      $this->email->cc($hr_email);
      $this->email->bcc($company_email);
      $this->email->subject($subject);
      $this->email->message($body);
      $sent = $this->email->send();
      if($sent)
      {
          $sent = 1;
      }
      else
      {
          $sent =  0;
      }
      return $sent;
  }
  public function getNotificationSameday()
  {
      $due_date = date('m-d');
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('user_id,company_id,name,date_of_birth,image,email');
      $this->db->from('member');
      $this->db->where('member.company_id',$query->company_id);
      $this->db->like('member.date_of_birth',$due_date);
      $this->db->where('member.isActive', 0);
      $res = $this->db->get()->result();

      $str = $this->db->last_query();

      return $res;
  }
  public function getNotificationdaysBefore()
  {
      $due_date = date('Y-m-d', strtotime('1 days'));
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('user_id,company_id,name,date_of_birth,image,email');
      $this->db->from('member');
      $this->db->where('member.company_id',$query->company_id);
      $this->db->where('member.date_of_birth >=',$due_date);
      $this->db->where('member.isActive', 0);
      $res = $this->db->get()->result();

      //$str = $this->db->last_query();
      //echo "<pre>"; print_r($str); echo "</pre>";exit();
      return $res;
  }
  public function getNotificationforLeaves()
  {
      $due_date = date('Y-m-d', strtotime('1 days'));
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('leaves.*,member.user_id,member.company_id,member.name,member.date_of_birth,member.image,member.email');
      $this->db->from('leaves');
      $this->db->join('member','member.user_id=leaves.user_id','left');
      $this->db->where('member.company_id',$query->company_id);
    
      $this->db->group_start();
      $this->db->where('leaves.startdate',$due_date);

      $this->db->or_where('leaves.enddate',$due_date);
      $this->db->group_end();

      $this->db->where('leaves.leave_status', 1);
      $this->db->where('member.isActive', 0);
      $res = $this->db->get()->result();
      //$str = $this->db->last_query();
      //echo "<pre>"; print_r($str); echo "</pre>";exit();
      return $res;
  }
}
?>