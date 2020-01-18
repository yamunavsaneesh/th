<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->table_name='menus';
    }
	
	function get_array()
	{
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	function get_active()
	{
		$this->db->where('status','Y');
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	
	function get_active_array()
	{
		$this->db->where('status','Y');
		$query = $this->db->get($this->table_name);
        foreach($query->result_array() as $row):
			$langs[$row['code']] = $row['name'];
		endforeach;
		return $langs;
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
        $this->db->from($this->table_name);
		$this->db->limit($num, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function code_exists($code,$id)
	{
		$this->db->where('code',$code);
		$this->db->where('id !=',$id);
		$query = $this->db->get($this->table_name);
        $result = $query->num_rows();
		if($result>0){
			return true;
		} else {
			return false;
		}
	}
}