<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cmt extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('back_end/Match_making_model','match_making_model');
		$this->config_array = $this->common_model->get_site_config();
	}

	public function e()
	{
	    $to = "sekawoj750@sinyago.com";
	    $info = "info@sriganeshmatrimony.com"; 
      $info_pass = "5spzTqpla]";
	 
	    
      // $config = Array(
      //    'protocol' => 'smtp',
      //    'smtp_host' => 'smtp.hostinger.com', // Your SMTP host
      //    'smtp_port' => 587, // Default port for SMTP
      //    'smtp_user' => $info,
      //    'smtp_pass' => $info_pass,
      //    'mailtype' => 'html',
      //    'charset' => 'iso-8859-1',
      //    'wordwrap' => TRUE
      //    );
        $config = array(
          'smtp_host' =>'mail.shaadihaldi.com',
          'smtp_port' =>587,
          'smtp_user' =>'info@shaadihaldi.com',
          'protocol' => 'mail',
          'mailtype' => 'html',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
          );


        $message = 'Hi, Its working. Send Email.';
        $this->load->library('email', $config);
        $this->email->from($info, $info);
        $this->email->to($to);
        $this->email->subject('Test For Crone');
        $this->email->message($message);
        
        if($this->email->send()) 
        {
          // Conditional true
            echo "Send Successfully. ";
        }
        else
        {
            echo "Not send";
        }
	}
}