<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Groups extends Web_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
		   redirect('admin/login');		
		}
		$this->load->model('groups_model');
		$this->load->model('users_model');	
	}
		
	public function index()
	{
		redirect('admin/groups/lists');		
	}
	
	public function lists()
	{
		$this->load->library('pagination');
		$main['page_title']='Groups';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$config['base_url'] = site_url('admin/groups/lists/');
		$config['total_rows'] = $this->groups_model->get_pagination_count();
		$config['per_page'] = 10;
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
		$content['hunts']=$this->groups_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']));
		$main['content']=$this->load->view('admin/groups/lists',$content,true);
		$this->load->view('admin/main',$main);
	}
	
	function add()
	{
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('short_desc', 'short_desc', ''); 
		$this->form_validation->set_rules('status', 'Status', 'required'); 
		$this->form_validation->set_message('required', 'required');   
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Groups';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu(); 
			$main['content']=$this->load->view('admin/groups/add','',true);
			$this->load->view('admin/main',$main);
		} else {
			 $data=array(
				'name'=>$this->input->post('name'),
				'short_desc'=>$this->input->post('short_desc'), 
				'status'=>$this->input->post('status')); 
			 
			$loginid=$this->groups_model->insert($data);
			if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				redirect('admin/groups/lists');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
				redirect('admin/groups/lists');
			}
		}
	}
	
	function edit($id,$return=0)
	{
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('short_desc', 'short_desc', ''); 
		$this->form_validation->set_rules('status', 'Status', 'required'); 
		$this->form_validation->set_message('required', 'required');   
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Groups';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu(); 
			$edit['hunt']= $this->groups_model->load($id);
			$main['content']=$this->load->view('admin/groups/add',$edit,true);
			$this->load->view('admin/main',$main);
		} else { 
			$data=array(
				'name'=>$this->input->post('name'),
				'short_desc'=>$this->input->post('short_desc'), 
				'status'=>$this->input->post('status')); 
			 
			$cond=array('id'=>$id);
			$loginid=$this->groups_model->update($data,$cond);
			if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				redirect('admin/groups/lists/'.$return);
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
				redirect('admin/groups/lists/'.$return);
			}
		}
	}
	function view($id,$return=0)
	{
	 	$view['hunt']= $this->groups_model->load($id);
		$view['users']= $this->users_model->get_user_count(array('group_id'=>$id));
		$main['page_title']='Groups';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$edit['return']=$return; 
		$main['content']=$this->load->view('admin/groups/view',$view,true);
		$this->load->view('admin/main',$main); 			 
	}
	function code_exists($code)
	{
		$id = $this->input->post('id');
		if ($this->groups_model->code_exists($code,$id))
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
		$loginid=$this->groups_model->delete($cond);
		if($loginid){
			$this->session->set_flashdata('message', '<div class="n_ok flash_messages"><p>User deleted Successfully.</p></div>');
			redirect('admin/groups/lists/'.$return);
		} else {
			$this->session->set_flashdata('message', '<div class="n_error flash_messages"><p>Error!! - User not deleted.</p></div>');
			redirect('admin/groups/lists/'.$return);
		}
	}
	function users($id)
	{
		$cond=array('group_id'=>$id,'status'=>'Y');
		$content['hunts']=$this->users_model->get_row_cond($cond,'array');
		$this->load->view('admin/groups/users',$content,false);
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
			redirect('admin/groups/');
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
			redirect('admin/groups/');
		}
		
		if(isset($status) && $ids){
			foreach($ids as $id):
				$data=array('status'=>$status);$cond=array('id'=>$id);
				$loginid=$this->groups_model->update($data,$cond);		  
				$flashmsg = 'Information updated Successfully.';				
			endforeach;
		} 
		if(isset($_POST['delete']) && $ids){			
			foreach($ids as $id):
				$loginid=$this->groups_model->delete($id);
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
		redirect('admin/groups/lists/'.$this->input->post('return'));
	} 
}
/* End of file users.php */
/* Location: ./application/controllers/admin/groups.php */