<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends Webfront_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('user_logged_in'))
		{
		   redirect('login');		
		}  
		//print_r($this->taskrecover);
		//elseif($this->session->userdata('sesshuntover')) { redirect('hunt/success');} 
	}
	 
	public function index()
	{
		//$this->outputCache(); 
		$this->load->model('hunts_model');   
		$this->form_validation->set_rules('code', 'Code','trim|required|callback_code_check');	 
		$this->form_validation->set_message('required', '( required )');  
		$this->form_validation->set_error_delimiters('<font color="red"> ', '</font> ');
		if($this->form_validation->run()== FALSE)
		{ 
			$home['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid'));
			$main['content']=$this->load->view('frontend/pages/home',$home,true);
			$main['header']=$this->frontheader();
			$main['footer']=$this->frontfooter();
			$main['meta']=$this->frontmetahead();
			$this->load->view('frontend/main',$main);
		} else {  
			redirect('start');   //HUNT_CODE
		} 	
	}
	function code_check($code)
	{
		if ($code != $this->alphasettings['HUNT_CODE'])
		{
			$this->form_validation->set_message('code_check', '( invalid code )'); 
			return FALSE;
		}
		else
		{
			$newdata = array( 'sesshuntcode'  => $this->alphasettings['HUNT_CODE']);
			$this->session->set_userdata($newdata);
			return TRUE;
		}
	} 
	function logout(){ 
		$newdata = array(
			   'sessid'  => '',
			   'sesshuntid'  =>'',
			   'sessname'  => '',
			   'sessemail'     => '',
			   'userloginid'  => '',
			   'user_logged_in' => '',
			   'sesshuntcode'  =>'',
			   'sesshuntover'  =>false
		);
		$this->session->set_userdata($newdata);
		redirect('login');
	}
}
