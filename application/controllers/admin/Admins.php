<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admins extends Web_Controller {
	function __construct()
    {
		// Call the Model constructor
		parent::__construct();
		if(!$this->session->userdata('admin_logged_in'))
		{
		   redirect('admin/login');		
		}
		$this->load->model('admin_model');	$this->load->model('hunts_model');	
	}
		
	public function index()
	{
		redirect('admin/admins/lists');		
	}
	
	public function lists()
	{
		$this->load->library('pagination');
		$main['page_title']='Administrators';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$config['base_url'] = site_url('admin/admins/lists/');
		$config['total_rows'] = $this->admin_model->get_pagination_count();
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
		$content['users']=$this->admin_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']));
		$main['content']=$this->load->view('admin/admins/lists',$content,true);
		$this->load->view('admin/main',$main);
	}
	
	function add()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[admin.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passwordconf]');
		$this->form_validation->set_rules('passwordconf', 'Confirm Password', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('roles_id', 'roles_id', 'required');
		$this->form_validation->set_rules('hunt_id', 'hunt_id', 'required');
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
			$content['roles']=$this->admin_model->get_roles_array();
			$content['hunts']=$this->hunts_model->get_array();
			$main['content']=$this->load->view('admin/admins/add',$content,true);
			$this->load->view('admin/main',$main);
		} else {
			$password=md5($this->input->post('password')); 
			$keypairs=$this->hunts_model->get_keypair();
			$data=array(
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'username'=>$this->input->post('username'),
				'password'=>$password,
				'roles_id'=>$this->input->post('roles_id'),
				'hunt_id'=>$this->input->post('hunt_id'),
				'huntkey'=>$keypairs[$this->input->post('hunt_id')],
				'status'=>$this->input->post('status'));
			$loginid=$this->admin_model->insert($data);
			if($loginid){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong>  Informations saved successfully
                                </div>');
				redirect('admin/admins/lists');
			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Information not Saved
                                </div>');
				redirect('admin/admins/lists');
			}
		}
	}
	
	function edit($id,$return=0)
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_code_exists');
		$this->form_validation->set_rules('roles_id', 'roles_id', 'required');
		$this->form_validation->set_rules('hunt_id', 'hunt_id', 'required');
		$this->form_validation->set_rules('password', 'password', '');
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
			$edit['roles']=$this->admin_model->get_roles_array();
			$edit['hunt']= $this->admin_model->load($id);
			$edit['hunts']=$this->hunts_model->get_array();
			$main['content']=$this->load->view('admin/admins/add',$edit,true);
			$this->load->view('admin/main',$main);
		} else { 
			$keypairs=$this->hunts_model->get_keypair(); 
			$data=array(
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'username'=>$this->input->post('username'),
				'roles_id'=>$this->input->post('roles_id'),
				'hunt_id'=>$this->input->post('hunt_id'),
				'huntkey'=>$keypairs[$this->input->post('hunt_id')],
				'status'=>$this->input->post('status'));
			$password=md5($this->input->post('password'));
			if($this->input->post('password')) {$data['password']= $password;}	 						
			$cond=array('id'=>$id);
			$loginid=$this->admin_model->update($data,$cond);
			if($loginid){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong>  Informations saved successfully
                                </div>');
				redirect('admin/admins/lists/'.$return);
			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Information not Saved
                                </div>');
				redirect('admin/admins/lists/'.$return);
			}
		}
	}
	
	function delete($id,$return)
	{
		$cond=array('id'=>$id);
		$loginid=$this->admin_model->delete($cond);
		if($loginid){
			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong>  Deleted successfully
                                </div>');
			redirect('admin/admins/lists/'.$return);
		} else {
			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Not deleted
                                </div>');
			redirect('admin/admins/lists/'.$return);
		}
	}
	
	function changepwd($id,$return)
	{
		$this->form_validation->set_rules('pass', 'Password', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required');
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_message('matches', 'password mismatch');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$changepwd['id']=$id;
			$changepwd['return']=$return;
			$main['page_title']='Users';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();
			$main['content']=$this->load->view('admin/admins/changepwd',$changepwd,true);
			$this->load->view('admin/main',$main);
		} else {
			$pass=md5($this->input->post('pass'));
			$data=array('password'=>$pass);
			$cond=array('id'=>$id);
			$loginid=$this->admin_model->update($data,$cond);			
			if($loginid){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong>  Password Changed saved successfully
                                </div>');
				redirect('admin/admins/lists/'.$return);
			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Information not Saved
                                </div>');
				redirect('admin/admins/lists/'.$return);
			}
		}
	}
	public function actions(){
		$ids=$this->input->post('id');
		$loginid=false;
		if(isset($_POST['enable']) && $this->input->post('enable')=='Activate'){ $status='Y';}
		if(isset($_POST['disable']) && $this->input->post('disable')=='Deactivate'){ $status='N';}
		 
		 
		if(isset($status) && $ids){
			foreach($ids as $id):
				$data=array('status'=>$status);$cond=array('id'=>$id);
				$loginid=$this->admin_model->update($data,$cond);		  
				$flashmsg = 'Information updated Successfully.';				
			endforeach;
		} 
		if(isset($_POST['delete']) && $ids){			
			foreach($ids as $id):
				$loginid=$this->admin_model->delete($id);
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
                                    <strong>Error ! - Information not Saved
                                </div>');
		}
		redirect('admin/admins/lists/'.$this->input->post('return'));
	} 
	function code_exists($code)
	{
		$id = $this->input->post('id');
		if ($this->admin_model->code_exists($code,$id))
		{
			$this->form_validation->set_message('code_exists', 'already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function roles()
	{
		$main['page_title']='Roles';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();
		$config['base_url'] = site_url('admin/admins/roles/');
		$content['roles']=$this->admin_model->get_roles_array();
		$main['content']=$this->load->view('admin/admins/roles',$content,true);
		$this->load->view('admin/main',$main);
	}
	
	public function permission()
	{
		//$this->form_validation->set_rules("roleid[]", 'Options', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Permission';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();
			$config['base_url'] = site_url('admin/admins/permission/');
			$content['permissions']=$this->admin_model->get_permission_array();
			$content['roles']=$this->admin_model->get_roles_array();
			foreach($content['roles'] as $key => $val):
			$content['access'][$val['roles_id']]=$this->admin_model->get_access_array(array('roles_id'=>$val['roles_id']));
			endforeach;
			$main['content']=$this->load->view('admin/admins/permission',$content,true);
			$this->load->view('admin/main',$main);
		}
		if($this->input->post())
		{
			$loginid=false;
			foreach($content['roles'] as $key => $val):
			if(isset($_POST['roleid'.$val['roles_id']])){ 
				$this->admin_model->clear_access(array('roles_id'=>$val['roles_id']));	
				foreach($_POST['roleid'.$val['roles_id']] as $id => $access): 
					$data=array('roles_id'=>$val['roles_id'],'permissions_id'=>$access); 
					$loginid=$this->admin_model->permission_access($data);				
				endforeach;			
			}
			endforeach;
			if($loginid){
				$this->session->set_flashdata('message', '<div class="n_ok flash_messages"><p>Permission updated Successfully.</p></div>');
				redirect('admin/admins/permission');
			} else {
				$this->session->set_flashdata('message', '<div class="n_error flash_messages"><p>Error!! - Permission not updated.</p></div>');
				redirect('admin/admins/permission');
			}
		}
	}
}
/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */