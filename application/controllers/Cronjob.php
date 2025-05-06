<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Cronjob extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Cronjob_model');
		$this->load->model('Custom_email');
		// $this->load->model('Admin_Dashboard_Model');

	}

	public function send_notification_birthday_same_day_birthdayboy()
    {
    	$data = array(
    		"function_name"=>"send_notification_birthday_same_day_birthdayboy",
    		"created_at"=>date('Y-m-d H:i:s'),
    		"updated_at"=>date('Y-m-d H:i:s')
    	);
    	$this->db->insert('logs',$data);
        $days_before_rows = $this->Cronjob_model->getNotificationSameday();
		if(!empty($days_before_rows))
        {
        	foreach ($days_before_rows as $row_week_before)
	        {
	      		$this->db->select('company_name');
			    $this->db->from('company');
			    $this->db->where('id',$row_week_before->company_id);
			    $query = $this->db->get()->row();

			    $image_path = base_url()."image/birthday.png";
	        	$to = $row_week_before->email;
		        $from ="softnoesis@gmail.com";
		        $email_body = "";
		        $subject = "Regarding birthday wishes";
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
		                                    <td>
		                                    	<div style="font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;"><img src='.$image_path.'></div>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td>
		                                    	<div style="color: #555559;font-family: Arial;font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">A fantastic team member like you is so invaluable to us! We’re pleased that you’ve built such strong bonds with every member of the team. Here is a bouquet of happiness for you! Wishing you good health and prosperity happiest birthday.</div>
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
		                                  <p id="footer-txt"> <b>© Copyright '.$current_year.' Softnoesis. All rights reserved.</b>
		                                  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/leaves/admin/login">here</a>
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
		        $sent = $this->Custom_email->sendemail($to, $subject, $email_body,$member_email,$hr_email ="");
	        }
        }
    }
    public function send_bod_notification_one_day_before()
    {
    	$data = array(
    		"function_name"=>"send_bod_notification_one_day_before",
    		"created_at"=>date('Y-m-d H:i:s'),
    		"updated_at"=>date('Y-m-d H:i:s')
    	);
    	$this->db->insert('logs',$data);
        $days_before_rows = $this->Cronjob_model->getNotificationdaysBefore();
       
        if(!empty($days_before_rows))
        {
        	foreach ($days_before_rows as $row_week_before)
	        {
	        	$member_name_arr[] = $row_week_before->name;

	      		$this->db->select('company_name');
			    $this->db->from('company');
			    $this->db->where('id',$row_week_before->company_id);
			    $query = $this->db->get()->row();

			    $this->db->select('email');
			    $this->db->from('member');
			    $this->db->where('email !=',$row_week_before->email);
			    $this->db->where('company_id',$row_week_before->company_id);
			    $this->db->where('member.isActive', 0);
			    $comp_row = $this->db->get()->result();
			    $member_array = array();
			    foreach ($comp_row as $key => $value) {
			        $member_array[] = $value->email;
			    }
			    $member_email = implode(', ', $member_array);
			}
			$member_names = implode(' and ', $member_name_arr);
		    $image_path = base_url()."image/birthday.png";
	    	$to = $row_week_before->email;
	        $from ="softnoesis@gmail.com";
	        $email_body = "";
	        $subject = "Regarding birthday reminder";
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
	                                Dear Members of '.$query->company_name.',<br><br>
	                                <tr>
	                                    <td>
	                                    	<div style="color: #555559;font-family: Arial;font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">Tomorrow is <b>'.$member_names.'</b>\'s birthday. Let\'s come and wish him a very Happiest Birthday and a great life ahead.</div>
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
	                                  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.in/leaves/admin/login">here</a>
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
	            $sent = $this->Custom_email->sendemail($to, $subject, $email_body,$member_email="",$hr_email ="");
        }
    }
    public function send_notification_for_leave_one_day_before()
    {
    	$data = array(
    		"function_name"=>"send_notification_for_leave_one_day_before",
    		"created_at"=>date('Y-m-d H:i:s'),
    		"updated_at"=>date('Y-m-d H:i:s')
    	);
    	$this->db->insert('logs',$data);
        $days_before_rows = $this->Cronjob_model->getNotificationforLeaves();
		 
        if(!empty($days_before_rows))
        {
        	foreach ($days_before_rows as $row_week_before)
	        {
	        	$this->db->select('company_name');
			    $this->db->from('company');
			    $this->db->where('id',$row_week_before->company_id);
			    $query = $this->db->get()->row();

			    $this->db->select('email');
			    $this->db->from('member');
			    $this->db->where('email !=',$row_week_before->email);
			    $this->db->where('company_id',$row_week_before->company_id);
			    $this->db->where('member.isActive', 0);
			    $comp_row = $this->db->get()->result();
			    $member_array = array();
			    foreach ($comp_row as $key => $value) {
			        $member_array[] = $value->email;
			    }
			    $member_email = implode(', ', $member_array);

				$startdate = new DateTime($row_week_before->startdate);
				$enddate = new DateTime($row_week_before->enddate);
				$dayOfLeaves = ($enddate->diff($startdate)->format("%a") + 1);
				if($dayOfLeaves == 1) {
					$msg = 'This is to inform you all that '.$row_week_before->name.' will be on leave Tomorrow. Please adjust your work accordingly.';
				} else{
					$msg = 'This is to inform you all that '.$row_week_before->name.' will be on leave from '.date('dS F, Y', strtotime($row_week_before->startdate)).' to '.date('dS F, Y', strtotime($row_week_before->enddate)).'. Please adjust your work accordingly.';
				}
			 
			    $image_path = base_url()."image/birthday.png";
	        	$to = $row_week_before->email;
		        $from ="softnoesis@gmail.com";
		        $email_body = "";
		        $subject = "Reminder Tomorrow ".$row_week_before->name." is on leave";
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

	                                  <p>Hello Members,</p>
	                                  <p>'.$msg.'</p>

	   									<p>Kind Regards,<br>
	                                      '. $query->company_name.'
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
 
		            //$sent = $this->send_email($to, $subject, $email_body,$member_email,$hr_email ="");
				$sent = $this->Custom_email->sendemail($to, $subject, $email_body,$member_email,$hr_email ="");
	        }
        }
    }
  //   public function send_notification_for_leave_one_day_before()
  //   {

  //   	$data = array(
  //   		"function_name"=>"send_notification_for_leave_one_day_before",
  //   		"created_at"=>date('Y-m-d H:i:s'),
  //   		"updated_at"=>date('Y-m-d H:i:s')
  //   	);
  //   	$this->db->insert('logs',$data);
  //       $days_before_rows = $this->Cronjob_model->getNotificationforLeaves();

		// $member_array = array();


  //       if(!empty($days_before_rows))
  //       {

		// 	foreach($days_before_rows as $name =>$value){
		// 		array_push($member_array,$value->name);
		// 	}
		// 	  $member_name = implode(', ', $member_array);

  //       	foreach ($days_before_rows as $row_week_before)
	 //        {
		// 		$date = $row_week_before->startdate;
		// 		$prev_date = date('Y-m-d', strtotime($date .' -1 day'));

	 //        	$this->db->select('company_name');
		// 	    $this->db->from('company');
		// 	    $this->db->where('id',$row_week_before->company_id);
		// 	    $query = $this->db->get()->row();

		// 	    $this->db->select('email');
		// 	    $this->db->from('member');
		// 	    $this->db->where('email !=',$row_week_before->email);
		// 	    $this->db->where('company_id',$row_week_before->company_id);
		// 	    $this->db->where('member.isActive', 0);
		// 	    $comp_row = $this->db->get()->result();
		// 	    $member_array = array();
		// 	    foreach ($comp_row as $key => $value) {
		// 	        $member_array[] = $value->email;
		// 	    }
		// 	    $member_email = implode(', ', $member_array);

		// 	    $image_path = base_url()."image/birthday.png";
	 //        	$to = $row_week_before->email;
		//         $from ="softnoesis@gmail.com";
		//         $email_body = "";

	 //        }
		// 	$today = date('Y-m-d');

		// 	if($prev_date == $today){

		// 	$subject = "Leave Reminder Tomorrow ".$member_name." is on leave";
		// 	$email_body .='
		// 	<htm>
		// 		<body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
		// 		  <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		// 			<tr>
		// 			  <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
		// 				<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		// 				  <tr>
		// 					<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
		// 					  <a href="https://leaves.softnoesis.com/leaves/"><img class="top-image" src="https://leaves.softnoesis.com/leaves/image/leaves.jpg" style="width:100%;" alt="Softnoesis"></a>
		// 					</td>
		// 				  </tr>
		// 				  <tr>
		// 					<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
		// 					  <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		// 						<tr>
		// 						  <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
		// 						</tr>
		// 						<tr>
		// 						  <td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
		// 						  <div class="mktEditable" id="main_text">
		// 							Hello Members ,<br><br>
		// 							<tr>
		// 								<td>
		// 									<div style="color: #555559;font-family: Arial;font-size: 16px; padding: -3px; margin-top:10px; margin-bottom:10px;">This is to inform you all that '.$member_name.' will be on leave on tomorrow. So please make you work plan accordingly.</div>
		// 								</td>
		// 							</tr>
		// 						  </div>
		// 						  </td>
		// 						</tr>
		// 						<tr>
		// 							<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
		// 								<div class="mktEditable" id="intro_title" style="float:left;">
		// 								Kind Regards,
		// 								</div>
		// 							</td>
		// 						</tr>
		// 						<tr>
		// 							<td class="sub-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;padding-top:5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 29px;font-weight: bold;text-align: center;">
		// 								<div class="mktEditable" id="intro_title" style="float:left;">
		// 								'. $query->company_name.'
		// 								</div>
		// 							</td>
		// 						</tr>
		// 						<tr>
		// 						  <td style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;">
		// 						   &nbsp;<br>
		// 						  </td>
		// 						</tr>
		// 					  </table>
		// 					</td>
		// 				  </tr>
		// 				  <tr>
		// 					<td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
		// 					  <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		// 						<tr>
		// 						  <td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
		// 							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		// 							  <tr>
		// 								<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://www.facebook.com/softnoesis/"><img src="https://info.tenable.com/rs/tenable/images/facebook-teal.png"></a></td>
		// 								<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="https://in.linkedin.com/in/hr-softnoesis"><img src="https://info.tenable.com/rs/tenable/images/linkedin-teal.png"></a></td>
		// 								<td style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"><a href="mailto:contact@softnoesis.com"><img src="https://info.tenable.com/rs/tenable/images/google-teal.png"></a></td>
		// 							  </tr>
		// 							</table>
		// 						  </td>
		// 						</tr>
		// 					  </table>
		// 					</td>
		// 				  </tr>
		// 				  <tr bgcolor="#fff" style="border-top: 4px solid #00a5b5;">
		// 					<td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
		// 					  <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
		// 						<tr>
		// 						  <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
		// 							<div id="address" class="mktEditable">
		// 							  <p id="footer-txt"> <b>© Copyright 2021 Softnoesis. All rights reserved.</b>
		// 							  <br/> You received this email for login credentials of your leaves tracker acount. To Login click <a href="https://leaves.softnoesis.com/leaves/admin/login">here</a>
		// 							</p>
		// 							  <b>Softnoesis Private Ltd.</b><br>
		// 									11/587-90, Kachara ni pole, <br>  Nr Fayda Bazar, <br> Nanavat Main Rd, Surat, GJ, india<br>
		// 									<a style="color: #00a5b5;" href="https://leaves.softnoesis.com/">Contact Us</a>
		// 							</div>
		// 						  </td>
		// 						</tr>
		// 					  </table>
		// 					</td>
		// 				  </tr>
		// 				</table>
		// 			  </td>
		// 			</tr>
		// 		  </table>
		// 		  </body>
		// 		</htm>';
		// 		$sent = $this->Custom_email->sendemail($to, $subject, $email_body,$member_email,$hr_email ="");
		// 	}
  //       }
  //   }
   
}
?>