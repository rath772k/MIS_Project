<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$user = "admin";
		$pass = "p";
		$this->load->model('user/user_login_attempts_model','',TRUE);
			$this->user_login_attempts_model->insert(array("id" => $this->session->userdata('id'), "time" => date('Y-m-d H:i:s')));
                       //changes
                        $maxID= $this->user_login_attempts_model->get_log_in_maxID($this->session->userdata('id'));
                 
                        $re= $this->user_login_attempts_model->get_logg(array('log_id'=>$maxID));
                               if(is_array($re)){
                                if($re[0]->logged_out_time == ''){
                          $this->user_login_attempts_model->update_log(
                                  array('logged_out_time'=>date('Y-m-d H:i:s'),'logout_ip'=>$this->input->ip_address()),
                                  array('log_id'=>$maxID)
                                  );
                                }
                               }
                                $data['user_id'] = $this->session->userdata('id');
                                $data['logged_in_time']=date('Y-m-d H:i:s');
                                $data['login_ip']=$this->input->ip_address();
                                $this->user_login_attempts_model->insert_log($data);
                                
	}

	function index()
	{
		echo "hello";
		//redirect('fee_splitter/add_fee_details/form');
	}
	
	function add_fee_details()
	{
		redirect('fee_splitter/add_fee_details/form');
	}

	function generate_report()
	{
		redirect('fee_splitter/generate_report');
	}
}
