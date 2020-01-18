<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->table_name='admin';
		$this->role_table_name='roles';
		$this->permission_table_name='permissions';
		$this->access_table_name='role_access';
		$this->primary_key ='id';
		$this->permissions_foreign_key='permissions_id';
		$this->roles_foreign_key = 'roles_id';
    }
	
	function get_array()
	{
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	
	function get_array_limit($limit)
	{
		$this->db->limit($limit);
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	
	function load($id)
	{
		$id=$this->db->escape_str($id);
		$cond=array('id'=>$id);
		$this->db->where($cond);
		$query = $this->db->get($this->table_name);
        return $query->row();
	}
	
	function get_row_cond($cond)
	{
		$this->db->where($cond);
		$query = $this->db->get($this->table_name);
        return $query->row();
	}
	
	function login_check($user,$pass,$huntkey='')
	{
		$user=$this->db->escape_str($user);
		$pass=$this->db->escape_str($pass);
		$huntkey=$this->db->escape_str($huntkey);
		$pass=md5($pass);
		$cond=array('username'=>$user,'password'=>$pass,'status'=>'Y');
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
	
	function username_check($user)
	{
		$user=$this->db->escape_str($user);
		$cond=array('username'=>$user);
		$this->db->where($cond);
		$query = $this->db->get($this->table_name);
        $result = $query->num_rows();
		if($result>0){
			return true;
		} else {
			return false;
		}
	}
	
	function insert($data)
	{
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
	
	function get_pagination_count($cond='')
    {
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
        $this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
		$this->db->select("$this->table_name.*,$this->role_table_name.role");    
        $this->db->from($this->table_name);
		$this->db->join($this->role_table_name, "$this->role_table_name.$this->roles_foreign_key = $this->table_name.$this->roles_foreign_key",'left');
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
	function password_check($code)
	{
		$this->db->where('password',md5($code));
		$this->db->where('id',$this->session->userdata('admin_id'));
		$query = $this->db->get($this->table_name);
        $result = $query->num_rows();
		if($result>0){
			return true;
		} else {
			return false;
		}
	}
	function get_roles_array()
	{
		$query = $this->db->get($this->role_table_name);
        return $query->result_array();
	}
	function get_permission_array()
	{
		$query = $this->db->get($this->permission_table_name);
        return $query->result_array();
	}
	function get_access_array($cond)
	{
		$this->db->select("$this->permissions_foreign_key");
		$this->db->where($cond);
		$query = $this->db->get($this->access_table_name);
        return $query->result_array();
	}
	
	function permission_access($data)
	{
		return $this->db->insert($this->access_table_name,$data);
	}
	
	function clear_access($cond)
	{
		return $this->db->delete($this->access_table_name,$cond);
	}
	
	function check_permission($cond)
	{
		$this->db->select("$this->permissions_foreign_key");
		$this->db->where($cond);
		$query = $this->db->get($this->permission_table_name);
        return $query->row();
	}
	
	function check_access($cond)
	{
		$this->db->where($cond);
		$query = $this->db->get($this->access_table_name);
        return $query->num_rows();
	}
}