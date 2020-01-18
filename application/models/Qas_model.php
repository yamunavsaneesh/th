<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qas_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->table_name='questions';$this->answer_table='answers';
		$this->huntid = $this->session->userdata('sesshuntid');
		$this->where = $this->huntid>0?array('hunt_id'=>$this->huntid):array('hunt_id'=>1);
    }
	
	function get_array()
	{
		if($this->where !='') $this->db->where($this->where);
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	
	function get_array_limit($limit)
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->where('status','Y');
		$this->db->limit($limit);
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	
	function load($id)
	{
		if($this->where !='') $this->db->where($this->where);
		$id=$this->db->escape_str($id);
		$cond=array('id'=>$id);
		$this->db->where($cond);
		$query = $this->db->get($this->table_name);
        return $query->row();
	}
	function huntkey()
	{
		$this->db->select_max('id');
		$query = $this->db->get($this->table_name);  
		$key = $query->row(); 
        return 'THA'.($key->id+1);
	}
	function get_row_cond($cond)
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->where($cond);
		$query = $this->db->get($this->table_name);
        return $query->row();
	}
	
	
	function insert($data)
	{
		if($this->where !='') $data['hunt_id']=$this->huntid;		
		$this->db->insert($this->table_name,$data);
		return $this->db->insert_id();
	}
	
	function update($data,$cond)
	{
		return $this->db->update($this->table_name,$data,$cond);
	}
	
	function delete($cond)
	{
		return $this->db->delete($this->table_name,$cond);
	}
	function sortorders($cond='')
	{
		if($this->where !='') $this->db->where($this->where);
		if($cond !='') $this->db->where($cond);
		$query = $this->db->get('question_orders');
        $resuts = $query->result_array(); $returns1= $returns2 = $returns3 =array();
		if($resuts) foreach($resuts as $result):
			$returns1[$result['group_id']][$result['question_id']] = $result['sort_order'];
			$returns2[$result['group_id']][$result['question_id']] = $result['duration'];
			$returns3[$result['group_id']][$result['question_id']] = $result['penalty'];
		endforeach;
		return array('orders'=>$returns1,'durations'=>$returns2,'penalties'=>$returns3);
	}
	function sortorder($cond='')
	{
		if($this->where !='') $this->db->where($this->where);
		if($cond !='') $this->db->where($cond);
		$query = $this->db->get('question_orders');
        $resuts = $query->result_array(); $returns= array();
		if($resuts) foreach($resuts as $result):
			$returns[$result['group_id']][$result['question_id']] = $result['sort_order'];
		endforeach;
		return $returns;
	}
	function durations($cond='')
	{
		if($this->where !='') $this->db->where($this->where);
		if($cond !='') $this->db->where($cond);
		$query = $this->db->get('question_orders');
        $resuts = $query->result_array(); $returns= array();
		if($resuts) foreach($resuts as $result):
			$returns[$result['group_id']][$result['question_id']] = $result['duration'];
		endforeach;
		return $returns;
	}
	function saveorder($data,$cond)
	{
		if($this->where !='') {$cond['hunt_id']=$this->huntid; }
		$this->db->delete('question_orders',$cond); 
		$this->db->insert('question_orders',$data);
		return true;
	}
	function hunt_duration(){
		if($this->where !='') $this->db->where($this->where);
		$this->db->where(array('user_id'=>$this->session->userdata('sessid')));
		$this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        $this->db->from($this->answer_table);
		$query = $this->db->get();
        $results = $query->result_array();
		$rows = $query->num_rows();
		$task1 = strtotime($results[0]['submision_time']);
		$task2 = strtotime($results[$rows]['submision_time']);
		return gmdate($task2-$task1);
	}
	function get_pagination_count($cond='')
    {
        if($this->where !='') $this->db->where($this->where);
	    $this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        $this->db->from($this->table_name);
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_pagination($num, $offset, $cond='')
    {
        if($this->where !='') $this->db->where($this->where);
		$this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        $this->db->from($this->table_name);
		$this->db->limit($num, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_answers_count($cond='')
    {
        if($this->where !=''){ $this->db->where(array("$this->answer_table.hunt_id" => $this->huntid));}
		if(is_array($cond) && count($cond)>0){ $this->db->where($cond);}
		$this->db->select("users.*,$this->answer_table.*,$this->table_name.question"); 
        $this->db->from($this->answer_table);
		$this->db->join('users', "users.id = $this->answer_table.user_id",'left'); 
		$this->db->join($this->table_name, "$this->table_name.id = $this->answer_table.question_id",'left'); 
		//$this->db->group_by("$this->answer_table.user_id"); 
		//$this->db->order_by("$this->answer_table.id desc"); 
        $query = $this->db->get();
        return $query->num_rows();
    }	
	
	function get_answers($num, $offset, $cond='')
    {
        if($this->where !=''){ $this->db->where(array("$this->answer_table.hunt_id" => $this->huntid));}
		if(is_array($cond) && count($cond)>0){ $this->db->where($cond);}
		$this->db->select("users.*,$this->answer_table.*,$this->table_name.question"); 
        $this->db->from($this->answer_table);
		$this->db->join('users', "users.id = $this->answer_table.user_id",'left'); 
		$this->db->join($this->table_name, "$this->table_name.id = $this->answer_table.question_id",'left'); 
		//$this->db->group_by("$this->answer_table.user_id"); 
		//$this->db->order_by("$this->answer_table.id desc"); 
		$this->db->limit($num, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_status_count($cond='')
    {
        if($this->where !=''){ $this->db->where(array("$this->answer_table.hunt_id" => $this->huntid));}
		if(is_array($cond) && count($cond)>0){ $this->db->where($cond);}
		$this->db->select("users.*,$this->answer_table.*,$this->table_name.question"); 
        $this->db->from($this->answer_table);
		//$this->db->join('tasklog', "tasklog.user_id = $this->answer_table.user_id and tasklog.question_id = $this->answer_table.question_id",'inner'); 
		$this->db->join('users', "users.id = $this->answer_table.user_id",'left'); 
		$this->db->join($this->table_name, "$this->table_name.id = $this->answer_table.question_id",'left'); 
		$this->db->group_by("$this->answer_table.user_id"); 
		///$this->db->order_by("$this->answer_table.id desc"); 
        $query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_status($num, $offset, $cond='')
    {
        if($this->where !=''){ $this->db->where(array("$this->answer_table.hunt_id" => $this->huntid));}
		if(is_array($cond) && count($cond)>0){ $this->db->where($cond);}
		$this->db->select("users.*,$this->answer_table.*,$this->table_name.question"); 
        $this->db->from($this->answer_table);
		//$this->db->join('tasklog', "tasklog.user_id = $this->answer_table.user_id and tasklog.question_id = $this->answer_table.question_id",'inner'); 
		$this->db->join('users', "users.id = $this->answer_table.user_id",'left'); 
		$this->db->join($this->table_name, "$this->table_name.id = $this->answer_table.question_id",'left');   
		$this->db->group_by("users.id"); 
		$this->db->order_by("$this->answer_table.id desc"); 
		$this->db->limit($num, $offset);
        $query = $this->db->get(); 
        return $query->result_array();
    }
	function code_exists($code,$id)
	{
		$this->db->where('username',$code);
		$this->db->where('id !=',$id);
		$query = $this->db->get($this->table_name);
        $result = $query->num_rows();
		if($result>0){
			return true;
		} else {
			return false;
		}
	}
	function get_idpair()
	{
		$idpair=array(); if($this->where !='') $this->db->where(array('groups.hunt_id'=>$this->huntid));
		$this->db->from($this->table_name); 
		$query = $this->db->get();
        foreach($query->result_array() as $row):
			$idpair[$row['id']]=$row['name'];
		endforeach;
		return $idpair;
	}
}