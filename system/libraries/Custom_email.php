<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author    : Mian Saleem
 *  Email     : saleem@tecdiary.com
 *  For       : Stock Manager Advance
 *  Web       : http://tecdiary.com
 *  ==============================================================================
 */

class CI_Custom_email
{

    public function __construct()
    {

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