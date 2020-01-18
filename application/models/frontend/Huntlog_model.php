<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Huntlog_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->table_name='questions';
		$this->sort_table = 'question_orders';
		$this->logtable = 'tasklog';
		$this->answer_table = 'answers';
		$this->foreign_key ='question_id';
		$this->primary_key = 'id';
		$this->huntid = $this->session->userdata('sesshuntid');
		$this->where = $this->huntid>0?array("$this->table_name.hunt_id"=>$this->huntid):'';  
    }
	public function isexists($table,$cond){ 
		$this->db->where($cond); 
        $this->db->from($table);  
		$query = $this->db->get();  
        return $query->row();
	}
	public function get_tasklog($cond){ 
		$cond['user_id']=$this->session->userdata('sessid');
		$this->db->where($cond); 
        $this->db->from('tasklog');  
		$query = $this->db->get();  
        return $query->row();
	}
	public function insert_huntlog(){  
		if(!$this->isexists('huntlog',array('user_id'=>$this->session->userdata('sessid')))) {
			$data=array( 
			'user_id'=>$this->session->userdata('sessid'), 
			'start_time'=>date('Y-m-d H:i:s') ); 
			$this->db->insert('huntlog',$data);
			return $this->db->insert_id();
		}else{ return false;}
	} 
	public function insert_tasklog($qas){  
		$now =  time();
		$duration = gettime($qas['duration']);
		$penalty = gettime($qas['penalty']);
		$endtime = $now + $duration;
		$penaltyendtime  = $endtime+$penalty;
		$data=array( 
		'user_id'=>$this->session->userdata('sessid'),
		'question_id'=>$qas['id'], 
		'start_time'=>date('Y-m-d H:i:s'), 
		'end_time'=>date('Y-m-d H:i:s',$endtime), 
		'penalty_start_time'=>date('Y-m-d H:i:s',$endtime),  
		'penalty_end_time'=>date('Y-m-d H:i:s',$penaltyendtime)); 
	   	$this->db->insert('tasklog',$data);
		return $this->db->insert_id();
	}
	public function update_tasklog($data,$cond){  
	   $this->db->update('tasklog',$data,$cond);
	}
}