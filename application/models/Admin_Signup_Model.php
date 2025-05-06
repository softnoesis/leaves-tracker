<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Admin_Signup_Model extends CI_Model
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('Custom_email');
  }
	public function insert($company_name,$emailid,$password)
	{
      $to = $emailid;
      $email = $emailid;
      $name = $company_name;
      $password = $password;
      $email_body = "";
      $subject = "Company registration";
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
                              Dear ' . $name . ',<br><br>
                              <tr>
                                  <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This is to inform you that you are successfully registered as a company of leaves tracker. Please use your below email and password to access your leaves tracker account.</div>
                                  </td>
                              </tr>
                            </div>
                            </td>
                          </tr>
                          <tr>
                              <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                  <div class="mktEditable" id="intro_title" style="float:left;">
                                  Email ID: '.$email.'
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
                                  <div class="mktEditable" id="intro_title" style="float:left;">
                                  Password: '.$password.'
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
                                  '. $query->company_name.'
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
          $sent = $this->Custom_email->sendemail($to, $subject, $email_body,$company_email="",$hr_email="");
          $insertdata = array(
              'company_name'=>$company_name,
              'emailid'=>$emailid,
              'password'=>md5($password),
              'created_at' => date("Y/m/d H:i:s"),
              'updated_at' => date("Y/m/d H:i:s"),
          );
          $this->db->insert('company',$insertdata);
          $company_id = $this->db->insert_id();

          $company_data = array(
            'company_id'=>$company_id,
            'email' =>$emailid,
            'name' =>$company_name,
            'password' =>md5($password),
            'is_Admin'=>3,
            'role_id'=>5,
            'isActive'=>0,
          );
          $this->db->insert('member',$company_data);
          $member_id = $this->db->insert_id();
      return $company_id;
  }
  public function sendemail($to, $subject, $body)
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
      //$this->email->cc($hr_email);
      //$this->email->bcc($admin_email);
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
}