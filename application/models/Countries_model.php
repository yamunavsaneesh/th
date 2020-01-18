<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Countries_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->lang_table_name='languages';
		$this->table_name='countries';
		$this->primary_key ='id';
    }
	
	function get_array()
	{
		$this->db->from($this->table_name);
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_active($cond='')
	{
		if($cond)$this->db->where($cond);
		$this->db->where('status','Y');
		$this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_active_gcc($cond='')
	{
		if($cond)$this->db->where($cond);
		$this->db->where('status','Y');
		$this->db->where('is_gcc','Y');
		$this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_array_limit($limit)
	{
		$this->db->limit($limit);
		$this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();
	}
	
	function load($id)
	{
		$id=$this->db->escape_str($id);
		$cond=array('id'=>$id);
		$this->db->where($cond);
		$this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->row();
	}
	
	function get_row_cond($cond)
	{
		$this->db->where($cond);
		$this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->row();
	}
	
	function insert($maindata)
	{
 		$query = $this->db->get($this->lang_table_name);
        foreach($query->result_array() as $row):
 			$maindata['language']=$row['code'];
			$this->db->insert($this->table_name,$maindata);  
			$prime=$this->db->insert_id();
		endforeach;		
		return $prime;
	}
	
	function update($maindata,$id)
	{
		$cond[$this->primary_key]=$id;
 		$cond['language']=$this->session->userdata('admin_language');
 		$return = $this->db->update($this->table_name,$maindata,$cond);//echo $this->db->last_query();exit;
		return $return;
	}
	
	function delete($id)
	{
		$cond=array('id'=>$id);
		return $this->db->delete($this->table_name,$cond);
	}
	
	
	function get_pagination_count($cond='')
    {
        $this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        $this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->num_rows();
    }
	
	function get_pagination($num, $offset, $cond='')
    {
        $this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
		$this->db->limit($num, $offset);
        $this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
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
	
	function get_widgets($conds)
	{
		$data=array();
		foreach($conds as $cond):
			$this->db->where('key',$cond);
			$this->db->where('status','Y');
			$this->db->from($this->table_name);$this->db->where('language',$this->session->userdata('admin_language'));
			$query = $this->db->get();
			$data[$cond]=$query->row();
		endforeach;
		return $data;
	}
}