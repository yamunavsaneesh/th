<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Webfront_Controller {
	function __construct()
    {
 		parent::__construct();
	}
	
	public function index()
	{
		
		$this->load->model('users_model'); 
		$this->form_validation->set_rules('login', 'Username','required|callback_login_check');		
		$this->form_validation->set_rules('pass', 'Password','required');
		$this->form_validation->set_message('required', '( required )');
		$this->form_validation->set_error_delimiters('<font color="red"> ', '</font> ');
		if ($this->form_validation->run()== FALSE)
		{
		 	$login['content']=$this->load->view('frontend/login/form','',true);
			$login['header']=$this->frontheader();
			$login['footer']=$this->frontfooter();
			$login['meta']=$this->frontmetahead();
			$this->load->view('frontend/login',$login);			 
		} else { 
			$user=$this->db->escape_str($this->input->post('login'));
			$pass=$this->db->escape_str($this->input->post('pass'));
			$pass=md5($pass);
			$cond=array('email'=>$user,'password'=>$pass);
			$user_row=$this->users_model->get_row_cond($cond);
			if($user_row){
				$logindata=array( 'user_id'  => $user_row->id,
								'login_date'=>date('Y-m-d H:i:s'),
								'login_ip'=>$this->input->ip_address());
				$loginid=$this->users_model->insert_logins($logindata); 
				$newdata = array(
					   'sessid'  => $user_row->id,
					   'sesshuntid'  => $user_row->hunt_id, 
					   'sessname'  => $user_row->firstname.' '.$user_row->lastname, 
					   'sessemail'     => $user_row->email, 
					   'userloginid'  => $loginid,
					   'user_logged_in' => TRUE,
					   'sesshuntcode'  =>'',
					   'sesshuntover'  =>false
				);
				$this->session->set_userdata($newdata);
				
			}
			redirect('home');
		}
  	}
	function login_check($user)
	{
		$this->load->model('users_model'); 
		$pass= $this->input->post('pass');
		$huntkey= $this->input->post('huntkey');
		if (!$this->users_model->login_check($user,$pass,$huntkey))
		{
			$this->form_validation->set_message('login_check', '( invalid login )'); 
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	} 
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */