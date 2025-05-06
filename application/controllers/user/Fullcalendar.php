<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fullcalendar extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('admin/login');
		$this->load->model('User_Fullcalendar_model');
		$this->load->model('User_Profile_Model');

	}

	function index()
	{
		$data['profile']=$this->User_Profile_Model->getprofile($userid);
		$this->load->view('user/Fullcalendar',$data);
	}

	function load()
	{
		$event_data = $this->User_Fullcalendar_model->fetch_all_event();
		$rand = str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
		$event_color='#' . $rand;
		
		$i = 0;
		$color = [];
		foreach($event_data as $row)
		{
			$color[$row->user_id] ='#'.dechex(rand(0x000000, 0xFFFFFF));
		}
		
		foreach($event_data as $row)
		{
			if($row->user_id == "3")
			{

			}
			else
			{
				
				$this->db->select('sum(duration) as duration');
		        $this->db->from('leaves_policy');
				$this->db->where('year =',date("Y"));	
		        $this->db->where('company_id',$row->company_id);
		        $duration = $this->db->get()->result();

		        $this->db->select('sum(duration) as total_leaves');
		        $this->db->from('leaves');
				$this->db->where('created_at >=',date("Y") . '-01-01');
		        $this->db->where('leave_status',1);
		        $this->db->where('user_id',$row->user_id);
		        $teken_leaves = $this->db->get()->result();

				if($row->half_day == 0)
				{
					$half_day = " (half day)";
					$end_date = date('Y-m-d', strtotime($row->startdate.$row->end_time))."T23:59:00";
				}
				else
				{
					$half_day = "";
					$end_date = date('Y-m-d', strtotime('+30 minutes'. $row->enddate.$row->end_time))."T23:59:00";
				}
				$data[] = array(
					'id'	=>	$row->id,
					'reason' => $row->reason,
					'title'	=>	$row->name.$half_day,
					'start'	=>	$row->startdate." ".$row->start_time,
					'end'	=>	$end_date,
					'total_leaves' => $teken_leaves[0]->total_leaves." / ".$duration[0]->duration,
					'backgroundColor' => $row->member_color,	
				);
			}
		}
		$holiday_data = $this->User_Fullcalendar_model->fetch_all_holiday();
		
		$holiday_color='#FF0000';

		foreach ($holiday_data as $holiday_data_row) 
		{
			$item =array('id' => $holiday_data_row->id,
						'reason' =>"",
						'title' =>$holiday_data_row->name,
						'start' =>date('Y-m-d H:i:s', strtotime($holiday_data_row->date)),
						'end' => date('Y-m-d H:i:s', strtotime('+1 hour +30 minutes',strtotime($holiday_data_row->date))),
						'total_leaves' =>"",
						'backgroundColor' => '#4CB7A5',
					);
			$i++;
		$data[] = $item;
		}

		$year = date('Y');
		$new_arr = array(
		  "0" => "01",
		  "1" => "02",
		  "2" => "03",
		  "3" => "04",
		  "4" => "05",
		  "5" => "06",
		  "6" => "07",
		  "7" => "08",
		  "8" => "09",
		  "9" => "10",
		  "10" => "11",
		  "11" => "12",
		);

		foreach ($new_arr as $key => $month)
		{
			$firstday = new  DateTime("$year-$month-1 0:0:0");
			$first_w = $firstday->format('w');  

			$saturday1 = new DateTime;
			$saturday1->setDate($year,$month,7-$first_w);
			
			$saturday2 = new DateTime;
			$saturday2->setDate($year,$month,21-$first_w);

			$sates[] = $saturday1->format('Y-m-d');
			$sates[] = $saturday2->format('Y-m-d');
		}
		foreach ($sates as  $value) 
		{
			$hald_days =array('id' => $i + 1,
						'reason' =>"",
						'title' =>"Half Day",
						'start' =>date('Y-m-d H:i:s', strtotime($value)),
						'end' =>date('Y-m-d H:i:s', strtotime('+1 hour +30 minutes',strtotime($value))),
						'total_leaves' =>"",
						'backgroundColor' => '#ff4d88',
					);
			$i++;
			$data[] = $hald_days;
		}

		$birth_data = $this->User_Fullcalendar_model->fetch_all_birth_date();
		foreach ($birth_data as  $birth_data_row) 
		{
			$date1=date('d F', strtotime($birth_data_row->date_of_birth));
			$date=strtotime($birth_data_row->date_of_birth);
			$time  = $date;
			$day   = date('d',$time);
			$month = date('m',$time);
			$year  = date('Y',$time);
			$curryear = date('Y');
			$full_day = $curryear . "-" . $month . "-" . $day;
			$birth_dates =array('id' => $i + 1,
						'reason' =>"Wish You Happy Birthday!!!",
						'title' =>$birth_data_row->name." (Birthday) ",
						'start' =>date('Y-m-d H:i:s', strtotime('+1 hour +30 minutes',strtotime($full_day))) ,
						'end' =>date('Y-m-d H:i:s', strtotime('+2 hour +30 minutes',strtotime($full_day))),
    					'textColor'  => '#000000',
    					'display' => "'background'",
    					'total_leaves' =>"",
						'backgroundColor' => '#ff751a',
					);
			$i++;
			$data[] = $birth_dates;
		}
		//echo "<pre>"; print_r($data); echo "</pre>";exit();
		echo json_encode($data);	
	}
	function insert()

	{
		if($this->input->post('title'))
		{
			$data = array(       
				'title'		=>	$this->input->post('title'),
				'start_event'=>	$this->input->post('start'),
				'end_event'	=>	$this->input->post('end')

			);
			/*echo "<pre>";print_r($data);echo "</pre>";exit();*/
			
			$this->User_Fullcalendar_model->insert_event($data);
		}
	}

	function update()
	{
		if($this->input->post('id'))
		{
			$data = array(
				'title'			=>	$this->input->post('title'),
				'start_event'	=>	$this->input->post('start'),
				'end_event'		=>	$this->input->post('end')
			);

			$this->User_Fullcalendar_model->update_event($data, $this->input->post('id'));
		}
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			$this->User_Fullcalendar_model->delete_event($this->input->post('id'));
		}
	}
}
?>