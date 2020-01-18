<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qas extends Web_Controller {
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
		redirect('admin/qas/lists');		
	}
	
	public function lists()
	{
		$this->load->library('pagination');
		$main['page_title']='Hunts';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$config['base_url'] = site_url('admin/qas/lists/');
		$config['total_rows'] = $this->qas_model->get_pagination_count();
		$config['per_page'] =15;
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
		$this->pagination->initialize($config);
		$content['hunts']=$this->qas_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']));
		$main['content']=$this->load->view('admin/qas/lists',$content,true);
		$this->load->view('admin/main',$main);
	}
	public function sort()
	{
		$this->load->library('pagination');
		$main['page_title']='Hunts';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$config['base_url'] = site_url('admin/qas/sort/');
		$config['total_rows'] = $this->qas_model->get_pagination_count();
		$config['per_page'] = 50;
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
		$this->pagination->initialize($config);
		$content['groups']=$this->groups_model->get_active();
		$content['sortorders']=$this->qas_model->sortorders(); 
		//echo '<pre>';print_r($content['sortorders']);
		$content['hunts']=$this->qas_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']));
		$main['content']=$this->load->view('admin/qas/sort',$content,true);
		$this->load->view('admin/main',$main);
	}
	public function sortaction(){ 
		$sortorders=$this->input->post('sortorder');
		$durations=$this->input->post('duration');  
		$penalty=$this->input->post('penalty');  
		$loginid=false;		
		$groups=$this->groups_model->get_active(); 
		if($groups) foreach($groups as $group):
			if(isset($_POST['sortsave']) && $this->input->post('sortsave')=='Save' && count($sortorders[$group['id']])>0){
			foreach($sortorders[$group['id']] as $id => $sortorder): 
				$loginid=$this->qas_model->saveorder(array('group_id'=>$group['id'],
				'question_id'=>$id,'sort_order'=>$sortorder,
				'duration'=>$durations[$group['id']][$id],
				'penalty'=>$penalty[$group['id']][$id]),
				array('group_id'=>$group['id'],'question_id'=>$id));				
			endforeach;			
			}   
		endforeach;
		if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				 
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
			}
		redirect('admin/qas/sort'.$this->input->post('return'));
	} 
	function add()
	{
		$this->form_validation->set_rules('question', 'question', 'required');
		$this->form_validation->set_rules('location', 'location', 'required');
		$this->form_validation->set_rules('answer', 'answer', 'required');
		/*$this->form_validation->set_rules('durhr', 'Hour', 'required');
		$this->form_validation->set_rules('durmin', 'Minute', 'required'); 
		$this->form_validation->set_rules('dursec', 'Second', 'required');
		$this->form_validation->set_rules('penhr', 'Hour', 'required'); 
		$this->form_validation->set_rules('penmin', 'Minute', 'required');
		$this->form_validation->set_rules('pensec', 'Secong', 'required'); */
		$this->form_validation->set_rules('status', 'Status', 'required'); 
		$this->form_validation->set_message('required', 'required'); 
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Users';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu(); 
			$main['content']=$this->load->view('admin/qas/add','',true);
			$this->load->view('admin/main',$main);
		} else {
			$duration = $this->input->post('durhr').':'.$this->input->post('durmin').':'.$this->input->post('dursec');
			$penalty = $this->input->post('penhr').':'.$this->input->post('penmin').':'.$this->input->post('pensec');
			 $data=array(
				'question'=>$this->input->post('question'),
				'location'=>$this->input->post('location'),
				'answer'=>$this->input->post('answer'),
				//'duration'=>$duration,'penalty'=>$penalty,  
				'status'=>$this->input->post('status')); 
			$loginid=$this->qas_model->insert($data);
			if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				redirect('admin/qas/lists');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
				redirect('admin/qas/lists');
			}
		}
	}
	function edit($id,$return=0)
	{
		$this->form_validation->set_rules('question', 'question', 'required');
		$this->form_validation->set_rules('location', 'location', 'required');
		$this->form_validation->set_rules('answer', 'answer', 'required');
		/*$this->form_validation->set_rules('durhr', 'Hour', 'required');
		$this->form_validation->set_rules('durmin', 'Minute', 'required'); 
		$this->form_validation->set_rules('dursec', 'Second', 'required');
		$this->form_validation->set_rules('penhr', 'Hour', 'required'); */
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_message('required', 'required'); 
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{ 
			$main['page_title']='Users';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();
			$edit['return']=$return; 
			$edit['hunt']= $this->qas_model->load($id);
			$main['content']=$this->load->view('admin/qas/add',$edit,true);
			$this->load->view('admin/main',$main);
		} else { 
			$duration = $this->input->post('durhr').':'.$this->input->post('durmin').':'.$this->input->post('dursec');
			$penalty = $this->input->post('penhr').':'.$this->input->post('penmin').':'.$this->input->post('pensec');
			 $data=array(
				'question'=>$this->input->post('question'),
				'location'=>$this->input->post('location'),
				'answer'=>$this->input->post('answer'),
				//'duration'=>$duration,'penalty'=>$penalty,  
				'status'=>$this->input->post('status')); 	 
			$cond=array('id'=>$id);
			$loginid=$this->qas_model->update($data,$cond);
			if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				redirect('admin/qas/lists/'.$return);
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
				redirect('admin/qas/lists/'.$return);
			}
		}
	}
	function view($id,$return=0)
	{
	 	$view['hunt']= $this->qas_model->load($id);
		$main['page_title']='Users';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$edit['return']=$return; 
		$main['content']=$this->load->view('admin/qas/view',$view,true);
		$this->load->view('admin/main',$main); 			 
	}
	function code_exists($code)
	{
		$id = $this->input->post('id');
		if ($this->qas_model->code_exists($code,$id))
		{
			$this->form_validation->set_message('code_exists', 'already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function delete($id,$return)
	{
		$cond=array('id'=>$id);
		$loginid=$this->qas_model->delete($cond);
		if($loginid){
			$this->session->set_flashdata('message', '<div class="n_ok flash_messages"><p>User deleted Successfully.</p></div>');
			redirect('admin/qas/lists/'.$return);
		} else {
			$this->session->set_flashdata('message', '<div class="n_error flash_messages"><p>Error!! - User not deleted.</p></div>');
			redirect('admin/qas/lists/'.$return);
		}
	}
	public function actions(){
		$ids=$this->input->post('id');
		$loginid=false;
		if(isset($_POST['enable']) && $this->input->post('enable')=='Activate'){ $status='Y';}
		if(isset($_POST['disable']) && $this->input->post('disable')=='Deactivate'){ $status='N';}
		if(isset($_POST['reset']) && $this->input->post('reset')=='Reset'){
			$newdata = array(
				   'contact_key'  => '',
				   'contact_field'  => '',
				   'contact_category_id'  => '',
				   'order_field'=>'',
				   'sort_field' =>''
			);
			$this->session->unset_userdata($newdata);
			redirect('admin/qas/');
		}
		if(isset($_POST['search']) && $this->input->post('search')=='Search'){
			if($this->input->post('keyword')!='' || $this->input->post('category')!='' ||  $this->input->post('sortby')!=''){
				$newdata = array(
					   'contact_key'  => $this->input->post('keyword'),
					   'contact_field'  => $this->input->post('field'),
					   'contact_category_id'  => $this->input->post('category'),
					   'order_field' =>  $this->input->post('orderby'),
					   'sort_field' => $this->input->post('sortby') 
				);
				$this->session->set_userdata($newdata);
			} else {
				$newdata = array(
					   'contact_key'  => '',
					   'contact_field' => '',
					   'contact_category_id'  => '',
					   'order_field' => '',
					   'sort_field' =>''
				);
				$this->session->unset_userdata($newdata);
			}
			redirect('admin/qas/');
		}
		
		if(isset($status) && $ids){
			foreach($ids as $id):
				$data=array('status'=>$status);$cond=array('id'=>$id);
				$loginid=$this->qas_model->update($data,$cond);		  
				$flashmsg = 'Information updated Successfully.';				
			endforeach;
		} 
		if(isset($_POST['delete']) && $ids){			
			foreach($ids as $id):
				$loginid=$this->qas_model->delete($id);
				$flashmsg = 'Information deleted Successfully.';				
			endforeach;
		}
		if($loginid){
			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong> '.$flashmsg.'
                                </div>');
		} else {
			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Shops not Updated
                                </div>');
		}
		redirect('admin/qas/lists/'.$this->input->post('return'));
	} 
}
/* End of file users.php */
/* Location: ./application/controllers/admin/qas.php */