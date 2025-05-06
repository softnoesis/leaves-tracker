<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Admin_Login_Model extends CI_Model 
{
	public function validatelogin($email,$password)
	{	
		$this->db->select("role_id");
		$this->db->from("member");
		$this->db->where(['email'=>$email,'password'=>md5($password)]);
		$status=$this->db->get()->row();
		 
		$query=$this->db->where(['email'=>$email,'password'=>md5($password),'role_id'=>$status->role_id,'isActive'=>0]);
		$account=$this->db->get('member')->row();
		if(!empty($account))
		{
			$dbstatus=$account->role_id;
			if($dbstatus == 1)
			{
				$this->session->set_userdata('adid',$account->user_id);
				return $account->role_id;
			}
			else if($dbstatus == 2)
			{
				$this->session->set_userdata('adid',$account->user_id);
				return $account->role_id;	
			} 
			else if($dbstatus == 3)
			{
				$this->session->set_userdata('uid',$account->user_id);
				return $account->role_id;	
			}
			else if($dbstatus == 4)
			{
				$this->session->set_userdata('adid',$account->user_id);
				return $account->role_id;
			}
			else if($dbstatus == 5)
			{
				$this->session->set_userdata('adid',$account->user_id);
				return $account->role_id;
			}
			else 
			{
				return NULL;
			}
		}
		else
		{
			return 6;
		}
		redirect('admin/login');
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
    public function Update_password($forgot_code,$newpassword)
	{
      	$data = array('password' =>md5($newpassword));
	    return $this->db->where(['forgot_code'=>$forgot_code])->update('member',$data);
	}
}
?>