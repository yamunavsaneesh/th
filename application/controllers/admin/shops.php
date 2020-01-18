<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shops extends App_Controller {
	function __construct()
    {
 		// Call the Model constructor
		parent::__construct(); 
		if(!$this->session->userdata('admin_logged_in'))
		{
		   redirect('admin/login');		
		}
		$this->load->helper('text');  
		$this->load->model('countries_model');
		$this->load->model('shops_model');
		$this->load->model('shoplogins_model');
 	}
	
	public function index()
	{
		redirect('admin/shops/lists');
	}
	
 	public function lists()
	{
		$this->load->library('pagination');
		
 		$main['page_title']='Shops';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();	
		$cond = array();
		$config['base_url'] = site_url('admin/shops/lists/');
		$config['total_rows'] = $this->shops_model->get_pagination_count($cond);
		$config['per_page'] = '10';
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['first_tag_open'] = '<div>';
 		$config['first_tag_close'] = '</div>';
		$config['full_tag_open'] = '<div class="dataTables_paginate paging_full_numbers">';
		$config['full_tag_close'] = '</div>';
		$config['cur_tag_open'] = '<a class="paginate_active" href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a>';
		$this->pagination->initialize($config);
  		$lists['statusarray'] = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning');
		$lists['shops']=$this->shops_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']),$cond);
 		$main['content']=$this->load->view('admin/shops/lists',$lists,true);
		$this->load->view('admin/main',$main);
	}
	
	public function add()
	{ 
  		$main['page_title']=$this->config->item('site_name');
		$this->load->library('ckeditor');
		$this->load->library('ckfinder');
 		$this->ckeditor->basePath = base_url('public/admin/webeditor').'/';
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '100%';
		$this->ckeditor->config['height'] = '200px';
		//Add Ckfinder to Ckeditor
		$this->ckfinder->SetupCKEditor($this->ckeditor,base_url('public/admin/ckfinder/'));
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('country', 'country', 'required'); 
		$this->form_validation->set_rules('email', 'email', 'required'); 
		$this->form_validation->set_rules('address', 'address', 'required'); 
		$this->form_validation->set_rules('phone', 'phone', 'required'); 
		$this->form_validation->set_rules('fax', 'fax', '');  
		$this->form_validation->set_rules('contact_name', 'contact_name', 'required');  
		$this->form_validation->set_rules('website', 'website', '');  
		$this->form_validation->set_rules('description', 'description', ''); 
 		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Shops';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();
			$add['countries'] = $this->countries_model->get_active(); 
 			$main['content']=$this->load->view('admin/shops/add',$add,true);
			$this->load->view('admin/main',$main);
		} else {
			$slug = $this->shops_model->create_slug($this->input->post('title'));
		  	$maindata = array(  
			'status'=>$this->input->post('status'),
 			'country'=>$this->input->post('country'),
			'email'=>$this->input->post('email'),
			'slug'=>$slug,'title'=>$this->input->post('title'), 
			'address'=>$this->input->post('address'),
			'phone'=>$this->input->post('phone'),
			'fax'=>$this->input->post('fax'),
			'contact_name'=>$this->input->post('contact_name'),
			'website'=>$this->input->post('website'),
			'description'=>$this->input->post('description')
			); 
			$config['upload_path']       = 'public/uploads/shoplogos';
			$config['allowed_types']     = 'jpg|png|gif';
			$this->load->library('upload', $config); 
			if($this->upload->do_upload('logo'))
			{
				$logodata=$this->upload->data();
				$maindata['logo']=$logodata['file_name'];
			}
			$config['upload_path'] = 'public/uploads/shopcontracts';
			$config['allowed_types'] = 'pdf';
			$this->load->library('upload', $config);	 
			if($this->upload->do_upload('contract'))
			{
				$logodata=$this->upload->data();
				$maindata['contract']=$logodata['file_name'];
			}
			$config2['upload_path'] = 'public/uploads/shopcontracts';
		    $config2['allowed_types'] = 'pdf';
 			$this->upload->initialize($config2);
 			if ( $this->upload->do_upload('contract')) {
  				$contractdata=$this->upload->data('contract');	
			 	$maindata['contract'] = $contractdata['file_name']; 
			}
			$inserted= false;
 			$inserted = $this->shops_model->insert($maindata);
 			if($inserted){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
									<strong>Success !</strong> Shops Saved successfully.
								</div>');
				redirect('admin/shops/lists/'.$this->input->post('return'));
 			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
										</button>
										<strong>Error ! - Shops not saved
									</div>');
				redirect('admin/shops/lists/'.$this->input->post('return'));
			}
       	}
	
	}
	public function edit($id)
	{ 
		
 		$main['page_title']=$this->config->item('site_name');
		$this->load->library('ckeditor');
		$this->load->library('ckfinder');
		$this->ckeditor->basePath = base_url('public/admin/webeditor').'/';
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '100%';
		$this->ckeditor->config['height'] = '200px';
		//Add Ckfinder to Ckeditor
		$this->ckfinder->SetupCKEditor($this->ckeditor,base_url('public/admin/ckfinder/'));
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('country', 'country', 'required'); 
		$this->form_validation->set_rules('email', 'email', 'required'); 
		$this->form_validation->set_rules('address', 'address', 'required'); 
		$this->form_validation->set_rules('phone', 'phone', 'required'); 
		$this->form_validation->set_rules('fax', 'fax', '');  
		$this->form_validation->set_rules('contact_name', 'contact_name', 'required');  
		$this->form_validation->set_rules('website', 'website', '');  
		$this->form_validation->set_rules('description', 'description', ''); 
 		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Shops';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();	  
			$edit['countries'] = $this->countries_model->get_active(); 
			$edit['shop'] = $this->shops_model->load($id);
			$main['content']=$this->load->view('admin/shops/edit',$edit,true);
			$this->load->view('admin/main',$main);
		} else {
			$slug = $this->shops_model->create_slug($this->input->post('title'));
		  	$maindata = array(  
			'status'=>$this->input->post('status'),
 			'country'=>$this->input->post('country'),
			'email'=>$this->input->post('email'),
			'slug'=>$slug,'title'=>$this->input->post('title'), 
			'address'=>$this->input->post('address'),
			'phone'=>$this->input->post('phone'),
			'fax'=>$this->input->post('fax'),
			'contact_name'=>$this->input->post('contact_name'),
			'website'=>$this->input->post('website'),
			'description'=>$this->input->post('description')
			); 
			$config['upload_path'] = 'public/uploads/shoplogos';
			$config['allowed_types'] = 'jpg|png|gif';
			$this->load->library('upload',$config);
			if($this->upload->do_upload('logo'))
			{
				$logodata=$this->upload->data('logo');
				$maindata['logo']=$logodata['file_name'];
			}	
 			$config2['upload_path'] = 'public/uploads/shopcontracts';
		    $config2['allowed_types'] = 'pdf';
 			$this->upload->initialize($config2);
 			if ( $this->upload->do_upload('contract'))
			{
   				$contractdata=$this->upload->data('contract');	
			 	$maindata['contract'] = $contractdata['file_name']; 
			}
			$updated= false;   
			$updated = $this->shops_model->update($maindata,$id); 
 			if($updated){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
									<strong>Success !</strong> Shops saved successfully.
								</div>');
				redirect('admin/shops/lists/'.$this->input->post('return'));
 			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
										</button>
										<strong>Error ! - Shops not saved
									</div>');
				redirect('admin/shops/lists/'.$this->input->post('return'));
			}
       	}
	
	}
	public function delete($id,$return)
	{
 		$deleted=$this->shops_model->delete($id);
		if($deleted){
 			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong> Shops deleted Successfully
                                </div>');
			redirect('admin/shops/lists/'.$return);
		} else {
			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Shops not Deleted
                                </div>');
			redirect('admin/shops/lists/'.$return);
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
			redirect('admin/shops/');
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
			redirect('admin/shops/');
		}
		
		if(isset($status) && $ids){
			foreach($ids as $id):
				$data=array('status'=>$status);
				$loginid=$this->shops_model->update($data,$id);				
				$flashmsg = 'Shops updated Successfully.';				
			endforeach;
		}
		if(isset($_POST['delete']) && $ids){			
			foreach($ids as $id):
				$loginid=$this->shops_model->delete($id);
				$flashmsg = 'Shops deleted Successfully.';				
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
		redirect('admin/shops/lists/'.$this->input->post('return'));
	} 
	
	public function login()
	{
		$this->load->library('pagination');
		
 		$main['page_title']='Logins';
		$main['header']=$this->adminheader();
		$main['footer']=$this->adminfooter();
		$main['left']=$this->adminleftmenu();	
		$cond = array();
		$config['base_url'] = site_url('admin/shops/login/');
		$config['total_rows'] = $this->shoplogins_model->get_pagination_count($cond);
		$config['per_page'] = '10';
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['first_tag_open'] = '<div>';
 		$config['first_tag_close'] = '</div>';
		$config['full_tag_open'] = '<div class="dataTables_paginate paging_full_numbers">';
		$config['full_tag_close'] = '</div>';
		$config['cur_tag_open'] = '<a class="paginate_active" href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a>';
		$this->pagination->initialize($config);
  		$lists['statusarray'] = array('Y'=>'Active','N'=>'Deactive','classY'=>'success','classN'=>'warning');
		$lists['logins']=$this->shoplogins_model->get_pagination($config['per_page'],$this->uri->segment($config['uri_segment']),$cond);
 		$main['content']=$this->load->view('admin/shops/login/lists',$lists,true);
		$this->load->view('admin/main',$main);
	}
	
	public function addlogin()
	{  
  		$main['page_title']=$this->config->item('site_name'); 
		$this->form_validation->set_rules('name', 'name', 'required'); 
		$this->form_validation->set_rules('email', 'email', 'required'); 
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[shop_logins.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passwordconf]');
		$this->form_validation->set_rules('passwordconf', 'Confirm Password', 'required');
		$this->form_validation->set_rules('phone', 'phone', 'required');   
		$this->form_validation->set_rules('shops_id', 'shop', 'required');    
 		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Shops Login';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();
			$add['shops'] = $this->shops_model->get_active(); 
 			$main['content']=$this->load->view('admin/shops/login/add',$add,true);
			$this->load->view('admin/main',$main);
		} else {
 		  	$maindata = array(  
			'status'=>$this->input->post('status'),
 			'shops_id'=>$this->input->post('shops_id'),
			'email'=>$this->input->post('email'),
			'name'=>$this->input->post('name'), 
			'username'=>$this->input->post('username'),
			'contactno'=>$this->input->post('phone'), 
			'password'=>md5($this->input->post('password')));  
			$inserted= false;
 			$inserted = $this->shoplogins_model->insert($maindata);
 			if($inserted){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
									<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
									</button>
									<strong>Success !</strong> Shops saved successfully.
								</div>');
				redirect('admin/shops/login/'.$this->input->post('return'));
 			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
										<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
										</button>
										<strong>Error ! - Shops not saved
									</div>');
				redirect('admin/shops/login/'.$this->input->post('return'));
			}
       	}
	
	}
	public function editlogin($id)
	{ 
  		$main['page_title']=$this->config->item('site_name'); 
		$this->form_validation->set_rules('name', 'name', 'required'); 
		$this->form_validation->set_rules('email', 'email', 'required'); 
		$this->form_validation->set_rules('username', 'Username', 'required|callback_code_exists');
		$this->form_validation->set_rules('password', 'Password', ''); 
		$this->form_validation->set_rules('phone', 'phone', 'required');   
		$this->form_validation->set_rules('shops_id', 'shop', 'required');    
 		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_message('required', 'required');
		$this->form_validation->set_error_delimiters('<span class="red">(', ')</span>');
		if ($this->form_validation->run() == FALSE)
		{
			$main['page_title']='Shops Login';
			$main['header']=$this->adminheader();
			$main['footer']=$this->adminfooter();
			$main['left']=$this->adminleftmenu();	  
			$edit['shops'] = $this->shops_model->get_active(); 
			$edit['login'] = $this->shoplogins_model->load($id);
			$main['content']=$this->load->view('admin/shops/login/edit',$edit,true);
			$this->load->view('admin/main',$main);
		} else {
 		  	$maindata = array(  
			'status'=>$this->input->post('status'),
 			'shops_id'=>$this->input->post('shops_id'),
			'email'=>$this->input->post('email'),
			'name'=>$this->input->post('name'), 
			'username'=>$this->input->post('username'),
			'contactno'=>$this->input->post('phone'));  
			if($this->input->post('password') !='' ){ $maindata['password'] =  md5($this->input->post('password')); }
			$updated= false;   
			$updated = $this->shoplogins_model->update($maindata,$id); 
 			if($updated){
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
					<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
					</button>
					<strong>Success !</strong> Shops saved successfully.
				</div>');
				redirect('admin/shops/login/'.$this->input->post('return'));
 			} else {
				$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
					<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
					</button>
					<strong>Error ! - Shops not saved
				</div>');
				redirect('admin/shops/login/'.$this->input->post('return'));
			}
       	}
	}
	public function deletelogin($id,$return)
	{
 		$deleted=$this->shoplogins_model->delete($id);
		if($deleted){
 			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-success alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success !</strong> Shops deleted Successfully
                                </div>');
			redirect('admin/shops/login/'.$return);
		} else {
			$this->session->set_flashdata('message', '<div role="alert" class="alert alert-danger alert-dismissible fade in">
                                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error ! - Shops not Deleted
                                </div>');
			redirect('admin/shops/login/'.$return);
		}
	}
	public function loginactions(){
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
			redirect('admin/shops/login');
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
			redirect('admin/shops/login');
		}
		
		if(isset($status) && $ids){
			foreach($ids as $id):
				$data=array('status'=>$status);
				$loginid=$this->shoplogins_model->update($data,$id);				
				$flashmsg = 'Shops updated Successfully.';				
			endforeach;
		}
		if(isset($_POST['delete']) && $ids){			
			foreach($ids as $id):
				$loginid=$this->shoplogins_model->delete($id);
				$flashmsg = 'Shops deleted Successfully.';				
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
		redirect('admin/shops/login/'.$this->input->post('return'));
	} 
	
	function code_exists($code)
	{
		$id = $this->input->post('id');
		if ($this->shoplogins_model->code_exists($code,$id))
		{
			$this->form_validation->set_message('code_exists', 'already exists');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
/* End of file Shops.php */
/* Location: ./application/controllers/admin/Shops.php */