<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qas_model extends CI_Model {
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
	
	function get_array()
	{
		if($this->where !='') $this->db->where($this->where);
		$query = $this->db->get($this->table_name);
        return $query->result_array();
	}
	
	function get_active()
	{
		if($this->where !='') $this->db->where($this->where);
        $this->db->from($this->table_name);
		$this->db->join($this->sort_table,"$this->sort_table.$this->foreign_key = $this->table_name.$this->primary_key and $this->sort_table.hunt_id='{$this->huntid}' and $this->sort_table.group_id  ='{$this->signedduser->group_id}' ",'left'); 
		$this->db->order_by("$this->sort_table.sort_order asc,$this->table_name.$this->primary_key asc");
		$query = $this->db->get();
        return $query->result_array();
	}
	function get_array_limit($limit)
	{
		if($this->where !='') $this->db->where($this->where);
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
	
	function saveorder($data,$cond)
	{
		if($this->where !='') {$cond['hunt_id']=$this->huntid; $data['hunt_id']=$this->huntid;}
		$this->db->delete('question_orders',$cond); 
		$this->db->insert('question_orders',$data);
		return true;
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
		$this->db->select("$this->table_name.*");
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        $this->db->from($this->table_name);
        $this->db->join($this->sort_table,"$this->sort_table.$this->foreign_key = $this->table_name.$this->primary_key and $this->sort_table.hunt_id='{$this->huntid}' and $this->sort_table.group_id  ='{$this->signedduser->group_id}' ",'left'); 
		$this->db->order_by("$this->sort_table.sort_order asc,$this->table_name.$this->primary_key asc");
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
	function answer($data){ 
		if($this->where !='') $data['hunt_id']=$this->huntid;				
		$this->db->insert($this->answer_table,$data);
		return $this->db->insert_id();
	}
	function tasklog($data){
		$this->db->where(array('user_id'=>$this->session->userdata('sessid'),'hunt_id'=>$this->huntid));
		$query = $this->db->get($this->logtable);
        $result = $query->num_rows();
		if( $result >0){
			$this->db->update($this->logtable,$data,array('user_id'=>$this->session->userdata('sessid'),'hunt_id'=>$this->huntid));
			return $this->session->userdata('sessid');
		}else{
			$data['user_id']=$this->session->userdata('sessid');	
			if($this->where !='') $data['hunt_id']=$this->huntid;		
			$this->db->insert($this->logtable,$data);
			return $this->db->insert_id();
		}
	}
	function get_orderpair()
	{
		$idpair=array(); 
		if($this->where !='') $this->db->where($this->where);
		$this->db->select("$this->sort_table.sort_order,$this->sort_table.question_id");
        $this->db->from($this->table_name);
		$this->db->join($this->sort_table,"$this->sort_table.$this->foreign_key = $this->table_name.$this->primary_key and $this->sort_table.hunt_id='{$this->huntid}' and $this->sort_table.group_id  ='{$this->signedduser->group_id}' ",'left'); 
		$this->db->order_by("$this->sort_table.sort_order asc,$this->table_name.$this->primary_key asc");
		$query = $this->db->get();
        foreach($query->result_array() as $row):
			$idpair[$row['question_id']]=$row['sort_order'];
		endforeach;
		return $idpair;
	}
	function recover_task(){		
		$this->db->from($this->logtable);
		if($this->where !='') $this->db->where(array("$this->logtable.hunt_id"=>$this->huntid));
		$userid =$this->session->userdata('sessid');
		$this->db->where(array('user_id'=>$userid));
		//$this->db->order_by('submision_time desc');
		$query = $this->db->get();  
        $lasttask = $query->result_array(); 
		$result  = array(); 
		if($lasttask){  		 
			$time = strtotime(date('H:i:s'));
			$subtime = strtotime($lasttask[0]['now']);
			//$pentime = strtotime($lasttask[0]['penatly_time']); 
			$idletime = gmdate('H:i:s',$time-$subtime); //CHANGE HERE 			
			$questions = $this->load($lasttask[0]['question_id']);
			$noqs = 0;$totaldur=$totalpen=$tottasktime='00:00:00';
			$qasorders = $this->get_orderpair();
			$order = $qasorders[$lasttask[0]['question_id']];			
			$nextqas = $this->nexttasks(array("$this->sort_table.sort_order > "=>$order,'group_id'=>$lasttask[0]['group_id']));
			if($nextqas) foreach($nextqas as $key => $qsn): 
				//$secs = strtotime($qsn['duration'])-strtotime("00:00:00");$totaldur = date("H:i:s",strtotime($totaldur)+$secs);
				$dur = explode(':',$qsn['duration']);$pen = explode(':',$qsn['penalty']);
				$dur1 = $dur[0]*3600+$dur[1]*60+$dur[2];				
				$pen1 = $pen[0]*3600+$pen[1]*60+$pen[2];
				$totaldur = $totaldur+$dur1;
				$totalpen = $totalpen+$pen1; 				
				$tasktime  =  gmdate('H:i:s', $totaldur);		
				$pentime  =  gmdate('H:i:s', $totalpen);
				$secs = strtotime($tasktime)-strtotime("00:00:00");
				$tottasktime = date("H:i:s",strtotime($pentime)+$secs);  
				if($idletime >= $tottasktime){ $noqs++; }
				if($noqs>0 && $noqs<=$key){
					$data=array(
					'answer'=>'',
					'user_id'=>$this->session->userdata('sessid'),
					'group_id'=>$lasttask[0]['group_id'],
					'question_id'=>$qsn['qid'], 
					'start_time'=>'', 
					'submision_time'=>date('H:i:s'),
					'taken_time'=>'',
					'penatly_time'=>$qsn['penalty'],
					'is_penalty'=>'Y'); 
				   //$ans  = $this->answer($data); 
				}
			endforeach; // echo '<br>'.  $noqs;echo '<pre>';print_r($nextqas[$noqs]); exit;
			 
			if(isset($nextqas[$noqs])){
				$taskremains = $nextqas[$noqs];	
				$secs = $time-strtotime("00:00:00");
				// $hunttimer = date("H:i:s",strtotime($lasttask[0]['hunttimer'])+$secs); 
				$subtime = strtotime($lasttask[0]['tasktimer']); //
				//$idletime = strtotime($idletime);				
				//echo $idletime;
				$idletime = gmdate('H:i:s',$subtime-$idletime); 
				$taskremains['hunttimer'] = date("H:i:s",strtotime($lasttask[0]['hunttimer'])+$secs);
				$taskremains['tasktimer'] =$lasttask[0]['tasktimer'];
				return $taskremains;
			}
			else {
				//$this->session->set_userdata(array('sesshuntover'=>true));  
			} 
		}
	}
	function nexttasks($cond)
	{
		if($this->where !='') $this->db->where($this->where);
		$this->db->select("$this->table_name.*,$this->table_name.id as qid,$this->sort_table.sort_order");
		if(is_array($cond) && count($cond)>0){ 
			$this->db->where($cond);
		}
		$this->db->from($this->table_name);
		$this->db->join($this->sort_table,"$this->sort_table.$this->foreign_key = $this->table_name.$this->primary_key and $this->sort_table.hunt_id='{$this->huntid}' and $this->sort_table.group_id  ='{$this->signedduser->group_id}' ",'left'); 
		$this->db->order_by("$this->sort_table.sort_order asc,$this->table_name.$this->primary_key asc");
		$query = $this->db->get(); //echo $this->db->last_query();
        return $query->result_array();
	}
	
	function hunt_duration($cond=''){
		if($this->where !='') $this->db->where(array("$this->answer_table.hunt_id"=>$this->huntid));
		$this->db->where(array('user_id'=>$this->session->userdata('sessid')));
		$this->db->select('*');
		if(is_array($cond) && count($cond)>0){
		$this->db->where($cond);
		}
        $this->db->from($this->answer_table);
        $this->db->order_by("$this->answer_table.submision_time asc");
		$query = $this->db->get();
        $results = $query->result_array();
		$rows = $query->num_rows();
		$pen =isset($results[$rows-1]) ?  strtotime($results[$rows-1]['penatly_time']) : '0'; 
		$ispen=isset($results[$rows-1]) ?  $results[$rows-1]['is_penalty'] : 'N';
		$task1 = isset($results[0]) ? strtotime($results[0]['submision_time']) : '0';//start_time
		$task2 =isset($results[$rows-1]) ?  strtotime($results[$rows-1]['submision_time']) : '0'; 
		//$task2 = ($ispen=='Y')? $task2+$pen:$task2;
		return gmdate('H:i:s',$task2-$task1); 
	}
}