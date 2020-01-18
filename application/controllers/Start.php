<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Start extends Webfront_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('user_logged_in'))
		{
		   redirect('login');		
		}   
		$this->load->model('frontend/qas_model'); 
		$this->load->model('frontend/huntlog_model');$this->load->model('hunts_model');
	} 
	
	public function index()
	{		 
		$main['content']=$this->load->view('frontend/start/index',$hunt='',true);
		$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter();
		$main['meta']=$this->frontmetahead();
		$this->load->view('frontend/main',$main); 
		$this->qas_model->huntlog_model->insert_huntlog();
	}
	//Get Question
	public function question($nextq=''){
		$this->load->library('pagination');	
		$cond = array();
		$config['base_url'] = site_url('start/index/'.$nextq);
		$config['per_page'] =1;
		$config['uri_segment']=3;
		$config['num_links'] =0;
		$config['display_pages'] = false; 
		$config['first_link'] = false;
		$config['last_link'] = false; 
		$config['prev_link'] = false;
		$config['next_link'] = false;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'>";
		$config['cur_tag_close'] = "</li>";  
		$now = time();$hunt['now'] =$now;
		$hunt['tasks'] =$this->tasks;
		$config['total_rows'] = $hunt['total'] =$this->qas_model->get_pagination_count();  
		$hunt['segment'] =$segment = $nextq?$nextq:$this->uri->segment($config['uri_segment']); 
		$this->pagination->initialize($config);  
		$hunt['questions']=$this->qas_model->get_pagination($config['per_page'],$segment);		
		$this->qas_model->huntlog_model->insert_tasklog($hunt['questions'][0]);
		$hunt['tasklog'] =$this->qas_model->huntlog_model->get_tasklog(array('question_id'=>$hunt['questions'][0]['id']));
		$this->load->view('frontend/start/question',$hunt,false);
	}
	//Submit answer
	public function answer(){
		$this->form_validation->set_rules('answer', 'Answer','trim|callback_validate_answer');	
		$this->form_validation->set_rules('question', 'Question','required'); 
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		$this->form_validation->set_message('required', '( required )');  
		$nextpg = $this->input->post('task');
		if($this->form_validation->run()== FALSE)
		{ 
			$this->question($nextpg-1); 
		} else {  
			 $start_time = $this->input->post('start_time'); 
			 $now = time();
			 $time_diff = $now-$start_time;
			 $penatly_time = $this->input->post('penatly_time');
			 $data=array(
				'answer'=>$this->input->post('answer'),
				'user_id'=>$this->session->userdata('sessid'),
				'group_id'=>$this->signedduser->group_id,
				'question_id'=>$this->input->post('question'), 
				'start_time'=>date('Y-m-d H:i:s',$start_time),  
				'penatly_time'=>$penatly_time,
				'is_penalty'=>$this->input->post('ispenality')); 
			  $ans  = $this->qas_model->answer($data);
			  if($ans){
				 $this->huntlog_model->update_tasklog(array('status'=>0),array('user_id'=>$this->session->userdata('sessid'),		'question_id'=>$this->input->post('question'))); 
				 $total = count($this->tasks);
				 if($total== $nextpg ){ 
				 	$this->session->set_userdata(array('sesshuntover'=>true)); 
					redirect('start/finish');
				 }else{
					redirect('start/question/'.$nextpg);  
				 }
			 } 
		}
	}	
	public function validate_answer($answer){
		$qid = $this->input->post('question');
		if (!$this->qas_model->validate_answer($answer,$qid))
		{
			$this->form_validation->set_message('validate_answer', '( wrong code )'); 
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	//Penalty
	public function penalty()
	{	$qid=$this->input->post('question');
		$hunt['total'] =$this->qas_model->get_pagination_count();
		$hunt['tasks'] =$this->tasks;
		$hunt['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid')); 
		$hunt['tasklog'] =$this->qas_model->huntlog_model->get_tasklog(array('question_id'=>$qid));
		$hunt['question'] = $question =$this->qas_model->load($this->input->post('question'));  
		//$pen = explode(':',$question->penalty);$hunt['penalty'] =$pen[0]*3600+$pen[1]*60+$pen[2];
		$this->load->view('frontend/start/penalty',$hunt,false); 
	}
	public function finish()
	{			
		//$hunt['total'] =$this->qas_model->get_pagination_count();
		//$hunt['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid')); 		
		$main['content']=$this->load->view('frontend/hunt/finish',$hunt='',false);
		/*$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter();
		$main['meta']=$this->frontmetahead();
		$this->load->view('frontend/main',$main);*/	
	}
	
	public function success()
	{ 
		$this->load->model('hunts_model');$this->load->model('frontend/qas_model');  	
		$hunt['total'] =$this->qas_model->get_pagination_count();	
		$hunt['timetaken'] =$this->qas_model->hunt_duration();
		$hunt['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid')); 		
		$main['content']=$this->load->view('frontend/hunt/success',$hunt,true);
		$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter();
		$main['meta']=$this->frontmetahead();
		$this->load->view('frontend/main',$main);	
	}
}
