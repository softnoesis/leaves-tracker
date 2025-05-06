<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Custom_email');
    }
	public function index()
	{
		if(!$this->session->userdata('adid'))
		{
			$this->form_validation->set_rules('emailid','emailid','trim|required|valid_email');
			$this->form_validation->set_rules('password','password','required');
			if($this->form_validation->run())
			{
				$emailid=$this->input->post('emailid');
				$password=$this->input->post('password');
				$this->load->model('Admin_Login_Model');
				$validate=$this->Admin_Login_Model->validatelogin($emailid,$password);
		
				 
				if($validate == 1)
				{
					ob_clean();
					$this->session->set_flashdata('massage', 'Admin login successfully!');
					return redirect('admin/dashboard');
				}
				else if($validate == 2)
				{
					ob_clean();
					$this->session->set_flashdata('massage', 'HR Executive login successfully!');
					return redirect('admin/dashboard');
				}
				else if($validate == 3)
				{
					ob_clean();
					$this->session->set_flashdata('massage', 'User login successfully!');
					// redirect('index.php/user/dashboard');
					return redirect('user/dashboard');

				}
				else if($validate == 4)
				{
					ob_clean();
					$this->session->set_flashdata('massage', 'Super admin login successfully!');
					return redirect('admin/dashboard');
				}
				else if($validate == 5)
				{
					ob_clean();
					$this->session->set_flashdata('massage', 'Company login successfully!');
					return redirect('admin/dashboard');
				}
				else
				{
					ob_clean();
					$this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
					redirect(base_url('admin/login'));
				}
			}
			else
			{

				$this->load->view('admin/login');
				
				//$this->load->view('user/login');
			}
		}
		else
		{
			return redirect('admin/dashboard');
		}
	// "come";exit();
	}
	public function logout()
	{
		$this->session->unset_userdata('adid');
		$this->session->sess_destroy();
		return redirect('admin/login');
	}

	public function forgot_pass()
	{
		$email = $this->input->post('emailid');
		if($this->input->post('forgot_password'))
		{
			$res = $this->db->select("user_id,password,name")->from("member")->where("email", $email)->get()->row();
		 
			$forgot_code = $this->generateRandomString($length = 25);
            $data = array('forgot_code' =>$forgot_code);
         	$this->db->where('email',$email);
	        $this->db->update('member',$data);

			$MailToAddress = $email; // your email address.
			$demo_type = "Regarding softnoesis company account password";
			$date_added = date("d/m/y : H:i:s", time());
			$logo_image = base_url()."image/leaves.jpg";
			$email_body .='
			<htm>
	            <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
	              	<table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		                <tr>
		                  	<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
			                    <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
			                      <tr>
			                        <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
			                          <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="'.$logo_image.'" alt="Softnoesis"></a>
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
			                                Dear Member ' . $res->name . ',<br><br>
			                               <tr>
			                                    <td><div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">Seems like you forgot your password for login softnoesis company account if this is true, click below to reset your password.</div>
			                                    	<a href="https://leaves.softnoesis.in/admin/login/changepassword?q='.$forgot_code.'"
			                                            style="background:#20e277;text-decoration:none !important; font-weight:500; margin-bottom:15px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
			                                            Password</a>
			                                    </td>
			                                </tr>
			                              </div>
			                              </td>
			                            </tr>
			                            <tr>
			                                <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
			                                    <div class="mktEditable" id="intro_title" style="float:left;">
			                                    Thanks You,
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
			                                  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/admin/login">here</a>
			                                </p>
			                                  <b>Softnoesis Private Ltd.</b><br>
			                                        11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, Gujarat 395003<br>
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
			$to = $MailToAddress;
			$subject = $demo_type;
			$sent = $this->send_email($to, $subject, $email_body,$company_email="",$hr_email="");
		 
			//$sent = $this->sendemail($to, $subject, $email_body);
			if($sent)
			{
				$this->session->set_flashdata('massage', 'Email has been sent to your registered email!');
				redirect('admin/login');
			}
			else
			{
				$this->session->set_flashdata('error', 'Email address is not available in our records.');
				redirect('admin/login/forgot_pass');
			}
		}
	   	$this->load->view('admin/Forgot_pass');
   	}

    public function get_stringbetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
	public function changepassword()
	{
		$this->form_validation->set_rules('password','Password','required|min_length[6]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','required|min_length[6]|matches[password]');
		if($this->form_validation->run())
		{
			$newpassword = $this->input->post('password');
			$forgot_code = $this->input->post('hdn_forgot_code');
			$this->load->model('Admin_Login_Model');
			if($this->Admin_Login_Model->Update_password($forgot_code,$newpassword))
			{
				$this->session->set_flashdata('massage', 'Password changed successfully');
				redirect('admin/login');
			}
			else
			{
				$this->session->set_flashdata('error', 'Current password is wrong. Error!!');
				redirect('admin/login/changepassword');
			}
		}
		else
		{
			$data['q'] = $_GET['q'];
			$this->load->view('forgot_pass',$data);
		}
	}
	public function generateRandomString($length = 25)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	public function SendemailForMemberLeaves()
    {
    	date_default_timezone_set("Asia/Calcutta");
    	$array_data = array('function_name'=>'SendemailForMemberLeaves',
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s')
    					);
    	$insert_id = $this->db->insert('logs',$array_data);

    	$date = date('Y-m-d');
    	$this->db->select('leaves.*,member.name');
        $this->db->from('leaves');
        $this->db->join('member','member.user_id=leaves.user_id','left');
        $this->db->where("leaves.leave_status",'1');
        $this->db->where("leaves.startdate >",$date);
        $q_custom = $this->db->get()->result();
        $html = '';
        if(!empty($q_custom))
        {
	        foreach ($q_custom as $key => $value)
	        {
	    		$html.='<tr><td><div style="font-size:16px;padding:-3px;margin-top:10px;margin-bottom:10px">This is to inform that Mr/Mrs <strong>'.$value->name.'</strong> is on leave <strong>'.date('j M l', strtotime($value->startdate)).'</strong> due to '.$value->reason.'</div></td><tr>';
	        }
	        $MailToAddress = "bharat.softnoesis@gmail.com"; // your email address.
			$FromEmail ="softnoesis@gmail.com";
			$demo_type = "Regarding members leaves";
			$date_added = date("d/m/y : H:i:s", time());
			$logo_image = base_url()."image/leaves.jpg";
			$email_body .='
			<htm>
	            <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
	              	<table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		                <tr>
		                  	<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
			                    <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
			                      <tr>
			                        <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
			                          <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="'.$logo_image.'" alt="Softnoesis"></a>
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
			                                Dear company ,<br><br>
			                                    '.$html.'
			                              </div>
			                              </td>
			                            </tr>
			                            <tr>
			                                <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
			                                    <div class="mktEditable" id="intro_title" style="float:left;">
			                                    Thanks You,
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
			                                  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/admin/login">here</a>
			                                </p>
			                                  <b>Softnoesis Private Ltd.</b><br>
			                                        11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, Gujarat 395003<br>
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
			$from = $FromEmail;
			$to = $MailToAddress;
			$subject = $demo_type;
			//$sent = $this->send_email($to, $subject, $email_body,$company_email="",$hr_email="");
		}
    }

    public function send_birthday_notification_one_day_before()
    {
 		date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
		$array_data = array('function_name'=>'send_birthday_notification_one_day_before',
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s')
    					);
    	$insert_id = $this->db->insert('logs',$array_data);
      	$due_date = date('m-d', strtotime('1 days'));
      	$where = "date_of_birth LIKE '%".$due_date."%'";
      	$this->db->select('user_id,company_id,name,date_of_birth,image,email');
      	$this->db->from('member');
      	$this->db->where($where);
      	$res = $this->db->get()->result();
    	if(!empty($res))
    	{
	        foreach ($res as $row_week_before)
	        {
	        	$this->db->select('company_name,emailid');
			    $this->db->from('company');
			    $this->db->where('id',$row_week_before->company_id);
			    $query = $this->db->get()->row();

			    $this->db->select('email');
			    $this->db->from('member');
			    $this->db->where('email !=',$row_week_before->email);
			    $this->db->where('company_id',$row_week_before->company_id);
			    $comp_row = $this->db->get()->result();
			    $member_array = array();
			    foreach ($comp_row as $key => $value) {
			        $member_array[] = $value->email;
			    }
			    $member_email = implode(', ', $member_array);

			    $image_path = base_url()."image/".$row_week_before->image;
			    $to = "";
		        $from ="softnoesis@gmail.com";
		        $email_body = "";
		        $subject = "Birthday Reminder";
		        $email_body .='
		        <htm>
		            <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
		              <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		                <tr>
		                  <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
		                    <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		                      <tr>
		                        <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
		                          <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/leaves/image/leaves.jpg" style="width:100%;" alt="Softnoesis"></a>
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
		                                Dear Members,<br><br>
		                                <tr>
		                                    <td align="center">
		                                    	<div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px; width:35%"><img src='.$image_path.' style="width:100%; height="auto;	"></div>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                    	<div id="main_text" style="font-size:16px;padding:-3px;margin-top:10px;margin-bottom:10px">This is the inform to all members that tommorrow is Mr/Mrs '.$row_week_before->name.' have birthday so wish him good health and great year ahead.</div>
		                                    </td>
		                                </tr>
		                              </div>
		                              </td>
		                            </tr>
		                            <tr>
		                                <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
		                                    <div class="mktEditable" id="intro_title" style="float:left;">
		                                    Kind Regards,
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
		                                    <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="mailto:contact@softnoesis.com"><img src="https://info.tenable.com/rs/tenable/images/google-teal.png"></a></td>
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
		                                  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/admin/login">here</a>
		                                </p>
		                                  <b>Softnoesis Private Ltd.</b><br>
		                                        11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, GJ, india<br>
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

		        $to = $row_week_before->email;
			    $from ="softnoesis@gmail.com";
		        $html_email_body = "";
		        $subject = "Birthday Wishes";
				$html_email_body .='
		        <htm>
		            <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
		              <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		                <tr>
		                  <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
		                    <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		                      <tr>
		                        <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
		                          <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/leaves/image/leaves.jpg" style="width:100%;" alt="Softnoesis"></a>
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
		                                Dear '.$row_week_before->name.',<br><br>
		                                <tr>
		                                    <td align="center">
		                                    	<div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px; width:35%"><img src='.$image_path.' style="width:100%; height="auto;	"></div>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                    	<div id="main_text" style="font-size:16px;padding:-3px;margin-top:10px;margin-bottom:10px">You are the sweetest person I know, and this birthday is a fresh beginning. I wish you confidence, courage, and capability. Happy birthday.</div>
		                                    </td>
		                                </tr>
		                              </div>
		                              </td>
		                            </tr>
		                            <tr>
		                                <td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
		                                    <div class="mktEditable" id="intro_title" style="float:left;">
		                                    Kind Regards,
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
		                                    <td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="mailto:contact@softnoesis.com"><img src="https://info.tenable.com/rs/tenable/images/google-teal.png"></a></td>
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
		                                  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/admin/login">here</a>
		                                </p>
		                                  <b>Softnoesis Private Ltd.</b><br>
		                                        11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, GJ, india<br>
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
		            //$sent = $this->send_email($to, $subject, $email_body,$member_email,$hr_email ="");
		            //$sent_mail = $this->send_email($to, $subject, $html_email_body,$member_email="",$hr_email ="");
	        }
	    }
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
        if($hr_email != ""){
        	$hr_email_exp = explode(",",trim($hr_email));
	        foreach ($hr_email_exp as $row_ind) {
	            $mail->addCC(trim($row_ind));    
	        }	
        }
        
        if($company_email != ""){
        	$company_email_exp = explode(",",trim($company_email));
	        foreach ($company_email_exp as $row_ind) {
	            $mail->addBCC(trim($row_ind));   
	        }
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