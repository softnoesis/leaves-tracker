<?php

class User_Fullcalendar_model extends CI_Model
{
	function fetch_all_event()
	{
		$userid = $this->session->userdata('uid');
        $this->db->select('company_id');
        $this->db->from('member');
        $this->db->where('member.user_id',$userid);
        $query = $this->db->get()->row();
    	
        $this->db->select('leaves.*,member.name,member.date_of_birth,member.member_color');
        $this->db->from('leaves');
        $this->db->join('member','member.user_id = leaves.user_id'); 
        $this->db->where('leaves.company_id',$query->company_id);
        $this->db->where('leaves.leave_status=',1);
        $this->db->where('member.isActive=',0);
        $res = $this->db->get()->result();
        
        return $res;
    }
    function fetch_all_holiday()
    {
        $userid = $this->session->userdata('uid');
        $this->db->select('company_id');
        $this->db->from('member');
        $this->db->where('member.user_id',$userid);
        $query = $this->db->get()->row();

    	$this->db->select('*');
        $this->db->from('holidays');
        $this->db->where('holidays.company_id',$query->company_id);
        $res = $this->db->get()->result();
        return $res;
    }
    function fetch_all_birth_date()
    {
        $userid = $this->session->userdata('uid');
        $this->db->select('company_id');
        $this->db->from('member');
        $this->db->where('member.user_id',$userid);
        $query = $this->db->get()->row();

        $this->db->select('name,date_of_birth');
        $this->db->from('member');
        $this->db->where('member.isActive=',0);
        $this->db->where('member.company_id',$query->company_id);
        $this->db->where('member.date_of_birth is NOT NULL', NULL, FALSE);
        $res = $this->db->get()->result(); 
       
        return $res;
    }
	function insert_event($data)
	{
		$this->db->insert('holidays', $data);
	}
	function update_event($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('holidays', $data);
	}
	function delete_event($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('holidays');
	}
}
?>