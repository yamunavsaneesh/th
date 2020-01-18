<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contentcategory_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->table_name='content_category';
		$this->primary_key ='id';
		$this->huntid = $this->session->userdata('sesshuntid');
		$this->where = $this->huntid>0?array('hunt_id'=>$this->huntid):'';
    }
	function get_array()
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->from($this->table_name);
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_active($cond='')
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->where('status','Y');
		if($cond!=''){
			$this->db->where($cond);
		}
		$this->db->from($this->table_name);
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_active_count($cond='')
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->where('status','Y');
		if($cond!=''){
			$this->db->where($cond);
		}
		$this->db->from($this->table_name);
		$query = $this->db->get();
        return $query->num_rows();
	}
	function get_array_limit($limit)
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->limit($limit);
		$this->db->from($this->table_name);
		$query = $this->db->get();
        return $query->result_array();
	}
	
	function load($id)
	{
		if($this->where !='') $this->db->where($this->where);
		$id=$this->db->escape_str($id);
		$cond=array('id'=>$id);
		$this->db->where($cond);
		$this->db->from($this->table_name);
		$query = $this->db->get();
        return $query->row();
	}
	
	function get_row_cond($cond,$return='row')
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->where($cond);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		$returns = ($return=='row') ? $query->row():$query->result_array();
        return $returns;
	}
	
	function insert($maindata)
	{
		if($this->where !='') $maindata['hunt_id']=$this->huntid;
		$this->db->insert($this->table_name,$maindata);
		$prime=$this->db->insert_id();
		return $prime;
	}
	
	function update($maindata,$cond)
	{
		if(count($maindata)>0){
			$logid = $this->db->update($this->table_name,$maindata,$cond);
		}
		return $logid;
	}
	
	function delete($id)
	{
		$cond=array('id'=>$id);
		return $this->db->delete($this->table_name,$cond);
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
	
	function get_pagination($num, $offset, $cond='',$order ='')
    {
        if($this->where !='') $this->db->where(array('groups.hunt_id'=>$this->huntid));
		$this->db->select('groups.*, COUNT(users.id) as users');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
		if(!empty($order) && count($order)>0){
		$this->db->order_by($order);
		}
		$this->db->limit($num, $offset);
        $this->db->from($this->table_name);
		$this->db->join('users', "users.group_id = $this->table_name.$this->primary_key",'left');
		$this->db->group_by('groups.id'); 
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