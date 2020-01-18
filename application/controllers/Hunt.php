<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hunt extends Webfront_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('user_logged_in'))
		{
		   redirect('login');		
		}  
		//elseif($this->session->userdata('sesshuntover')) { redirect('hunt/success');}
		//elseif($this->session->userdata('sesshuntcode') =='') { redirect('home');}
		$this->load->model('frontend/qas_model'); 
	}
	public function test(){
		$main['content']=$this->load->view('frontend/hunt/penalty','',true);
		$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter();
		$main['meta']=$this->frontmetahead();
		$this->load->view('frontend/hunt/test',$main='');		
	}
	public function index()
	{
		 redirect('hunt/start');
	} 
	public function start()
	{		
		$this->load->model('hunts_model'); 
		$hunt['recovertask'] = $this->taskrecover; 
		$hunt['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid')); 		
		$main['content']=$this->load->view('frontend/hunt/start',$hunt,true);
		$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter();
		$main['meta']=$this->frontmetahead();
		$this->load->view('frontend/main',$main);	
	}
	public function tasklog($qas){ 
		$dur = explode(':',$qas['duration']);
		$pen = explode(':',$qas['penalty']);
		$duration = $dur[0]*3600+$dur[1]*60+$dur[2];
		$penalty = $pen[0]*3600+$pen[1]*60+$pen[2];
		$endtime = time() + $duration;
		$penaltyendtime  = $endtime+$penalty;
		$data=array( 
		'user_id'=>$this->session->userdata('sessid'),
		'question_id'=>$qas['id'], 
		'start_time'=>date('H:i:s'), 
		'end_time'=>date('H:i:s',$endtime), 
		'penalty_start_time'=>date('H:i:s',$endtime),  
		'penalty_end_time'=>date('H:i:s',$penaltyendtime)); 
	   	$this->db->insert('tasklog',$data);
		return $this->db->insert_id();
	}
	public function update_tasklog($data,$cond){  
	   $this->db->update('tasklog',$data,$cond);
	}
	public function validate_answer($answer){
		//$answer = $this->input->post('answer');
		$qid = $this->input->post('question');
		if (!$this->qas_model->validate_answer($answer,$qid))
		{
			$this->form_validation->set_message('validate_answer', '( wrong answer )'); 
			return false;
		}
		else
		{
			return true;
		}
	} 
	public function checkstatus($question){
		/// Check status = 1
			$tasklog = $this->qas_model->gettasklog(array('question_id'=>$question['id'],'status'=>1));
			if($tasklog){				
				if(time() >= strtotime($tasklog->end_time)){
					/// update with status 2
					$this->update_tasklog(array('status'=>2),array('id'=>$tasklog->id));
				}else{
					
				}
			}else{
				/// Check status = 2
				$tasklog = $this->qas_model->gettasklog(array('question_id'=>$question['id'],'status'=>2));
				if($tasklog){				
					if(time() >= strtotime($tasklog->penalty_end_time)){
						/// update with status 0 
						$this->update_tasklog(array('status'=>0),array('id'=>$tasklog->id));
						redirect('hunt/task/'.$tthis->tasks[$question['id']]);  
					}
				}else{
					$this->tasklog($question) ;
				}
			}
	}
	public function task($task='')
	{
		$this->load->library('pagination');	
		$this->form_validation->set_rules('answer', 'Answer','trim|callback_validate_answer');	
		$this->form_validation->set_rules('question', 'Question','required'); 
		$this->form_validation->set_message('required', '( required )'); 
		$config['total_rows'] = $hunt['total'] =$this->qas_model->get_pagination_count();
		if($this->form_validation->run()== FALSE)
		{ 
			$cond = array();
			$config['base_url'] = site_url('hunt/task/');
			$config['per_page'] =1;
			$config['uri_segment']=3;
			$config['num_links'] =0;
			$config['display_pages'] = false;
			/*//$config['use_page_numbers'] = true;
			//$config['prefix'] =''; 
			$config['full_tag_open'] = '';//"<ul>";
			$config['full_tag_close'] ='';//"</ul>";*/
			$config['first_link'] = false;
			$config['last_link'] = false; 
			$config['prev_link'] = false;
			$config['next_link'] = false;
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'>";
			$config['cur_tag_close'] = "</li>";  
			$hunt['segment'] = $this->uri->segment($config['uri_segment']>0) ? $this->uri->segment($config['uri_segment']) : 1;
			$this->pagination->initialize($config); 
			/*$hunt['qas']=$qas=$this->qas_model->get_active();
			$tasks = array();
			if($qas) foreach($qas as $key => $qus):
			$tasks[$qus['id']] = $key+1;  
			endforeach; */
			$hunt['tasks'] =$tthis->tasks;
			$hunt['answerpair']=$this->qas_model->get_answerpair();
			$hunt['start_time'] = date('H:i:s');//$this->input->get('start_time');
			$hunt['questions']= $question = $this->qas_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment'])); 		
			$this->checkstatus($question[0]);	
			$this->load->view('frontend/hunt/task',$hunt,false);
		} else {  
			 $nextpg = $this->input->post('task');
			 $start_time = strtotime($this->input->post('start_time'));
			// $current_time = strtotime(date('H:i:s'));	 
			 $time_diff = date('H:i:s',time()-$start_time);
			 $penatly_time = $this->input->post('penatly_time');
			 $data=array(
				'answer'=>$this->input->post('answer'),
				'user_id'=>$this->session->userdata('sessid'),
				'group_id'=>$this->signedduser->group_id,
				'question_id'=>$this->input->post('question'), 
				'start_time'=>$this->input->post('start_time'), 
				'submision_time'=>date('H:i:s'),
				'taken_time'=>$time_diff,
				'penatly_time'=>$penatly_time,
				'is_penalty'=>$this->input->post('ispenality')); 
			 $ans  = $this->qas_model->answer($data);
			 if($ans){
				 if($hunt['total'] == $nextpg ){ 
				 	$this->session->set_userdata(array('sesshuntover'=>true)); 
					$this->load->view('frontend/hunt/finish',$hunt,false); 
				 }else{
					redirect('hunt/task/'.$nextpg);  
				 }
			 }
		}
	}
	public function finish()
	{
		$this->load->model('hunts_model');$this->load->model('frontend/qas_model');  	
		$hunt['total'] =$this->qas_model->get_pagination_count();
		$hunt['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid')); 		
		$main['content']=$this->load->view('frontend/hunt/finish',$hunt,true);
		$main['header']=$this->frontheader();
		$main['footer']=$this->frontfooter();
		$main['meta']=$this->frontmetahead();
		$this->load->view('frontend/main',$main);	
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
	public function penalty()
	{
		$this->load->model('hunts_model'); $this->load->model('frontend/qas_model'); 	
		$hunt['total'] =$this->qas_model->get_pagination_count();
		$hunt['hunt'] = $this->hunts_model->load($this->session->userdata('sesshuntid')); 
		$hunt['question'] = $question =$this->qas_model->load($this->input->post('question'));  
		$pen = explode(':',$question->penalty);$hunt['penalty'] =$pen[0]*3600+$pen[1]*60+$pen[2];
		$this->load->view('frontend/hunt/penalty',$hunt,false); 
	}
}
