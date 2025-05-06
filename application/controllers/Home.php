<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Home extends CI_Controller {

public function index()
{
	// die('hello');
	//$this->load->view('home');
	$this->load->view('admin/login');
	
}

}	