<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_email extends CI_Model
{
  public function sendemail($to, $subject, $body, $company_email='',$hr_email='')
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
        if($hr_email) {
            $hr_email_exp = explode(",",trim($hr_email));

                foreach ($hr_email_exp as $row_ind) {
                $mail->addCC($row_ind);    
            }
        }
         
        if($company_email) {
            $company_email_exp = explode(",",trim($company_email));
                foreach ($company_email_exp as $row_ind) {
                $mail->addBCC($row_ind);    
            }
        }
     
     
        // if($company_email) {
        //     $mail->addBCC($company_email);
        // }

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
?>