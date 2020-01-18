<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Status extends Web_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
		   redirect('admin/login');		
		}
		$this->load->model('qas_model');	
		$this->load->model('groups_model');	
	}
		
	public function index()
	{
		redirect('admin/status/report');		
	}
	
	public function answers()
	{
		$main['page_title']='Status';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu(); 
		$content['hunts']='';
		$main['content']=$this->load->view('admin/qas/answers',$content,true);
		$this->load->view('admin/main',$main);
	}
	public function ajaxanswer()
	{
		$this->load->library('pagination');
		$main['page_title']='Status'; 
		$config['base_url'] = site_url('admin/status/ajaxanswer/');
		$config['total_rows'] = $this->qas_model->get_answers_count();
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;  
		$config['prev_tag_open'] = "<li class='paginate_button previous'>";
		$config['prev_tag_close'] ="</li>"; 
		$config['next_tag_open'] = "<li class='paginate_button next'>";
		$config['next_tag_close'] ="</li>";
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = "<li class='paginate_button previous'>";
		$config['first_tag_close'] ="</li>"; 
		$config['last_tag_open'] = "<li class='paginate_button next'>";
		$config['last_tag_close'] ="</li>";
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] ="</ul>";   
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='paginate_button active'><a href='#'>";
		$config['cur_tag_close'] = "</a></li>";  
		$config['div'] = '#answer'; /* Here #content is the CSS selector for target DIV */
		$config['js_rebind'] = " ";//$config['additional_param'] = 'filteranswer()';
		$this->jquery_pagination->initialize($config);
		$content['hunts']=$this->qas_model->get_answers($config['per_page'],$this->uri->segment($config['uri_segment']));
		$this->load->view('admin/qas/ajaxanswer',$content,false); 
	}	
	public function report()
	{
 		$main['page_title']='Status';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu(); 
		$content['hunts']='';
		$main['content']=$this->load->view('admin/qas/report',$content,true);
		$this->load->view('admin/main',$main);
	}
	public function reportstatus()
	{
		$this->load->library('pagination'); 
		$config['base_url'] = site_url('admin/status/reportstatus/');
		$config['total_rows'] = $this->qas_model->get_status_count();
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;  
		$config['prev_tag_open'] = "<li class='paginate_button previous'>";
		$config['prev_tag_close'] ="</li>"; 
		$config['next_tag_open'] = "<li class='paginate_button next'>";
		$config['next_tag_close'] ="</li>";
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = "<li class='paginate_button previous'>";
		$config['first_tag_close'] ="</li>"; 
		$config['last_tag_open'] = "<li class='paginate_button next'>";
		$config['last_tag_close'] ="</li>";
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] ="</ul>";   
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='paginate_button active'><a href='#'>";
		$config['cur_tag_close'] = "</a></li>";  
		$config['div'] = '#report'; /* Here #content is the CSS selector for target DIV */
		$config['js_rebind'] = " "; /* if you want to bind extra js code */
		//$config['additional_param'] = 'serialize_form()'; 
		$this->jquery_pagination->initialize($config);
		$content['hunts']=$this->qas_model->get_status($config['per_page'],$this->uri->segment($config['uri_segment'])); //echo $this->db->last_query();
		$main['content']=$this->load->view('admin/qas/status',$content,false); 
	}
}
/* End of file users.php */
/* Location: ./application/controllers/admin/qas.php */