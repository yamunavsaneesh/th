<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orders_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		$this->lang_table_name='languages';
		$this->table_name='user_order';
		$this->gymtable_name='gymnasium';
		$this->desc_table_name='gymnasium_desc';
		$this->primary_key ='order_id';
		$this->foreign_key='gym_id';
    }
	function get_saleschart()
	{
		$salesarray = array();
		$sql= "SELECT SUM(total) AS total, DATE_FORMAT(added_on,'%M') as permonth,month(added_on) as salesmonth,YEAR(added_on) as peryear,added_on FROM  user_order WHERE YEAR(added_on) = YEAR(NOW()) GROUP BY  MONTH(added_on)";
		$query = $this->db->query($sql);
        $returns = $query->result_array();
		if($returns) foreach($returns  as $sale):
			//$salesarray[$sale['permonth']] = $sale;
			$salesarray[$sale['salesmonth']] = $sale;
		endforeach;
		//return $salesarray;
		return $returns ;
		/*$months = array();
		for ($i = 0; $i < 8; $i++) {
			$timestamp = mktime(0, 0, 0, date('n') - $i, 1);
			$months[date('n', $timestamp)] = date('F', $timestamp);
		}*/
	}
	function get_array($cond='')
	{
		/*$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();*/
		$this->db->select('a.order_id,a.order_date,a.order_refno,a.total,a.payment_status,c.name,c.email,c.mobile,c.address');
		$this->db->distinct();
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		} 
        $this->db->from("$this->table_name a");
        $this->db->join('order_details b ',"a.order_id=b.order_id");
        $this->db->join('user_registeration c ',"a.user_id=c.id"); 
		$this->db->group_by('a.order_id');
		$this->db->order_by('a.order_date','desc');
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_active()
	{
		$this->db->where('status','Y');
		$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_array_limit($limit)
	{
		$this->db->limit($limit);
		$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->result_array();
	}
	function load($id)
	{
		$id=$this->db->escape_str($id);
		$cond=array('id'=>$id); 
        $sql = "select a.*,c.*
from user_order a 
join user_registeration c on a.user_id=c.id 
where a.order_id=? " ;
$values = array($id);
        $rs = $this->db->query($sql,$values);
        return $rs->row();
	}
	function get_details($id){
	   	$id=$this->db->escape_str($id);
 		$cond=array('id'=>$id); 
        $sql = "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name
from user_order a join order_details b on a.order_id=b.order_id
join user_registeration c on a.user_id=c.id 
join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
join pass_desc gp on b.pass_id=gp.pass_id
where a.order_id=? and gs.language=? and gp.language=?" ;
$values = array($id,$this->session->userdata('admin_language'),$this->session->userdata('admin_language'));
        $rs = $this->db->query($sql,$values);
        return $rs->result_array();
	}
	
	function get_order_details($id){
		$id=$this->db->escape_str($id);
		$sql = "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name
				from user_order a join order_details b on a.order_id=b.order_id
				join user_registeration c on a.user_id=c.id 
				join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
				join pass_desc gp on b.pass_id=gp.pass_id
				where a.order_id=? and gs.language=? and gp.language=? and b.order_type ='pass' group by b.row_id";
		$sql .= " union "; 
		$sql .= "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name
				from user_order a join order_details b on a.order_id=b.order_id
				join user_registeration c on a.user_id=c.id 
				join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
				join gym_classes_desc gp on b.pass_id=gp.class_id
				where a.order_id=? and gs.language=? and gp.language=? and b.order_type='class' group by b.row_id";
		$values = array($id,$this->session->userdata('admin_language'),$this->session->userdata('admin_language'),$id,$this->session->userdata('admin_language'),$this->session->userdata('admin_language'));
        $rs = $this->db->query($sql,$values);
		return $rs->result_array();
	}
	
	function get_row_cond($cond)
	{
		$this->db->where($cond);
		$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->row();
	}
	
	function insert($maindata,$descdata,$facilities,$amenities)
	{
		$this->db->insert($this->table_name,$maindata);
		$prime=$this->db->insert_id();
		$query    = $this->db->get($this->lang_table_name);
        $slug     = $this->create_slug($descdata['title']);
        $descdata['slug'] = $slug; 
        foreach($query->result_array() as $row):
			$rowdata=$descdata;
			$rowdata[$this->foreign_key]=$prime;
			$rowdata['language']=$row['code'];
			$this->db->insert($this->desc_table_name,$rowdata);
 			unset($rowdata);
 		endforeach;		
         $this->save_facilities($facilities,$prime);
        $this->save_amenities($amenities,$prime);
		return $prime;
	}
    function save_facilities($facilities,$gymid){
        $this->db->delete('gym_facilities',array('gym_id'=>$gymid));
        foreach($facilities as $fid){
            $rowdata['gym_id'] = $gymid;
            $rowdata['facility_id'] = $fid;
            $this->db->insert('gym_facilities',$rowdata);
        }
        
    }
	function save_amenities($amenities,$gymid){
	   $this->db->delete('gym_amenities',array('gym_id'=>$gymid));
        foreach($amenities as $fid){
            $rowdata['gym_id'] = $gymid;
            $rowdata['amenity_id'] = $fid;
            $this->db->insert('gym_amenities',$rowdata);
        }
        
    }
    function savepass($data,$gymid){
        $this->db->delete('gym_passes',array('gym_id'=>$gymid));
        foreach($data as $fid){
            $rowdata['gym_id'] = $gymid;
            $rowdata['pass_id'] = $fid;
            $rowdata['status'] = 'Y';
            $this->db->insert('gym_passes',$rowdata);
        }
    }
    function deleteimage($imgid){
        $this->db->delete('gym_gallery',array('row_id'=>$imgid));
    }
    function updategallery($data,$imgid){
        $desccond = array('row_id'=>$imgid);
        $this->db->update('gym_gallery',$data,$desccond);
    }
    function get_passes($gid){
        $this->db->select('pass_id');
        $this->db->where('gym_id',$gid);
		$this->db->from('gym_passes');
		$query = $this->db->get();
        return $query->result_array();
    }
    function get_gymfacilities($gid){
        $this->db->where('gym_id',$gid);
		$this->db->from('gym_facilities');
		$query = $this->db->get();
        return $query->result_array();
    }
    function get_gymamenities($gid){
        $this->db->where('gym_id',$gid);
		$this->db->from('gym_amenities');
		$query = $this->db->get();
        return $query->result_array();
    }
    function insertgallery($data){
        $this->db->insert('gym_gallery',$data);
    }
    
    function savetiming($data){
      // $this->db->insert('gym_timing',$data);
      $sql = 'INSERT INTO gym_timing (gym_id, day_of_week, start_time,end_time, availability_status)
        VALUES (?, ?, ?, ?,?)
        ON DUPLICATE KEY UPDATE 
            start_time=VALUES(start_time), 
            end_time=VALUES(end_time), 
            availability_status=VALUES(availability_status)';
$query = $this->db->query($sql, array( $data['gym_id'], 
                                       $data['day_of_week'], 
                                       $data['start_time'], 
                                       $data['end_time'],
                                       $data['availability_status']
                                      ));  
    }
    
	function update($maindata,$descdata,$id)
	{
		$cond[$this->primary_key]=$id;
		$desccond[$this->foreign_key]=$id;
		$desccond['language']=$this->session->userdata('admin_language');
		if(count($descdata)>0){
			$this->db->update($this->desc_table_name,$descdata,$desccond);
		}
		return $this->db->update($this->table_name,$maindata,$cond);
	}
	
	function delete($id)
	{
        //--- -delete facilities
        //delete amenities
        $this->db->delete('gym_facilities',array('gym_id'=>$id));
        $this->db->delete('gym_amenities',array('gym_id'=>$id));
        //delte timings
        $this->db->delete('gym_timing',array('gym_id'=>$id));
        //delete images
        $this->db->delete('gym_gallery',array('gym_id'=>$id));
        
		$desccond=array($this->foreign_key=>$id);
		$this->db->delete($this->desc_table_name,$desccond);
		$cond=array('id'=>$id);
		return $this->db->delete($this->table_name,$cond);
	}
	
	function get_order_pagination_count($cond='')
    {
        $this->db->select('*');
		$where =array();
        if($this->session->userdata('payment_status')!=''){
			$where[] ="a.payment_status='".$this->session->userdata('payment_status')."'";
		}
		if($this->session->userdata('start_date')!=''){
			$where[] ="a.order_date >='". date('Y-m-d',strtotime($this->session->userdata('start_date')))."'";
  		}
		if($this->session->userdata('end_date')!=''){
			$where[] ="a.order_date <='". date('Y-m-d',strtotime($this->session->userdata('end_date')))."'";
 		}
 		$wherecond .= count($where)>0 ? implode(' and ',$where) : '1';
		$sql = "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name,b.order_type
				from user_order a join order_details b on a.order_id=b.order_id
				join user_registeration c on a.user_id=c.id 
				join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
				join pass_desc gp on b.pass_id=gp.pass_id
				where b.order_type ='pass' and $wherecond group by b.row_id";
		$sql .= " union "; 
		$sql .= "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name ,b.order_type
				from user_order a join order_details b on a.order_id=b.order_id
				join user_registeration c on a.user_id=c.id 
				join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
				join gym_classes_desc gp on b.pass_id=gp.class_id
				where b.order_type='class' and $wherecond group by b.row_id";
		$values = array();
  		$query = $this->db->query($sql,$values);
        return $query->num_rows();
    }
	function get_order_pagination($num, $offset=0, $cond='')
    {
 		if($offset=='') $sqllimit = "LIMIT $num";
		else
		$sqllimit = "LIMIT $offset,$num";
        $this->db->select('a.order_id,a.order_date,a.order_refno,a.total,a.payment_status,c.name,c.email,c.mobile,c.address');
		$this->db->distinct();
		$where =array();
        if($this->session->userdata('payment_status')!=''){
			$where[] ="a.payment_status='".$this->session->userdata('payment_status')."'";
		}
		if($this->session->userdata('start_date')!=''){
			$where[] ="a.order_date >='". date('Y-m-d',strtotime($this->session->userdata('start_date')))."'";
  		}
		if($this->session->userdata('end_date')!=''){
			$where[] ="a.order_date <='". date('Y-m-d',strtotime($this->session->userdata('end_date')))."'";
 		}
 		$wherecond .= count($where)>0 ? implode(' and ',$where) : '1';
		$sql = "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name,b.order_type
				from user_order a join order_details b on a.order_id=b.order_id
				join user_registeration c on a.user_id=c.id 
				join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
				join pass_desc gp on b.pass_id=gp.pass_id
				where b.order_type ='pass' and $wherecond group by b.row_id";
		$sql .= " union "; 
		$sql .= "select a.*,c.*,b.rate,b.order_qty,gs.title,gp.title as pass_name ,b.order_type
				from user_order a join order_details b on a.order_id=b.order_id
				join user_registeration c on a.user_id=c.id 
				join gymnasium g on b.gym_id=g.id join gymnasium_desc gs on g.id=gs.gym_id 
				join gym_classes_desc gp on b.pass_id=gp.class_id
				where b.order_type='class' and $wherecond group by b.row_id";
		$values = array();
		$sql .= " $sqllimit"; 
 		/*$this->db->from('order_details');
		$this->db->join("$this->table_name a", "order_details.order_id =a.order_id","inner");
 		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = a.$this->primary_key","left");
         $this->db->join('user_registeration c ',"a.user_id=c.id",'left');
		$this->db->group_by("row_id");
		$this->db->order_by("a.order_date","desc");*/
 		//$this->db->limit($num, $offset);
		//$query = $this->db->get(); 
		$query = $this->db->query($sql,$values);
        return $query->result_array();
    }
	function get_pagination_count($cond='')
    {
        $this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        if($this->session->userdata('payment_status')!=''){
			$this->db->where('payment_status',$this->session->userdata('payment_status'));
		}
		if($this->session->userdata('start_date')!=''){
			$this->db->where('order_date >=',  date('Y-m-d',strtotime($this->session->userdata('start_date'))));
 		}
		if($this->session->userdata('end_date')!=''){
			$this->db->where('order_date <=', date('Y-m-d',strtotime( $this->session->userdata('end_date'))));
 		}
		$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        return $query->num_rows();
    }
	function get_pagination($num, $offset, $cond='')
    {
        $this->db->select('a.order_id,a.order_date,a.order_refno,a.total,a.payment_status,c.name,c.email,c.mobile,c.address');
		$this->db->distinct();
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		} 
        if($this->session->userdata('payment_status')!=''){
			$this->db->where('payment_status',$this->session->userdata('payment_status'));
		}
		if($this->session->userdata('start_date')!=''){
			$this->db->where('order_date >=',  date('Y-m-d',strtotime($this->session->userdata('start_date'))));
 		}
		if($this->session->userdata('end_date')!=''){
			$this->db->where('order_date <=', date('Y-m-d',strtotime( $this->session->userdata('end_date'))));
 		}
		$this->db->limit($num, $offset);
        $this->db->from("$this->table_name a");
        $this->db->join('order_details b ',"a.order_id=b.order_id");
        $this->db->join('user_registeration c ',"a.user_id=c.id");
		$this->db->group_by('a.order_id');
		$this->db->order_by('a.order_date','desc');
		$query = $this->db->get();// echo $this->db->last_query();
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
	function get_fields()
	{
		return array('address'=>'Address');
	}
    function create_slug($title)
	{
	$slug=url_title($title);
  $slug=sanitizeStringForUrl($slug);
		//$slug=sanitizeStringForUrl($title);
		$this->db->where('slug',$slug);
		$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        $result = $query->num_rows();
		if($result>0){
			return $slug.date('ymdhis');
		} else {
			return $slug;
		}
	}
	function update_slug($slug,$id)
	{
	$slug=url_title($slug);
  $slug=sanitizeStringForUrl($slug);
		//$slug=sanitizeStringForUrl($slug);
		$this->db->where('slug',$slug);
		$this->db->where('id !=',$id);
		$this->db->from($this->table_name);
		$this->db->join($this->desc_table_name, "$this->desc_table_name.$this->foreign_key = $this->table_name.$this->primary_key");
		$this->db->where('language',$this->session->userdata('admin_language'));
		$query = $this->db->get();
        $result = $query->num_rows();
		if($result>0){
			return $slug.date('ymdhis');
		} else {
			return $slug;
		}
	}	
	function get_all_order_counts($cond=''){
		if($cond) $this->db->where($cond);
		$this->db->from($this->table_name);
		return  $this->db->count_all_results();
	}
}