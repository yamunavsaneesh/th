<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->table_name='users';
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
		$this->db->where('status','Y');
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
		if($this->where !='') $cond['hunt_id']=$this->huntid;		
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
	function get_user_count($cond)
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->where($cond);
		$this->db->from($this->table_name);
		$query = $this->db->get();
		 return $query->num_rows();
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
		if($this->where !='') $this->db->where($this->where);
        $this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
		if(!empty($order) && count($order)>0){
		$this->db->order_by($order);
		}
		$this->db->limit($num, $offset);
        $this->db->from($this->table_name);
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
	
	function login_check($user,$pass,$huntkey='')
	{
		$user=$this->db->escape_str($user);
		$pass=$this->db->escape_str($pass);
		$huntkey=$this->db->escape_str($huntkey);
		$pass=md5($pass);
		$cond=array('email'=>$user,'password'=>$pass,'status'=>'Y');
		if($huntkey !='') $cond['huntkey'] = $huntkey;
		$this->db->where($cond);
		$query = $this->db->get($this->table_name);
        $result = $query->num_rows();
		if($result>0){
			return true;
		} else {
			return false;
		}
	}
	function insert_logins($data){
		$this->update(array('last_login'=>date('Y-m-d H:i:s')),array('id'=>$data['user_id']));
		$this->db->insert('user_logins',$data);
		return $this->db->insert_id();
	}
	function get_lastlogin(){
		$this->db->where('id',$this->session->userdata('userloginid')-1);
		$query = $this->db->get($this->table_name);
        return $query->row();
	}
}