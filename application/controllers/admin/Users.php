<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends Web_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
		   redirect('admin/login');		
		}
		$this->load->model('users_model');	
		$this->load->model('groups_model');	
	}
		
	public function index()
	{
		redirect('admin/users/lists');		
	}
	
	public function lists()
	{
		$this->load->library('pagination');
		$main['page_title']='Hunts';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$config['base_url'] = site_url('admin/users/lists/');
		$config['total_rows'] = $this->users_model->get_pagination_count();
		$config['per_page'] = '10';
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
		$content['groups'] = $this->groups_model->get_idpair();
		$content['hunts']=$this->users_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']));
		$main['content']=$this->load->view('admin/users/lists',$content,true);
		$this->load->view('admin/main',$main);
	}
	
	function add()
	{
		$this->form_validation->set_rules('firstname', 'firstname', 'required');
		$this->form_validation->set_rules('lastname', 'lastname', 'required');
		$this->form_validation->set_rules('gender', 'gender', 'required');
		$this->form_validation->set_rules('group_id', 'group', 'required');
		$this->form_validation->set_rules('mobile', 'mobile', 'required');
		$this->form_validation->set_rules('shirtsize', 'shirtsize', '');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[hunts.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passwordconf]');
		$this->form_validation->set_rules('passwordconf', 'Confirm Password', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required'); 
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_message('valid_email', 'invalid email');
		$this->form_validation->set_message('is_unique', 'already exists');
		$this->form_validation->set_message('matches', 'password mismatch');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Users';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu(); 
			$data['groups'] = $this->groups_model->get_active();
			$main['content']=$this->load->view('admin/users/add',$data,true);
			$this->load->view('admin/main',$main);
		} else {
			$password=md5($this->input->post('password'));
			$data=array(
				'firstname'=>$this->input->post('firstname'),
				'lastname'=>$this->input->post('lastname'),
				'gender'=>$this->input->post('gender'),
				'email'=>$this->input->post('email'),
				'mobile'=>$this->input->post('mobile'),
				'shirtsize'=>$this->input->post('shirtsize'),
				'group_id'=>$this->input->post('group_id'),
				'username'=>$this->input->post('username'),
				'status'=>$this->input->post('status'));
				if($this->input->post('password')) {$data['password']= $password;}
			 
			$loginid=$this->users_model->insert($data);
			if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				redirect('admin/users/lists');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
				redirect('admin/users/lists');
			}
		}
	}
	
	function edit($id,$return=0)
	{
		$this->form_validation->set_rules('firstname', 'firstname', 'required');
		$this->form_validation->set_rules('lastname', 'lastname', 'required');
		$this->form_validation->set_rules('gender', 'gender', 'required');
		$this->form_validation->set_rules('group_id', 'group', 'required');
		$this->form_validation->set_rules('shirtsize', 'shirtsize', '');
		$this->form_validation->set_rules('mobile', 'mobile', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_code_exists'); 
		$this->form_validation->set_rules('password', 'Password', '');
		$this->form_validation->set_rules('passwordconf', 'Confirm Password', '');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_message('valid_email', 'invalid email');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{ 
			$main['page_title']='Users';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();
			$edit['return']=$return; 
			$edit['hunt']= $this->users_model->load($id);
			$edit['groups'] = $this->groups_model->get_active();
			$main['content']=$this->load->view('admin/users/add',$edit,true);
			$this->load->view('admin/main',$main);
		} else { 
			$data=array(
				'firstname'=>$this->input->post('firstname'),
				'lastname'=>$this->input->post('lastname'),
				'gender'=>$this->input->post('gender'),
				'group_id'=>$this->input->post('group_id'),
				'email'=>$this->input->post('email'),
				'mobile'=>$this->input->post('mobile'),
				'shirtsize'=>$this->input->post('shirtsize'),
				'username'=>$this->input->post('username'), 
				'status'=>$this->input->post('status'));	
			$password=md5($this->input->post('password'));
				if($this->input->post('password')) {$data['password']= $password;}	 
			$cond=array('id'=>$id);
			$loginid=$this->users_model->update($data,$cond);
			if($loginid){
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Success!</strong> information saved successfully.
        </div>');
				redirect('admin/users/lists/'.$return);
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
            <strong>Error!</strong> information not saved.
        </div>');
				redirect('admin/users/lists/'.$return);
			}
		}
	}
	function view($id,$return=0)
	{
	 	$view['groups']= $this->groups_model->get_idpair();
	 	$view['hunt']= $this->users_model->load($id);
		$main['page_title']='Users';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$edit['return']=$return; 
		$main['content']=$this->load->view('admin/users/view',$view,true);
		$this->load->view('admin/main',$main); 			 
	}
	function code_exists($code)
	{
		$id = $this->input->post('id');
		if ($this->users_model->code_exists($code,$id))
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
		$loginid=$this->users_model->delete($cond);
		if($loginid){
			$this->session->set_flashdata('message', '<div class="n_ok flash_messages"><p>User deleted Successfully.</p></div>');
			redirect('admin/users/lists/'.$return);
		} else {
			$this->session->set_flashdata('message', '<div class="n_error flash_messages"><p>Error!! - User not deleted.</p></div>');
			redirect('admin/users/lists/'.$return);
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
			redirect('admin/users/');
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
			redirect('admin/users/');
		}
		
		if(isset($status) && $ids){
			foreach($ids as $id):
				$data=array('status'=>$status);$cond=array('id'=>$id);
				$loginid=$this->users_model->update($data,$cond);		  
				$flashmsg = 'Information updated Successfully.';				
			endforeach;
		} 
		if(isset($_POST['delete']) && $ids){			
			foreach($ids as $id):
				$loginid=$this->users_model->delete($id);
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
		redirect('admin/users/lists/'.$this->input->post('return'));
	} 
}
/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */