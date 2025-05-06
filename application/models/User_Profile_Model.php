<?php


defined('BASEPATH') OR exit('No direct script access allowed');
class User_Profile_Model extends CI_Model
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('Custom_email');
  }
  public function getprofile($userid)
  {
  	 $query=$this->db->select('name,image,designation,email,address,city,state,country,phone_no,member_color,date_of_birth')
                  ->where('user_id',$userid)
                  ->from('member')
                  ->get();
                  return $query->row();
  }
  public function update_user($data,$id)
  {
      $this->db->where('user_id',$id);
      $this->db->update('member',$data);
      return true ;
  }
  public function  getLeaves($id)
  {
      $query=$this->db->select('*')->where('id',$id)->from('leaves')->get();
      return $query->row();
  }

  public function update_profile($name,$image,$email,$designation,$address,$city,$state,$country,$phone_no)
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
             'name' =>$name,
             'image' =>$arr["image"],
             'designation'=>$designation,
             'email' =>$email,
             'address'=>$address,
             'city'=>$city,
             'state'=>$state,
             'country'=>$country,
             'phone_no'=>$phone_no,
            );
        }
      }
      $sql_query = $this->db->where('user_id',$userid)->update('member', $data);
  }
  public function getPendingLeaves()
  {
    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,leaves_type.leavetype as leave_type_name');
    $this->db->from('leaves');
    $this->db->where('leave_status=',0);
    $this->db->where('leaves.user_id',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type');
    $this->db->order_by('leaves.user_id','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getTodaysLeaves($userid)
  {
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $current_date = date('Y-m-d');
    $this->db->select('leaves.*,member.name');
    $this->db->from('leaves');
    $this->db->where('startdate <=',$current_date);
    $this->db->where('enddate >=',$current_date);
    $this->db->where('leaves.user_id',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->order_by('leaves.user_id','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getUpcomingLeaves($userid)
  {
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,m.name as approved_name,leaves_type.leavetype as leave_type_name');
    $this->db->from('leaves');
    $this->db->where('leave_status=',1);
    $this->db->where('leaves.user_id',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type','left');
    $this->db->join('member as m','m.user_id = leaves.approved_by','left');
    $this->db->order_by('leaves.user_id','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getRejectLeaves($userid)
  {
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,m.name as approved_name,leaves_type.leavetype as leave_type_name');
    $this->db->from('leaves');
    $this->db->where('leave_status=',2);
    $this->db->where('leaves.user_id',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type');
    $this->db->join('member as m','m.user_id = leaves.approved_by','left');
    $this->db->order_by('leaves.user_id','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function gethistoryLeaves($userid)
  {
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name');
    $this->db->from('leaves');
    $this->db->where('leave_status=',1);
    $this->db->where('leaves.user_id',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->order_by('leaves.user_id','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function getTotalLeavesDays($userid)
  {
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $year = date('Y');

    $this->db->select('SUM(duration) as duration');
    $this->db->from('leaves_policy');
    $this->db->where('year=',$year);
    $this->db->where('leaves_policy.company_id',$company_id->company_id);
    $res = $this->db->get()->result();
    return $res;

  }
  public function getTotalLeavesByUsers($userid)
  {
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $year = date('Y-m-d H:i:s');
    $this->db->select('count(user_id) as user_id');
    $this->db->from('leaves');
    $this->db->where('user_id=',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $res = $this->db->get()->result();
    return $res;
  }
  public function filename_exists($email)
  {
    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('*');
    $this->db->from('member');
    $this->db->where('email', $email);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  public function getAllMyLeaves($id)
  {
    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $this->db->select('leaves.*,member.name,leaves_type.leavetype as leave_type_name');
    $this->db->from('leaves');
    $this->db->where('leaves.user_id',$userid);
    $this->db->where('leaves.company_id',$company_id->company_id);
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('leaves_type','leaves_type.id = leaves.leave_type');
    $this->db->order_by('leaves.user_id','desc');
    $res = $this->db->get()->result();
    return $res;
  }
  public function update_leave_reason($data,$id)
  {
    $this->db->select('leaves.*,member.name,company.company_name');
    $this->db->from('leaves');
    $this->db->join('member','member.user_id = leaves.user_id');
    $this->db->join('company','company.id = leaves.company_id');
    $this->db->where('leaves.id',$id);
    $leaves_data = $this->db->get()->row();

    $this->db->select('emailid');
    $this->db->from('company');
    $this->db->where('id',$leaves_data->company_id);
    $comp_row = $this->db->get()->row();
    $company_email = $comp_row->emailid;

    $this->db->select('member.email,member.name');
    $this->db->from('member');
    $this->db->where('company_id',$leaves_data->company_id);
    $this->db->where('role_id',2);
    $row_email = $this->db->get()->result();
    $hr_array = array();
    foreach ($row_email as $key => $value) {
        $hr_array[] = $value->email;
    }
    $hr_email = implode(', ', $hr_array);

    $this->db->select('member.email,member.name');
    $this->db->from('member');
    $this->db->where('user_id',$leaves_data->user_id);
    $member_email = $this->db->get()->row();

    $to = $member_email->email;
    $email_body = "";
    $subject = "Leaves Cancel- ".$member_email->name;
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
                      <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/leaves/image/leaves.jpg" alt="Tenable Network Security"></a>
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
                            Dear ' . $leaves_data->name . ',<br><br>

                            <tr>
                                <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This mail is generated to inform that <strong>'. $leaves_data->name.'</strong> cancelled his leave.</div>
                                </td>
                            </tr>
                          </div>
                          </td>
                        </tr>
                        <tr>
                            <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                <div class="mktEditable" id="intro_title" style="float:left;">
                                Reason: '.$data['reason'].'
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
                                '. $leaves_data->name.'
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
        $sent = $this->Custom_email->sendemail($to, $subject, $email_body, $hr_email='',$company_email='');
        $this->db->where('id',$id);
        $this->db->update('leaves',$data);
        $this->session->set_flashdata('success','Your Leave Cancelled Successfully');
        redirect("user/User_Profile/my_leaves");
  }
  public function sendemail($from, $to, $subject, $body, $hr_email, $company_email)
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
      $this->email->bcc($admin_email);
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
      /*$to = str_replace('+'.$this->get_string_between($to, "+", "@").'@',"@", $to);
      $headers = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'From: "'.$from.'"' . "\r\n";
      $headers .= 'cc: <'.$hr_email.'>' . "\r\n";
      $headers .= 'Bcc: <'.$company_email.'>' . "\r\n";

      ini_set("sendmail_from", 'info@crystallace.in');
      $sent = mail($to, $subject, $body, $headers);
      return $sent;*/
  }
     
  public function get_string_between($string, $start, $end)
  {
      $string = ' ' . $string;
      $ini = strpos($string, $start);
      if ($ini == 0) return '';
      $ini += strlen($start);
      $len = strpos($string, $end, $ini) - $ini;
      return substr($string, $ini, $len);
  }
  public function getAllLeaveTypes()
  {
    $userid = $this->session->userdata('uid');
    $this->db->select('company_id');
    $this->db->from('member');
    $this->db->where('user_id',$userid);
    $company_id = $this->db->get()->row();

    $query = $this->db->select('*')->where('company_id',$company_id->company_id)->get('leaves_type');
    return $query->result();
  }
}
?>