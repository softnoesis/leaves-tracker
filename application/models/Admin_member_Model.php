<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   Class Admin_member_Model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Custom_email');
    }
    public function getusersdetails()
    {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('member.*,company.company_name');
      $this->db->from('member');
      $this->db->where('member.role_id !=',1);
      $this->db->where('member.role_id !=',5);
      $this->db->where('company_id',$query->company_id);
      $this->db->join('company','company.id = member.company_id');
      $res = $this->db->get()->result();
      return $res;
    }

    public function getreportdetail($uid)
    {
        $ret=$this->db->select('name,email,image,role_id,designation,password,is_admin')->where('user_id',$uid)->get('member');
        return $ret->row();

    }
    public function adddata($data)
    {

        $user_id=$this->session->userdata('adid');
        $this->db->select('member.email,member.password,member.name,company.company_name');
        $this->db->from('member');
        $this->db->join('company','company.id=member.company_id','left');
        $this->db->where('member.user_id',$user_id);
        $query = $this->db->get()->row();

        $email = $data['email'];
        $name = $data['name'];
        $password = $data['password'];
        $role_id = $data['role_id'];
        if($role_id == 1)
        {
            $massage = "HR";
        }
        else if($role_id == 2)
        {
            $massage = "Admin";
        }
        else if($role_id == 3)
        {
            $massage = "Member";
        }
        $email = $data['email'];
        $name = $data['name'];
        $password = $data['password'];
        $data['password'] = md5($password);
        $this->db->insert('member',$data);
        return true;
    }
    public function deleteadmin($uid)
    {
      $sql_query=$this->db->where('user_id',$uid)->delete('member');
    }

    public function getcompany_name()
    {
        $query = $this->db->get('company');
        return $query;
    }

    public function update_member($data,$id)
    {
        $userid = $this->session->userdata('adid');
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

        $this->db->select('member.role_id,user_role.name');
        $this->db->from('member');
        $this->db->join('user_role','user_role.role_id=member.role_id');
        $this->db->where('member.user_id',$id);
        $res = $this->db->get()->row();

        $this->db->select('user_role.name');
        $this->db->from('user_role');
        $this->db->where('user_role.role_id',$data['role_id']);
        $role_name = $this->db->get()->row();

        $prvious_role = $res->role_id;
        $new_role = $data['role_id'];
        $to = $data['email'];
        $name = $data['name'];
        $email_body = "";
        $subject = "Member Conversion Notification";
        $current_year = date("Y");

        if($prvious_role != $new_role)
        {
          $email_body .='
            <htm>
              <body link="#00a5b5" vlink="#00a5b5" alink="#00a5b5">
                <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
                  <tr>
                    <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                      <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                        <tr>
                          <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #00a5b5">
                            <a href="https://leaves.softnoesis.in/leaves/"><img class="top-image" src="https://leaves.softnoesis.in/leaves/image/leaves.jpg" alt=""></a>
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
                                  This is to inform you that your role is changed as from <b>'.$res->name.'</b> to <b>'.$role_name->name.'</b>.
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
          $sent = $this->Custom_email->sendemail($to, $subject, $email_body,$company_email, $hr_email);
        }
        else
        {
        }
        $this->db->where('user_id',$id);
        $this->db->update('member',$data);
        return true;

    }

    public function getproduct($id)
    {
        $result=$this->db->where('user_id',$id)->get('member');
        return $result->row();
    }
    public function change_user_status($id,$status)
    {
        $update = $this->db->query("UPDATE member SET isActive='".$status."' WHERE user_id='".$id."'");
        if($update)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function filename_exists($email)
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getleaves_typs()
    {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('member.user_id',$userid);
      $query = $this->db->get()->row();

      $this->db->select('*');
      $this->db->from('leaves_type');
      $this->db->where('company_id',$query->company_id);
      $result_all = $this->db->get()->result();
      return $result_all;
    }
    public function getAllRoles()
    {
        $this->db->select('*');
        $this->db->from('user_role');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getadmindetails()
    {
        $query=$this->db->select('user_id,leave_type,startdate,enddate,half_day,full_day,start_time,end_time,reason,id')->get('leaves');
        return $query->result();
    }
    public function getprofile($userid)
    {
        $year = date('Y');
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('user_id',$userid);
        $res = $this->db->get()->row();
        return $res;
    }
    public function getTodaysLeaves($userid)
    {
        $current_date = date('Y-m-d');
        $this->db->select('leaves.*,member.name');
        $this->db->from('leaves');
        $this->db->where('startdate <=',$current_date);
        $this->db->where('enddate >=',$current_date);
        $this->db->join('member','member.user_id = leaves.user_id');
        $this->db->order_by('leaves.user_id','desc');
        $res = $this->db->get()->result();
        return $res;
    }

    public function getRejectLeaves($userid)
    {
        $userid = $this->session->userdata('adid');
        $this->db->select('leaves.*,member.name,leaves_type.leavetype as leave_type_name');
        $this->db->from('leaves');
        $this->db->where('leave_status=',2);
        $this->db->where('leaves.user_id',$userid);
        $this->db->join('member','member.user_id = leaves.user_id');
        $this->db->join('leaves_type','leaves_type.id = leaves.leave_type');
        $this->db->order_by('leaves.user_id','desc');
        $res = $this->db->get()->result();
        return $res;
    }
    public function getTotalLeavesDays($userid)
    {
        $year = date('Y');
        $this->db->select('SUM(duration) as duration');
        $this->db->from('leaves_policy');
        $this->db->where('year=',$year);
        $res = $this->db->get()->result();
        return $res;
    }
    public function getTotalLeavesByUsers($userid)
    {
        $year = date('Y-m-d H:i:s');
        $this->db->select('count(user_id) as user_id');
        $this->db->from('leaves');
        $this->db->where('user_id=',$userid);
        //$this->db->where('created_at=',$year);
        $res = $this->db->get()->result();
        return $res;
    }
    public function  getLeaves($id)
    {
        $query=$this->db->select('*')->where('id',$id)->from('leaves')->get();
        return $query->row();
    }
    public function getAllMyLeaves()
    {
      $userid = $this->session->userdata('adid');
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

      $this->db->select('member.email,member.name');
      $this->db->from('member');
      $this->db->where('company_id',$leaves_data->company_id);
      $row_email = $this->db->get()->row();
      $admin_email = $row_email->email;

      $this->db->select('email');
      $this->db->from('member');
      $this->db->where('company_id',$leaves_data->company_id);
      $this->db->where('role_id',2);
      $hr_row = $this->db->get()->result();
      $hr_array = array();
      foreach ($hr_row as $key => $value) {
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
          $sent = $this->Custom_email->sendemail($to, $subject, $email_body, $admin_email, $hr_email);
          $this->db->where('id',$id);
          $this->db->update('leaves',$data);
          // $this->session->set_flashdata('success','Your Leave Cancelled Successfully');
          // redirect("user/User_Profile/my_leaves");
    }
    public function getAllLeaveTypes()
    {
      $userid = $this->session->userdata('adid');
      $this->db->select('company_id');
      $this->db->from('member');
      $this->db->where('user_id',$userid);
      $company_id = $this->db->get()->row();

      $query = $this->db->select('*')->where('company_id',$company_id->company_id)->get('leaves_type');
      return $query->result();
    }
    public function reject_leaves($data,$id)
    {
      $this->db->select('leaves.*,member.name,company.company_name');
      $this->db->from('leaves');
      $this->db->join('member','member.user_id = leaves.user_id');
      $this->db->join('company','company.id = leaves.company_id');
      $this->db->where('leaves.id',$id);
      $leaves_data = $this->db->get()->row();

      $this->db->select('member.email,member.name');
      $this->db->from('member');
      $this->db->where('company_id',$leaves_data->company_id);
      $row_email = $this->db->get()->row();
      $admin_email = $row_email->email;

      $this->db->select('email');
      $this->db->from('member');
      $this->db->where('company_id',$leaves_data->company_id);
      $this->db->where('role_id',2);
      $hr_row = $this->db->get()->result();
      $hr_array = array();
      foreach ($hr_row as $key => $value) {
          $hr_array[] = $value->email;
      }
      $hr_email = implode(', ', $hr_array);

      $this->db->select('member.email,member.name');
      $this->db->from('member');
      $this->db->where('user_id',$leaves_data->user_id);
      $member_email = $this->db->get()->row();

      $to = $member_email->email;
      $email_body = "";
      $subject = "Leave Rejected";

       $massage =  '<p>We regret to inform you that your leave request for the period '.date('dS F Y', strtotime($leaves_data->startdate)).' to '.date('dS F Y', strtotime($leaves_data->enddate)).' has been rejected.</p><p>Thank you for your understanding.</p>';


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
                                <p>Dear '.$leaves_data->name.',</p>
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

          $sent = $this->Custom_email->sendemail($to, $subject, $email_body, $admin_email, $hr_email);
          $this->db->where('id',$id);
          $this->db->update('leaves',$data);
          $this->session->set_flashdata('success','Leave declined!');
          redirect("admin/Dashboard");
    }
    public function send_email($to, $subject, $body, $admin_email, $hr_email)
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
        // $this->email->cc($hr_email);
        // $this->email->bcc($admin_email);
        $hr_email_exp = explode(",",trim($hr_email));
        foreach ($hr_email_exp as $row_ind) {
            $mail->addCC(trim($row_ind));    
        }
        $mail->addBCC($admin_email);

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
    public function get_stringbetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function getUserLeaves($id)
    {

        $currentMonth = date('m'); // Get the current month
        $currentYear = date('Y'); // Get the current year
        
        $userid = $this->session->userdata('adid');
        $this->db->select('company_id');
        $this->db->from('member');
        $this->db->where('user_id', $userid);
        $company_id = $this->db->get()->row();
        
        $this->db->select('leaves.*, member.name, member.role_id, leaves_type.leavetype');
        $this->db->from('leaves');
        $this->db->where('leave_status =', 1);
        
        // Check if current month is January, and include the necessary records
        if ($currentMonth == '01') {
            // Include leaves that started in December of the previous year and ended in the current year
            $this->db->group_start();
            // For the previous year (leaves that end in December but started before)
            $this->db->where('leaves.enddate >=', ($currentYear - 1) . '-12-01');
            $this->db->where('leaves.startdate <=', ($currentYear - 1) . '-12-31');
            // Or leaves that started in the current year
            $this->db->or_group_start();
            $this->db->where('leaves.startdate >=', $currentYear . '-01-01');
            $this->db->where('leaves.enddate <=', $currentYear . '-12-31');
            $this->db->group_end();
            $this->db->group_end();
        } else {
            // For other months, only consider leaves within the current year
            $this->db->where('leaves.startdate >=', $currentYear . '-01-01');
            $this->db->where('leaves.enddate <=', $currentYear . '-12-31');
        }
        
        // Filter by company_id and user_id
        $this->db->where('leaves.company_id', $company_id->company_id);
        $this->db->where('leaves.user_id', $userid);
        
        // Join the necessary tables
        $this->db->join('member', 'member.user_id = leaves.user_id');
        $this->db->join('leaves_type', 'leaves_type.id = leaves.leave_type', 'left');
        
        // Order by the most recent leave creation date
        $this->db->order_by('leaves.created_at', 'desc');
        
        // Get the results
        $res = $this->db->get()->result();
        
        // Return the results
        return $res;
    }
}
?>